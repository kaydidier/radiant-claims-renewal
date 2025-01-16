<?php
	require_once("../includes/connection.php");

	$html='<select name="district">';
	$initialProvince=$_GET['province'];
	//echo $initialProvince;
	$district=mysql_query("SELECT * from district WHERE provinceId='$initialProvince'")or die(mysql_error());
	
	$i=0;
	$row=mysql_fetch_array($district);
	//var_dump($row);
	while ($row=mysql_fetch_array($district)) {
		 
			
		
		$html.='<option selected value='.$row['districtId'].'>'.$row['districtName'].'</option>';

		
	}
	$html.='</select>';
	echo $html;
?>