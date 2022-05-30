<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<title>Page Title</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
</head>
<body>
	<div>
		<p>句子文件上傳</p>
		<form method="post" enctype="multipart/form-data" action="uploadCSV.php">
		  <input type="file" name="my_file" accept=".csv">
		  <input type="submit" value="Upload"><br>
		</form>
	</div>

	<div>
		<form action="" method="post">
			MarkerID<input type="text" name="name"><br>
		<input type="submit"><br>
		<?php
			require_once("conndb.php");
			$sql = "SELECT MarkerID FROM marker";
			$result = mysqli_query($conn, $sql);
			$row = mysqli_fetch_array($result);
			if(empty(!@$_POST["name"]) && $_POST["name"] == $row[0]){//https://blog.davidou.org/archives/827
				$sql = "SELECT * FROM information";
				$result = mysqli_query($conn, $sql);
				echo '標記人員帳號 : '.$_POST["name"];
				echo "<table border='1'>";
				while($row = mysqli_fetch_array($result)){
					echo '<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
				}
				echo "</table>";
				/*$sql = "SELECT SentenceID FROM sentence ORDER BY Id ASC";
				$result = mysqli_query($conn, $sql);

				//$row = mysqli_fetch_array($result);
				while($row = mysqli_fetch_array($result)){
					echo $row["SentenceID"]."<br>";
				}	*/
			}
		?>
	</div>
</form>
</body>
</html>