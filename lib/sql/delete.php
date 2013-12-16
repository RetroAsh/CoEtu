<?php

function deleteContact($i){
    try{
		$connec = getPDO();

		$deleteContact1 = $connec->prepare("DELETE FROM carnet
					WHERE id_etu = :id_etu
					AND id_etu_etudiant = :id_etu_etudiant ;");

		$deleteContact1->bindParam('id_etu', $_SESSION["user_id"], PDO::PARAM_INT);
		$deleteContact1->bindParam('id_etu_etudiant', $i, PDO::PARAM_INT);
		
		if($deleteContact1->execute()){
			try{
				$requete2 = "DELETE FROM carnet
					WHERE id_etu_etudiant =".$_SESSION["user_id"]."
					AND id_etu = ".$i.";";
		
		
			
		}
		
		

		$q = $connec->exec($requete1);

		if($q == 0)$q = $connec->exec($requete2);

		return $q;
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression  : ".$e->getMessage());
	}
}

function deleteRequete($etu1, $etu2)
{
    $connec = getPDO();

    $requete = "DELETE FROM `".BASE."`.`carnet`
                WHERE `carnet`.`id_etu` = $etu1
                AND `carnet`.`id_etu_etudiant` = $etu2
                AND `carnet`.`statut_car` = '0';";

    $connec->query($requete);
}