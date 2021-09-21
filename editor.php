<?php require 'include/header_editor.php';

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <!-- ./row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            CodeMirror : <a href="" target="_blank" id="openlink"> <?php echo (isset($data['name'])) ? $data['name'] : 'Projects'; ?> </a>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <input type="hidden" id="openfile" name="openfile">
                        <textarea id="codeMirror" class="p-3"> </textarea>
                    </div>
                    <div class="card-footer">
                        <p>
                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseShortcut" aria-expanded="false" aria-controls="collapseShortcut">
                                Some useful shortcuts
                            </button>
                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseScoder" aria-expanded="false" aria-controls="collapseScoder">
                                Scoder
                            </button>
                        <div id="autoloadbutton"></div>
                        </p>
                        <div class="collapse" id="collapseShortcut">
                            <div class="card card-body">
                                <dl>
                                    <dt>Ctrl + J</dt>
                                    <dd>Put the cursor on or inside a pair of tags to highlight them. Press Ctrl-J to jump to the tag that matches the one under the cursor.</dd>
                                    <dt>Ctrl-F / Cmd-F</dt>
                                    <dd>Start searching</dd>
                                    <dt>Ctrl-G / Cmd-G</dt>
                                    <dd>Find next</dd>
                                    <dt>Shift-Ctrl-G / Shift-Cmd-G</dt>
                                    <dd>Find previous</dd>
                                    <dt>Shift-Ctrl-F / Cmd-Option-F</dt>
                                    <dd>Replace</dd>
                                    <dt>Shift-Ctrl-R / Shift-Cmd-Option-F</dt>
                                    <dd>Replace all</dd>
                                    <dt>Alt-F</dt>
                                    <dd>Persistent search (dialog doesn't autoclose,
                                        enter to find next, Shift-Enter to find previous)</dd>
                                    <dt>Alt-G</dt>
                                    <dd>Jump to line</dd>
                                </dl>
                            </div>
                        </div>

                        <div id="collapseScoder" class="collapse">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card card-body">
                                        <?php foreach ($codes as $code) : ?>
                                            <p>
                                                <button class="btn btn-success" onclick="scoder('<?php echo $code['slug']; ?>','<?php echo $code['type']; ?>')"><?php echo $code['name']; ?></button>
                                            </p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="card card-body">
                                        <div id="scoderResponse"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- ./row -->

        <div class="row">
            <?php require 'fm.php'; ?>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php require 'include/footer_editor.php'; ?>