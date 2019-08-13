<?php
error_reporting(E_ALL);
//$path = "/home/student060/upload/"; //directory outside public_html on the server
$path = "upload/";
$file = ($_GET['file']);
$image = $path.$file;
header("Content-Type: image/jpg");
@readfile($image);
?> 