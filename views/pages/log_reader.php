<?php
$logs = array_slice($logs, 0, $_SESSION['pagelength']);
?>

<div class="row logs-list" data-rows=<?= count($logs) ?>>
    <div class="col s12">
        <h5>Loading log file...</h5>
        <div class="card blue-grey lighten-4">
            <div class="card-content">
                <div class="card-body">
                    <?php foreach ($logs as $time => $log) { ?>
                        <strong><?= $time ?></strong><br>
                        <pre><?= implode($log, "<br>") ?></pre>
                        <hr>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
