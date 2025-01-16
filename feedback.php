<?php
include ("includes/connection.php");

if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
}
@$client=$_GET['client'];
?>
<html>
<head>
<title>Radiant Insurance Company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<?php include("includes/header.php");
?>
<div id="navbar">
<ul>
<li><a href="emppage.php">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php?action=add">New</a></li>
<li><a href="empclient.php">View</a></li>
</ul>
</li>
<li><a href="claimed.php">claimed</a></li>
<li><a href="ansfeed.php">Feedback</a></li>
<!--<li><a href="#">Products</a></li>-->
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<form method="POST" action="">

<center>
<div id="feed">
<table>
<tr><td><p id="header">Send Feedback to Client</p></td></tr>
<tr><td><textarea cols="55" rows="15" id="tv" name="msg" required></textarea></td>
<td><input type="submit" value="send" name="snd" ></td></tr>
</table>
</div>
</center>
</form>
</body>
</html>
<?php include("includes/footer.php");?>
<?php
$id=$_GET['id'];
$now=date("Y-m-d");

@$a=mysql_real_escape_string($_POST['msg']);
if(isset($_POST['snd'])){
$send1="INSERT INTO feedback values('null','$a','$now','$client')";
$execmsg=mysql_query($send1)or die(mysql_error());
if($execmsg){
	echo "<script type='text/javascript'>alert('sent');</script>";
}
else{
	echo "<script type='text/javascript'>alert('not sent try again');</script>";
}
}
?>
<?php 

mysql_query(" UPDATE claim set status='read' where claim_id='$id'")or die(mysql_error());
?>