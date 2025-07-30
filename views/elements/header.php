<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= buildUrl('') ?>">LogHappens</a>
        <div class="navbar-brand update-notification" id="header-update-notification" style="display: none;">
            <small class="text-light">
                <i class="iconify" data-icon="mdi:update" style="font-size: 0.8em;"></i>
                <a href="https://github.com/ToX82/logHappens/" target="_blank" class="text-light text-decoration-none">
                    Update available
                </a>
            </small>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header" aria-controls="header" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
            </ul>

            <ul class="navbar-nav d-flex">
                <li class="nav-item">
                    <a class="nav-link" href="<?= buildUrl("configurations") ?>">Configuration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= buildUrl("display/settings") ?>">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= buildUrl("display/troubleshooting") ?>">Troubleshooting</a>
                </li>
                <li class="nav-item">
                    <a target="_blank" rel="noreferrer" class="nav-link" href="https://github.com/ToX82/logHappens">GitHub</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
