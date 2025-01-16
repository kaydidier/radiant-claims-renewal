<?php
include("includes/connection.php");

?>
<html>
<head><TITLE>Radiant Insurance Company</TITLE>
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">
<script>
$(document).ready(function(){
$("#lg").hide();
$("#lgn").click(function(){
$("#lg").show();
});
});
</script>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<form method="POST">
<?php include("includes/header.php");
?>
<center></center>
<div id="navbar">
<ul >
<li><a href="index.php">Home</a></li>
<li><a href="aboutus.php">AboutUs</a></li>
<li><a href="contactus.php">ContactUs</a></li>
<li><a href="proser.php">Services</a></li>
<li><a href="index.php" id="lgn">Login</a></li>
<li><a href="gallery.php">Gallery</a></li>
</ul>
</div>

<img src="insurance/radiant.jpg" id="photo" align="left">
<div id="nax">
<p id="contact">
RADIANT INSURANCE COMPANY is a web based built to help clients to get services online without losing time 
and  to know Information about us and have more detail about every thing you need to know to Radiant insurance company



</p>
</div>
</form>
</body>
</html>
<?php include("includes/footer.php")?>
