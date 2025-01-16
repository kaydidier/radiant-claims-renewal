<?php
include("includes/connection.php");
	if(isset($_POST['save'])){
$id=$_POST['id'];
$a=$_POST['insurance_name'];
$sql="UPDATE insurance set insurance_name='$a',
	 where insurance_id='$id'";
	$exec=mysql_query($sql) or die(mysql_error());
	if($exec){
header("location:empclient.php");
}
}
?>