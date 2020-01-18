<?php
  require '../dbh.php';

  $collectionid = $_POST['collectionid'];
  $collectionName = $_POST['collection'];
  $newName = $_POST['name'];
  $capital = $_POST['capital'];


  if ($newName != null) {
    $sql_upd = "UPDATE collections SET name = '$newName' WHERE id='$collectionid'";
    $result_upd = mysqli_query($conn, $sql_upd);
  }

  if ($capital != null){
    $sql_upd = "UPDATE collections SET capital = '$capital' WHERE id='$collectionid'";
    $result_upd = mysqli_query($conn, $sql_upd);
  }
  
  mysqli_close($conn);
  header("Location: ../collections.php");
