<?php
//http://jsnwork.kiiuo.com/archives/2738/xampp-mysql-phpmyadmin-%E8%A8%AD%E5%AE%9A-root-%E5%AF%86%E7%A2%BC/
$servername = "localhost";
$username = "M0833001";
$password = "hsiang703";
$dbname = "m0833001_test";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$_status = "Connected successfully";
//echo $_status;
?>