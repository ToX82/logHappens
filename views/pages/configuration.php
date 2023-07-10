<?php
$filename = "config.json";
$filepath = ROOT . $filename;
if(file_exists($filepath)) $configurations = getConfigurations($filepath);
            
                
                

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
            <?php
            $configurations ?
                displayConfigurations($configurations) :
                noConfigYet();
            ?>
        </div>
    </div>
    
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
                            <input type="text" id="txt-icon" name="txt-icon" />
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

</div>
<?php
function noConfigYet()  {
    echo "no configurations yet!";
}
?>