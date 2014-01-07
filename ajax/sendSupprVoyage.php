<?php

	require_once '../lib/securite.php';

	require_once '../login.inc';
    require_once '../lib/sql.php';

    $ok = false;

    if(isset($_POST["id"])){
    	foreach (selectAllVoyages($_SESSION["user_id"]) as $voy) {
    		if ($voy["id"]==$_POST["id"]) {
    			deleteVoyage($voy["id"]);
    			$ok = true;
    		}
    	}
    }

    if (!$ok) {
    	echo "Erreur lors de la suppression.";
    }

?>