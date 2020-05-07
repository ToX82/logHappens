<?php
$json = new stdClass();
$json->recordsTotal = $return['recordsTotal'];
$json->recordsFiltered = $return['recordsFiltered'];
$json->data = [];
?>

<?php if (empty($return['data'])) { ?>
    <?php ob_start(); ?>
        <div class="card border-success">
            <div class="card-header">No entries</div>
            <div class="card-body">
                <p class="card-text text-center">
                    <?php if ($return['recordsTotal'] > 0) { ?>
                        <span class="iconify" data-icon="emojione:see-no-evil-monkey" data-inline="false" data-width="80"></span>
                        <pre class="text-center">Sorry, there is nothing that matches your search<br>Try different search terms</pre>
                    <?php } else { ?>
                        <span class="iconify" data-icon="emojione:party-popper" data-inline="false" data-width="80"></span>
                        <pre class="text-center">Hooray! No logs to be seen here</pre>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php $json->data[]['log'] = ob_get_clean(); ?>
<?php } else { ?>
    <?php foreach ($return['data'] as $time => $log) { ?>
        <?php ob_start(); ?>
        <tr>
            <td>
                <div class="card border-primary mb-2">
                    <div class="card-header"><?= $time ?></div>
                    <div class="card-body">
                        <pre class="card-text"><?= implode("<br>", $log) ?></pre>
                    </div>
                </div>
            </td>
        </tr>
        <?php $json->data[]['log'] = ob_get_clean(); ?>
    <?php } ?>
<?php } ?>

<?php
return json_encode($json);
