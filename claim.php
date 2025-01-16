<?php
include ("includes/connection.php");

if (!$_SESSION['clientid']) {
header("LOCATION:index.php");
}

?>
<html>
<head>
<title>Radiant Insurance Company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript">
	$(function(){
		$('select[name="ptins"]').change(function(){
			var insId=$(this).val();
			//alert(insId);
			$(".ppt-type").load("ajax/loadproperties.php?insId="+insId);
		});
		
	});
</script>
</head>
<body>
<?php include("includes/header.php");
?>
<div id="navbar">
<ul>
<li><a href="clientpage.php">Home</a></li>
<li><a href="clientaccount.php">MyAccount</li>

<li><a href="claim.php">Claim</a></li>
<li><a href="cliansfeed.php">View Feedback</a></li>


<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="data">
<form method="POST" action=""enctype='multipart/form-data'>
<style>
#data table{border:1px solid grey;border-radius:3px;
box-shadow:0 0 1px #ddd;padding:10px;margin-top:60px;}
#data table input[type=file]{padding:10px;background-color:white;
border:1px solid grey;border-radius:3px;
box-shadow:0 0 1.5px grey;width:100%;}
textarea{text-align: center;font-size:16px;}
#data table select{padding:10px;width:100%;
border:1px solid grey;border-radius:3px;
box-shadow:0 0 1.5px grey;}

#data table td{text-align: center;font-family:sans-serif;}
#data table input[type=submit]{padding:10px;border-radius:4px;
border:1px solid #66c5f7;background:#10a4f0;font-family:arial;
color:white;cursor:pointer;font-size: 16px;}
#data table input[type=submit]:hover{
	background:#1090d2;transition:all 0.6s ease;
}
</style>
<center>
<table>
<tr><td><p >Description to your Accident:</p></td></tr>
<tr>
<td><textarea cols="45" rows="7" id="tv" name="msg"placeholder='note your accident description here'required></textarea></td></tr>	
<tr><td>Attach Accident File:</td></tr><tr>
<td><input type="file" name="attach"required/></td></tr>
<tr><td>Insurance-type</td></tr><tr>
<td><select name="ptins">
<?php
	$insQuery=mysql_query("SELECT * FROM insurance");
	while ($insQueryRow=mysql_fetch_array($insQuery)) {
		?>
		<option value="<?php echo $insQueryRow['insurance_id']; ?>" <?php 
		$insuranceType=split(" ",$insQueryRow['insurance_name']);
		if (strtolower($insuranceType[0])=='fire'){
				echo "selected";
			} ?>>
			
		
			<?php echo $insQueryRow['insurance_name'] ?>
			
		</option>
		<?php
	}
?>
</td></tr>

<tr><td>Select Your Property Property</td></tr><tr>
<td>
<?php
	$options=mysql_query("SELECT * FROM houses where houses.id_client={$_SESSION['clientid']}") or die(mysql_error());
	//$optionsdata=mysql_fetch_array($options);
	//var_dump($optionsdata);
?>
<div class="ppt-type">
<select name="pt">
<?php
	while ($optionsdata=mysql_fetch_array($options)) {
		?>
		<option value=<?php echo $optionsdata['house_id']; ?>><?php echo $optionsdata['plot_number']; ?></option>
		<?php
	}
?>
</select>
</div>
</td></tr>
<tr><td align="center" colspan="2"><input type="submit" value="Send Claim" name="sav">
</table>
</center>
</form>
</div>
</body>
</html>
<?php include("includes/footer.php");?>
<?php
if (isset($_POST['sav'])) {
	$msg=mysql_real_escape_string($_POST['msg']);
	$file=$_FILES['attach']['name'];
	$type=$_POST['pt'];
	$time=date("d-m-Y H:i:s");
	$ins="INSERT INTO claim VALUES('','$time','{$_SESSION['clientid']}','$type','$msg','$file','unread')";
	if (mysql_query($ins) or die(mysql_error())) {
	move_uploaded_file($_FILES['attach']['tmp_name'], "files/".$file);
		echo "<script type='text/javascript'>alert('Information Uploaded');</script>";
	}
    
}
?>