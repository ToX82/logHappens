<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= buildUrl('') ?>">LogHappens</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header" aria-controls="header" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
            </ul>

            <ul class="navbar-nav d-flex">
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
