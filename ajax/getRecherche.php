<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    $result = array();
    $perso = array();

    function order($a,$b){
        return $a["nb"]<$b["nb"];
    }

    if (isset($_POST["r"])) {

        $result = explode(" ",$_POST["r"]);

        $id_C = array();
        $id_V = array();
        foreach ($result as $value) {
            if (empty($value)) {
                continue;
            }
            $id_C[] = selectIdPerso($value);
            $id_V[] = selectVoyages($value);
        }
        foreach ($id_C as $value) {
            foreach ($value as $info) {
                if (isset($perso[$info["id_etu"]])) {
                    $perso[$info["id_etu"]]["nb"]++;
                }
                else {
                    $info["nb"] = 1;
                    $perso[$info["id_etu"]] = $info;
                }
            }
        }
        foreach ($id_V as $value) {
            foreach ($value as $info) {
                if (isset($perso[$info["id_voy"]])) {
                    $perso[$info["id_voy"]]["nb"]++;
                }
                else {
                    $info["nb"] = 1;
                    $perso[$info["id_voy"]] = $info;
                }
            }
        }

        uasort($perso,'order');
    }
	


    if (!isset($_POST["r"]) || $_POST["r"]=="") {
    	echo "<p class='msg'>Entrez une ville, un nom, une destination...</p>";
    }
    elseif (count($perso)<=0) {
    	echo "<p class='msg'>Aucun résultat ne correspond à \"" . $_POST["r"] . "\", désolé.</p>";
    }
    else {
    	echo "<br />";
    	foreach ($perso as $value) {
			if(isset($value['id_etu'])){
                printPerson($value['id_etu'],$value["prenom_etu"],$value["nom_etu"],$value["libelle"],$value["nom_ville"]);
			}
			else if(isset($value['id_voy'])){
                printVoyage($value['id_voy'],$value['nom_villeD'],$value['nom_villeA'],$value["date_aller"],$value['date_retour'],$value["prenom_etu"]." ".$value["nom_etu"]);
			}
    	}
        echo "<div class='tampon'></div>";
    }


?>