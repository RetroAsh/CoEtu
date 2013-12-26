<?php

function updatePerso($id_etu,$idville,$idcampus,$mois,$annee){
	try{
		$connec = getPDO();
		$updateEtu = $connec->prepare("UPDATE etudiant SET id_ville = :idville, id_camp = :idcampus, mois_ne_etu = :mois, annee_ne_etu = :annee WHERE id_etu = :id_etu;");
		$updateEtu->bindParam('idville', $idville, PDO::PARAM_INT);
		$updateEtu->bindParam('idcampus', $idcampus, PDO::PARAM_INT);
		$updateEtu->bindParam('mois', $mois, PDO::PARAM_INT);
		$updateEtu->bindParam('annee', $annee, PDO::PARAM_INT);
		$updateEtu->bindParam('id_etu', $id_etu, PDO::PARAM_INT);
		return $updateEtu->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour des informations personnelles : ".$e->getMessage());
	}
	/*else {
            $updateEtu = "UPDATE coordonnee SET libelle_coordonnee='$lib_coord', information='$information' WHERE id_etu='$id_etu';";
            $q = $connec->exec($updateEtu);
            if ($q == 0) {
                return $q = -2; //erreur lors de la modification des coordonnees
            }
        */
		
	return false;
}

function updateStatutRequete($etu1, $etu2, $statut){
	try{
		$connec = getPDO();

		$updateCarnet = $connec->prepare("UPDATE carnet SET statut_car = :statut
					WHERE id_etu = :etu1
					AND id_etu_etudiant = :etu2;");
		
		$updateCarnet->bindParam('statut', $statut, PDO::PARAM_INT);
		$updateCarnet->bindParam('etu1', $etu1, PDO::PARAM_INT);
		$updateCarnet->bindParam('etu2', $etu2, PDO::PARAM_INT);
		return $updateCarnet->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour du lien de contact : ".$e->getMessage());
	}
	return false;
}

function updateCouleur($id,$couleur){
	try{
		$connec = getPDO();
		$updateCouleur = $connec->prepare("UPDATE etudiant
					SET couleur = :couleur
					WHERE id_etu = :id");
		$updateCouleur->bindParam('couleur', $couleur, PDO::PARAM_STR);
		$updateCouleur->bindParam('id', $id, PDO::PARAM_INT);
		return $updateCouleur->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour de la couleur : ".$e->getMessage());
	}
	return false;
}

function updateMsgRead($de,$a){
	try{
		$connec = getPDO();
		$updateMessage = $connec->prepare("UPDATE etudiant ES, etudiant EG, message M
					SET M.msg_vu = TRUE
					WHERE ES.id_etu = M.etu_send
					AND EG.id_etu = M.etu_get
					AND ES.id_etu = :de
					AND EG.id_etu = :a
					AND M.msg_vu = FALSE;");
		$updateMessage->bindParam('de', $de, PDO::PARAM_INT);
		$updateMessage->bindParam('a', $a, PDO::PARAM_INT);
		return $updateMessage->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour de l'état du message : ".$e->getMessage());
	}
	return false;
}