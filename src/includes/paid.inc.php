  <?php
  require '../dbh.php';

  $transactid = $_GET['transactid'];

  $sql = "UPDATE transactions SET status='unpaid' where transactid = '$transactid'";
  $result = mysqli_query($conn, $sql);

  $sql_status = "UPDATE items JOIN orders on items.id = orders.item join transactions ON transactions.transactid = orders.transactid SET items.status='reserved' WHERE transactions.transactid='$transactid'";
  $result_status = mysqli_query($conn, $sql_status);

  mysqli_close($conn);
  header("Location: ../transactions.php");
