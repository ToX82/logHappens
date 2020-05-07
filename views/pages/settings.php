<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Settings
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="theme">Style</label>
                    <select class="form-control settings-switcher" id="theme">
                        <?php foreach (listSettings('theme')['options'] as $theme) { ?>
                            <option value="<?= $theme ?>" <?= (setting('theme') === $theme) ? 'selected' : '' ?>><?= ucfirst($theme) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="theme">Refresh interval</label>
                    <select class="form-control settings-switcher" id="refresh">
                        <?php foreach (listSettings('refresh')['options'] as $refresh) { ?>
                            <option value="<?= $refresh ?>" <?= (setting('refresh') === $refresh) ? 'selected' : '' ?>><?= $refresh ?> sec.</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="theme">Default page length</label>
                    <select class="form-control settings-switcher" id="page-length">
                        <?php foreach (listSettings('page-length')['options'] as $pageLength) { ?>
                            <option value="<?= $pageLength ?>" <?= (setting('page-length') === $pageLength) ? 'selected' : '' ?>><?= $pageLength ?> items per page</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
