<?php
$item = $menu_items[$logic];
?>

<div class="row logs-list" data-rows=<?= $item['count'] ?>>
    <div class="col s12">
        <h5><?= $item['title'] ?></h5>

        <?php foreach ($item['logs'] as $time => $log) { ?>
            <div class="card color-themed <?= $colors["default"] ?> lighten-5">
                <div class="card-content">
                    <div class="card-body">
                        <span class="card-title"><?= $time ?></span>
                        <pre><?= implode($log, "<br>") ?></pre>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div class="fixed-action-btn">
    <a class="btn-floating btn-large red">
        <i class="large material-icons">menu</i>
    </a>
    <ul>
        <li>
            <a class="btn-floating indigo darken-2 viewLink" href='file:///<?= $item['file'] ?>' target='_blank'>
                <i class="material-icons tooltipped" data-position="left" data-delay="50" data-tooltip="Open this log file">visibility</i>
            </a>
        </li>
        <li>
            <a class="btn-floating deep-orange truncateLink" href='ajax.php?action=truncate&amp;logFile=<?= $item['file'] ?>'>
                <i class="material-icons tooltipped" data-position="left" data-delay="50" data-tooltip="Truncate this log file">delete_sweep</i>
            </a>
        </li>
    </ul>
</div>