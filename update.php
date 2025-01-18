<?php
include("includes/connection.php");
?>
<html>
<head><title>"web"</title>
<link rel="stylesheet" type="text/css" href="file.css">
<body bgcolor="white">

	<?php
$kv=$_GET['id'];

$sql="SELECT * from employees where emp_id='$kv'";
$exec=mysqli_query($sql)or die(mysqli_error());
$row=mysqli_fetch_array($exec);
//var_dump($row);


?>


<html>
<head><title>vis</title>

</head>
<body>
<script>
	
</script>	
<form  method="POST"action='update2.php'>
<center><table id="up">
<p id="pup" >Update Employee</p>
<tr><td>Firstname:</td>
<input type='hidden'value='<?=$kv?>'name='id'>
<td><input type="text" id='fname'name="fname" value="<?php echo $row['firstname'];?>"></td></tr>
<tr><td>Lastname:</td>
<td><input type="text" name="lname" value="<?php echo $row['lastname'];?>"></td></tr>
<tr><td>Username:</td>
<td><input type="text" name="uname" value="<?php echo $row['username'];?>"></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="pass" value="<?php echo $row['password'];?>"></td></tr>
<tr><td>E-mail:</td>
<td><input type="email" name="email" value="<?php echo $row['email'];?>"></td></tr>
<tr><td>Phone:</td>
<td><input type="text" name="phone" value="<?php echo $row['phonenumber'];?>"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="save" value="Save"></td></tr>
<?php 

	
	
	?>
</table>
</form>
</body>
</html>






























































	

	