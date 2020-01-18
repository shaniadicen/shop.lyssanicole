<?php
  require '../dbh.php';

  $itemName = $_POST['itemName'];
  $collectionName = $_POST['collectionName'];
  $price = $_POST['itemPrice'];
  $itemid = $_POST['itemid'];


  if ($itemName != null) {
    $sql = "UPDATE items SET name='$itemName' WHERE id='$itemid'";
    $result = mysqli_query($conn, $sql);
  }

  if ($price != null) {
    $sql = "UPDATE items SET price=$price WHERE id='$itemid'";
    $result = mysqli_query($conn, $sql);

    $sql_item = "UPDATE orders SET price='$price' WHERE item='$itemid'";
    $result_item = mysqli_query($conn, $sql_item);

    $sql_amount = "SELECT sum(price) 'amount' FROM orders where item='$itemid'";
    $result_amount = mysqli_query($conn, $sql_amount);
    $row_amount = mysqli_fetch_assoc($result_amount);
    $amount = $row_amount['amount'];

    $sql_tran = "UPDATE transactions t JOIN orders o ON t.transactid = o.transactid SET t.amount = '$amount' WHERE item='$itemid'";
    $result_tran = mysqli_query($conn, $sql_tran);
  }

  header("Location: ../collection.php?name=$collectionName");
  mysqli_close($conn);
