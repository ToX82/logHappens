<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary">
            <div class="card-header">
                <?= $configName ?> configuration
            </div>

            <form method="post" class="mt-3 ms-2 d-flex flex-column">
                <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                    <h6><label for="icon" class="form-label">Icon</label></h6>
                    <input class="" type="text" id="input-icon" name="input-icon"
                    value="<?=$config->icon?>">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="color" class="form-label">Color</label></h6>
                    <input type="color" class="form-control form-control-color" id="input-color" name="input-color"
                    value="<?=$config->color?>">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="title" class="form-label">Title</label></h6>
                    <input type="text" class="form-control" id="input-title" name="input-title"
                    value="<?=$config->title?>">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="file" class="form-label">File</label></h6>
                    <input type="text" class="form-control" id="input-file" name="input-file"
                    value="<?=$config->file?>">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="parser" class="form-label">Parser</label></h6>
                    <input type="text" class="form-control" id="input-parser" name="input-parser"
                    value="<?=$config->parser?>">
                </div>

                <div class="d-flex align-items-center justify-content-between m-3">
                    <div class="d-flex align-items-start">
                        <h6><label for="state" class="form-label">State</label></h6>
                        <div class="form-check form-switch ms-3">
                            <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled"
                            role="switch" <?= $config->disabled ? '' : 'checked'; ?>
                            >
                        </div>
                    </div>
                    <input type="submit" name="btn-modifyConfig" value="Save" class="btn btn-primary">
                    <?php $configClass->modifyConfig($configurations, $configName); ?>
                </div>
            </form>
        </div>
    </div>
</div>
