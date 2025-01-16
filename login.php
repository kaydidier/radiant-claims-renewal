<?php
include("includes/connection.php");
session_start();
?>
<html>
<head><TITLE>Radiant Insurance Company</TITLE>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">


<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>

<?php include("includes/header.php");
?>
<center></center>
<div id="navbar">
<ul >
<li><a href="index.php">Home</a></li>
<li><a href="#">AboutUs</a></li>
<li><a href="contactus.php">ContactUs</a></li>
<li><a href="#">Products&Services</a></li>
<li><a id="lgn">Login</a></li>
<li><a href="">Gallery</a></li>
</ul>
</div>

<img src="insurance/radiant.jpg" id="photo" align="left">
<div id="login">
<form method="POST">

</form>
</div>
<div id="nac">

</div>

</body>
</html><?php
if (isset($_POST['login'])){
$ab=$_POST['uname'];
    $bc=$_POST['pass'];
    $a=mysql_real_escape_string($ab);
    $b=mysql_real_escape_string($bc);
$sql1=mysql_query("SELECT * FROM admin where username='$a'and password='$b'") or die(mysql_error());
$sql2=mysql_query("SELECT * FROM employees  where username='$a' and password='$b'")or die(mysql_error());
$sql3=mysql_query("SELECT * FROM clients where username='$a' and password='$b'")or die(mysql_error());
//var_dump($row1);

if(mysql_num_rows($sql1)>0){
	$rowid=mysql_fetch_array($sql1);
	$_SESSION['adminid']=$rowid['ad_id'];
	header("location:adminpage.php");
}
	else{
		if (mysql_num_rows($sql2)>0) {
	$rowid=mysql_fetch_array($sql2)or die(mysql_error());
	$_SESSION['employeeid']=$rowid['emp_id'];
		header("location:emppage.php");
		}else{
			if(mysql_num_rows($sql3)>0) {
			$rowid=mysql_fetch_array($sql3)or die(mysql_error());
	$_SESSION['clientid']=$rowid['id_client'];
	header("location:clientpage.php");
			}else{
				$msg="<tr><td colspan='2'>enter your Username or<br>password which is correctly</td></tr>";
				header("location:index.php");
		}
        }
		}
	    }
        ?>
        <?php include("includes/footer.php");?>