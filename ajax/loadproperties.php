<?php
include("../includes/connection.php");

	$insId=$_GET['insId'];
	//$optionsdata=mysql_fetch_array($options);
	//var_dump($optionsdata);
	$ins=mysql_query("SELECT * FROM insurance where insurance_id='$insId'");
	$insData=mysql_fetch_array($ins);
	//var_dump($insData);
	 $insuranceType=split(" ",$insData['insurance_name']);
		if (strtolower($insuranceType[0])=='fire'){
				$pptQuery=mysql_query("SELECT * FROM houses where id_client={$_SESSION['clientid']}");
				//$pptQueryRow=mysql_fetch_array($pptQuery);
				?>

				<select name="pt">
				<?php
					while ($pptQueryRow=mysql_fetch_array($pptQuery)) {
						?>
						<option value="<?php echo $pptQueryRow['house_id']; ?>"><?php echo $pptQueryRow['plot_number']; ?></option>
						<?php
					}
				?>
				</select>
				<?php

		}elseif (strtolower($insuranceType[0])=='motor'){
				$pptQuery=mysql_query("SELECT * FROM cars where id_client={$_SESSION['clientid']}");
				//$pptQueryRow=mysql_fetch_array($pptQuery);
				//var_dump($pptQueryRow);
				?>
				<select name="pt">
				<?php
					while ($pptQueryRow=mysql_fetch_array($pptQuery)) {
						?>
						<option value="<?php echo $pptQueryRow['car_id']; ?>"><?php echo $pptQueryRow['plaque']; ?></option>
						<?php
					}
				?>
				</select>
				<?php
		} ?>
