<ul class="list-group flex-column">
    <li class="list-group-item nav-item <?= ($displayPage === 'info') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= buildUrl("display/info") ?>">
            <span class="iconify" data-icon="flat-color-icons:info" data-inline="false"></span>
            About LogHappens...
        </a>
    </li>
    <?php foreach ($objParsers->list() as $key => $item) { ?>
        <li class="list-group-item nav-item <?= ($key === @$logs['file']) ? 'active' : '' ?>">
            <a class="nav-link <?= ($key === @$logs['file']) ? 'text-white' : '' ?>" href="<?= buildUrl("viewlog/" . $key) ?>" data-file="<?= $key ?>">
                <span class="iconify" style="color: <?= $item['color'] ?>" data-height="22" data-width="22" data-icon="<?= $item['icon'] ?>" data-inline="false"></span>
                <?= $item['title'] ?>
                <span class="badge <?= ($key === @$logs['file']) ? 'badge-light' : 'badge-primary' ?> badge-pill float-right"><?= $countAll[$key] ?></span>
            </a>
        </li>
    <?php } ?>
</ul>
