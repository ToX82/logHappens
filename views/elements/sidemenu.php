<?php
/** @var \Logics\Services\Parsers $objParsers */
/** @var array $logs */
/** @var array $countAll */
$objParsers = $objParsers ?? null;
$logs = $logs ?? [];
$countAll = $countAll ?? [];
?>
<?php if ($objParsers !== null) { ?>
<ul class="list-group flex-column logs-list" data-refresh="<?= \Libs\Utilities::setting('refresh') ?>">
    <?php foreach ($objParsers->listLogs() as $key => $item) { ?>
        <li class="list-group-item nav-item <?= ($key === ($logs['file'] ?? null)) ? 'active' : '' ?>">
            <a class="nav-link" href="<?= \Libs\UrlHelper::buildUrl("viewlog/" . $key) ?>"
               data-file="<?= $key ?>">
                <i style="color: <?= $item['color'] ?>">
                    <span class="iconify" data-height="22" data-width="22" data-icon="<?= $item['icon'] ?>" data-inline="false"></span>
                </i>
                <?= $item['title'] ?>
                <span class="badge <?= ($key === ($logs['file'] ?? null)) ? 'bg-secondary' : 'bg-primary' ?>
                             rounded-pill float-end"><?= $countAll[$key] ?? 0 ?></span>
            </a>
        </li>
    <?php } ?>
</ul>
<?php } ?>
