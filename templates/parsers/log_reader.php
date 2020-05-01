<h4 data-file="<?= $logs['file'] ?>" class="mb-4">
    <?= $logs['title'] ?>

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
</h4>

<table class="table table-borderless datatable log-entries"></table>
