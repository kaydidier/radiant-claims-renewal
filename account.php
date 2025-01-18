<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
$a=$_POST['fname'];
$b=$_POST['lname'];
$c=$_POST['dob'];
$d=$_POST['sex'];
$e=$_POST['uname'];
$f=$_POST['pass'];
$g=$_POST['email'];
$h=$_POST['phone'];
$sql="INSERT INTO employees VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h')";
$ec=mysqli_query($sql)or die(mysqli_error());
if($ec){
	echo "data is inserted";	
}
else{
echo "not inserted";
	}

?>