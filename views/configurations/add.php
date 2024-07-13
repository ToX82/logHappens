<div class="row">
    <div class="col-8 offset-2">
        <div class="add_configurations card border-secondary-subtle">
            <div class="card-header">
                <span class="iconify-preview iconify" data-width="24" data-icon="mdi:error" data-inline="false"></span>
                <span class="title-preview">New Log Configuration</span>
            </div>

            <form method="post" action="save_configurations" class="needs-validation mt-3 ms-2 d-flex flex-column me-3" novalidate>
                <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                    <h6><label for="input-icon" class="form-label">Select the icon and color for this configuration</label></h6>
                    <div class="d-flex flex-row align-items-center">
                        <input type="color" class="iconify-color form-control form-control-color me-2" id="input-color" name="input-color" value="#000000">
                        <input type="text" value="mdi:error" placeholder="Iconify code, eg. mdi:error" class="iconify-select form-control me-2" size="20" id="input-icon" name="input-icon" required>
                        <button type="button" class="iconify-open-dialog btn btn-primary" data-icon-input="iconify-select" data-color-input="iconify-color">Cambia</button>
                    </div>
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="input-title" class="form-label">Name</label></h6>
                    <input type="text" class="form-control" id="input-title" name="input-title" placeholder="Enter a name for this configuration (eg. 'My app error.log')" required>
                    <div class="invalid-feedback">The config name is missing.</div>
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="input-file" class="form-label">Log file path</label></h6>
                    <input type="text" class="form-control" id="input-file" name="input-file" placeholder="Enter the path to the log file (eg. '/var/www/myapp/error.log')" required>
                    <div class="invalid-feedback">
                        The log file path is missing or does not exist.
                    </div>
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="input-parser" class="form-label">Parser</label></h6>
                    <select class="form-control" id="input-parser" name="input-parser">
                        <?php foreach ($parsers as $parser) { ?>
                            <option><?= $parser ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="d-flex align-items-center justify-content-between m-3 me-0">
                    <div class="d-flex align-items-start">
                        <h6><label for="input-disabled" class="form-label">Active</label></h6>
                        <div class="form-check form-switch ms-3">
                            <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled" role="switch" checked>
                        </div>
                    </div>
                    <input type="submit" name="btn-save-config" value="Add" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
