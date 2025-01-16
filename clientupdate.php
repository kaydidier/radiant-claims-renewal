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
$exec=mysql_query($sql)or die(mysql_error());
$row=mysql_fetch_array($exec);
//var_dump($row);


?>

<table>
<tr><td>First-name:</td>
<td><input type="text" name="fname" placeholder="enter firstname" value="<?php echo $row['firstname'];?>"></td></tr>
<tr><td>Last-name:</td>
<td><input type="text" name="lname" placeholder="enter lastname" value="<?php echo $row['lastname'];?>"></td></tr>
<tr><td>Username:</td>
<td><input type="text" name="uname" placeholder="enter Username" value="<?php echo $row['username'];?>"></td></tr>

<tr><td>E-mail:</td>
<td><input type="email" name="email" placeholder="enter E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"
value="<?php echo $row['email'];?>"></td></tr>


<tr><td>province:</td>
<td><select name="province" >
<?php
	$province=mysql_query("SELECT * from province");
	
	$i=0;
	while ($row=mysql_fetch_array($province)) {
		 {
			$i++;
			if ($i==1) {
				$initialProvince=$row['provinceId'];
			}
		
		?>
		<option <?php echo "selected" ?> value="<?=$row['provinceId'] ?>" ><?php echo $row['provinceName']; ?></option>
<?php
		
	}
}
?>
</select>
</td></tr>
<tr><td>District:</td>
<td>
<div id="districts">
<select name="district">
<?php
	$district=mysql_query("SELECT district.* from district,province WHERE province.provinceId=district.provinceId and district.provinceId='$initialProvince'");
	
	$i=0;
	while ($row=mysql_fetch_array($district)) {
		 
			
		?>
		<option <?php echo "selected" ?> value="<?=$row['provinceId'] ?>" > <?php echo $row['districtName']; ?></option>
<?php
		
	}
?>
</select>
</div>
</td></tr>

<tr><td>Sector:</td>
<td><input type="text" name="sector" placeholder="enter Sector" value="<?php echo $row['sector'];?>"></td></tr>


<tr><td>Phone:</td>
<td><input type="text" name="phone" placeholder="enter phonenumber" value="<?php echo $row['phonenumber'];?>"></td></tr>
<tr><td>ID-NO:</td>
<td><input type="text" name="idno" placeholder="enter identity-number" maxlength="16" value="<?php echo $row['ID_no'];?>"></td></tr>


<tr><td colspan="2" align="center"><input type="submit" href="nextinsert.php" name="save" value="Save"></td></td>
</table>