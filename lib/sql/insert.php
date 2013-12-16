<?php

function insertCarnet($etu1, $etu2){
	try{
		$connec = getPDO();
		$insertCarnet = "INSERT INTO carnet (statut_car, id_etu, id_etu_etudiant)
							VALUES (0, :etu1, :etu2);";
		$insertCarnet->bindParam('etu1', $etu1, PDO::PARAM_INT);
		$insertCarnet->bindParam('etu2', $etu2, PDO::PARAM_INT);	
		return $insertCarnet->execute();
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de l'insertion de la demande de contact : ".$e->getMessage());
	}
	return false;
}

function insertMsg($de,$a,$msg){
	try{
		$connec = getPDO();
		$insertMsg = "INSERT INTO message (msg, etu_send, etu_get)
					VALUES (:msg, :de, :a);";
		$insertMsg->bindParam('msg', $msg, PDO::PARAM_STR);
		$insertMsg->bindParam('de', $de, PDO::PARAM_INT);
		$insertMsg->bindParam('a', $a, PDO::PARAM_INT);
		return $insertMsg->execute();
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de l'insertion du message : ".$e->getMessage());
	}
	return false;
}

function insertInscription($mdp, $nom, $prenom, $mois, $annee, $ville, $campus, $mail){
	try{
		$connec = getPDO();

		$motdepasse = hash("sha256", $mdp, null);

		$selectEtu = $connec->prepare("SELECT id_etu
					FROM etudiant
					WHERE mot_de_passe = :motdepasse
					AND nom_etu = :nom
					AND prenom_etu = :prenom
					AND mois_ne_etu = :mois
					AND annee_ne_etu = :annee
					AND id_ville = :ville
					AND id_camp = :campus;");
		
		$selectEtu->bindParam('motdepasse', $motdepasse, PDO::PARAM_STR);
		$selectEtu->bindParam('nom', $nom, PDO::PARAM_STR);
		$selectEtu->bindParam('prenom', $prenom, PDO::PARAM_STR);
		$selectEtu->bindParam('mois', $mois, PDO::PARAM_INT);
		$selectEtu->bindParam('annee', $annee, PDO::PARAM_INT);
		$selectEtu->bindParam('ville', $ville, PDO::PARAM_INT);
		$selectEtu->bindParam('campus', $campus, PDO::PARAM_INT);
		
		if($selectEtu->execute()){
			if($selectEtu->rowCount() == 0){
				try{
				
					$insertEtu = $connec->prepare("INSERT INTO etudiant
							VALUES (null, :motdepasse, :nom, :prenom, :mois, :annee, :ville, :campus, '0078E7');");
					$insertEtu->bindParam('motdepasse', $motdepasse, PDO::PARAM_STR);
					$insertEtu->bindParam('nom', $nom, PDO::PARAM_STR);
					$insertEtu->bindParam('prenom', $prenom, PDO::PARAM_STR);
					$insertEtu->bindParam('mois', $mois, PDO::PARAM_INT);
					$insertEtu->bindParam('annee', $annee, PDO::PARAM_INT);
					$insertEtu->bindParam('ville', $ville, PDO::PARAM_INT);
					$insertEtu->bindParam('campus', $campus, PDO::PARAM_INT);
					
					if($insertEtu->execute()){
						try{
							$id_etu = $connec->lastInsertId();
							
							$insertCoord = $connec->prepare("INSERT INTO coordonnee
										VALUES (null,'email',:mail,:id_etu)");
							$insertCoord->bindParam('mail', $mail, PDO::PARAM_INT);
							$insertCoord->bindParam('id_etu', $id_etu, PDO::PARAM_INT);
							return $insertCoord->execute();
						}
						catch( Exception $e ){
							echo("Une erreur est survenue lors de l'insertion du mail : ".$e->getMessage());
						}
					}
				}
				catch( Exception $e ){
					echo("Une erreur est survenue lors de l'insertion de l'utilisateur : ".$e->getMessage());
				}
			}
		}
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la vérification de l'existence de l'utilisateur : ".$e->getMessage());
	}
	return false;
}

function ajoutVoyage($v_dep, $v_arr, $d_dep, $d_arr, $rec){
	try{
		$connec = getPDO();
		
		$insertVoyage = $connec->prepare("INSERT INTO voyage (id_voy, date_aller, date_retour, ville_depart, ville_arrive, statut, id_etu, recursivite) 
					VALUES (NULL, :d_dep, :d_arr, :v_dep, :v_arr, NULL, :id_etu, :rec);");
		
		$insertVoyage->bindParam('d_dep', $d_dep, PDO::PARAM_STR);
		$insertVoyage->bindParam('d_arr', $d_arr, PDO::PARAM_STR);
		$insertVoyage->bindParam('v_dep', $v_dep, PDO::PARAM_INT);
		$insertVoyage->bindParam('v_arr', $v_arr, PDO::PARAM_INT);
		$insertVoyage->bindParam('id_etu', $_SESSION['user_id'], PDO::PARAM_INT);
		$insertVoyage->bindParam('rec', $rec, PDO::PARAM_INT);
		
		return $insertVoyage->execute();
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de l'insertion du voyage : ".$e->getMessage());
	}
	return false;
}