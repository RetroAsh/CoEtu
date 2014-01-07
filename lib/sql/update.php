<?php

function updatePerso($id_etu,$idville,$iduniv,$mois,$annee){
	try{
		$connec = getPDO();
		$updateEtu = $connec->prepare("UPDATE etudiant SET id_ville = :idville, id_univ = :iduniv, mois_ne_etu = :mois, annee_ne_etu = :annee WHERE id_etu = :id_etu;");
		$updateEtu->bindParam('idville', $idville, PDO::PARAM_INT);
		$updateEtu->bindParam('iduniv', $iduniv, PDO::PARAM_INT);
		$updateEtu->bindParam('mois', $mois, PDO::PARAM_INT);
		$updateEtu->bindParam('annee', $annee, PDO::PARAM_INT);
		$updateEtu->bindParam('id_etu', $id_etu, PDO::PARAM_INT);
		return $updateEtu->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour des informations personnelles : ".$e->getMessage());
	}
		
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

function updateMdp($id,$mdp){
    $mdp = hash("sha256", $mdp, null);
    try{
        $connec = getPDO();
        $update = $connec->prepare("UPDATE etudiant
					SET mot_de_passe = :mdp
					WHERE id_etu = :id");
        $update->bindParam('mdp', $mdp, PDO::PARAM_STR);
        $update->bindParam('id', $id, PDO::PARAM_INT);
        return $update->execute();
    }
    catch(Exception $e){
        echo("Une erreur est survenue lors de la mise à jour du mot de passe : ".$e->getMessage());
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

function updateVoyage($id,$usr,$depart, $arrive, $aller, $retour, $recurence){
	try{
		$connec = getPDO();
		$updateMessage = $connec->prepare("UPDATE voyage V
					SET V.date_aller = :aller,
					V.date_retour = :retour,
					V.ville_depart = :depart,
					V.ville_arrive = :arrive,
					V.recursivite = :recurence
					WHERE V.id_voy = :id
					AND V.id_etu = :usr");
		$updateMessage->bindParam('aller', $aller, PDO::PARAM_STR);
		$updateMessage->bindParam('retour', $retour, PDO::PARAM_STR);
		$updateMessage->bindParam('depart', $depart, PDO::PARAM_INT);
		$updateMessage->bindParam('arrive', $arrive, PDO::PARAM_INT);
		$updateMessage->bindParam('recurence', $recurence, PDO::PARAM_INT);
		$updateMessage->bindParam('id', $id, PDO::PARAM_INT);
		$updateMessage->bindParam('usr', $usr, PDO::PARAM_INT);
		return $updateMessage->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour du voyage " . $id . " : ".$e->getMessage());
	}
	return false;
}

function updateVoyageDate($id,$aller,$retour){
	try{
		$connec = getPDO();
		$updateMessage = $connec->prepare("UPDATE voyage V
					SET V.date_aller = :aller,
					V.date_retour = :retour,
					WHERE V.id_voy = :id");
		$updateMessage->bindParam('aller', $aller, PDO::PARAM_STR);
		$updateMessage->bindParam('retour', $retour, PDO::PARAM_STR);
		$updateMessage->bindParam('id', $id, PDO::PARAM_INT);
		return $updateMessage->execute();
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour des dates du voyage " . $id . " : ".$e->getMessage());
	}
	return false;
}


function updateVoyageDateAuto(){
	try{
		$connec = getPDO();
		$updateVoyage = $connec->prepare("UPDATE voyage V
			SET V.date_aller = date_add(V.date_aller,INTERVAL V.recursivite DAY),
				V.date_retour = 
					CASE WHEN V.date_retour='0000-00-00' 
					THEN '0000-00-00' 
					ELSE date_add(V.date_retour,INTERVAL V.recursivite DAY) END
			WHERE V.date_aller<CURDATE()
			AND (V.date_retour='0000-00-00' 
				OR (V.date_retour<CURDATE() 
				AND V.date_retour<>'0000-00-00'))
			AND V.recursivite<>0");
		
		do {
			$updateVoyage->execute();
		} while ($updateVoyage->rowCount());
	}
	catch(Exception $e){
		echo("Une erreur est survenue lors de la mise à jour des dates du voyage : ".$e->getMessage());
	}
	return false;
}


function updateCoordonne($id,$info){
    try{
        $connec = getPDO();
        $update = $connec->prepare("UPDATE coordonnee
                                    SET information=:info
                                    WHERE id_coordonnee=:id");
        $update->bindParam('info', $info, PDO::PARAM_STR);
        $update->bindParam('id', $id, PDO::PARAM_INT);
        return $update->execute();
    }
    catch(Exception $e){
        echo("Une erreur est survenue lors de la mise à jour des dates du voyage " . $id . " : ".$e->getMessage());
    }
    return false;
}