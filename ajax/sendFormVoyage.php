<?php

	require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';
    
    $verif = true;
    $err = "";
    
    $v_dep = selectIdVille($_POST["v_dep"]);
    $v_arr = selectIdVille($_POST["v_arr"]);
    
    $d1 = null;
    $d2 = null;
    
    if(!$v_dep){
		$verif = false;
		$err = $err."Ville de départ inconnu.<br/>";
    }
    if(!$v_arr){
		$verif = false;
		$err = $err."Ville d'arrivé inconnu.<br/>";
    }
    if(!verifDate($_POST["d_dep"])){
		$verif = false;
		$err = $err."Date de départ invalide. <br/>";
    }else{
		$d1 = new DateTime(dateNormalToCrade($_POST["d_dep"]));
	}
	if ($_POST["d_arr"]!="00/00/00") {
		if(!verifDate($_POST["d_arr"])){
			$verif = false;
			$err = $err."Date d'arrivé invalide.<br/>";
		}else{
			$d2 = new DateTime(dateNormalToCrade($_POST["d_arr"]));
		}
	}else{
		$d2 = "0000-00-00";
	}
	if($_POST["d_arr"]!="00/00/00" && $d1>$d2){
		$verif = false;
		$err = $err."La date de départ ne peut etre supérieur à la date d'arrivé.<br />";
	}
    if(!ctype_digit($_POST["rec"]) && $_POST["rec"] < 1){
		$verif = false;
		$err = $err."récurence doit être un nombre entier suppérieur à 0.<br/>";
    }
    
    if($verif)
    {
    	if ($_POST["d_arr"]=="00/00/00") {
    		$d2 = "0000-00-00";
    	} else {
    		$d2 = $d2->format("Y-m-d");
    	}
    	if (isset($_POST["mod_id"]) && $_POST["mod_id"]!=0) {
    		updateVoyage($_POST["mod_id"],$_SESSION["user_id"],$v_dep, $v_arr, $d1->format("Y-m-d"), $d2, $_POST["rec"]);
    	} 
    	else {
    		ajoutVoyage($v_dep, $v_arr, $d1->format("Y-m-d"), $d2, $_POST["rec"]);
    	}
		print("true");
    }else{
		print($err);
	}

?>