<?php
require '../dbh.php';

$itemid = $_POST['itemid'];
$collectionid = $_POST['collectionid'];

$sql = "UPDATE items SET collection='31' WHERE id='$itemid'";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
header("Location: ../clearancesale.php");