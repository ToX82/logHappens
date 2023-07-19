<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary-subtle">
            <div class="card-header">
                Add your configuration
            </div>

            <form method="post" action="save_configurations" class="mt-3 ms-2 d-flex flex-column me-3">
                <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                    <h6><label for="icon" class="form-label">Icon</label></h6>
                    <div class="d-flex flex-row align-items-center">
                        <i></i>
                        <button type="button" class="iconify-open-dialog px-2 btn btn-primary"
                        data-icon-input="iconify-select" data-color-input="iconify-color">Search it</button>
                        <p class="mt-3 ms-2">or insert it manually</p>
                        <input type="text" placeholder="Iconify code" class="iconify-select ms-2" size="20"
                        id="input-icon" name="input-icon">
                        <input type="color" class="iconify-color ms-2"
                        id="input-color" name="input-color" value="#000000">
                    </div>
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="title" class="form-label">Title</label></h6>
                    <input type="text" class="form-control" id="input-title" name="input-title"
                    placeholder="title">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="file" class="form-label">File</label></h6>
                    <input type="text" class="form-control" id="input-file" name="input-file"
                    placeholder="file-path">
                </div>

                <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                    <h6><label for="parser" class="form-label">Parser</label></h6>
                    <input type="text" class="form-control" id="input-parser" name="input-parser"
                    placeholder="parser">
                </div>

                <div class="d-flex align-items-center justify-content-between m-3 me-0">
                    <div class="d-flex align-items-start">
                        <h6><label for="state" class="form-label">State</label></h6>
                        <div class="form-check form-switch ms-3">
                            <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled"
                            role="switch" checked>
                        </div>
                    </div>
                    <input type="submit" name="btn-save-config" value="Add" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
