<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
?>

<link rel="stylesheet" type="text/css" href="cssweb/addcompany.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<form method="POST" enctype="multipart/form-data">

<td><input type="file" name="uploadphoto" ></td></tr>
<tr><td colspan="2" align="center"><input type="submit" name="save" value="save"></td></td>
</form>
</body>
</html>
<?php

@$b=$_FILES['uploadphoto']['name'];


if (isset($_POST['save'])) {
	$sql="INSERT INTO phototest VALUES ('$b')";
	$exec=mysqli_query($sql);
	if($exec){
	move_uploaded_file($_FILES['uploadphoto']['tmp_name'],"./logos\ ".$_FILES['uploadphoto']['name']);
	echo "<script type='text/javascript'>alert('data is inserted');</script>";
}
else{
	echo "<script type='text/javascript'>alert('not inserted');</script>";
	
}}
?>
