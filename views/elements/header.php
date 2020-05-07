<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?= buildUrl('') ?>">LogHappens</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header" aria-controls="header" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="header">
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="navbar-nav right">
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
</nav>
