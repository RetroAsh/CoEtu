<?php
	require_once "../lib/sql.php";
	require_once "../login.inc";
	
	$code=$_GET['term'];
	$array = selectNomVilleLike($code);

	echo json_encode($array);
?>