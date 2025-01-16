<?php
include("includes/connection.php");

if (!$_SESSION['adminid']) {
header("LOCATION:index.php");
}
?>
<html>
<head>
<script src='js/jquery.js'></script>
<script src='js/jquery-ui.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
	<title>Radiant Insurance Company</title>
<script>
	$(function(){
		$("#dialog").dialog({
			autoOpen:false,
			width:450,
			modal:true,
			draggable:false,
			showAnim:'slideDown',
			resizable:false,
			position:{
				my:"center top",
				at:"center bottom",
				of:"#navbar"
			}
		});
		$(".update").click(function(e){
			e.preventDefault();
			var id=$(this).attr('href');
			$("#dialog").dialog('open').load('update.php?id='+id);
		});
		$(".delete").click(function(e){
			e.preventDefault();
			var id=$(this).attr('href');
			var name=$(this).attr('name');
			var conf=confirm('Are you sure to delete '+name+'?');
			if (conf) {
				$("#col"+id).hide().load('delete.php?id='+id);
			}
		});

	});
</script>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<?php include("includes/header.php");
?><div id='dialog'title='Update Form' onclick="update"></div>
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
<center>
<div id="fetemp">
<table border="0" >
<tr id="row">
<td id="as">#</td>
<td id="as">firstName</td>
<td id="as">Lastname</td>
<td id="as">Date-of-birth</td>
<td id="as">Sex</td>
<td id="as">Username</td>
<td id="as">E-mail</td>
<td id="as">Phonenumber</td>
<td colspan="3" id="as">Action</td>
</tr>
<?php
$sql="SELECT * from employees";	
$exec=mysql_query($sql)or die(mysql_error());
$a=1;
while($row=mysql_fetch_array($exec)){

	?>
	<tr id='col<?=$row['emp_id']?>'>
<td><?php echo $a;?></td> 
<td><?php echo $row['firstname'];?></td>
<td><?php echo $row['lastname'];?></td>
<td><?php echo $row['date_of_birth'];?></td>
<td><?php echo $row['sex'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['email'];?></td>
<td><?php echo $row['phonenumber'];?></td>
<td><a class='delete' name='<?=$row['firstname'];?>'href="<?php echo $row['emp_id'];?>"><img src="insurance/delete.png" height="23"></td>
<td><a class='update' href="<?=$row['emp_id'];?>"><img src="insurance/edit.png" height="23"></td>
</tr>
	<?php
	$a++;
	}

?>
</table>
</center>

</body>
</html>
<?php include("includes/footer.php");?>