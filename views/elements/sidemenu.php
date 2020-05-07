<ul class="list-group flex-column logs-list" data-refresh="<?= setting('refresh') ?>">
    <?php foreach ($objParsers->list() as $key => $item) { ?>
        <li class="list-group-item nav-item <?= ($key === @$logs['file']) ? 'active' : '' ?>">
            <a class="nav-link <?= ($key === @$logs['file']) ? 'text-light' : '' ?>" href="<?= buildUrl("viewlog/" . $key) ?>" data-file="<?= $key ?>">
                <i style="color: <?= $item['color'] ?>">
                    <span class="iconify" data-height="22" data-width="22" data-icon="<?= $item['icon'] ?>" data-inline="false"></span>
                </i>
                <?= $item['title'] ?>
                <span class="badge <?= ($key === @$logs['file']) ? 'badge-light' : 'badge-primary' ?> badge-pill float-right"><?= $countAll[$key] ?></span>
            </a>
        </li>
    <?php } ?>
</ul>
