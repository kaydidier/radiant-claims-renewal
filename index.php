<?php
include("includes/connection.php");

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
<style type="text/css">
#reset a{text-decoration: none;}

</style>
<?php include("includes/header.php");
?>
<center></center>
<div id="navbar">
<ul >
<li><a href="index.php">Home</a></li>
<li><a href="aboutus.php">AboutUs</a></li>
<li><a href="contactus.php">ContactUs</a></li>
<li><a href="proser.php">Services</a></li>
<li><a href="index.php" id="lgn">Login</a></li>
<li><a href="gallery.php">Gallery</a></li>
</ul>
</div>
<img src="insurance/radiant.jpg" id="photo" align="left">
<div id="login">
<form method="POST">
<table id="lg">
<tr><td><p id='tt' align="center">Login Here To Continue</p></td></tr>
<tr><td><input type="text" name="uname" placeholder="enter Username" required></td></tr>
<tr><td><input type="password" name="pass" placeholder="enter Password" required></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" name="login" value="Login">


</tr>
<!--<tr><td align="center"><a href="aaa"><p id="sa">Forget Password</p></a></td></tr>-->
<?php
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
	header("location:employees.php");
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
				echo $msg="<center><tr><td colspan='4' id='nop'>enter your Username or<br>password which is correct</td></tr></center>";
				//header("location:index.php");
		}
        }
		}
	    }
        ?>
</table>
<!--<div id="forgot">

<table id="lg">
<tr><td><p id='bc' align="center">Forgot your Password</p></td></tr>
<tr><td><input type="text" name="uname" placeholder="enter your idno" required></td></tr>
<tr><td><input type="password" name="pass" placeholder="enter your email" required></td></tr>
<tr><td colspan="2" align="center">
<input type="submit" name="login" value="Forgot"></td>
</tr>
</table>
</div>-->
</form>
</div>
<div id="nac">
<p>
<p><b>WELCOME TO RADIANT INSURANCE COMPANY</b><br>
We provide many services and insurances in easy way. Come to RADIANT INSURANCE COMPANY
for Quick and Quality Service that you will never find
elsewhere.</p>
<p >
We thank all of you that have insured with us so far
and remind you that with RADIANT, "a promise is a
promise.</p>
<p>
Here you can login by using username and password branch-manager(employee)<br> gave you and <br>
you can see your insurance information and<br> you can
claim your accident.<br>
and then you get Feedback <br>For more information,<br>please call:
0788 38 64 39 <br> 0788 38 64 41 / 0788 38 28 58
</p>
<p><strong>Our HOTLINE:2050</strong></p>
</div>

</body>

</html>
        <?php include("includes/footer.php");?>



