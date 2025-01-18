
<?php
include ("includes/connection.php");
require_once("includes/functions.php");

if (!$_SESSION['clientid']) {
header("LOCATION:index.php");
}

?>
<html>
<head>
<script src='js/jquery.js'></script>
<script src='js/jquery-ui.js'></script>
<link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
	<title>Radiant Insurance Company</title>

<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<link rel="stylesheet" type="text/css" href="cssweb/settingdrop.css">

</head>
<body>

<style>
.upgrade:hover{
	cursor: hand;
}
#cla table{border: 1px solid #ddd;box-shadow: 0 0 1px #ddd;}
#head{font-weight:bold;}
	
		#tir{font-family: century gothic;font-size: 18px;margin-top: 50px;border:0px solid red;font-weight: bold;}

		
		</style>
<script>
	$(function(){
		$("#cla").dialog({
			title:'Upload Requirements',
			autoOpen:false,
			width:420,
			height:250,
			draggable:false,
			position:{
				my:"center top",
				at:"center bottom",
				of:"#navbar"
			}


		});	
		$('input[name="sdate"],input[name="edate"]').datepicker({
	dateFormat:"yy-mm-dd",
    changeMonth:true,
    changeYear:true,
    yearRange:"c-100:c+100",
   minDate:"<?=date("Y-m-d"); ?>"
});
		$(".upgrade").click(function(e){
			e.preventDefault();
			$('input[name="pptid"]').val($(this).val());
			//alert($('input[name="pptid"]').val());
			
			$("#cla").dialog("open");
			
		});
	});
		</script>

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








<center>


	
	<div class="insured-ppt" style="">
	<p id="tir">Here you can view your insured properties and when your insurance end you can upgrade it.</p>
	
	<div id='res'>
	<table>
		<?php
			$query=mysqli_query("SELECT * FROM insured where id_client={$_SESSION['clientid']}") or die(mysqli_error());
			$display=4;
			$cols=0;
			while ($row=mysqli_fetch_array($query)) {
				if($cols==0){
					?>
					<tr>
					<?php
				}	
				?>
				<td>
				<div class="ppt">
				<div style="" class="type"><?php echo $row['type']; ?></div>
				<?php

						switch ($row['type']) {
							case 'car':
								$query2=mysqli_query("SELECT cars.* FROM cars WHERE cars.car_id={$row['propertyId']}") or die(mysqli_error());

								while ($row2=mysqli_fetch_array($query2)) {
									?>
									
									<div class="img">
										<img src="./images/cars/ <?php echo $row2['photo'];?>" height="200" width="200">
									</div>
									<div><span class="label-ppt">PlateNumber: </span><?php echo $row2['plaque']; ?></div>
									<div><span class="label-ppt">Description: </span><?php echo $row2['description']; ?></div>
									<div><span class="label-ppt">Model: </span><?php echo $row2['model']; ?></div>
									<div><span class="label-ppt">Price/Month: </span><?php echo $row['price']."RWF"; ?></div>
									<div><span class="label-ppt">From: </span><?php echo $row['start_date']; ?> to :<?php echo $row['end_date']; ?></div>
									<div><span class="label-ppt">Remaining: </span><?php echo getInsuranceStatus($row['start_date'],$row['end_date']) ?></div>
									<button href="" style="text-decoration:none;background-color:black;color:white;" class="upgrade" value="<?php echo $row['insured_id']; ?>">Upgrade Here!</button>
									<?php
								}
								
								break;
							
							case 'house':
								$query2=mysqli_query("SELECT houses.* FROM houses WHERE houses.house_id={$row['propertyId']} ORDER BY houses.house_id ASC") or die(mysqli_error());

								while ($row2=mysqli_fetch_array($query2)) {
									$i=$row['insured_id'];
									?>
									<div class="img">
										<img src="./images/houses/ <?php echo $row2['photo'];?>" height="200" width="200">
									</div>
									<div><span class="label-ppt">plot no: </span><?php echo $row2['plot_number']; ?></div>
									<div><span class="label-ppt">description: </span><?php echo $row2['description']; ?></div>
									<div><span class="label-ppt">Price/Month: </span><?php echo $row['price']."RWF"; ?></div>
									
									<div><span class="label-ppt">From: </span><?php echo $row['start_date']; ?> to: <?php echo $row['end_date']; ?></div>
									<div><span class="label-ppt">remaining: </span><?php echo getInsuranceStatus($row['start_date'],$row['end_date']) ?></div>
									<button style="text-decoration:none;background-color:black;color:white;" class="upgrade" value="<?php echo $row['insured_id']; ?>">Upgrade Here!</button>
									<?php
								}
								
								break;
						}

				?>
				</div>
				</td>
				<?php
				$cols++;
		if ($cols==$display) {
			$cols=0;
			?>
			</tr>
			<?php
		}
			}
			if ($cols!=0 and $cols!=$display) {
				$neededtds=$display-$cols;

				for ($i=0; $i <$neededtds ; $i++) { 
					?>
					<td></td>
					<?php
				}
				?>
				</tr></table>
				<?php

			}else{
				?>
				</table>
				<?php
			}
		?>
	</div>
</div>

<div id="cla">
<form method="POST" action="" enctype="multipart/form-data">
<div><p>Upload Your BankSlip</p></div>
<table>
<input type="hidden" value="" name="pptid">
<tr>
	<td><input type="text" name="sdate" placeholder="start date"></td>
</tr>
<tr>
	<td><input type="text" name="edate" placeholder="end date"></td>
</tr>
<tr>
<td>
Bankslip<br>
<input type="file" name="attach"></td></tr>
<tr><td align="center" colspan="2"><input type="submit" name="send" value="Send"></td></tr>

</table>
</form>
</div>

</center>

</body>

</html>
<?php include("includes/footer.php");?>
<?php

if (isset($_POST['send'])) {
$i=$_POST['pptid'];
$file=time().$_FILES['attach']['name'];
$sdate=$_POST['sdate'];
$edate=$_POST['edate'];
$existing=mysqli_query("SELECT * from insured_details WHERE insured_id='$i' and status='waiting'");
if (mysqli_num_rows($existing)<=0) {
	
$ins=" INSERT INTO insured_details VALUES(null,'$i','$file','$sdate','$edate','waiting')";
if (mysqli_query($ins) or die(mysqli_error())) {
move_uploaded_file($_FILES['attach']['tmp_name'], "slips/".$file);
		echo "<script type='text/javascript'>alert('Information Uploaded');</script>";
	}
}else{
	?>
	<script type="text/javascript">
	alert("your request has been sent");
	</script>
	<?php
}
}      
?>