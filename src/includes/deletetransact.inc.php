<?php
  require '../dbh.php';

  $transactid = $_GET['transactid'];

  $sql_status = "UPDATE items JOIN orders on items.id = orders.item SET status='available' WHERE transactid='$transactid'";
  $result_status = mysqli_query($conn, $sql_status);

  $sql = "DELETE FROM transactions where transactid='$transactid'";
  $result = mysqli_query($conn, $sql);

  header("Location: ../transactions.php");
  mysqli_close($conn);
