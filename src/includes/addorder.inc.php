<?php
require '../dbh.php';

  $transactid = $_POST['transactid'];
  $itemid = $_POST['itemid'];
  $collectionid = $_POST['collectionid'];

  $sql_price = "SELECT id,price from items where id='$itemid'";
  $result_price = mysqli_query($conn, $sql_price);
  $row_price = mysqli_fetch_assoc($result_price);
  $price = $row_price['price'];

  $sql = "INSERT INTO orders (transactid,item,collectionid,price) VALUES ('$transactid','$itemid','$collectionid','$price')";
  $result = mysqli_query($conn, $sql);

  $sql_amount = "SELECT sum(price) 'amount' FROM orders where transactid='$transactid'";
  $result_amount = mysqli_query($conn, $sql_amount);
  $row_amount = mysqli_fetch_assoc($result_amount);
  $amount = $row_amount['amount'];

  $sql_tran = "UPDATE transactions set amount = '$amount' WHERE transactid='$transactid'";
  $result_tran = mysqli_query($conn, $sql_tran);

  $sql_tran = "UPDATE items set status='reserved' WHERE id='$itemid'";
  $result_tran = mysqli_query($conn, $sql_tran);

  mysqli_close($conn);
  header("Location: ../orders.php?transactid=$transactid");
