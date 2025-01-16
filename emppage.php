<?php

include("includes/connection.php");
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
//var_dump($_SESSION['adminid']);


//if (!$_SESSION['admin']) {
	//header("location:login.php");
	//}

}
?>
<html>
<head><title>Radiant insurance compnany</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">
<script>

</script>
</head>
<body>
<?php include("includes/header.php"); ?>
<form method="POST" action="">
<?php
$sql=mysql_query("SELECT * FROM employees WHERE emp_id={$_SESSION['employeeid']}") or die(mysql_error());
$rowname=mysql_fetch_array($sql,MYSQL_ASSOC);
?>
<div id="navbar">
<ul>
<li><a href="#">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php?action=add">New</a></li>
<li><a href="empclient.php">View</a></li>
</ul>
</li>
<li><a href="upgrades.php">Upgrades</a></li>
<li><a href="claimed.php">claimed</a></li>
<li><a href="ansfeed.php">Feedback</a></li>
<!--<li><a href="#">Products</a></li>-->
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
</form>
<center>
<div id="emppa">
<p>Welcome&nbsp<?= $rowname['username'];?>&nbsp
Here you can register client and you can manage clients and then you give username and password to the 
clients and you can view all clients which make claim and then you give answer(feedback)
and you can view all clients who make upgrades and then you can confirm it or deny it his/her upgrades
</center>
</div> 
</body>
</html>
<?php include("includes/footer.php");?>
