<?php
/*$conn = mysqli_connect("localhost", "root", "", "shoplyssanicole"); //WAMP Server*/
// $conn = mysqli_connect("localhost","root","root","shoplyssanicoletest"); //MAMP Server
$conn = mysqli_connect("localhost","id2374274_memeng","memeng26;","id2374274_shoplyssanicole"); //MAMP Server
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}