<?php
  require '../dbh.php';

  $transactid = $_GET['transactid'];

  $sql = "UPDATE transactions SET status='paid' where transactid = '$transactid'";
  $result = mysqli_query($conn, $sql);

  $sql_status = "UPDATE items JOIN orders on items.id = orders.item join transactions ON transactions.transactid = orders.transactid SET items.status='sold' WHERE transactions.transactid='$transactid'";
  $result_status = mysqli_query($conn, $sql_status);

  header("Location: ../transactions.php");
  mysqli_close($conn);
