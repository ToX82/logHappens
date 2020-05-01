<ul class="list-group flex-column">
    <li class="list-group-item nav-item <?= ($displayPage === 'info') ? 'active' : '' ?>">
        <a class="nav-link <?= ($displayPage === 'info') ? 'text-white' : '' ?>" href="<?= buildUrl("display/info") ?>">
            <span class="iconify" data-icon="flat-color-icons:info" data-height="20" data-width="20" data-inline="false"></span>
            <strong>About LogHappens...</strong>
        </a>
    </li>
    <?php foreach ($objParsers->list() as $key => $item) { ?>
        <li class="list-group-item nav-item <?= ($key === @$logs['file']) ? 'active' : '' ?>">
            <a class="nav-link <?= ($key === @$logs['file']) ? 'text-white' : '' ?>" href="<?= buildUrl("viewlog/" . $key) ?>" data-file="<?= $key ?>">
                <i style="color: <?= $item['color'] ?>">
                    <span class="iconify" data-height="22" data-width="22" data-icon="<?= $item['icon'] ?>" data-inline="false"></span>
                </i>
                <?= $item['title'] ?>
                <span class="badge <?= ($key === @$logs['file']) ? 'badge-light' : 'badge-primary' ?> badge-pill float-right"><?= $countAll[$key] ?></span>
            </a>
        </li>
    <?php } ?>
</ul>
