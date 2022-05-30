<!DOCTYPE html>
<html>
<head>
	<title>Page Title</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

	<style type="text/css">
		.rwd-table {
		 background: #fff;
		 overflow: hidden;
		}

		.rwd-table tr:nth-of-type(2n){
		  background: #eee;
		}
		.rwd-table th, 
		.rwd-table td {
		  margin: 0.5em 1em;
		}
		.rwd-table {
		  min-width: 100%;
		}

		.rwd-table th {
		  display: none;
		}

		.rwd-table td {
		  display: block;
		}

		.rwd-table td:before {
		  content: attr(data-th) " : ";
		  font-weight: bold;
		  width: 6.5em;
		  display: inline-block;
		}

		.rwd-table th, .rwd-table td {
		  text-align: left;
		}

		.rwd-table th, .rwd-table td:before {
		  color: #D20B2A;
		  font-weight: bold;
		}

		@media (min-width: 360px) {
		  .rwd-table td:before {
			display: none;
		  }
		 .rwd-table th, .rwd-table td {
			display: table-cell;
			padding: 0.25em 0.5em;
		  }
		  .rwd-table th:first-child, 
		  .rwd-table td:first-child {
			padding-left: 0;
		  }
		  .rwd-table th:last-child, 
		  .rwd-table td:last-child {
			padding-right: 0;
		  }
		   .rwd-table th, 
		   .rwd-table td {
			padding: 1em !important;
		  }
		}
	</style>

</head>
<body>
	<nav class=" fixed-top navbar navbar-expand-sm bg-light navbar-light">
		<a class="navbar-brand" href="#">Logo</a>
		<ul class="navbar-nav">
			<li class="nav-item active">
				<a class="nav-link" href="#">Active</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>
	</nav>
	<div class="container" style="margin-top:80px">
		<div class="row">
			<div class="col-md-12 col-sm-6">
				<table class="rwd-table ">
				  <tr>
					<th>旅遊名稱</th>
					<th>出發日</th>
					<th>售價</th>
					<th>機位</th>
					<th>可售</th>
				  </tr>
				  <?php #https://stackoverflow.com/questions/7462043/css-in-php-echo/7462088
						require 'conndb.php';
						$sql = "SELECT * FROM marker WHERE MarkerID = '".$_COOKIE["UserName"]."'";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_array($result);
						$obj = json_decode($row[1],true);
						//$obj["Scope"][0]["SentenceID"];
						/*for($i=0;$i<count($obj["Scope"]);$i++){
							echo  "<tr>" ,
								  "<td><button type=button class=\"btn btn-primary btn-lg\" onclick=alert('Angry')>害怕</button></td>",
								  "<td>第一句</td>",
								  "<td>第一句</td>",
								  "<td>第一句</td>",
								  "<td>第一句</td>",
								  #echo    "<td>第一句</td>" ;,
								  "</tr>" ;
						}*/
						//https://jscorpio.pixnet.net/blog/post/30454572
						//https://dotblogs.com.tw/jellycheng/2011/03/17/21884
						for($i=0;$i<count($obj["Scope"]);$i++){
							echo $obj["Scope"][$i]["Mark"];
							if($obj["Scope"][$i]["Mark"] == "true"){
								$btnColor = "btn-primary";
							}else{
								$btnColor = "btn-danger";
							}
							if($i%5 == 0){
							    //echo '<tr><td>'.$obj["Scope"][$i]["SentenceID"].'</td>';
								echo '<tr><td><button type=button class=\'btn '. $btnColor .' btn-lg\' onclick=alert("Angry")>'.$obj["Scope"][$i]["SentenceID"].'</button></td>';
							}
							elseif($i%5 == 4){
							    echo '<td><button type=button class=\'btn '. $btnColor .' btn-lg\' onclick=alert("Angry")>'.$obj["Scope"][$i]["SentenceID"].'</button></td></tr>';
							}
							else{
							    echo '<td><button type=button class=\'btn '. $btnColor .' btn-lg\' onclick=alert("Angry")>'.$obj["Scope"][$i]["SentenceID"].'</button></td>';
							}
						}
				  ?>
				</table>
			</div>
		</div>
	</div>
</body>
</html>