<?php
include("includes/connection.php");
	if(isset($_POST['save'])){
$id=$_POST['id'];
$a=$_POST['fname'];
$b=$_POST['lname'];
$c=$_POST['uname'];
$d=$_POST['pass'];
$e=$_POST['email'];
$f=$_POST['phone'];
	$sql="UPDATE clients set 
	firstname='$a',lastname='$b',username='$c',password='$d',
	email='$e',phone='$f' where id_client='$id'";
	$exec=mysql_query($sql) or die(mysql_error());
	if($exec){
header("location:empclient.php");
}
}
?>