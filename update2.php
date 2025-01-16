<?php
include("includes/connection.php");
	if(isset($_POST['save'])){
$id=$_POST['id'];
$a=$_POST['fname'];
$b=$_POST['lname'];
$e=$_POST['uname'];
$f=$_POST['pass'];
$g=$_POST['email'];
$h=$_POST['phone'];
	$sql="UPDATE employees set firstname='$a',lastname='$b',
	username='$e',password='$f',
	email='$g',phonenumber='$h' where emp_id='$id'";
	$exec=mysql_query($sql) or die(mysql_error());
	if($exec){
header("location:employees.php");
}
}
?>