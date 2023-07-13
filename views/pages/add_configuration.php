<?php

$configClass = new Logics\Configurations();

$configurations = $configClass->getConfigurations();

?>

<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary">
            <div class="card-header">
                Add your configuration
            </div>

            <form method="post" class="mt-3 ms-2 d-flex flex-column">
                <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                    <h6><label for="name" class="form-label">Name</label></h6>
                    <input class="form-control" type="text" id="txt-add-name" name="txt-add-name"
                    placeholder="configuration-name">
                </div>

                <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                    <h6><label for="icon" class="form-label">Icon</label></h6>
                    <input class="form-control" type="text" id="txt-add-icon" name="txt-add-icon"
                    placeholder="icon-name">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="color" class="form-label">Color</label></h6>
                    <input type="color" class="form-control form-control-color" id="txt-add-color" name="txt-add-color"
                    value="#000000">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="title" class="form-label">Title</label></h6>
                    <input type="text" class="form-control" id="txt-add-title" name="txt-add-title"
                    placeholder="title">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="file" class="form-label">File</label></h6>
                    <input type="text" class="form-control" id="txt-add-file" name="txt-add-file"
                    placeholder="file-path">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="parser" class="form-label">Parser</label></h6>
                    <input type="text" class="form-control" id="txt-add-parser" name="txt-add-parser"
                    placeholder="parser">
                </div>

                <div class="d-flex align-items-center justify-content-between m-3">
                    <div class="d-flex align-items-start">
                        <h6><label for="state" class="form-label">State</label></h6>
                        <div class="form-check form-switch ms-3">
                            <input type="checkbox" class="form-check-input" id="txt-add-disabled"
                            name="txt-add-disabled" role="switch" checked>
                        </div>
                    </div>
                    <input type="submit" name="btn-addConfig" value="Add" class="btn btn-primary">
                    <?php $configClass->addConfig($configurations); ?>
                </div>
            </form>
        </div>
    </div>
</div>
