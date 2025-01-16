<?php
include("includes/connection.php");
if (!$_SESSION['employeeid']) {
	header("LOCATION:logout.php");
}

?>
<html>
<head>
	<title>Radiant Insurance Company</title>
	<link rel="shortcut icon" href="insurance/LOGO.png">
	<script src='js/jquery.js'></script>
<script src='js/jquery-ui.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
</head>
<script>
$(document).ready(function(){
$("#print").click(function(){
	$(this).hide();
	$("#back").hide();
	setTimeout(function(){
		window.print();
	}, 200);

});

});
</script>
<body>


<?php

if (isset($_GET['ppt'])) {
	$dataQuery=mysql_query("SELECT clients.firstname as fname,clients.lastname as lname,clients.phone as phn,province.*,district.*,
	 clients.*,insurance.*,insured.*,employees.* FROM clients,insurance,insured,employees,province,district where 
		clients.id_client=insured.id_client 
		and insurance.insurance_id=insured.insurance_id and clients.province=province.provinceId and clients.district=district.districtId and employees.emp_id=clients.emp_id and insured.insured_id={$_GET['ppt']}")or die(mysql_error());
	$dataQueryRow=mysql_fetch_array($dataQuery);
	
}
?>
<html>
<head>
	<title></title>
</head>
<body>
<div id="to">
<div id="photo">
<img src="insurance/rad.png" height="600" ></div>
<div class="alldiv">

<div class="name">
	Name:<?php echo $dataQueryRow['fname']." ".$dataQueryRow['lname']; ?>
</div>
<div class="phone">
Phone-Number:<?php echo $dataQueryRow['phn'];?>
</div>
<div class="address">
	address:<?php echo $dataQueryRow['sector'].",".$dataQueryRow['districtName'].",".$dataQueryRow['provinceName']?>
</div>
<div class="ins-name">
Insurance:<?php echo $dataQueryRow['insurance_name']?>
</div>
<div class="duration">
Duration:<?php echo $dataQueryRow['start_date']." to ".$dataQueryRow['end_date']?>
</div>

<div class="ppt-name">
Property-name:
<?php
	switch ($dataQueryRow['type']) {
		case 'car':
			$pptQuery=mysql_query("SELECT * FROM cars where car_id={$dataQueryRow['propertyId']}");
			$pptQueryRow=mysql_fetch_array($pptQuery);
			echo $pptQueryRow['plaque']." ".$pptQueryRow['model'];
			break;
		case 'house':
			$pptQuery=mysql_query("SELECT * FROM houses where house_id={$dataQueryRow['propertyId']}");
			$pptQueryRow=mysql_fetch_array($pptQuery);
			echo $pptQueryRow['plot_number'];
			
			break;
		
	}
?>
<?php
//var_dump($_SESSION);
$emp=mysql_query("SELECT employees.firstname as finame,employees.lastname as laname ,employees.phonenumber as phon ,employees.*,clients.* FROM employees,clients where clients.emp_id=employees.emp_id && employees.emp_id='{$_SESSION['employeeid']}'");
$empa=mysql_fetch_array($emp);

?>
</div>
<p>Branch-Manager Name:<?php echo $empa['finame']." ".$empa['laname'];?><br>
Phone:<?php echo $empa['phon'];?>
</p>
signature

.........................
<p>
Stamp of Radiant Insurance Company
</p>
</div>
</div>

<button id="back"  onclick='window.location="./emppage.php"'>Back</button>
<button id="print">Print</button>
<style type="text/css">
#to{border: 1px solid #ddd;height: 600px;}
.alldiv{border: 1px solid #ddd;width: 600px;margin-left: 510px;font-family: century gothic;font-size: 20px;margin-top: -400px;}
#print {
		margin-left: 1000px;
		width: 100px;
		height: 40px;
		padding:10px;
		border-radius:4px;
		border:1px solid #66c5f7;
		background:#10a4f0;
		font-family:arial;
		color:white;
		cursor:pointer;
		font-size: 16px;
		margin-bottom: -100px;
}
#back {
		/*margin-left: 1000px;*/
		width: 100px;
		height: 40px;
		padding:10px;
		border-radius:4px;
		border:1px solid #66c5f7;
		background:#10a4f0;
		font-family:arial;
		color:white;
		cursor:pointer;
		font-size: 16px;
		margin-bottom: -100px;
}
#photo {margin-left: 240px;margin-bottom: 70px;}
</style>
</body>
</html>
