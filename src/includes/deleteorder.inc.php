  <?php
  require '../dbh.php';

  $orderid = $_GET['orderid'];
  $transactid = $_GET['transactid'];
  $itemid = $_GET['item'];

  $sql = "DELETE FROM orders where transactid='$transactid' and orderid='$orderid'";
  $result = mysqli_query($conn, $sql);

  $sql_a= "UPDATE items set status='available' WHERE id='$itemid'";
  $result_a = mysqli_query($conn, $sql_a);

  $sql_amount = "SELECT sum(price) 'amount' FROM orders where transactid='$transactid'";
  $result_amount = mysqli_query($conn, $sql_amount);
  $row_amount = mysqli_fetch_assoc($result_amount);
  $amount = $row_amount['amount'];

  $sql_tran = "UPDATE transactions set amount = '$amount' WHERE transactid='$transactid'";
  $result_tran = mysqli_query($conn, $sql_tran);



  header("Location: ../orders.php?transactid=$transactid");
  mysqli_close($conn);
