<?php
include("includes/connection.php");

if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
}
$id=$_SESSION['employeeid'];
?>
<html>
<head><TITLE>Radiant Insurance Company</TITLE>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<body>
<?php include("includes/header.php");?>
<div id="navbar">
<ul>
<li><a href="emppage.php">Home</a></li>
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
<div id='res'>



	<?php

	echo "<H2>New Claim </H1>";
$sl="SELECT claim.*,clients.emp_id,clients.firstname as fnamee,clients.lastname as lnamee,clients.id_client,employees.firstname,
employees.lastname FROM claim,clients,employees where claim.id_client=clients.id_client
and clients.emp_id=employees.emp_id and employees.emp_id='$id' and status='unread' order by claim_time desc";
$query=mysql_query($sl)or die(mysql_error());
if(mysql_num_rows($query)>0){


while ($row=mysql_fetch_array($query)) {

	?>
	<div id='head'>Name:<?php echo$row['fnamee']." ".$row['lnamee'];?></div>
	<?php echo htmlentities($row['description']);?><br/>
	
	<div id='file'>More Details:<label><?php echo $row['attachments'];?></label>
	<a href='down.php?file=<?php echo $row['attachments'];?>'>
	Download<img src='insurance/dw.png' height='23'></a>
	
<div><?php echo $row['claim_time'];?><br>
		<a href='feedback.php?client=<?php echo $row['id_client'];?>&id=<?php echo $row['claim_id'];?>'>Send Answer To the Clients</a></div>
<?php
}
echo "<br>";


}else{
	echo "No New Claim You have Please";
}

	?>
<hr>
	<?php

	echo "<H2>Old Claim</H1>";
$sl="SELECT claim.*,clients.emp_id,clients.firstname as fname,clients.lastname as lname,clients.id_client,employees.firstname,
employees.lastname FROM claim,clients,employees where claim.id_client=clients.id_client
and clients.emp_id=employees.emp_id and employees.emp_id='$id' and status='read'";
$query=mysql_query($sl)or die(mysql_error());
if(mysql_num_rows($query)>0){


while ($row=mysql_fetch_array($query)) {

	?>
	<div id='head'>Client's Name:<?php echo$row['fname']." ".$row['lname'];?></div>
	<?php echo htmlentities($row['description']);?><br/>
	
	<div id='file'>More Details:<label><?php echo $row['attachments'];?></label>
	<a href='down.php?file=<?php echo $row['attachments'];?>'>
	Download<img src='insurance/dw.png' height='23'></a>
	
<div><?php echo $row['claim_time'];?><br>
		<a href='feedback.php?client=<?php echo $row['id_client'];?>'>Send Answer To the Clients</a></div>

<?php
}

}else{
	echo "No Claim You have Please";
}

	?>

</div>
<style>
#file label{color:orange;}
#head{font-weight:bold;}
	#res{border-radius:3px;border:1px solid grey;display:block;margin-top:100px;font-family:segoe UI;box-shadow:0 0 1px #ddd;width: 1195px;}
</style>
</body>
</html>
<?php include("includes/footer.php");?>