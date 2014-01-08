<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/bibli.php';
    require_once '../lib/sql.php';

    $ajax = "";

    foreach (selectAllVoyages($_SESSION["user_id"]) as $voy) {
    	if ($ajax!="") {
    		$ajax .= "#\n";
    	}
    	$ajax .= $voy["id"] . ";";
    	$ajax .= $voy["depart"] . ";";
    	$ajax .= $voy["arrive"] . ";";
    	$ajax .= timestamp($voy["aller"]) . ";";
        if ($voy["retour"]!="0000-00-00") {
            $ajax .= timestamp($voy["retour"]) . ";";
        }
        else {
    	   $ajax .= ";";
        }
    	$ajax .= "";
    }

    $all = null;
    if($_SESSION["user_id"]==3){
        $all = selectAllVoyagesAdmin();
    }
    else {
        $all = selectAllContactVoyages($_SESSION["user_id"]);
    }

    foreach ($all as $voy) {
    	if ($ajax!="") {
    		$ajax .= "#\n";
    	}
    	$ajax .= $voy["id"] . ";";
    	$ajax .= $voy["depart"] . ";";
    	$ajax .= $voy["arrive"] . ";";
    	$ajax .= timestamp($voy["aller"]) . ";";
    	if ($voy["retour"]!="0000-00-00") {
            $ajax .= timestamp($voy["retour"]) . ";";
        }
        else {
           $ajax .= ";";
        }
    	$ajax .= $voy["pre"] . " " . $voy["nom"];
    }

    echo $ajax;

?>
