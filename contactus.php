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
<strong>RADIANT Headquarters</strong>
<br>
at KN2Av Former ETO MUHIMA<br>
<strong>Kigali Rwanda  new building CHIC INVESTMENT LTD</strong>
<br>
<strong>Email:info@radiant.rw</strong><br>
For more details contact Us:<br><strong>HOTLINE:</strong>2050<br>
<strong>PHONE:</strong>0788316155,0788381093.</p>

<p id="naz">

You can also find us at our branches all over the
Country:
Nyabugogo, Remera, Magerwa, Kicukiro, Muhanga,
Huye, Rusizi, Rubavu, Musanze, Gicumbi, Nyamata,
Kabarondo, Nyamagabe, Gisozi, Nyarugenge,
Rwamagana, Rusumo, Muhima, Karongi, Nyagatare,
La Bonne Adresse, Sonatubes, La Bonne Source,
Kabuga, Gatsibo, Kabaya, Kayonza, Kirehe.
<p>
</div>
<style type="text/css">
	#naf{width: 600px;border:1px solid black;margin-left: 600px;margin-bottom: 200px;}
	#naz{font-size: 20px;}
</style>
</form>
</body>
</html>
<?php include("includes/footer.php");?>