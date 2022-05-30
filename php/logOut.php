<?php
	setcookie("UserName","",time()-3600);
	header("Location: index.php ");
?>