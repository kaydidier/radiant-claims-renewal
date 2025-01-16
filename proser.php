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
<div id="nap">
<p id="bv">We Provide This Services for you</p>
<p>1.we provide many Insurance in easy way and the insurance<br>
we provide includes FireInsurance 
you can take this insurance to your property like houses and other properties.
other insurance we provide is MotorInsurance which can help people which need to take insurance for his cars,motto
to be insured in easy way and in secured insurance company</p>

<p>2.Other service we provide is Claim you make claim when you want to inform us that you made an accident and you can inform the 
company that you had an accident and company can solve your claim and you can you can upgrade your Insurance </p>           
</div>
</form>
<style type="text/css">
#nap{font-family: century gothic;border: 0px solid red;margin-left: 490px;width: 600px;margin-top: 40px;}
#bv{font-size: 20px;font-weight: bold;}
</style>
</body>
</html>
<?php include("includes/footer.php")?>