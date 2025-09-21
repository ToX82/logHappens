<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Settings
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="theme">Style</label>
                    <select class="form-select settings-switcher" id="theme">
                        <?php foreach (\Libs\Utilities::listSettings('theme')['options'] as $theme) { ?>
                            <option value="<?= $theme ?>"
                                    <?= (\Libs\Utilities::setting('theme') === $theme) ? 'selected' : '' ?>>
                                <?= ucfirst($theme) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="theme">Refresh interval</label>
                    <select class="form-select settings-switcher" id="refresh">
                        <?php foreach (\Libs\Utilities::listSettings('refresh')['options'] as $refresh) { ?>
                            <option value="<?= $refresh ?>"
                                    <?= (\Libs\Utilities::setting('refresh') === $refresh) ? 'selected' : '' ?>>
                                <?= $refresh ?> sec.
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="theme">Default page length</label>
                    <select class="form-select settings-switcher" id="page-length">
                        <?php foreach (\Libs\Utilities::listSettings('page-length')['options'] as $pageLength) { ?>
                            <option value="<?= $pageLength ?>"
                                    <?= (\Libs\Utilities::setting('page-length') === $pageLength) ? 'selected' : '' ?>>
                                <?= $pageLength ?> items per page
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
