<?php
$con=mysql_connect("127.0.0.1","root","");
$db=mysql_select_db("radiant");
$i=mysqli_real_escape_string($_GET['id']);
$sql="DELETE FROM employees where emp_id='$i'";
$exec=mysqli_query($sql);
if ($exec) {
	echo "deleted";
}









?>