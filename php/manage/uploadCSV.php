<?php
	# 檢查檔案是否上傳成功https://blog.gtwang.org/programming/php-upload-files-tutorial/
	if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
	  echo '檔案名稱: ' . $_FILES['my_file']['name'] . '<br/>';
	  echo '檔案類型: ' . $_FILES['my_file']['type'] . '<br/>';
	  echo '檔案大小: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
	  echo '暫存名稱: ' . $_FILES['my_file']['tmp_name'] . '<br/>';

	  # 檢查檔案是否已經存在
	  if (file_exists('upload/' . $_FILES['my_file']['name'])){
		echo '檔案已存在。<br/>';
	  } else {
		$file = $_FILES['my_file']['tmp_name'];
		$dest = './' . $_FILES['my_file']['name'];//路徑

		# 將檔案移至指定位置
		move_uploaded_file($file, $dest);
	  }
	} else {
	  echo '錯誤代碼：' . $_FILES['my_file']['error'] . '<br/>';
	}
	
	//https://www.twblogs.net/a/5c343d04bd9eee35b3a54062
	
	function getFileData($file)
	{
		require 'conndb.php';
		mysqli_set_charset($conn,"utf8");
		echo $_status.'<br>';
		if (!is_file($file)) {
			exit('沒有文件');
		}

		$handle = fopen($file, 'r');
		if (!$handle) {
			exit('讀取文件失敗');
		}

		while (($data = fgetcsv($handle)) !== false) {
			// 跳過第一行標題
			if ($data[0] == 'SentenceID') {
				continue;
			}
			
			// 下面這行代碼可以解決中文字符亂碼問題
			$data[1] = mb_convert_encoding($data[1], "UTF-8", "big5");

			// data 爲每行的數據，這裏轉換爲一維數組
			//print_r($data);// Array ( [0] => tom [1] => 12 )
			echo $data[0]." ".$data[1]." ".$data[2]." ".$data[3]." ".$data[4].'<br><br>';
			
			$sql = "INSERT INTO sentence(SentenceID,Sentence,SentenceTime,ShowID,EpisodeID) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."')";
			//echo $sql.'<br>';
			mysqli_query($conn, $sql);
		}
		fclose($handle);
		unlink($_FILES['my_file']['name']);//將檔案刪除//https://pjchender.blogspot.com/2015/04/php.html
	}

	getFileData($_FILES['my_file']['name']);
?>