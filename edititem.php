<?php
    require_once 'includes/header.inc.php';
    

    $collectionid= $_GET['collectionid'];
    $collectionName= $_GET['collection'];
    $itemname = $_GET['itemname'];
    $itemid = $_GET['itemid'];
?>
    <div class="container">
        <h3>
            <?php echo "$collectionName";?>
        </h3>
        <div class="container">
            <?php
            echo <<<FRAG
                <h4>$itemname</h4>
FRAG;
        ?>
                <div class="container">
                    <form action="includes/edititem.inc.php" class="form-inline" method="POST">
                        <div class="form-group">
                            <label for="itemName" class="col-sm-3 col-form-label">Item Name </label>
                            <div class="col-sm-9">
                                <input type="text" name="itemName" class="form-control">
                            </div>
                        </div>
                        <br>
                        <input type="hidden" name="collectionName" class="form-control" value="<?php echo $collectionName?>">
                        <input type="hidden" name="itemid" class="form-control" value="<?php echo $itemid?>">
                        <div class="form-group">
                            <label for="itemPrice" class="col-sm-3 col-form-label"> Price </label>
                            <div class="col-sm-9">
                                <input type="number" name="itemPrice" class="form-control">
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-default form-control">Update</button>
                    </form>

                </div>
        </div>

    </div>

    <?php
    require_once 'includes/footer.inc.php';
?>
