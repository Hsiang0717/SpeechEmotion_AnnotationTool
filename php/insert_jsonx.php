<?php 
require 'conndb.php';

$name ="M0833001";
/*$sql = "SELECT * FROM marker WHERE MarkerID = '".$name."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$obj = json_decode($row[1],true);*/
//echo count($obj["Scope"]);

$data1 = "1";

$sql = "SELECT SentenceID FROM sentence ORDER BY Id ASC";
$result = mysqli_query($conn, $sql);
	while($row = mysqli_fetch_array($result)){
		echo $row["SentenceID"]."<br>";
			$sql = "UPDATE marker SET Recoders = JSON_ARRAY_APPEND(Recoders, '$.Scope', 
		JSON_OBJECT('EpisodeID','".$data1."','Sentiment','','SentenceID','".$row["SentenceID"]."')) 
		WHERE MarkerID = '".$name."'";
		mysqli_query($conn, $sql);
	}	

/*$sql = "UPDATE marker SET Recoders = JSON_ARRAY_APPEND(Recoders, '$.Scope', 
	JSON_OBJECT('EpisodeID','".$data1."','Sentiment','','SentenceID','".$data2."')) 
	WHERE MarkerID = '".$name."'";
$result = mysqli_query($conn, $sql);*/
//echo $sql;
?>
