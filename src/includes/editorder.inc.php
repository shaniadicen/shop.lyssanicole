<?php
  require '../dbh.php';

  $discount = $_POST['discount'];
  $shipping = $_POST['shipping'];
  $orderid = $_POST['orderid'];
  $transactid = $_POST['transactid'];


  if ($discount != null) {
    $sql = "SELECT price FROM orders where orderid='$orderid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);


    $new_amount = ($row['price'] - $discount);

    $sql_upd = "UPDATE orders SET price = '$new_amount' WHERE orderid='$orderid'";
    $result_upd = mysqli_query($conn, $sql_upd);

    $sql_amount = "SELECT sum(price) 'amount' FROM orders where transactid='$transactid'";
    $result_amount = mysqli_query($conn, $sql_amount);
    $row_amount = mysqli_fetch_assoc($result_amount);
    $amount = $row_amount['amount'];

    $sql_tran = "UPDATE transactions SET amount = '$amount' WHERE transactid='$transactid'";
    $result_tran = mysqli_query($conn, $sql_tran);

  }

  if ($shipping != null){
    $sql = "SELECT price FROM orders where orderid='$orderid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $new_amount = $row['price'] + $shipping;

    $sql_upd = "UPDATE orders SET price = '$new_amount' WHERE orderid='$orderid'";
    $result_upd = mysqli_query($conn, $sql_upd);

    $sql_amount = "SELECT sum(price) 'amount' FROM orders where transactid='$transactid'";
    $result_amount = mysqli_query($conn, $sql_amount);
    $row_amount = mysqli_fetch_assoc($result_amount);
    $amount = $row_amount['amount'];

    $sql_tran = "UPDATE transactions SET amount = '$amount' WHERE transactid='$transactid'";
    $result_tran = mysqli_query($conn, $sql_tran);

  }


  mysqli_close($conn);
  header("Location: ../orders.php?transactid=$transactid");
