<?php
mysql_connect("localhost","root","");
mysql_select_db("vis");
?>
<html>
<head>
<style type="text/css">
</style>
<title>Insurance
</title>
<link rel="stylesheet" type="text/css" href="cssweb/addcompany.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<form method="POST" enctype="multipart/form-data">
<center><img src="insurance/ban.jpg" id="ban"></center>
<div id="navbar">
<ul>
<li><a href="#">Home</a></li>
<li><a href="clients.php">Clients</a></li>
<li><a href="company.php">Companies</a>
<ul><li><a href="addcompany.php">AddCompany</a></li>
<li><a href="company.php">ViewCompany</a></li>
</ul>
</li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="insert">
<table>

<tr><td>Company-name:</td>
<td><input type="text" name="cname" placeholder="company name"></td></tr>
<tr><td>company-logo</td>
<td><input type="file" name="uploadphoto" ></td></tr>
<tr><td>Company-Slogan:</td>
<td><input type="text" name="cslogan" placeholder="company Slogan"></td></tr>
<tr><td>Cell:</td>
<td><input type="text" name="ccell" placeholder="cell"></td></tr>
<tr><td>Sector:</td>
<td><input type="text" name="csector" placeholder="sector"></td></tr>
<tr><td>District:</td>
<td><input type="text" name="cdistrict" placeholder="district"></td></tr>
<tr><td>Phone:</td>
<td><input type="text" maxlength="13" name="cphone" placeholder="phone"></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="cpass" placeholder="Password"></td></tr>
<tr><td>E-mail:</td>
<td><input type="text" name="cemail" placeholder="E-mail"></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="save" value="save"></td></td>
</table>
</div>
</form>
</body>
</html>
<?php
@$a=$_POST['cname'];
@$b=$_FILES['uploadphoto']['name'];
@$c=$_POST['cslogan'];
@$d=$_POST['ccell'];
@$e=$_POST['csector'];
@$f=$_POST['cdistrict'];
@$g=$_POST['cphone'];
@$h=$_POST['cpass'];
@$i=$_POST['cemail'];
if (isset($_POST['save'])) {
$sql="INSERT INTO company VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h', '$i')";
$sq="SELECT * FROM company WHERE email='$i' AND phonenumber='$g' AND company_slogan='$c'";
$e=mysql_query($sq);
if(empty($a) or empty($b) or empty($c) or empty($d) or empty($e)
or empty($f) or empty($g) or empty($h) or empty($i)){
echo "<script type='text/javascript'>alert('empty');</script>";
}
else if ($e){
	echo "<script type='text/javascript'>alert('duplication data');</script>";	

}
else{
move_uploaded_file($_FILES['uploadphoto']['tmp_name'],"./images\ ".$_FILES['uploadphoto']['name']);
	echo "<script type='text/javascript'>alert('inserted');</script>";
	
}}
?>
