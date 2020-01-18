<?php
  require '../dbh.php';

  $customerName     = $_POST['customer'];

  $sql = "INSERT INTO transactions (customer) VALUES ('$customerName')";
  $result = mysqli_query($conn, $sql);

  mysqli_close($conn);
  header("Location: ../transactions.php");
