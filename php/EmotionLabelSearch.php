<?php
function execSQL($str){
	require 'conndb.php';
	mysqli_set_charset($conn, "utf8");//https://jscorpio.pixnet.net/blog/post/30418829
	$result = mysqli_query($conn, $str);
	return $result;
}

if (isset($_GET['s'])) {

	echo "你輸入的是 : ".$_GET['s']."<br>";
	$sql = "SELECT * FROM emotion_label WHERE word LIKE '%" . $_GET['s'] . "%'";
	// SQL 執行查詢
	$result = execSQL($sql);
	// SQL 搜尋錯誤訊息
	if (!$result) {
		echo ("錯誤：" . mysqli_error($con));
		exit();
	}
	// 搜尋無資料時顯示「查無資料」
	if (mysqli_num_rows($result) <= 0) {
		echo "請更換形容詞<br>";	
	}
	// 顯示查詢內容
	while ($row = mysqli_fetch_array($result)) {
        echo "情緒標籤為 : ".$row[2];
    }
}
else{
   echo "情緒標籤查詢...";
}
?>