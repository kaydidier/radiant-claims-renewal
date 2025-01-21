<?php
	require_once("../includes/connection.php");

	$html='<select name="district">';
	$initialProvince=$_GET['province'];
	//echo $initialProvince;
	$district=mysqli_query($mysqli, "SELECT * from district WHERE provinceId='$initialProvince'")or die(mysqli_error($mysqli));
	
	$i=0;
	$row=mysqli_fetch_array($district);
	//var_dump($row);
	while ($row=mysqli_fetch_array($district)) {
		 
		$html.='<option selected value='.$row['districtId'].'>'.$row['districtName'].'</option>';

		
	}
	$html.='</select>';
	echo $html;
?>