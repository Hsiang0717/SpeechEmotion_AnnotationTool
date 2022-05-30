<?php 
require 'conndb.php';


/*$sql = "SELECT * FROM marker WHERE MarkerID = '".$name."'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$obj = json_decode($row[1],true);*/
//echo count($obj["Scope"]);

$name ="M0833001";
$Status="audio";
$SentenceID ="u1GEQ3EZ4dc";
$EpisodeID = "10";

$sql = "UPDATE marker SET `Recoders` = JSON_ARRAY_APPEND(`Recoders`, 
		'$.Data',JSON_OBJECT('Status','".$Status."','Remarks','','EpisodeID','".$EpisodeID."','Scope',JSON_ARRAY())) 
				WHERE MarkerID = '".$name."'";		
mysqli_query($conn, $sql);

$sql = "SELECT JSON_LENGTH(Recoders, '$.Data') FROM `marker` WHERE MarkerID = '".$name."'";
$result = mysqli_query($conn, $sql);
$x = mysqli_fetch_array($result);
echo $x[0];
$x =$x[0]-1;

$sql = "SELECT SentenceID FROM sentence WHERE SentenceID LIKE '".$SentenceID."%' ORDER BY Id ASC";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_array($result)){
	//echo $row[0];
	$sql = "UPDATE marker SET `Recoders` = JSON_ARRAY_APPEND(`Recoders`, '$.Data[".$x."].Scope',JSON_OBJECT('Sentiment','','SentenceID','".$row[0]."')) WHERE MarkerID = '".$name."'";
	mysqli_query($conn, $sql);
}	
//echo $sql;
	
		
		
/*$sql = "UPDATE marker SET `Recoders` = JSON_ARRAY_APPEND(`Recoders`, 
		'$.Data',JSON_OBJECT('Status','','Remarks','','EpisodeID','','Scope',JSON_ARRAY(JSON_OBJECT(".$content.")))) 
				WHERE MarkerID = '".$name."'";
mysqli_query($conn, $sql);
echo $sql;*/
//UPDATE marker SET `Recoders` = JSON_ARRAY_APPEND(`Recoders`, '$.Data',JSON_OBJECT('Status','','Remarks','','EpisodeID','','Scope',JSON_ARRAY(JSON_OBJECT('Sentiment','','SentenceID','')))) WHERE MarkerID = 'M0833012'
	
/*$sql = "UPDATE marker SET Recoders = JSON_ARRAY_APPEND(Recoders, '$.Scope', 
JSON_OBJECT('EpisodeID','".$data1."','Sentiment','','SentenceID','".$row["SentenceID"]."')) 
WHERE MarkerID = '".$name."'";*/
//echo $sql;
?>
