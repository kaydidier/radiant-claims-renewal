<?php
include ("includes/connection.php");

if (!$_SESSION['clientid']) {
header("LOCATION:index.php");
}
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
<li><a href="clientpage.php">Home</a></li>
<li><a href="clientaccount.php">MyAccount</li>

<li><a href="claim.php">Claim</a></li>
<li><a href="cliansfeed.php">View Feedback</a></li>


<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>

<form method="POST" action="">

<center>
<div id="fat">
<table style="margin-left:-200px;width:700px;margin-top:40px;">
<tr id="row">
<td id="ay">n<sup>o</sup></td>


<td id="ay">Feedback</td>
<td id="ay">Date</td>
<?php
$sel=mysql_query("SELECT distinct feedback.date,feedback.feedmsg from feedback where feedback.id_client={$_SESSION['clientid']}");
$a=1;
while($row=mysql_fetch_array($sel)){
	?>
	<tr>
<td><?php echo $a;?></td> 

<td><?php echo $row['feedmsg'];?></td>
<td><?php echo $row['date'];?></td>
</tr>
	<?php
	$a++;}
?>
</table>
</div>

</form>
</body>
</html>
<?php include("includes/footer.php");?>
