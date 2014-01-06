<?php
	require_once "../lib/sql.php";
	require_once "../login.inc";
	
	$code=$_GET['term'];
	$array = selectNomUniversiteLike($code);
	
	echo json_encode($array);
?>