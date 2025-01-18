<?php
include("includes/connection.php");
?>
<html>
<head><title>"web"</title>
<link rel="stylesheet" type="text/css" href="file.css">
<body bgcolor="white">
<style type="text/css">
#Tips{font-family:segoe UI;font-size:15px;background:grey;
	border-radius:3px;padding:10px;
	text-align:center;font-weight:lighter;background-color: #0eb6f8;
color: white;font-family: century gothic;font-size:17px;}
</style>

	<?php
$kv=$_GET['id'];

$sql="SELECT * from clients where id_client='$kv'";
$exec=mysqli_query($sql)or die(mysqli_error());
$row=mysqli_fetch_array($exec);
//var_dump($row);


?>



<html>
<head>
<title></title>
<body>
<table>
</table>
<form  method="POST" action='updateclient2.php'>
<center><table id="up">
<p><div id="Tips">Update Branch-Manager(Employee)</div></p>
<tr><td>First-Name</td>
<td><input type="text" name='fname' value="<?php echo $row['firstname'];?>"></td></tr>
<tr><td>Last-Name</td>
<td><input type="text" name='lname' value="<?php echo $row['lastname'];?>"></td></tr>
<tr><td>User-Name</td>
<td><input type="text" name='uname' value="<?php echo $row['username'];?>"></td></tr>
<tr><td>E-mail:</td>
<input type='hidden'value='<?=$row['id_client']?>'name=id>
<td><input type="email" name='email' value="<?php echo $row['email'];?>"></td></tr>
<tr><td>Phone:</td>
<td><input type="text" name="phone" value="<?php echo $row['phone'];?>"></td></tr>
<tr><td>Id-no:</td>
<td><input type="text" name="id-no" value="<?php echo $row['ID_no'];?>"></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="pass" value="<?php echo $row['password'];?>"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="save" value="Update">
</form>
</table>
</body><html>