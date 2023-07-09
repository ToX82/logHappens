<?=
$filename = "config.json";
$filepath = ROOT . $filename;
?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header">
                Configurations
            </div>

            <?php
            if(file_exists($filepath)) {
                displayConfigurations($filepath);
            } else {
                echo "No configurations yet";
            }
            ?>
        </div>
    </div>
</div>
