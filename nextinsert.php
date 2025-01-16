<?php
session_start();
include("includes/connection.php");
if (!$_SESSION['emplyeeid']) {
header("LOCATION:indx.php");
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
<div id="navbar">
<ul>
<li><a href="#">Home</a></li>
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
<center>
<div id="insert">
<center>	
<table>
<tr><td>Insurance:</td>
<td><select name="ins">

<option>FireInsurance</option>
<option>MotorInsurance</option></select>
</td></tr>
<tr><td>Start-Date</td>
<td><input type="text" name="sdate" ></td></tr>
<tr><td>End-Date</td>
<td><input type="text" name="edate" ></td></tr>
<tr><td>Price:/month</td>
<td><input type="text" name="price" ></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="pass" placeholder="enter Password"></td></tr>




</body>
</html>
<?php include("includes/footer.php");?>