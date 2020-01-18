<?php
  require '../dbh.php';

  $collectionName = $_POST['name'];
  $capital = $_POST['collectionCapital'];

  $sql_namecheck = "SELECT name FROM collections WHERE name='$collectionName'";
  $result_namecheck = mysqli_query($conn, $sql_namecheck);

  if(mysqli_num_rows($result_namecheck) > 0){
    echo "already exists";
  } else {
    $sql = "INSERT INTO collections (name,capital) VALUES ('$collectionName',$capital)";
    $result = mysqli_query($conn, $sql);
  }

  mysqli_close($conn);
  header("Location: ../collections.php");
