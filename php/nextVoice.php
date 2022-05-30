<?php
function execSQL($str){
	require 'conndb.php';
	mysqli_set_charset($conn, "utf8");//https://jscorpio.pixnet.net/blog/post/30418829
	$result = mysqli_query($conn, $str);
	$row = mysqli_fetch_array($result);
	return $row;
}
//echo $_status;
//$q = $_POST["q"];
//echo $q;

$sql = "SELECT * FROM marker WHERE MarkerID = '".$_COOKIE["UserName"]."'";
$temp = execSQL($sql);
$obj = json_decode($temp[1],true);

$Nowsubtitle = "";
$Now = 0;
$Ep = 0;
$Status ="";
$All = 0;
$SaveKey = 0;

for($i=0 ; $i<count($obj["Data"]) ; $i++){
	for($j=0;$j<count($obj["Data"][$i]["Scope"]);$j++){
		$All = count($obj["Data"][$i]["Scope"]);
		if($obj["Data"][$i]["Scope"][$j]["Sentiment"] == ""){
			 $Nowsubtitle = $obj["Data"][$i]["Scope"][$j]["SentenceID"];
			 $Ep = $obj["Data"][$i]["EpisodeID"];
			 $Now = $j;
			 $Status = $obj["Data"][$i]["Status"];
			 $SaveKey = $i;
			 break 2; //https://www.itread01.com/content/1550147427.html
		}
	}
}

$sql = "SELECT * FROM sentence WHERE SentenceID = '".$Nowsubtitle."'";
$temp = execSQL($sql);
$tempID=$temp[0];
$content = $temp[2];

$sql = "SELECT * FROM sentence WHERE Id = '".($tempID-1)."'";
$temp = execSQL($sql);
$content2 = $temp[2];

$sql = "SELECT * FROM sentence WHERE Id = '".($tempID+1)."'";
$temp = execSQL($sql);
$content3 = $temp[2];


echo json_encode(array("voiceID"=>$Nowsubtitle, "Nowsentence"=> $content,
			"Prevsentence"=>$content2,"Nextsentence"=>$content3,"Now"=>($Now),
			"All"=>$All,"Status"=>$Status,
			"EpisodeID"=>$Ep,"SaveKey"=>$SaveKey));

?>