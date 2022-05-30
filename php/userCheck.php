<?php
require 'conndb.php';
//echo $_status;
$pass = $_POST["pass"];

$sql = "SELECT * FROM marker WHERE MarkerID = '".$pass."'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

setcookie("UserName",$row[0],time()+3600);

//echo json_encode(array("name"=>$row[0], "information"=> $row[1]));
echo $row[0];
//echo $q;
?>