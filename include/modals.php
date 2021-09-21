<!-- modal for database -->
<div class="modal fade" id="dbModal" tabindex="-1" role="dialog" aria-labelledby="dbModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="dbform">
                <input type="hidden" name="method" value="createAndCheck">
                <div class="modal-header">
                    <h5 class="modal-title" id="dbModalLabel">Database Connection</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Server name:</label>
                        <input type="text" class="form-control" id="servername" name="servername" placeholder="Eg: localhost">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Eg: root">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Database(Leave blank if not created):</label>
                        <input type="text" class="form-control" id="database" name="database" placeholder="Eg: scoder">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- modal for database end -->