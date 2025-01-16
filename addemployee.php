<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
session_start();
if(!$_SESSION['adminid']){
header("location:index.php");
}
?>
<html>
<head>
<TITLE>Radiant insurance company</TITLE>
<link rel="shortcut icon" href="insurance/LOGO.png">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<script>
$(document).ready(function(){
$("#dat").datepicker({
	dateFormat:"yy-mm-dd",
    changeMonth:true,
    changeYear:true,
    yearRange:"c-190:c+10",
});
});
</script>
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<?php include("includes/header.php");
?>
<div id="navbar">
<ul>
<li><a href="employees.php">Home</a></li>
<li><a href="">Employees</a>
<ul><li><a href="addemployee.php">New</a></li>
<li><a href="employees.php">View</a></li>
</ul>
</li>
<li><a href="insurance.php">Insurances</a></li>
<li><a href="allclients.php">Clients</a></li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>

<form method="POST"id='form'>
<center><table id="add">
<tr><td colspan="2"><div align="center"id='Tips'>Add (branch-manager)Employee</div></td></tr>
<tr><td>Firstname:</td>
<td><input type="text" name="fname"id='first' placeholder="enter firstname" pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>Lastname:</td>
<td><input type="text" name="lname"id='last' placeholder="enter lastname" pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>DateOfBirth:</td>
<td><input type="text" name="dob" id="dat" placeholder="enter dob"></td></tr>
<tr><td>Sex:</td>
<td><select name="sex"id='sex'>

<option>Male</option>
<option>Female</option>
</select></td></tr>
<tr><td>Username:</td>
<td><input type="text" id='uname'name="uname" placeholder="enter username" pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>Password:</td>
<td><input type="password" id='pass'name="pass" placeholder="enter password"></td></tr>
<tr><td>E-mail:</td>
<td><input type="text" id='email'name="email" placeholder="enter email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"></td></tr>
<tr><td>Phone:</td>
<td><input type="text" name="phone"id='phone' placeholder="enter phone" pattern="07[2,3,8]{1}[0-9]{7}"></td></tr>
<tr><td>Id-no:</td>
<td><input type="text" name="idno"id='idno' placeholder="enter identity-number" pattern="[0-9]{16}" maxlength="16"></td></tr>

<?php

	//$sql=mysql_query("SELECT * FROM admin");
	//while($row=mysql_fetch_array($sql))
	//{
		
		//$a=$row['ad_id']."."." ".$row['firstname']." ".$row['lastname'];
		//echo $a;
	//}
	?>
<style>
#add input{border-radius:3px;width:100%;padding:5px;border:1px solid white;}




#add {background-color:#ddd;box-shadow:0 0 6px white;padding:5px;width:370px;margin-left: 100px;margin-top: 40px;height: 300px;}

#Tips{font-family:segoe UI;font-size:15px;background:grey;
	border-radius:3px;padding:10px;
	text-align:center;font-weight:lighter;background-color: #0eb6f8;
color: white;font-family: century gothic;font-size:17px;}
</style>
</select>
<tr><td align="center" colspan="2"><input type="submit" name="save" value="Save"id='button'></td></tr>
</table>
</center>
</form>
</body>
</html>

<?php include("includes/footer.php");?>
<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
@$a=mysql_real_escape_string($_POST['fname']);
@$b=mysql_real_escape_string($_POST['lname']);
@$c=mysql_real_escape_string($_POST['dob']);
@$d=mysql_real_escape_string($_POST['sex']);
@$e=mysql_real_escape_string($_POST['uname']);
@$f=mysql_real_escape_string($_POST['pass']);
@$g=mysql_real_escape_string($_POST['email']);
@$h=mysql_real_escape_string($_POST['phone']);
if (isset($_POST['save'])) {
	

$sql="INSERT INTO employees VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h')";
$sq="SELECT * FROM employees WHERE email='$g' or phonenumber='$h' or username='$e'";
$query=mysql_query($sq)or die(mysql_error());
if(empty($a)  or empty($b) or empty($c) or empty($d) or empty($e) or empty($f) or empty($g) or empty($h)){
	echo "<script type='text/javascript'>alert('empty fields');</script>";
	}
else if (mysql_num_rows($query)>0){
	$rowquery=mysql_fetch_array($query);
		if ($rowquery['email']==$g||$rowquery['phone']==$h) {
			
		echo "<script type='text/javascript'>alert('duplication data');</script>";
	}
		

}
else{
$insert=mysql_query($sql)or die(mysql_error());
if ($insert) {
	echo "<script type='text/javascript'>alert('Branch-manager Added Successfully');</script>";
}else{
	echo "<script type='text/javascript'>alert('Not Added TryAgain');</script>";
}
	
	
}}
?>