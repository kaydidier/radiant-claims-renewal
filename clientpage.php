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
<link rel="stylesheet" type="text/css" href="cssweb/settingdrop.css">
<script src='js/jquery.js'></script>
<script src='js/jquery-ui.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
</head>
<body>
<script>
	$(document).ready(function(){
		$("#change").hide();
		$("#pass").click(function(){
				$("#change").show();



		});
			
	
			});
		
	
	</script>
<style type="text/css">
	

#change {box-shadow:0 0 0px black;width: 200px;margin-left: 620px;margin-top: -380px;height: 360px;border: 0px solid #ddd;
width: 500px;}
#change table{border: 1px solid #ddd;}
#pass {border: 0px solid #ddd;margin-left: 620px;margin-top: -400px;height: 390px;width: 550px;}
#pass p :hover{cursor: pointer;}
#change input[type="password"]{border: 1px solid #ddd;height: 30px;width: 280px;}
#change table input[type=submit]{padding:10px;border-radius:4px;
border:1px solid #66c5f7;background:#10a4f0;font-family:arial;
color:white;cursor:pointer;font-size: 16px;}
#change table input[type=submit]:hover{
	transition:all 0.6s ease;}
</style>
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

<div>
<table>
<tr><td>	
</table>	



</div>


<?php
$sql=mysql_query("SELECT * FROM clients WHERE id_client={$_SESSION['clientid']}") or die(mysql_error());
$rowname=mysql_fetch_array($sql,MYSQL_ASSOC);
?>
<center>
<div id="clie">
<p>Welcome&nbsp<?= $rowname['username'];?> 
Here you can access our services like
upgrade your Insurance when your Insurance has Been end and you can claim your accident and you can must fill claim form  within 5 days after the accident
and after you wait for response  
whose Branch-manager(Employee)send to you and after we Repair your Property
</p>
</div>
<form method="POST">
<p id="pass">Change Your Password</p>
<div id="change">
<table>


<tr><td>Enter your Current-Password</td>
<td><input type="password" name="cpass" required></td></tr>
<tr><td>Enter New Password</td>
<td><input type="password" name="npass" required></td></tr>
<tr><td>Re-Type Password</td>
<td><input type="password" name="repass" required></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="change" value="Change"> 



</table>
</div>

</center>
</form>
<?php include("includes/footer.php");?>
</body>

</html>
<?php
if(isset($_POST['change'])){
$a=$_POST['cpass'];
$sql="SELECT * FROM clients where password='$a' and id_client={$_SESSION['clientid']}";
$exer=mysql_query($sql);

//var_dump($exer);
if(mysql_num_rows($exer)>0){
	$pass1=$_POST['npass'];
	$pass2=$_POST['repass'];
	if($pass1==$pass2){
		$update=mysql_query($sql = "UPDATE  clients set password='$pass2'
		where id_client={$_SESSION['clientid']}") or die(mysql_error());
//echo $sql;
	echo "<script type='text/javascript'>alert('password changed succesfully');</script>";
				
			
			}
			
	else {
			echo "<script type='text/javascript'>alert('passwords not match');</script>";
	}
}
	
		

}
?>

