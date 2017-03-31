<?php
$logs = array_slice($logs, 0, $_SESSION['pagelength']);
?>

<div class="row logs-list" data-rows=<?= count($logs) ?>>
    <div class="col s12">
        <h5>Loading log file...</h5>

        <?php foreach ($logs as $time => $log) { ?>
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
