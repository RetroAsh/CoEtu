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

function deleteVoyage($id){
	try{
		$connec = getPDO();
		$deleteCarnet = $connec->prepare("DELETE FROM voyage 
										WHERE id_voy = " . $id);
		$deleteCarnet->bindParam('etu1', $etu1, PDO::PARAM_INT);
		$deleteCarnet->bindParam('etu2', $etu2, PDO::PARAM_INT);	
		return $deleteCarnet->execute();	
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression de la demande de contact : ".$e->getMessage());
	}
	return false;	
}

function deleteRequete($etu1, $etu2) {
	try{
		$connec = getPDO();

		$deleteCarnet = $connec->prepare("DELETE FROM carnet
					WHERE id_etu = :etu1
					AND id_etu_etudiant = :etu2
					AND statut_car = 0;");
		$deleteCarnet->bindParam('etu1', $etu1, PDO::PARAM_INT);
		$deleteCarnet->bindParam('etu2', $etu2, PDO::PARAM_INT);	
		return $deleteCarnet->execute();	
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression de la demande de contact : ".$e->getMessage());
	}
	return false;
}

function deleteVoyagePasse(){
	try{
		$connec = getPDO();
		$deleteVoyage = $connec->prepare("DELETE FROM voyage 
				WHERE date_aller<CURDATE()
				AND (date_retour='0000-00-00' 
					OR (date_retour<CURDATE() 
					AND date_retour<>'0000-00-00'))
				AND recursivite=0");	
		return $deleteVoyage->execute();	
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression des vieux voyages : ".$e->getMessage());
	}
	return false;		
}

function deleteCompte($idetu){
	try{
		$connec = getPDO();
		$deleteCompte = $connec->prepare("DELETE FROM etudiant  
				WHERE id_etu=$idetu");	
		return $deleteCompte->execute();	
	}
	catch( Exception $e ){
		echo("Une erreur est survenue lors de la suppression du compte : ".$e->getMessage());
	}
	return false;	
}