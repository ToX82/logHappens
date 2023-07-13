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

            <!--
            <div class="d-flex flex-row ms-2 mt-2 justify-content-between align-items-center">
                <p>Total configurations: <?= count((array)$configurations) ?></p>
            </div>
            -->

            <div class="card-body d-flex flex-column ms-2 mt-2">
                <?php
                foreach ($configurations as $configName => $value) {
                    ?>
                <div class=" mb-2 card border-secondary <?= $value->disabled ? 'bg-secondary-subtle' : '' ?>">
                    <div class="row mt-2 ms-3">
                        <div class="col-8 d-flex flex-row">
                            <i style="color: <?= $value->color ?>">
                                <span class="iconify" data-height="22" data-width="22" data-icon="<?= $value->icon ?>"
                                data-inline="false"></span>
                            </i>
                            <p class="ms-3"><?= $configName ?></p>
                        </div>
                        <div class="col-4 d-flex justify-content-end mb-2">
                            <a href="<?= buildUrl("edit_configuration?configName=$configName") ?>" class="me-2" >
                                edit
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                </div>

        </div>
    </div>
</div>

<!--
<?php
function noConfigYet()
{
    echo "no configurations yet!";
}
?>
-->
