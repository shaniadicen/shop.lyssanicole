<?php
  require '../dbh.php';

  $itemName = $_POST['itemName'];
  $collection = $_POST['collection'];
  $price = $_POST['price'];

  $sql_namecheck = "SELECT name, collection FROM items WHERE name='$itemName' and collection='$collection'";
  $result_namecheck = mysqli_query($conn, $sql_namecheck);

  $sql = "INSERT INTO items (name,collection,price) VALUES ('$itemName','$collection',$price)";
  $result = mysqli_query($conn, $sql);

  $sql_check = "SELECT name FROM collections WHERE id='$collection'";
  $result_check = mysqli_query($conn, $sql_check);
  $row_check = mysqli_fetch_assoc($result_check);
  $collectionName = $row_check['name'];

  header("Location: ../collection.php?name=$collectionName");
  mysqli_close($conn);
