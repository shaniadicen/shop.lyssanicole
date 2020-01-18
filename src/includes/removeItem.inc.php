<?php
  require '../dbh.php';

  $itemid = $_GET['itemid'];
  $collectionName = $_GET['collection'];

  $sql = "DELETE FROM items where id='$itemid'";
  $result = mysqli_query($conn, $sql);

  if($collectionName == 'Clearance Sale'){
    header("Location: ../clearancesale.php");
  }else{
    header("Location: ../collection.php?name=$collectionName");
  }
  mysqli_close($conn);
