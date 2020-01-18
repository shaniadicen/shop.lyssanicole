<?php
  require_once 'includes/header.inc.php';

  $collectionid= $_GET['collectionid'];
  $collectionName= $_GET['collection'];
?>

<div class="container">
  <h3> <?php echo "$collectionName"; ?> </h3>
  <div class="container">
    <div class="container">
      <form action="includes/editcollection.inc.php" class="form-inline" method="POST">
        <div class="form-group">
            <label for="name" class="col-sm-3 col-form-label">Collection Name </label>
            <div class="col-sm-9">
                <input type="text" name="name" class="form-control">
            </div>
        </div>
        <br>
        <input type="hidden" name="collectionName" class="form-control" value="<?php echo $collectionName?>">
        <input type="hidden" name="collectionid" class="form-control" value="<?php echo $collectionid?>">
        <div class="form-group">
          <label for="capital" class="col-sm-3 col-form-label"> Capital </label>
          <div class="col-sm-9">
            <input type="number" name="capital" class="form-control">
          </div>
        </div>
        <br>
        <button type="submit" class="btn btn-default form-control">Update</button>
      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.inc.php'; ?>
