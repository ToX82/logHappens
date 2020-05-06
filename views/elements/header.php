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
                <select class="form-control mr-4 theme-switcher">
                    <option value="cerulean" <?= (getTheme() === 'cerulean') ? 'selected' : '' ?>>Cerulean</option>
                    <option value="darkly" <?= (getTheme() === 'darkly') ? 'selected' : '' ?>>Darkly</option>
                    <option value="litera" <?= (getTheme() === 'litera') ? 'selected' : '' ?>>Litera</option>
                    <option value="materia" <?= (getTheme() === 'materia') ? 'selected' : '' ?>>Materia</option>
                    <option value="sandstone" <?= (getTheme() === 'sandstone') ? 'selected' : '' ?>>Sandstone</option>
                    <option value="slate" <?= (getTheme() === 'slate') ? 'selected' : '' ?>>Slate</option>
                    <option value="superhero" <?= (getTheme() === 'superhero') ? 'selected' : '' ?>>Superhero</option>
                    <option value="cosmo" <?= (getTheme() === 'cosmo') ? 'selected' : '' ?>>Cosmo</option>
                    <option value="flatly" <?= (getTheme() === 'flatly') ? 'selected' : '' ?>>Flatly</option>
                    <option value="lumen" <?= (getTheme() === 'lumen') ? 'selected' : '' ?>>Lumen</option>
                    <option value="minty" <?= (getTheme() === 'minty') ? 'selected' : '' ?>>Minty</option>
                    <option value="simplex" <?= (getTheme() === 'simplex') ? 'selected' : '' ?>>Simplex</option>
                    <option value="solar" <?= (getTheme() === 'solar') ? 'selected' : '' ?>>Solar</option>
                    <option value="united" <?= (getTheme() === 'united') ? 'selected' : '' ?>>United</option>
                    <option value="cyborg" <?= (getTheme() === 'cyborg') ? 'selected' : '' ?>>Cyborg</option>
                    <option value="journal" <?= (getTheme() === 'journal') ? 'selected' : '' ?>>Journal</option>
                    <option value="lux" <?= (getTheme() === 'lux') ? 'selected' : '' ?>>Lux</option>
                    <option value="pulse" <?= (getTheme() === 'pulse') ? 'selected' : '' ?>>Pulse</option>
                    <option value="sketchy" <?= (getTheme() === 'sketchy') ? 'selected' : '' ?>>Sketchy</option>
                    <option value="spacelab" <?= (getTheme() === 'spacelab') ? 'selected' : '' ?>>Spacelab</option>
                    <option value="yeti" <?= (getTheme() === 'yeti') ? 'selected' : '' ?>>Yeti</option>
                </select>
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
