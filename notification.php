<?php

include("includes/connection.php");
if (!$_SESSION['adminid']) {
header("LOCATION:index.php");
}
//var_dump($_SESSION['adminid']);
//create connectionmysql_select_db("vis");//to select from the db
//if (!$_SESSION['admin']) {
	//header("location:login.php");
	//}

?>
<html>
<head><title>Radiant insurance company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">
<script>
$(document).ready(function(){
</script>
</head>
<body>
<?php include("includes/header.php");?>
<div id="navbar">
<ul>
<li><a href="employees.php">Home</a></li>
<li><a href="">Employees</a>
<ul><li><a href="addemployee.php">New</a></li>
<li><a href="employees.php">View</a></li>
</ul>
</li>
<li><a href="insurance.php">Insurances</a></li>
<li><a href="allclients.php">Clients</a></li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>






</body>
</form>
</html>
<?php include("includes/footer.php");?>

