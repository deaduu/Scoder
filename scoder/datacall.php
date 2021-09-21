<div class="container">
    <div class="row">
        <div class="col-md-4">
            <label for="db">Database Name</label>
            <div class="form-group">
                <select name="db" id="db" class="form-control">
                    <option value="">Select Database</option>
                </select>
            </div>
            <label for="ptable">Table Name</label>
            <div class="form-group">
                <select name="ptable" id="ptable" class="form-control">

                </select>
            </div>
        </div>
        <div class="col-md-8" id="columndata">
            <div id="querybuilder"></div>
        </div>
    </div>

    <div id="queryBlock">

    </div>

</div>
<input type="hidden" id="dbval">
<input type="hidden" id="tableval">
<script>
    $(document).ready(() => {
        $.post('./ajax/ajax.php', {
            method: 'dbnames'
        }, (res) => {
            res = JSON.parse(res);
            $.each(res, (k, v) => {
                $('#db').append(`<option value="${v.db}">${v.name}</option>`);
            });
        });

        $('#db').on('change', () => {
            var db = $('#db').val();

            $('#ptable').html('');
            $.post('./ajax/ajax.php', {
                method: 'tablename',
                db: db,
            }, (res) => {
                $('#ptable').html('<option value="">Select Table</option>');
                res = JSON.parse(res);
                $.each(res, (k, v) => {
                    $('#ptable').append(`<option value="${v.table_name}">${v.table_name}</option>`);
                });
            });
        });

        $('#ptable').on('change', () => {

            var db = $('#db').val();
            var table = $('#ptable').val();
            $('#dbval').val(db);
            $('#tableval').val(table);
            $('#querybuilder').html(`<div class="embed-responsive embed-responsive-16by9">
                <iframe id="ifrm" class="embed-responsive-item" src="./querybuilder.php?db=${db}&table=${table}" allowfullscreen></iframe>
            </div>`);
        });

        window.onmessage = (e) => {
            // $('#queryBlock').html(e.data);
            var data = JSON.parse(e.data);
            console.log(data.sql);
            $.post('./ajax/ajax.php', {
                method: 'codecall',
                val: 'scoder_rowsdata',
                db: $('#dbval').val(),
                table: $('#tableval').val(),
                sql: data.sql,
                params: data.params,
                column: data.column.join(','),
            }, (res) => {
                $('#queryBlock').html(`
                    <div class="form-group">
                        <label>Textarea</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." id="scoderResponseTextarea">${res}</textarea>
                        <button type="button" class="btn btn-block btn-default btn-sm" onclick="insertToCodeMirror()">Insert Into Code</button>
                    </div>
                `);
            });
        };

    });
</script>