<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
session_start();
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
}

?>
<html>
<head><title>Radiant insurance company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" type="text/css" href="cssweb/clientreg.css">
<style type="text/css">
	#insurance-form{
		float:left;
		width: 100%;
	}
	#navbar{
		z-index: 48;
	}
</style>
</head>
<body>

<?php include("includes/header.php");
?>
<div id="navbar">
<ul>
<li><a href="clientpage.php">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php">New</a></li>
<li><a href="empclient.php">View</a></li>
</ul>
</li>
<li><a href="claimed.php">claimed</a></li>
<li><a href="ansfeed.php">Feedback</a></li>
<!--<li><a href="#">Products</a></li>-->
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="main">

</div>
