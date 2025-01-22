<div class="row">
    <div class="col-10 offset-1">
        <div class="card border-secondary-subtle">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Log Files</h4>
                <span class="text-muted"><?= count((array)$configurations) ?> tracked files</span>
                <a href="<?= buildUrl("add_configuration") ?>" class="btn btn-primary">
                    <span class="iconify me-2" data-icon="mdi:plus"></span>
                    Add Configuration
                </a>
            </div>

            <div class="card-body p-3" id="configurations-list">
                <?php if (empty($configurations)) { ?>
                    <div class="text-center text-muted py-5">
                        <span class="iconify mb-3" data-icon="mdi:file-document-outline" style="font-size: 48px;"></span>
                        <h6>No configurations yet</h6>
                        <p class="mb-3">Start by adding your first log file configuration</p>
                    </div>
                <?php } else { ?>
                    <?php foreach ($configurations as $configName => $value) { ?>
                        <div class="d-flex flex-row mb-3 sortable-item" draggable="true" data-id="<?= $configName ?>">
                            <!-- Drag handle -->
                            <div class="d-flex align-items-center me-2">
                                <span class="iconify text-secondary" data-height="20" data-width="20" data-icon="mdi:drag"></span>
                            </div>

                            <!-- Main card -->
                            <div class="flex-grow-1 card border-secondary-subtle <?= $value->disabled ? 'bg-secondary-subtle' : '' ?>">
                                <div class="card-body py-2 px-3">
                                    <div class="row align-items-center">
                                        <!-- Icon and title -->
                                        <div class="col-md-5 d-flex align-items-center">
                                            <span class="iconify me-2"
                                                  data-height="24"
                                                  data-width="24"
                                                  data-icon="<?= $value->icon ?>"
                                                  style="color: <?= $value->color ?>">
                                            </span>
                                            <span class="h6 mb-0"><?= htmlspecialchars($value->title) ?></span>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-4">
                                            <?php if (!file_exists($value->file)) { ?>
                                                <span class="text-danger">
                                                    <span class="iconify me-1" data-icon="mdi:alert"></span>
                                                    File not found
                                                </span>
                                            <?php } elseif (!is_writeable($value->file)) { ?>
                                                <span class="text-warning">
                                                    <span class="iconify me-1" data-icon="mdi:alert"></span>
                                                    Read only - <a href='<?= buildUrl('display/troubleshooting') ?>'>Need help?</a>
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-md-3 d-flex justify-content-end align-items-center">
                                            <button type="button"
                                                    class="btn btn-link text-secondary p-1 me-2 icon-visibility clickable <?= $value->disabled ? 'opacity-50' : '' ?>"
                                                    id="<?= $configName ?>"
                                                    title="<?= $value->disabled ? 'Show in sidebar' : 'Hide from sidebar' ?>">
                                                <span class="iconify"
                                                      id="icon-eye-<?= $configName ?>"
                                                      data-icon="<?= $value->disabled ? 'dashicons:hidden' : 'dashicons:visibility' ?>"
                                                      data-width="18"
                                                      data-height="18">
                                                </span>
                                            </button>

                                            <a href="<?= buildUrl("edit_configuration?configName=$configName") ?>"
                                               class="btn btn-link text-primary p-1 me-2"
                                               title="Edit">
                                                <span class="iconify" data-icon="mdi:pencil" data-width="18" data-height="18"></span>
                                            </a>

                                            <a href="<?= buildUrl("duplicate_configuration?configName=$configName") ?>"
                                               class="btn btn-link text-success p-1 me-2"
                                               title="Clone">
                                                <span class="iconify" data-icon="mdi:content-copy" data-width="18" data-height="18"></span>
                                            </a>

                                            <button type="button"
                                                    class="btn btn-link text-danger p-1 btn-openModal"
                                                    title="Delete"
                                                    href="<?= buildUrl("delete_configuration?configName=$configName") ?>">
                                                <span class="iconify" data-icon="mdi:delete" data-width="18" data-height="18"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="js-confirm" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this configuration?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <a class="yes-btn btn btn-danger">Delete</a>
            </div>
        </div>
    </form>
</div>

<style>
.btn-link {
    text-decoration: none;
}
.btn-link:hover {
    opacity: 0.8;
}
.iconify {
    vertical-align: -0.125em;
}
.clickable {
    cursor: pointer;
}
.icon-visibility {
    transition: all 0.2s ease;
}
.icon-visibility:hover {
    transform: scale(1.1);
}
.icon-visibility.opacity-50:hover {
    opacity: 0.8 !important;
}
</style>
