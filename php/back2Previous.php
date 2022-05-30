<?php
require 'conndb.php';
//echo $_status;
$sentenceID = $_POST["SentenceID"];
//$emotion = $_POST["emotion"];
$Num = $_POST["Num"];
$Ep = $_POST["Ep"];
$SaveKey = $_POST["SaveKey"];
$Status = $_POST["Status"];

$sentenceID = explode('_',$sentenceID)[0]."_".$Num;
$Num = $Num - 1 ;


if(isset($_COOKIE["UserName"])&& !empty($_COOKIE["UserName"]) && !is_null($_COOKIE["UserName"])){
	
		setcookie("UserName",$_COOKIE["UserName"],time()+3600);

		$sql = "UPDATE marker SET Recoders = json_set(Recoders,'$.Data[".$SaveKey."].Scope[".$Num."].Sentiment','') 
			WHERE MarkerID = '".$_COOKIE["UserName"]."' AND 
				JSON_EXTRACT(Recoders,'$.Data[".$SaveKey."].Scope[".$Num."].Sentiment') != ''";

		mysqli_query($conn, $sql);
		
		$sql = "DELETE FROM comprehensive_form WHERE SentenceID = '".$sentenceID."' AND MarkerID = '".$_COOKIE["UserName"]."' AND Status ='".$Status."'";

		mysqli_query($conn, $sql);

		echo "Success back";
}
else{
	echo "null";
}

?>
