<?php 
	if (isset($_SESSION['EmpId']) || isset($_SESSION['CustomerID'])) {
		setcookie('user', '', time()-3600, '/', '', 0,0);
		$_SESSION = array();
		session_destroy();
		header("Location: index.php?pagelet=index");
	}else{
		header("Location: index.php?pagelet=index");
	}
?>