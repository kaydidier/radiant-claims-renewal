<?php
	include("includes/connection.php");

	$_SESSION['clientregistration']=$_GET['clid'];
	header("location:clientreg.php?clid={$_GET['clid']}");
?>