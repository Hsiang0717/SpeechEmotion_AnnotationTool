<?php
require 'conndb.php';
//echo $_status;
$sentenceID = $_POST["SentenceID"];
$emotion = $_POST["emotion"];
$MarkTime = $_POST["MarkTime"];
$Num = $_POST["Num"];
$Remark = $_POST["Remark"];
$Ep = $_POST["Ep"];
$SaveKey = $_POST["SaveKey"];
$Status = $_POST["Status"];
//https://ithelp.ithome.com.tw/articles/10156786
if(isset($_COOKIE["UserName"])&& !empty($_COOKIE["UserName"]) && !is_null($_COOKIE["UserName"])){
		setcookie("UserName",$_COOKIE["UserName"],time()+3600);
	
			//ALTER TABLE tablename AUTO_INCREMENT = 1 初始化 id 值 https://hant-kb.kutu66.com/mysql/post_52776
		$sql = "INSERT INTO comprehensive_form (SentenceID, Sentiment, MarkerID, MarkTime, Status, Remark) 
			VALUES ('".$sentenceID."','".$emotion."','".$_COOKIE["UserName"]."','".$MarkTime."','".$Status."','".$Remark."')";

		mysqli_query($conn, $sql);


		//https://www.sqlshack.com/modifying-json-data-using-json_modify-in-sql-server/
		//https://kknews.cc/zh-tw/code/gm863nl.html 語法
		//https://ithelp.ithome.com.tw/articles/10196875
		//https://ithelp.ithome.com.tw/articles/10197074

		$sql = "UPDATE marker SET Recoders = json_set(Recoders,'$.Data[".$SaveKey."].Scope[".$Num."].Sentiment','".$emotion."') 
			WHERE MarkerID = '".$_COOKIE["UserName"]."' AND 
				JSON_EXTRACT(Recoders,'$.Data[".$SaveKey."].Scope[".$Num."].Sentiment') != '".$emotion."'";
		//查詢 SELECT JSON_EXTRACT(Recoders,'$.Scope[0].Mark') FROM marker
		//更新 UPDATE marker SET Recoders = json_set(Recoders,'$.Scope[0].Mark','true') WHERE MarkerID = 'S01' AND JSON_EXTRACT(Recoders,'$.Scope[0].Mark') = 'false';
		mysqli_query($conn, $sql);

		echo json_encode(array("sentenceID"=>$sentenceID, "emotion"=> $emotion,
					"MarkTime"=>$MarkTime,"Marker"=>$_COOKIE["UserName"]));
}else{
	echo "null";
}

?>
