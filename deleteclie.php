<?php

$con=mysql_connect("127.0.0.1","root","");
$db=mysql_select_db("radiant");
$i=mysqli_real_escape_string($_GET['id']);
$sql="DELETE FROM clients where id_client='$i'";
$exec=mysqli_query($sql) or die(mysqli_error());
if ($exec) {
	echo "deleted";
	?>
	<a href="empclient.php">back</a>
	<?php
}









?>