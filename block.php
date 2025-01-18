<?php
mysql_connect("localhost","root","");
mysql_select_db("vis");
$id=$_GET['id'];
$type=$_GET['type'];
if ($type=='block') {
	$t='true';
}else{
	$t='false';
}
$query=mysqli_query("UPDATE company set blocked='$t' where c_id='$id'");
if ($query) {
	header("location:company.php");
}
?>
