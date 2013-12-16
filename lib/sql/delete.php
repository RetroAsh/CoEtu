<?php

function deleteContact($i){
    try{
		$connec = getPDO();

		$deleteContact = $connec->prepare("DELETE FROM carnet
					WHERE id_etu = :id_etu
					AND id_etu_etudiant = :id_etu_etudiant ;");

		$deleteContact->bindParam('id_etu', $_SESSION["user_id"], PDO::PARAM_INT);
		$deleteContact->bindParam('id_etu_etudiant', $i, PDO::PARAM_INT);
		
		if($deleteContact->execute()){
			try{
				$deleteContact->bindParam('id_etu', $i, PDO::PARAM_INT);
				$deleteContact->bindParam('id_etu_etudiant', $_SESSION["user_id"], PDO::PARAM_INT);	
				return $deleteContact->execute();	
			}
			catch( Exception $e ){
				echo("Une erreur est survenue lors de la suppression du lien de contact 2 : ".$e->getMessage());
			}
		}
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression du lien de contact 1 : ".$e->getMessage());
	}
	return false;
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