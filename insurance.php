<?php

include("includes/connection.php");
if (!$_SESSION['adminid']) {
header("LOCATION:index.php");
}
//var_dump($_SESSION['adminid']);
//create connectionmysql_select_db("vis");//to select from the db
//if (!$_SESSION['admin']) {
	//header("location:login.php");
	//}
if(@$_GET['action']=='delete'){
	if (mysqli_query("DELETE FROM insurance WHERE insurance_id={$_GET['id']}")) {
		?>
		<script type="text/javascript">
		alert("insurance Successfully deleted");
		</script>
		<?php
	}
}
if(isset($_POST['update'])){
	$insname=$_POST['ins'];
	$insID=$_GET['id'];

	if (mysqli_query("UPDATE insurance set insurance_name='$insname' WHERE insurance_id='$insID'")or die(mysqli_error())) {
		?>
		<script type="text/javascript">
		alert("insurance Successfully updated");
		</script>
		<?php
	}
}
?>
<html>
<head><title>Radiant insurance company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">
<script>
$(document).ready(function(){
</script>
</head>
<body>
<?php include("includes/header.php");?>

<?php
$sql=mysqli_query("SELECT * FROM admin WHERE ad_id={$_SESSION['adminid']}") or die(mysqli_error());
$rowname=mysqli_fetch_array($sql,MYSQL_ASSOC);
?>
<div id="navbar">
<ul>
<li><a href="employees.php">Home</a></li>
<li><a href="">Employees</a>
<ul><li><a href="addemployee.php">New</a></li>
<li><a href="employees.php">View</a></li>
</ul>
</li>
<li><a href="insurance.php">Insurances</a></li>
<li><a href="allclients.php">Clients</a></li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="fetinsurance">
<center>
<table>
<tr id="row">
<td id="as">#</td>
<td id="as">InsuranceName</td>
<td id="as" colspan="2">Action</td>
<?php
$sql="select *from insurance";	
$exec=mysqli_query($sql);
$a=1;
while($row=mysqli_fetch_array($exec)){
	?>
	<tr>
<td><?php echo $a;?></td> 
<td><?php echo $row['insurance_name'];?></td>
<td><a href="?id=<?php echo $row['insurance_id'];?>&action=delete"><img src="insurance/delete.png" height="20" onclick="delete"></a></td>
<td><a href="?id=<?php echo $row['insurance_id'];?>&action=update"><img src="insurance/edit.png" height="20" onclick="update"></a></td>
</tr>
	<?php
	$a++;}
?>
<div id="all">
<?php
if (@$_GET['action']=='update') {
	
	$sql="select *from insurance where insurance_id={$_GET['id']}";	
	$exec=mysqli_query($sql);
	$rows=mysqli_fetch_array($exec);
}
?>
<form method="POST" <?php if (isset($_GET['update'])){
		?>
		value="?id=<?php echo $_GET['id'];?>&action=update"
		<?php
	} ?>>

<center>
<table border="0" id="insurance_tbl">
<tr><td>InsuranceName</td>
<td><input type="text" name="ins" required value="<?php echo @$rows['insurance_name']; ?>"></td></tr>
<?php if (@$_GET['action']=='update') { $label="update"; }else{ $label="send";} ?>
<tr><td colspan="2" align="center"><input type="submit" value="save" name="<?=$label ?>"></td></tr>
</table>
</center>
</form>
</div>

<style type="text/css">
	#insurance_tbl{margin-top: 80px;border: 1px solid #0eb6f8;font-family: century gothic;margin-bottom: 80px;margin-top: 40px;}
	#insurance_tbl input[type='text']{padding: 4px;margin: 3px;
	border:1px solid #ddd;width: 300px;height: 45px;font-size: 20px;
border-radius: 2px;}
#insurance_tbl input[type='submit']{font-family:arial;font-size: 20px;
background-color:#0eb6f8;color: white;border: 0px solid #ddd;
font-weight: bold;}
#fetinsurance{margin-top: 40px;font-family: arial;margin-left: 30px;}
#all{border:0px solid black;}
</style>


</body>
</form>
</html>
<?php include("includes/footer.php");?>

<?php

@$a=$_POST['ins'];
if(isset($_POST['send'])){
	$sql="INSERT into insurance values(null,'$a')";
$sq="SELECT * FROM insurance WHERE insurance_name='$a'";
$query=mysqli_query($sq)or die(mysqli_error());
if(empty($a)) {
echo "<script type='text/javascript'>alert('empty fields');</script>";
}
else if (mysqli_num_rows($query)>0){
	$rowquery=mysqli_fetch_array($query);
		if ($rowquery['insurance_name']) {
			
		echo "<script type='text/javascript'>alert('duplication data');</script>";
	}
		

}
else{
$insert=mysqli_query($sql)or die(mysqli_error());
if ($insert) {
	echo "<script type='text/javascript'>alert('Insurance Added Successfully');</script>";
}else{
	echo "<script type='text/javascript'>alert(' not Added');</script>";
}
	
	
}}
?>
