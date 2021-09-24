<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- CodeMirror -->
<script src="plugins/codemirror/codemirror.js"></script>
<script src="plugins/codemirror/addon/fold/xml-fold.js"></script>
<script src="plugins/codemirror/addon/edit/matchtags.js"></script>
<script src="plugins/codemirror/addon/edit/matchbrackets.js"></script>
<script src="plugins/codemirror/addon/edit/closebrackets.js"></script>
<script src="plugins/codemirror/addon/edit/closetag.js"></script>
<script src="plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="plugins/codemirror/mode/xml/xml.js"></script>
<script src="plugins/codemirror/mode/javascript/javascript.js"></script>
<script src="plugins/codemirror/mode/css/css.js"></script>
<script src="plugins/codemirror/mode/clike/clike.js"></script>
<script src="plugins/codemirror/mode/php/php.js"></script>
<script src="plugins/codemirror/addon/dialog/dialog.js"></script>
<script src="plugins/codemirror/addon/search/searchcursor.js"></script>
<script src="plugins/codemirror/addon/search/search.js"></script>
<script src="plugins/codemirror/addon/scroll/annotatescrollbar.js"></script>
<script src="plugins/codemirror/addon/search/matchesonscrollbar.js"></script>
<script src="plugins/codemirror/addon/search/jump-to-line.js"></script>

<script src="js/scripts.js"></script>

<!-- Page specific script -->
<script>
    CodeMirror.commands.autocomplete = function(cm) {
        cm.showHint({
            hint: CodeMirror.hint.anyword
        });
    }

    var editor = CodeMirror.fromTextArea(document.getElementById("codeMirror"), {
        lineNumbers: true,
        matchBrackets: true,
        autoCloseBrackets: true,
        autoCloseTags: true,
        theme: "monokai",
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        matchTags: {
            bothTags: true
        },
        extraKeys: {
            "Ctrl-J": "toMatchingTag",
            "Alt-F": "findPersistent",
            "Ctrl-S": function(instance) {
                submitpage();
            },
        }
    });

    // var editor = CodeMirror.fromTextArea(document.getElementById("scoderResponseTextarea"), {
    //     lineNumbers: true,
    //     matchBrackets: true,
    //     autoCloseBrackets: true,
    //     autoCloseTags: true,
    //     theme: "monokai",
    //     mode: "application/x-httpd-php",
    //     indentUnit: 4,
    //     indentWithTabs: true,
    //     matchTags: {
    //         bothTags: true
    //     },
    //     extraKeys: {
    //         "Ctrl-J": "toMatchingTag",
    //         "Alt-F": "findPersistent",
    //         "Ctrl-S": function(instance) {
    //             submitpage();
    //         },
    //     }
    // });

    function pagecall(v) {
        event.preventDefault();
        var page = $(v).attr('href');
        $('#openfile').val(page);
        $('#openlink').attr('href', page);
        $.post('./ajax/ajax.php', {
            method: 'pagecall',
            'page': page
        }, (res) => {
            var isAutoload = "require_once dirname(__FILE__) . '/autoload.php';";
            console.log(res.indexOf(isAutoload));
            if (res.indexOf(isAutoload) == -1) {
                $('#autoloadbutton').html(`
                <button class="btn btn-danger" id="autoloadbtn" type="button" onclick="includeAutoload()">
                            Include Autoload
                        </button>`);
            } else {
                $('#autoloadbutton').html();
            }

            editor.setValue(res);
        })
    }

    function submitpage() {
        // var content = $('#codeMirror').val();
        var content = editor.getValue(); //textarea text
        $.post('./ajax/ajax.php', {
            method: 'pagesave',
            content: content,
            file: $('#openfile').val()
        }, (res) => {
            console.log(res);
        });
    }

    function scoder(val, type) {
        $.post('./ajax/ajax.php', {
            method: 'scoder',
            val: val
        }, (res) => {
            if (type == 'textarea') {
                $('#scoderResponse').html(`
                    <div class="form-group">
                        <label>Textarea</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." id="scoderResponseTextarea">${res}</textarea>
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="insertToCodeMirror()">Insert Into Code</button>
                    </div>
                `);
            } else {
                $('#scoderResponse').html(res);
            }
        });
    }

    function insertToCodeMirror() {
        var text = $('#scoderResponseTextarea').val();
        const doc = editor.getDoc();
        const cursor = editor.getCursor();
        doc.replaceRange(text, cursor);
        editor.focus();
        setTimeout(() => {
            cursor.ch += text.length;
            editor.setCursor(cursor);
        }, 0);
    }

    function includeAutoload() {
        appendToCM(0, "<?php echo "<?php require_once dirname(__FILE__) . '/autoload.php'; ?>"; ?>\n");
        $('#autoloadbtn').hide();
    }

    function appendToCM(line, text) {
        editor.replaceRange(text, CodeMirror.Pos(line, 0));
    }

    $(document).ready(() => {
        $.post('./ajax/ajax.php', {
            method: 'scoderdata'
        }, (res) => {
            res = JSON.parse(res);
            $.each(res, (k, v) => {
                $('#scoderdata').append(`
                <p>
                    <button class="btn btn-success" onclick="scoder('${v.slug}','${v.type}')">${v.name}</button>
                </p>
                `);
            });
        });
    });
</script>
</body>

</html>