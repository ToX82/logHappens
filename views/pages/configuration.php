<?php
$filename = "config.json";
$filepath = ROOT . $filename;
if(file_exists($filepath)) $configurations = getConfigurations($filepath);

$modify = false;
            
addConfig($configurations);

?>
<div class="row">
    <div class="col-8 offset-2">
        <div class="card border-secondary mb-3">
            <div class="card-header d-flex flex-row justify-content-between align-items-center">
                <p>Configurations</p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add config
                </button>
            </div>
            <div class="d-flex flex-row ms-2 mt-2 justify-content-between align-items-center">
                <p>Total configurations: <?= count((array)$configurations) ?></p>
            </div>
            
            <form form method="post" class="card-body d-flex flex-column">
           

            <?php 
            foreach ($configurations as $configName => $value) { 
                $modify = modifyAndSaveConfig($configurations, $configName, $value, $modify);
                ?>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <label for="configName"> <?= $configName ?> </label>
                <input <?= $modify ? '' : 'hidden' ?> type="submit" value="Save" name="btn-save_<?=$configName?>" class="btn btn-success btn-sm">
                <input <?= $modify ? 'hidden' : '' ?>  type="submit" value="Modify" name="btn-modify_<?=$configName?>" class="btn btn-primary btn-sm">
            </div>
        <!-- displayOptions($configurations, $configName, $value, $modify); -->
        

        <form method="post" class="mt-3 d-flex flex-column">
            <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                <h6><label for="icon" class="form-label">Icon</label></h6>
                <input class="" type="text" id="input-icon" name="input-icon"
                <?= $modify ? '' : ' hidden ' ?>
                value="<?=$value->icon?>"/>
                <?php if(!$modify) echo $value->icon ?>
                       
            </div>

            <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                <h6><label for="color" class="form-label">Color</label></h6>
                    <input <?= $modify ? '' : 'hidden' ?> type="color" class="form-control form-control-color" id="input-color" name="input-color" value="<?=$value->color?>">
                    <input <?= $modify ? 'hidden' : '' ?> disabled readonly type="color" class="form-control form-control-color" id="display-color" name="display-color" value="<?=$value->color?>">

                    </div>

            <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                <h6><label for="title" class="form-label">Title</label></h6>
                    <input type="text" class="form-control" id="input-title" name="input-title"
                    <?= $modify ? '' : ' hidden ' ?>
                    value="<?=$value->title?>"/>
                    <?php if(!$modify) echo $value->title ?>
                </div>

            <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                <h6><label for="file" class="form-label">File</label></h6>
                    <input type="text" class="form-control" id="input-file" name="input-file"
                    <?= $modify ? '' : ' hidden ' ?>
                    value="<?=$value->file?>"/>
                    <?php if(!$modify) echo $value->file ?>
                </div>

            <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                <h6><label for="parser" class="form-label">Parser</label></h6>
                    <input type="text" class="form-control" id="input-parser" name="input-parser"
                    <?= $modify ? '' : ' hidden ' ?>
                    value="<?=$value->parser?>"/>
                    <?php if(!$modify) echo $value->parser ?>
                </div>

            <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                <h6><label for="state" class="form-label">State</label></h6>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="input-disabled" name="input-disabled" role="switch"
                    <?php if(!$value->disabled) {
                        echo 'checked';
                    } ?>
                    >
                </div>
            </div>
                </form>
        </div>
        <?php } ?>
    </form>


        </div>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form method="post" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add configuration</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-3 d-flex flex-column">
                        <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                            <h6><label for="name" class="form-label">Name</label></h6>
                            <input type="text" id="txt-name" name="txt-name">
                        </div>

                        <div class="ms-2 d-flex flex-column mt-1 mb-3 align-items-start">
                            <h6><label for="icon" class="form-label">Icon</label></h6>
                            <input type="text" id="txt-icon" name="txt-icon"/>
                        </div>

                        <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                            <h6><label for="color" class="form-label">Color</label></h6>
                                <input type="color" class="form-control form-control-color" id="txt-color" name="txt-color">
                                </div>

                        <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                            <h6><label for="title" class="form-label">Title</label></h6>
                                <input type="text" class="form-control" id="txt-title" name="txt-title"/>
                                </div>

                        <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                            <h6><label for="file" class="form-label">File</label></h6>
                                <input type="text" class="form-control" id="txt-file" name="txt-file"/>
                                </div>

                        <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                            <h6><label for="parser" class="form-label">Parser</label></h6>
                                <input type="text" class="form-control" id="txt-parser" name="txt-parser"/>
                                </div>

                        <div class="ms-2 d-flex flex-column mb-3 align-items-start">
                            <h6><label for="state" class="form-label">State</label></h6>
                            <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="txt-disabled" name="txt-disabled" role="switch">  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="btn-close" class="btn btn-primary" value="Add">
            </div>
        </form>
    </div>
</div>


<?php
function noConfigYet()  {
    echo "no configurations yet!";
}
?>
