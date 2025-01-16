<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
$name=$_GET['file'];
$fileName ="files/".$name;
$downloadFileName = $fileName;

if (file_exists($fileName)) {
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$name);
    ob_clean();
    flush();
    readfile($fileName);
    //echo $fileName;
    exit;
}else{
echo "done";
}
?>