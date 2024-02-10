<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary-subtle">
            <div class="card-header">
                Configurations
            </div>

            <div class="card-body d-flex flex-column ms-2 mt-2">
                <?php
                foreach ($configurations as $configName => $value) {
                    ?>
                    <div class="d-flex flex-row mb-2">
                        <i id="<?= $configName ?>" class="icon-visibility p-2 my-auto card border-secondary-subtle me-2 align-items-center clickable <?= $value->disabled ? 'bg-secondary-subtle' : '' ?>"
                            <?= $value->disabled ? 'title="Display this element in the sidebar"' : 'title="Hide this element from the sidebar"' ?>>
                            <span id="icon-eye-<?= $configName ?>" class="icon-eye iconify" data-height="22" data-width="22" data-icon="<?= $value->disabled ? 'dashicons:hidden' : 'dashicons:visibility' ?>"
                            data-inline="false"></span>
                        </i>

                        <div class="w-100 card border-secondary-subtle <?= $value->disabled ? 'bg-secondary-subtle' : '' ?>">
                            <div class="row ms-2">
                                <div class="col-8 d-flex flex-row align-items-center">
                                    <i class="my-2" style="color: <?= $value->color ?>">
                                        <span class="iconify" data-height="22" data-width="22" data-icon="<?= $value->icon ?>"
                                        data-inline="false"></span>
                                    </i>
                                    <p class="my-2 ms-3"><?= $value->title ?></p>

                                    <?php if (!file_exists($value->file)) { ?>
                                        <p class="my-2 ms-3 text-danger">File not found</p>
                                    <?php } elseif (!is_writeable($value->file)) { ?>
                                        <p class="my-2 ms-3 text-warning">
                                            This file is read only. <a href='<?= buildUrl('display/troubleshooting') ?>'>Need help?</a>
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="col-4 my-2 d-flex justify-content-end">
                                    <a href="<?= buildUrl("duplicate_configuration?configName=$configName") ?>" title="Clone this element">
                                        <div class="iconify me-2 text-info" width="22" height="22" data-icon="clarity:clone-line"></div>
                                    </a>
                                    <a href="<?= buildUrl("edit_configuration?configName=$configName") ?>" title="Edit this element">
                                        <div class="iconify me-2 text-warning" width="22" height="22" data-icon="ic:round-edit"></div>
                                    </a>
                                    <input type="submit" name="btn-openDeleteModal" title="Delete this element"
                                        class="btn-openModal iconify me-2 text-danger"
                                        width="22" height="22" data-icon="mingcute:delete-fill"
                                        href="<?= buildUrl("delete_configuration?configName=$configName") ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="d-flex flex-row m-2 justify-content-between align-items-center">
                <p class="ms-3 mb-0">You have <?= count((array)$configurations) ?> tracked log files</p>
                <a href="<?= buildUrl("add_configuration") ?>" class="btn btn-primary py-1 px-2">
                    Add Configuration
                </a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="js-confirm" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Configuration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this configuration?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a
                class="yes-btn btn btn-danger">
                    Delete
                </a>
        </div>
        </div>
    </form>
</div>
