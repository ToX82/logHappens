<h4 data-file="<?= $logs['file'] ?>" class="mb-4">
    <?= $logs['title'] ?>

    <?php if (!empty($logs['entries'])) { ?>
        <?php if ($logs['writable'] === true) { ?>
            <a class="truncateLink ml-4" href="<?= buildUrl("truncate/" . $logs['file']) ?>">
                <span class="iconify" data-icon="ion:trash-bin" data-inline="false" style="color: red;" data-width="30"></span>
            </a>
        <?php } else { ?>
            <a class="ml-4" href="<?= buildUrl("display/troubleshooting") ?>">
                <small>
                    You don't have write permissions on this file. Why?
                </small>
            </a>
        <?php } ?>
    <?php } ?>
</h4>

<?php if (empty($logs['entries'])) { ?>
    <div class="card border-success">
        <div class="card-header">No entries</div>
        <div class="card-body">
            <p class="card-text">
                <pre>Hooray! No logs to be seen here</pre>
            </p>
        </div>
    </div>
<?php } else { ?>
    <table class="table table-borderless datatable log-entries">
        <thead>
            <tr>
                <th>Entries</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs['entries'] as $time => $log) { ?>
                <tr>
                    <td>
                        <div class="card border-warning">
                            <div class="card-header"><?= $time ?></div>
                            <div class="card-body">
                                <pre class="card-text"><?= implode("<br>", $log) ?></pre>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>
