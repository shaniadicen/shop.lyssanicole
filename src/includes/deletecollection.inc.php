<?php
  require '../dbh.php';

  $collection = $_POST['collectionid'];

  $sql = "DELETE FROM collections where id='$collection'";
  $result = mysqli_query($conn, $sql);


  header("Location: ../collections.php");
  mysqli_close($conn);
