<?php
include("includes/connection.php");
	if(isset($_POST['save'])){
$id=$_POST['id'];
$a=$_POST['fname'];
$b=$_POST['lname'];
$c=$_POST['uname'];

$d=$_POST['email'];
$e=$_POST['sector'];
$f=$_POST['phone'];
$g=$_POST['idno'];
	$sql="UPDATE clients set firstname='$a',lastname='$b',
	username='$c',email='$d',sector='$e',
	,phonenumber='$f', ID_no='$g' where id_client='$id'";
	$exec=mysqli_query($sql) or die(mysqli_error());
	if($exec){
header("location:empclient.php");
}
}
?>