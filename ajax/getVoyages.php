<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    $ajax = "";

    foreach (selectAllVoyages($_SESSION["user_id"]) as $voy) {
    	if ($ajax!="") {
    		$ajax .= "#\n";
    	}
    	$ajax .= $voy["id"] . ";";
    	$ajax .= $voy["depart"] . ";";
    	$ajax .= $voy["arrive"] . ";";
    	$ajax .= $voy["aller"] . ";";
    	$ajax .= $voy["retour"] . ";";
    	$ajax .= "";
    }

    foreach (selectAllContactVoyages($_SESSION["user_id"]) as $voy) {
    	if ($ajax!="") {
    		$ajax .= "#\n";
    	}
    	$ajax .= $voy["id"] . ";";
    	$ajax .= $voy["depart"] . ";";
    	$ajax .= $voy["arrive"] . ";";
    	$ajax .= $voy["aller"] . ";";
    	$ajax .= $voy["retour"] . ";";
    	$ajax .= $voy["pre"] . " " . $voy["nom"];
    }

    echo $ajax;

?>
