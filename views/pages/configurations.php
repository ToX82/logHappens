<?php

$configClass = new Logics\Configurations();
$configurations = $configClass->getConfigurations();

?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary">
            <div class="card-header">
                Configurations
            </div>

            <div class="card-body d-flex flex-column ms-2 mt-2">
                <?php
                foreach ($configurations as $configName => $value) {
                    ?>
                <div class=" mb-2 card border-secondary <?= $value->disabled ? 'bg-secondary-subtle' : '' ?>">
                    <div class="row mt-2 ms-2 align-items-center">
                        <div class="col-8 d-flex flex-row">
                            <i style="color: <?= $value->color ?>">
                                <span class="iconify" data-height="22" data-width="22" data-icon="<?= $value->icon ?>"
                                data-inline="false"></span>
                            </i>
                            <p class="ms-3"><?= $configName ?></p>
                        </div>
                        <div class="col-4 d-flex justify-content-end mb-2 align-items-center">
                            <a href="<?= buildUrl("edit_configuration?configName=$configName") ?>">
                                <div class="iconify me-2" width="25" height="25" data-icon="ic:round-edit"></div>
                            </a>
                            <input type="submit" id="btn-openDeleteModal" name="btn-openDeleteModal"
                            data-bs-target="#deleteModal" data-bs-toggle="modal" class="iconify me-2"
                            width="25" height="25" color="red" data-icon="mingcute:delete-fill" />
                            <?php $configClass->deleteConfig($configurations, $configName); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                </div>

                <div class="d-flex flex-row m-2 justify-content-between align-items-center">
                    <p class="ms-3 mb-0">Total: <?= count((array)$configurations) ?></p>
                    <a href="<?= buildUrl("add_configuration") ?>" class="btn btn-primary py-1 px-2">
                        Add Configuration
                    </a>
                </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Configuration</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this configuration?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="btn-deleteConfig_<?= $configName ?>" class="btn btn-danger" value="Delete">
        </div>
        </div>
    </form>
</div>

<!--
<?php
function noConfigYet()
{
    echo "no configurations yet!";
}
?>
-->
