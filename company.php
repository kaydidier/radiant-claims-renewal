<?php
mysql_connect("localhost","root","");
mysql_select_db("vis");
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="cssweb/login.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<center><img src="insurance/a.jpg" id="ban"></center>
<div id="navbar">
<ul>
<li><a href="#">Home</a></li>

<li><a href="clients.php">Clients</a></li>
<li><a href="#">Companies</a>
<ul><li><a href="addcompany.php">AddCompany</a></li>
<li><a href="company.php">ViewCompany</a></li>
</ul>
</li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<center>
<table border='0' id='fetched'>
<tr>
<td>#</td>
<td>name</td>
<td>logo</td>
<td>slogan</td>
<td>cell</td>
<td>sector</td>
<td>district</td>
<td>phone</td>
<td>password</td>
<td>email</td>
<td colspan="2">Action</td>
<?php
$sql="SELECT * FROM company";	
$exec=mysql_query($sql)or die(mysql_error());
$a=1;
while($row=mysql_fetch_array($exec)){

	?>
	<tr>
<td><?php echo $row['c_id'];?></td> 
<td><?php echo $row['company_name'];?></td>
<td><?php echo $row['company_logo'];?></td>
<td><?php echo $row['company_slogan'];?></td>
<td><?php echo $row['cell'];?></td>
<td><?php echo $row['sector'];?></td>
<td><?php echo $row['district'];?></td>
<td><?php echo $row['phonenumber'];?></td>
<td><?php echo $row['password'];?></td>
<td><?php echo $row['email'];?></td>
<td><?php
if($row['blocked']=='true'){?>
<a onclick='del("<?=$row['c_id']?>","<?=$row['company_name']?>","unblock");'>Unblock </a>
<?php
	
}else{
?><a onclick='del("<?=$row['c_id']?>","<?=$row['company_name']?>","block");'>block </a></td>
<?php }?><td><a href="update.php?id=<?php echo $row['c_id'];?>">delete </a></td>
<td><a href="update.php?id=<?php echo $row['c_id'];?>">update</a></td>
</tr>
<?php
$a++;
}
?>
</table>
<script type="text/javascript">
function del(ids,name,type){
	var conf=confirm("Are you sure to "+type+" "+name+"?");
	if(conf==true){
		window.location='block.php?id='+ids+'&type='+type;
	}
}
</script>
</center>
</body>
</html>
