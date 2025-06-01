<div class="row">
    <div class="col-10 offset-1">
        <div class="card border-secondary-subtle">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="iconify-preview iconify me-2"
                          data-height="24"
                          data-width="24"
                          style="color: <?=$config->color?>"
                          data-icon="<?=$config->icon?>"
                          data-inline="false">
                    </span>
                    <span class="title-preview h5 mb-0"><?= htmlspecialchars($config->title) ?></span>
                </div>
            </div>

            <form method="post" action="save_configurations" class="needs-validation p-4" novalidate>
                <input type="text" id="input-name" name="input-name" value="<?= htmlspecialchars($configName) ?>" hidden>

                <div class="row mb-4">
                    <!-- Colonna sinistra -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label for="input-title" class="form-label fw-bold">Configuration Name</label>
                            <input type="text" class="form-control" id="input-title" name="input-title"
                                   value="<?= htmlspecialchars($config->title) ?>" required>
                            <div class="invalid-feedback">Please enter a configuration name</div>
                        </div>

                        <div class="mb-4">
                            <label for="input-file" class="form-label fw-bold">Log File Path</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="input-file" name="input-file"
                                       value="<?= htmlspecialchars($config->file) ?>"
                                       placeholder="/var/log/myapp.log" required>
                                <button class="btn btn-outline-secondary" type="button" id="browse-file">
                                    <span class="iconify" data-icon="mdi:folder-open"></span>
                                </button>
                            </div>
                            <div class="form-text">Specify the absolute path to your log file</div>
                            <div class="invalid-feedback">The log file path is missing or does not exist</div>
                        </div>

                        <div class="mb-4">
                            <label for="input-parser" class="form-label fw-bold">Log Parser</label>
                            <select class="form-select" id="input-parser" name="input-parser">
                                <?php foreach ($parsers as $parser) { ?>
                                    <option <?= $config->parser == $parser ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($parser) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <div class="form-text">Select the parser that matches your log format</div>
                        </div>
                    </div>

                    <!-- Colonna destra -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Icon & Color</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-1">
                                        <span class="iconify-preview iconify"
                                              data-height="80"
                                              data-width="80"
                                              data-icon="<?= $config->icon ?>"
                                              data-inline="false"
                                              style="color: <?= $config->color ?>">
                                        </span>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="input-color" class="form-label">Color</label>
                                            <input type="color"
                                                   class="iconify-color form-control form-control-color w-100"
                                                   id="input-color"
                                                   name="input-color"
                                                   value="<?=$config->color?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input-icon" class="form-label">Icon</label>
                                            <div class="input-group">
                                                <input type="text"
                                                       value="<?=$config->icon?>"
                                                       class="iconify-select form-control"
                                                       id="input-icon"
                                                       name="input-icon"
                                                       required>
                                                <button type="button"
                                                        class="iconify-open-dialog btn btn-outline-primary"
                                                        data-icon-input="iconify-select"
                                                        data-color-input="iconify-color">
                                                    Browse
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-check form-switch">
                    <label class="form-check-label me-2" for="input-disabled">Show this configuration in the sidebar</label>
                    <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled"
                        role="switch" <?= $config->disabled === true ? '' : 'checked'; ?>>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="configurations" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="btn-save-config" class="btn btn-primary">
                        <span class="iconify me-1" data-icon="mdi:content-save"></span>
                        Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
