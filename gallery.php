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
<li><a href="">Gallery</a></li>
</ul>
</div>

<a href="insurance/radiant4.jpg"><img src="insurance/radiant4.jpg" height="240"></a>
<a href="insurance/radiant2.png"><img src="insurance/radiant2.png" height="240"></a>
<a href="insurance/radiant3.jpg"><img src="insurance/radiant3.jpg" height="250">
<a href="insurance/009.jpg"><img src="insurance/009.jpg" height="240">
<a href="insurance/radiant.jpg"><img src="insurance/radiant.jpg" height="240">
<a href="insurance/cars.jpg"><img src="insurance/cars.jpg" height="230"></a>

</div>
</form>
</body>
</html>
<?php include("includes/footer.php")?>