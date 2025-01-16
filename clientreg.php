<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
session_start();
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
}


if (isset($_POST['save'])) {
	//var_dump($_POST); die;
	$a=mysql_real_escape_string($_POST['fname']);
	$b=mysql_real_escape_string($_POST['lname']);
	$c=mysql_real_escape_string($_POST['uname']);
	$d=mysql_real_escape_string($_POST['pass']);
	$e=mysql_real_escape_string($_POST['email']);
	$v=mysql_real_escape_string($_POST['sexa']);
	$f=mysql_real_escape_string($_POST['dob']);
	$g=mysql_real_escape_string($_POST['sector']);
	$h=mysql_real_escape_string($_POST['district']);
	$i=mysql_real_escape_string($_POST['province']);
	$j=mysql_real_escape_string($_POST['phone']);
	$k=mysql_real_escape_string($_POST['idno']);
	$sql="INSERT INTO clients VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f','$v', '$g', '$h', '$i','$j','$k',{$_SESSION['employeeid']})";
	$sq="SELECT * FROM clients WHERE email='$e' or phone='$j' or ID_no='$k'";
	$query=mysql_query($sq)or die(mysql_error());
	if(empty($a) or empty($b) or empty($c) or empty($d) or empty($e) or empty($v)
	or empty($f) or empty($g) or empty($h) or empty($i) or empty($j) or empty($k)){
		echo "<script type='text/javascript'>alert('empty fields');</script>";
	}

	else if (mysql_num_rows($query)>0){
		$rowquery=mysql_fetch_array($query);
			if ($rowquery['email']==$e||$rowquery['phone']==$j) {
				
			echo "<script type='text/javascript'>alert('Information Saved Before');</script>";
		}
			

	}
	else{
	//check if date of birth is valid
	if($f > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60) ) )) {
		echo "<script type='text/javascript'>alert('Only People above 18 years old are allowed to have vehicles');</script>";
	} else {
		$insert=mysql_query($sql)or die(mysql_error());
		if ($insert) {
			$_SESSION['clientregistration']=mysql_insert_id();
			echo "<script type='text/javascript'>alert('Successfully! Continue Give Client Insurance');
			window.location='initsession.php?clid=".mysql_insert_id()."';
			</script>";
			?>
			<script type="text/javascript">
			alert("hello");
			</script>
			<?php


		}else{
			echo "<script type='text/javascript'>alert(' not inserted');</script>";
		}
			
			
		}
	}
}
if (isset($_POST['motor']) and isset($_SESSION['clientregistration'])) {
	$plaque=mysql_real_escape_string($_POST['plaque']);
	$model=mysql_real_escape_string($_POST['model']);
	$description=mysql_real_escape_string($_POST['description']);
	$photo=time().$_FILES['photo']['name'];
	
	$insId=mysql_real_escape_string($_POST['insid']);
	$price=mysql_real_escape_string($_POST['price']);
	$sdate=$_POST['startdate'];
	$edate=$_POST['enddate'];
	if (mysql_query("INSERT INTO cars VALUES(null,'$plaque','$model','$description','$photo',{$_SESSION['clientregistration']})")or die("here ".mysql_error())) {
		move_uploaded_file($_FILES['photo']['tmp_name'],"./images/cars\ ".$photo);
		$propertyid=mysql_insert_id();
	$insertdata=mysql_query("INSERT INTO insured VALUES(null,'$sdate','$edate','$price','$insId',{$_SESSION['clientregistration']},'$propertyid','car')") or die("here 2:".mysql_error());
	if ($insertdata) {
		unset($_SESSION['clientregistration']);
		header("location:clientprint.php?ppt=".mysql_insert_id());
	?>
	<script type="text/javascript">
	alert("insurance added");
	</script>
	<?php
		}
	}

}
if (isset($_POST['house']) and isset($_SESSION['clientregistration'])) {
	$plotno=mysql_real_escape_string($_POST['plotno']);
	$description=mysql_real_escape_string($_POST['description']);
	$photo=time().$_FILES['photo']['name'];
	$sdate=mysql_real_escape_string($_POST['startdate']);
	$edate=mysql_real_escape_string($_POST['enddate']);
	$insId=mysql_real_escape_string($_POST['insid']);
	$price=mysql_real_escape_string($_POST['price']);
		if (mysql_query("INSERT INTO houses VALUES(null,'$plotno',{$_SESSION['clientregistration']},'$description','$photo')")) {
		move_uploaded_file($_FILES['photo']['tmp_name'],"./images/houses\ ".$photo);
		$propertyid=mysql_insert_id();
	$insertdata=mysql_query("INSERT INTO insured VALUES(null,'$sdate','$edate','$price','$insId',{$_SESSION['clientregistration']},'$propertyid','house')") or die(mysql_error());
	if ($insertdata) {
		unset($_SESSION['clientregistration']);
		header("location:clientprint.php?ppt=".mysql_insert_id());
		
	?>
	<script type="text/javascript">
	alert("insurance added");
	</script>
	<?php
		}
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
<script type="text/javascript" src="js/script.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script>
$(document).ready(function(){

	$(".house").hide();
	$(".motor").hide();
$("#dat").datepicker({
	dateFormat:"yy-mm-dd",
    changeMonth:true,
    changeYear:true,
    yearRange:"c-190:c+10",
});
$(".sdate").datepicker({
	dateFormat:"yy-mm-dd",
    changeMonth:true,
    changeYear:true,
    yearRange:"c-100:c+100",
    minDate:"<?=date("Y-m-d"); ?>"
});

$(".edate").datepicker({
	dateFormat:"yy-mm-dd",
    changeMonth:true,
    changeYear:true,
    yearRange:"c-100:c+100",
    minDate:"<?=date("Y-m-d"); ?>"
});
$('select[name="province"]').change(function(){
	var province=$(this).val();
	
	$("#districts").load("ajax/loadprovince.php?province="+province);
});
$('select[name="type"]').change(function(){
	switch($(this).val()){
		case 'Motor':
			$(".house").hide();
			$(".motor").show();
		break;

		case 'Fire':
			$(".house").show();
			$(".motor").hide();
		break;
	}
});
});
</script>
<link rel="stylesheet" type="text/css" href="cssweb/clientreg.css">

</head>
<body>

<br>

<?php include("includes/header.php");
?>
<div id="navbar">
<ul>
<li><a href="clientpage.php">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php?action=add">New</a></li>
<li><a href="empclient.php">View</a></li>
</ul>
</li>
<li><a href="upgrades.php">Upgrades</a></li>
<li><a href="claimed.php">claimed</a></li>
<li><a href="ansfeed.php">Feedback</a></li>
<!--<li><a href="#">Products</a></li>-->
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<?php
	if (isset($_GET['clid'])) {

		
		
	
?>

		<div id="form" style="margin-left:20em; width:100%;float:left;">
			<div id="insurance-form">
			

			<table id="clienttable"> 
			<div id="insurancep">
			<p id="titi">Continue Registering by give client insurance</p>
				<tr>
				<td>
				insurance:</td><td>&nbsp;&nbsp;
				<select name="type">
				<option>Select insurance please......</option>
					
			<?php
				$i=1;
				$insurances=mysql_query("SELECT * FROM insurance");
				while ($row=mysql_fetch_array($insurances)) {
					?>

					<option value="<?php $a=split(" ",$row['insurance_name']); echo $a[0];?>"><?php echo $row['insurance_name'] ?></option>
					<?php

				}
			?>

				</select>
				</td>
				</tr>
				</table>
				</div>
				<div class="motor">
				<form method="POST" action="" enctype="multipart/form-data">
					<table id="motor">
						<tr>
						<?php $insurances=mysql_query("SELECT * FROM insurance where insurance_name='Motor insurance'");  
							$insData=mysql_fetch_array($insurances);
						?>
						<input type="hidden" name="insid" value="<?php echo $insData['insurance_id']; ?>">
						<tr>
							<td>start date:</td><td><input type="text" name="startdate" class="sdate"></td>

						</tr>
						<tr>
							<td>end date:</td><td><input type="text" name="enddate" class='edate'></td>
						</tr>
							<td>plateNumber:</td><td><input type="text" name="plaque"></td>
						</tr>
						<tr>
							<td>model:</td><td><input type="text" name="model"></td>
						</tr>
						<tr>
							<td>description:</td><td><textarea name="description"></textarea></td>
						</tr>
						<tr>
							<td>photo:</td><td><input type="file" name="photo"></td>
						</tr>
						<tr>
							<td>Price:</td><td><input type="text" name="price">/RWF</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="save" name="motor"></td>
						</tr>
					</table>
					</form>
				</div>

				<div class="house">
				<form method="POST" action="" enctype="multipart/form-data">
					<table id="fire">
						<?php $insurances=mysql_query("SELECT * FROM insurance where insurance_name='Motor insurance'");  
							$insData=mysql_fetch_array($insurances);
						?>
						<input type="hidden" name="insid" value="<?php echo $insData['insurance_id']; ?>">
						<tr>
							<td>start date:</td><td><input type="text" name="startdate" class="sdate" readonly></td>
						</tr>
						<tr>
							<td>end date:</td><td><input type="text" name="enddate" class="edate" readonly></td>
						</tr>
						<tr>
							
							<td>Plot number:</td><td><input type="text" name="plotno"></td>
						</tr>
						<tr>
							<td>description:</td><td><textarea name="description"></textarea></td>
						</tr>
						<tr>
							<td>photo:</td><td><input type="file" name="photo"></td>
						</tr>
						<tr>
							<td>Price:</td><td><input type="text" name="price">/RWF</td>
						</tr>
						<tr>
							<td colspan="2"><center><input type="submit" value="save" name="house"></center></td>
						</tr>
					</table>
					</form>
				</div>
			</form>
			</div>
		</div>
		<?php
			}
		?>
<div id="insert" style="margin-left:20em;">

<?php 
	if (@$_GET['action']=='add') {
		
	
?>
<form method="POST" enctype="multipart/form-data">
<center>
<table>
<p id="tit"><div align="center"id='Tips'>Register New Client Here</div></p>
<tr><td>First-name:</td>
<td><input type="text" name="fname" placeholder="enter firstname" value='<?= @$_POST['fname'] ?>' pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>Last-name:</td>
<td><input type="text" name="lname" placeholder="enter lastname" value='<?= @$_POST['lname'] ?>' pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>Username:</td>
<td><input type="text" name="uname" placeholder="enter Username" value='<?= @$_POST['uname'] ?>' pattern="[A-Za-z']{2,30}"></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="pass" placeholder="enter Password" ></td></tr>
<tr><td>E-mail:</td>
<td><input type="email" name="email" placeholder="enter E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"  value='<?= @$_POST['email'] ?>'></td></tr>
<tr><td>Date-of-Birth:</td>
<td><input type="text" name="dob" id="dat" placeholder="enter DateofBirth"  value='<?= @$_POST['dob'] ?>'></td>
</tr>
<tr><td>Sex:</td>
<td><select name="sexa">

<option <?= @$_POST['sexa'] == 'Male'?"selected":"" ?> >Male</option>
<option  <?= @$_POST['sexa'] == 'Female'?"selected":"" ?>>Female</option></select>
</td></tr>
<tr><td>province:</td>
<td><select name="province">
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
		<option <?= @$_POST['province'] == $row['provinceId']?"selected":"" ?> value="<?= $row['provinceId'] ?>" ><?php echo $row['provinceName']; ?></option>
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
		<option <?= @$_POST['district'] == $row['districtId']?"selected":"" ?> value="<?=$row['districtId'] ?>" > <?php echo $row['districtName']; ?></option>
<?php
		
	}
?>
</select>
</div>
</td></tr>

<tr><td>Sector:</td>
<td><input type="text" name="sector" placeholder="enter Sector"  value='<?= @$_POST['sector'] ?>'></td></tr>


<tr><td>Phone:</td>
<td><input type="text" name="phone" placeholder="enter phonenumber"  value='<?= @$_POST['phone'] ?>' pattern="07[2,3,8]{1}[0-9]{7}"></td></tr>
<tr><td>ID-NO:</td>
<td><input type="text" name="idno" placeholder="enter identity-number" maxlength="16" value='<?= @$_POST['idno'] ?>' pattern="[0-9]{16}" ></td></tr>


<tr><td colspan="2" align="center"><input type="submit" href="nextinsert.php" name="save" value="Save"></td></td>
</table>
</center>
</form>
<?php
	}
?>
<style>

#insert input{border-radius:3px;width:130%;padding:5px;border:1px solid white;font-family: arial;}



#insert{background-color:#ddd;box-shadow:0 0 0px white;padding:5px;width:370px;margin-left: 300px;margin-top: 40px;
font-family: segoe Ui;width: 500px;}
#insert input[type="submit"]{padding: 5px; width: 67px;border: 2px solid black;}

#insert table select{padding:10px;width:100%;
border:1px solid grey;border-radius:3px;
box-shadow:0 0 1.5px grey;height: 40px;}

#insert input[type="submit"]:hover{background-color: white;color: black;}

	.error{box-shadow:0 0 5px red;border:none;border-radius:4px;}
#Tips{font-family:segoe UI;font-size:15px;background:grey;
	border-radius:3px;padding:10px;
	text-align:center;font-weight:lighter;background-color: #0eb6f8;
color: white;font-family: century gothic;font-size:17px;}
#clienttable select{padding:10px;width:200%;
border:1px solid grey;border-radius:3px;
box-shadow:0 0 1.5px grey;}
#clienttable{font-family: arial;}
#motor textarea{font-size:16px;width: 300px;height: 200px;}
#motor input[type=file]{padding:7px;background-color:white;
border:1px solid grey;border-radius:3px;widows: 230px;}
#motor input[type="text"]{padding: 3px;margin: 2px;
	border:1px solid #afadad;width: 240px;height: 32px;font-size: 15px;box-shadow:0 0 1.5px grey}
#motor{background-color: #e4e5e6;}
#motor input[type="submit"]{padding: 5px; width: 67px;border: 0px solid black;
font-family: arial;background-color: black;color: white;
font-weight: bold;}
#motor input[type="submit"]:hover{background-color: white;color: black;}

#fire textarea{font-size:16px;width: 300px;height: 200px;}
#fire input[type=file]{padding:7px;background-color:white;
border:1px solid grey;width: 230px;}
#fire input[type="text"]{padding: 3px;margin: 2px;
	border:1px solid #afadad;width: 240px;height: 32px;font-size: 15px;box-shadow:0 0 1.5px grey;
}
#fire{background-color: #e4e5e6;}
#fire input[type="submit"]{padding: 5px; width: 67px;border: 0px solid black;
font-family: arial;background-color: black;color: white;
font-weight: bold;}
#fire input[type="submit"]:hover{background-color: white;color: black;}
#tit{font-family: century gothic;font-size: 20px;font-weight: bold;}
#titi{font-family: century gothic;font-size: 20px;font-weight: bold;}
#form{min-height: 400px;}

#Tips{font-family:segoe UI;font-size:15px;background:grey;
	border-radius:3px;padding:10px;
	text-align:center;font-weight:lighter;background-color: #0eb6f8;
color: white;font-family: century gothic;font-size:17px;margin-top: -20px;}
</style>
</div>

<?php include("includes/footer.php");?>
</body>
</html>
