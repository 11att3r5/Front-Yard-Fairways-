<?php
//$WEB_ROOT = getenv("DOCUMENT_ROOT");
//$APP_PATH = 'example_code/simple-get/';
if(isset($_GET['pagelet'])){
$pagelet = $_GET['pagelet'];
}
require ("includes/language.inc.php");
require_once ("includes/functions.inc.php");
# index.php
if (!isset($pagelet))  {
   $pagelet = "index";
   }

// Include the page header.
include ("includes/header.inc.php");
if($pagelet == "index" || $pagelet == "about" || $pagelet == "services" || $pagelet == "contact" || $pagelet == "ServiceArea"){
	include("includes/hero.inc.php");
}elseif(isset($_COOKIE['emp'])){
	include("includes/emp-view.inc.php");
}else{
	include("includes/hero-out.inc.php");
}

// Begin page content
include ("pagelets/$pagelet.inc.php");

// End page content
if(!isset($_SESSION['EmpId'])){
	include ("includes/footer.inc.php");  //  Include the footer
}
?>