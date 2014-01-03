<?php

function selectVerifPerso($id){
    $connec = getPDO();
    $requete = "SELECT count(*)
    			FROM etudiant
    			WHERE id_etu=:id;";

    $q = $connec->prepare($requete);
    $q->bindParam('id', $id, PDO::PARAM_INT);
    $q->execute();
    $q = $q->fetch();
    return $q[0];
}

function selectVerifDispoEmail($email){
    $connec = getPDO();
    $requete = "SELECT COUNT( * ) AS nb
                FROM  coordonnee 
                WHERE  libelle_coordonnee =  'email'
                AND  information = :email";

    $q = $connec->prepare($requete);
    $q->bindParam('email', $email, PDO::PARAM_STR);
    $q->execute();
    $q = $q->fetch();
    return $q[0];
}

function selectOpenConversations($id){
    $connec = getPDO();
    $requete = "SELECT DISTINCT EG.id_etu, EG.prenom_etu, EG.nom_etu
				FROM etudiant EG, etudiant ES, message M
				WHERE ES.id_etu=$id
				AND ((ES.id_etu=M.etu_send
						AND EG.id_etu=M.etu_get)
					OR (ES.id_etu=M.etu_get
						AND EG.id_etu=M.etu_send))
				ORDER BY M.msg_time;";
    $rep = $connec->query($requete);
    $etu = array();
    while ($tab = $rep->fetch()) {
        $etu[$tab["id_etu"]]["id"] = $tab["id_etu"];
        $etu[$tab["id_etu"]]["pre"] = $tab["prenom_etu"];
        $etu[$tab["id_etu"]]["nom"] = $tab["nom_etu"];
    }
    return $etu;
}

function selectNbOpenConversations($id){
    $connec = getPDO();
    $requete = "SELECT DISTINCT count(EG.id_etu)
				FROM etudiant EG, etudiant ES, message M
				WHERE ES.id_etu=$id
				AND ((ES.id_etu=M.etu_send
						AND EG.id_etu=M.etu_get)
					OR (ES.id_etu=M.etu_get
						AND EG.id_etu=M.etu_send))
				ORDER BY EG.prenom_etu;";
    $rep = $connec->query($requete);
    $rep = $rep->fetch();
    return $rep[0];
}

function selectNbUtilisateur(){
    $connec = getPDO();
    $requete = "SELECT count(*) FROM etudiant;";
    $q = $connec->query($requete);
    $q = $q->fetch();
    return $q[0];
}

function selectConversation($perso1,$perso2){
    $connec = getPDO();
    $requete = "SELECT ES.prenom_etu,ES.nom_etu,EG.prenom_etu,EG.nom_etu,M.id_msg,M.msg,M.msg_time, ES.id_etu
				FROM etudiant ES, etudiant EG, message M
				WHERE (ES.id_etu = M.etu_send
       				OR ES.id_etu = M.etu_get)
				AND ES.id_etu = M.etu_send
				AND EG.id_etu = M.etu_get
				AND ((M.etu_send=$perso1
         				AND M.etu_get=$perso2)
     				OR (M.etu_send=$perso2
         				AND M.etu_get=$perso1))
				ORDER BY M.msg_time;";
    $rep = $connec->query($requete);
    $msg = array();
    while ($tab = $rep->fetch()) {
        $msg[$tab["id_msg"]]["id"] = $tab["id_msg"];
        $msg[$tab["id_msg"]]["pre_emeteur"] = $tab[0];
        $msg[$tab["id_msg"]]["nom_emeteur"] = $tab[1];
        $msg[$tab["id_msg"]]["id_emeteur"] = $tab["id_etu"];
        $msg[$tab["id_msg"]]["pre_recepteur"] = $tab[2];
        $msg[$tab["id_msg"]]["nom_recepteur"] = $tab[3];
        $msg[$tab["id_msg"]]["msg"] = $tab["msg"];
        $msg[$tab["id_msg"]]["time"] = $tab["msg_time"];
    }
    return $msg;
}

function selectUnreadMsg($id){
    $connec = getPDO();
    $requete1 = "SELECT E.id_etu, E.prenom_etu, E.nom_etu, M.msg, M.msg_time
				FROM etudiant E, message M
				WHERE M.etu_get=$id
				AND M.etu_send=E.id_etu
				AND M.msg_vu=FALSE;";
    $rep = $connec->query($requete1);
    $etu = array();
    while ($tab = $rep->fetch()) {
        $etu[$tab["id_etu"]]["id"] = $tab["id_etu"];
        $etu[$tab["id_etu"]]["pre"] = $tab["prenom_etu"];
        $etu[$tab["id_etu"]]["nom"] = $tab["nom_etu"];
        $etu[$tab["id_etu"]]["msg"] = $tab["msg"];
        $etu[$tab["id_etu"]]["time"] = $tab["msg_time"];
    }
    return $etu;
}

function selectNewMsg($de,$a){
    $connec = getPDO();
    $requete1 = "SELECT ES.prenom_etu, ES.nom_etu, EG.prenom_etu, EG.nom_etu, M.id_msg, M.msg, M.msg_time, ES.id_etu
				FROM etudiant ES, etudiant EG, message M
				WHERE ES.id_etu = M.etu_send
				AND EG.id_etu = M.etu_get
				AND ES.id_etu = $de
				AND EG.id_etu = $a
				AND M.msg_vu = FALSE;";
    $rep = $connec->query($requete1);
    $msg = array();
    while ($tab = $rep->fetch()) {
        $msg[$tab["id_msg"]]["id"] = $tab["id_msg"];
        $msg[$tab["id_msg"]]["pre_emeteur"] = $tab[0];
        $msg[$tab["id_msg"]]["nom_emeteur"] = $tab[1];
        $msg[$tab["id_msg"]]["id_emeteur"] = $tab["id_etu"];
        $msg[$tab["id_msg"]]["pre_recepteur"] = $tab[2];
        $msg[$tab["id_msg"]]["nom_recepteur"] = $tab[3];
        $msg[$tab["id_msg"]]["msg"] = $tab["msg"];
        $msg[$tab["id_msg"]]["time"] = $tab["msg_time"];
    }
    updateMsgRead($de,$a);
    return $msg;
}

function selectInfoVoyage($id){
    $connec = getPDO();
    $requete = "SELECT V.id_voy, D.nom_ville, D.lng_ville, D.lat_ville, A.nom_ville, A.lng_ville, A.lat_ville, V.date_aller, V.date_retour, V.recursivite, E.prenom_etu, E.nom_etu, E.id_etu
				FROM ville D, ville A, voyage V, etudiant E
				WHERE V.ville_depart=D.id_ville
				AND V.ville_arrive=A.id_ville
				AND E.id_etu=V.id_etu
				AND V.id_voy=" . $id;
    $rep = $connec->query($requete);
    $voy = array();
    while ($tab = $rep->fetch()) {
        $voy["id"] = $tab["id_voy"];
        $voy["depart"] = $tab[1];
        $voy["depart_lng"] = $tab[2];
        $voy["depart_lat"] = $tab[3];
        $voy["arrive"] = $tab[4];
        $voy["arrive_lng"] = $tab[5];
        $voy["arrive_lat"] = $tab[6];
        $voy["aller"] = $tab['date_aller'];
        $voy["retour"] = $tab['date_retour'];
        $voy["pre"] = $tab["prenom_etu"];
        $voy["nom"] = $tab["nom_etu"];
        $voy["conduc"] = $tab["id_etu"];
        $voy["recursivite"] = $tab["recursivite"];
    }
    return $voy;
}

function selectVerificationConnexion($email, $mdp){
    $connec = getPDO();

    // On considere le mot de passe comme juste
    $rep = true;

    // On recupere l'etudiant correspondant a l'identifiant fourni
    $requete = "SELECT E.mot_de_passe
				FROM etudiant E, coordonnee C
				WHERE E.id_etu = C.id_etu
				AND C.libelle_coordonnee = \"email\"
				AND C.information = \"$email\";";

    try{
        $select = $connec->query($requete);
    }catch(Exception $e) {
        die($e->getMessage());
    }

    $tab = $select->fetch();

    // Si on trouve l'etudiant
    if (isset($tab['mot_de_passe'])) {
        // On verifie si le hash du mdp fourni et le meme que celui stocker
        if (hash("sha256", $mdp, null) != $tab['mot_de_passe']) {
            $rep = false;
        }
        // Si on ne trouve pas l'etudiant
    }else{
        $rep = false;
    }

    return $rep;
}

function selectAllVoyages($id){
    $connec = getPDO();
    $requete = "SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville,VA.nom_ville
				FROM voyage V, ville VD, ville VA
				WHERE V.id_etu=$id
				AND V.ville_depart=VD.id_ville
				AND V.ville_arrive=VA.id_ville
				ORDER BY V.date_aller;";
    $rep = $connec->query($requete);
    $voy = array();
    while ($tab = $rep->fetch()) {
        $voy[$tab["id_voy"]]["id"] = $tab["id_voy"];
        $voy[$tab["id_voy"]]["aller"] = $tab["date_aller"];
        $voy[$tab["id_voy"]]["retour"] = $tab["date_retour"];
        $voy[$tab["id_voy"]]["depart"] = $tab[3];
        $voy[$tab["id_voy"]]["arrive"] = $tab[4];
    }
    return $voy;
}

function selectVoyages($nom){
    $connec = getPDO();
    $requete = "SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville as nom_villeD,VA.nom_ville as nom_villeA, E.nom_etu, E.prenom_etu
				FROM voyage V, ville VD, ville VA, etudiant E
				WHERE V.ville_depart=VD.id_ville
				AND V.ville_arrive=VA.id_ville
				AND V.id_etu=E.id_etu
				AND (VD.nom_ville like '%$nom%'
				OR VA.nom_ville like '%$nom%')
				ORDER BY V.date_aller
				LIMIT 30 OFFSET 0;";

    $rep = $connec->query($requete);
    $voy = array();
    while($tab = $rep->fetch(PDO::FETCH_OBJ)){
        $voy[(int)$tab->id_voy] = (Array)$tab;
    }

    $requete = "SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville as nom_villeD ,VA.nom_ville as nom_villeA, E.nom_etu, E.prenom_etu
				FROM voyage V, ville VD, ville VA, etudiant E
				WHERE V.id_etu=E.id_etu
				AND V.ville_depart=VD.id_ville
				AND V.ville_arrive=VA.id_ville
				AND (E.nom_etu like '$nom%'
				OR E.prenom_etu like '$nom%')
				ORDER BY V.date_aller
				LIMIT 30 OFFSET 0;";

    $rep = $connec->query($requete);
    while($tab = $rep->fetch(PDO::FETCH_OBJ)){
        $voy[(int)$tab->id_voy] = (Array)$tab;
    }

    return $voy;
}

function selectAllContactVoyages($id){
    $connec = getPDO();
    $requete = "(SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville,VA.nom_ville,E.prenom_etu,E.nom_etu
				FROM voyage V, ville VD, ville VA, etudiant E, carnet C
				WHERE V.id_etu=C.id_etu
				AND C.id_etu_etudiant=$id
				AND V.ville_depart=VD.id_ville
				AND V.ville_arrive=VA.id_ville
				AND C.statut_car=1
				AND E.id_etu=V.id_etu
				ORDER BY V.date_aller)
				UNION
				(SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville,VA.nom_ville,E.prenom_etu,E.nom_etu
				FROM voyage V, ville VD, ville VA, etudiant E, carnet C
				WHERE V.id_etu=C.id_etu_etudiant
				AND C.id_etu=$id
				AND V.ville_depart=VD.id_ville
				AND V.ville_arrive=VA.id_ville
				AND C.statut_car=1
				AND E.id_etu=V.id_etu
				ORDER BY V.date_aller);";
    $rep = $connec->query($requete);
    $voy = array();
    while ($tab = $rep->fetch()) {
        $voy[$tab["id_voy"]]["id"] = $tab["id_voy"];
        $voy[$tab["id_voy"]]["aller"] = $tab["date_aller"];
        $voy[$tab["id_voy"]]["retour"] = $tab["date_retour"];
        $voy[$tab["id_voy"]]["depart"] = $tab[3];
        $voy[$tab["id_voy"]]["arrive"] = $tab[4];
        $voy[$tab["id_voy"]]["pre"] = $tab["prenom_etu"];
        $voy[$tab["id_voy"]]["nom"] = $tab["nom_etu"];
    }
    return $voy;
}

// renvoie les infos des personnes ayant comme nom $nom
function selectIdPerso($nom){
    $connec = getPDO();
    $requete = "SELECT E.id_etu, E.prenom_etu, E.nom_etu, C.libelle, V.nom_ville
				FROM etudiant E
				JOIN campus C ON E.id_camp = C.id_camp
				JOIN ville V ON E.id_ville = V.id_ville
				WHERE (E.nom_etu like '$nom%'
				OR E.prenom_etu like '$nom%'
				OR V.nom_ville like '$nom%')
				LIMIT 30 OFFSET 0;";

    $rep = $connec->query($requete);
    $id = array();
    while($tab = $rep->fetch(PDO::FETCH_OBJ)){
        $id[(int)$tab->id_etu] = (Array)$tab;
    }
    return $id;
}

// renvoie le prenom et nom de l'id en parametre
function selectNomPerso($id){
    $connec = getPDO();

    $requete = "SELECT E.prenom_etu, E.nom_etu
				FROM etudiant E
				WHERE E.id_etu = '$id';";

    $rep = $connec->query($requete);

    $tab = $rep->fetch();

    return ucfirst($tab[0]) . " " . ucfirst($tab[1]);
}

// Fonction permettant de récuperer l'ID correspondant a l'email
function selectIdEtudiant($email){

    $connec = getPDO();

    $requete = "SELECT E.id_etu
				FROM etudiant E, coordonnee C
				WHERE E.id_etu = C.id_etu
				AND C.libelle_coordonnee = \"email\"
				AND C.information = \"$email\";";

    $rep = $connec->query($requete);

    $tab = $rep->fetch();

    return $tab[0];
}

// retourne l'ID du campus si le libelle fourni existe ou false si il n'existe pas
function selectIdCampus($nomCampus){

    $connec = getPDO();

    $requete = "SELECT id_camp FROM campus WHERE libelle = '$nomCampus' ;";
    $tab = $connec->query($requete);

    if($res = $tab->fetch(PDO::FETCH_OBJ)){
        return $res->id_camp;
    }
    else{
        return false;
    }
}

// retourne l'ID de la ville si le nom de ville fourni existe ou false si il n'existe pas
function selectIdVille($nomVille){

    $connec = getPDO();

    $requete = "SELECT id_ville FROM ville WHERE nom_ville = '$nomVille' ;";
    $tab = $connec->query($requete);

    if($res = $tab->fetch(PDO::FETCH_OBJ)){
        return $res->id_ville;
    }
    else{
        return false;
    }
}

function selectAllContact(){
    $connec = getPDO();

    $requete1 = "SELECT e.id_etu, e.nom_etu, e.prenom_etu
				FROM etudiant e
				ORDER BY e.prenom_etu;";

    $tab = $connec->query($requete1);
    $rep = array();
    while($line = $tab->fetch()){
        $rep[] = $line;
    }

    return $rep;
}

function selectContacts($id){
    $connec = getPDO();

    $requete1 = "SELECT e.id_etu, e.nom_etu, e.prenom_etu
				FROM etudiant e, carnet c
				WHERE ((c.id_etu = $id
				AND e.id_etu = c.id_etu_etudiant)
				OR (c.id_etu_etudiant = $id
                AND e.id_etu = c.id_etu))
                AND c.statut_car = 1
                ORDER BY e.prenom_etu;";

    $tab = $connec->query($requete1);
    $rep = array();
    while($line = $tab->fetch()){
        $rep[] = $line;
    }

    return $rep;
}

function selectNbContacts($id){
    $connec = getPDO();

    $requete1 = "SELECT count(e.id_etu)
				FROM etudiant e, carnet c
				WHERE ((c.id_etu = $id
				AND e.id_etu = c.id_etu_etudiant)
				OR (c.id_etu_etudiant = $id
                AND e.id_etu = c.id_etu))
                AND c.statut_car = 1
                ORDER BY e.prenom_etu;";

    $tab = $connec->query($requete1);
    $tab = $tab->fetch();
    return $tab[0];
}

function selectInfoEtu($id){

    $connec = getPDO();
    $requete = "SELECT ca.libelle,v.id_ville,e.annee_ne_etu,e.mois_ne_etu,u.nom_univ
				FROM etudiant e,campus ca,ville v,universite u
				WHERE e.id_etu = '$id'
				AND e.id_camp = ca.id_camp
				AND e.id_ville = v.id_ville
				AND ca.id_univ = u.id_univ;";

    $tab = $connec->query($requete);
    $info = $tab->fetch();

    return $info;
}

function selectVerificationContact($id,$contact){
    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"]==3) {
        return true;
    }
    $connec = getPDO();

    $requete1 = "SELECT c.id_etu_etudiant
				FROM carnet c
				WHERE c.id_etu = '$id'
				AND c.id_etu_etudiant = '$contact'
                AND c.statut_car = 1;";

    $requete2 = "SELECT c.id_etu_etudiant
                FROM carnet c
                WHERE c.id_etu = '$contact'
                AND c.id_etu_etudiant = '$id'
                AND c.statut_car = 1;";

    $bool1 = true;
    $bool2 = true;

    $tab1 = $connec->query($requete1);

    if ($rep = $tab1->fetch(PDO::FETCH_OBJ)==null) {
        $bool1 = false;
    }

    $tab2 = $connec->query($requete2);

    if ($rep = $tab2->fetch(PDO::FETCH_OBJ)==null) {
        $bool2 = false;
    }

    return $bool1 || $bool2;
}

function selectStatut($etu1, $etu2)
{
    $connec = getPDO();

    $requet = $connec->query("select statut_car from carnet
                    where id_etu=\"".$etu1."\"
                    and id_etu_etudiant=\"".$etu2."\";");

    $tab = $requet->fetch();

    $statut = 42;

    if(!$tab){
        $requet = $connec->query("select statut_car from carnet
                    where id_etu_etudiant=\"".$etu1."\"
                    and id_etu=\"".$etu2."\";");
        $tab2 = $requet->fetch();
        if(!$tab2){
            $statut = -1;
        }else{
            $statut = $tab2[0];
        }
    }else{
        $statut = $tab[0];
    }

    return $statut;
}

function selectNbRequete($id){
    $connec = getPDO();
    $requete1 = "SELECT count(*)
    			FROM carnet C
    			WHERE id_etu_etudiant=$id
    			AND statut_car=0;";
    $q = $connec->query($requete1);
    $q = $q->fetch();
    return $q[0];
}

function selectNbMsgNonLu($id){
    $connec = getPDO();
    $requete2 = "SELECT count(*)
    			FROM message
    			WHERE etu_get=$id
    			AND msg_vu=FALSE;";
    $d = $connec->query($requete2);
    $d = $d->fetch();
    return $d[0];
}

function selectInfoVille($id){
    $connec = getPDO();

    $requete1 = "SELECT v.nom_ville, v.lat_ville, v.lng_ville
				FROM ville v
				WHERE v.id_ville = '$id';";

    $tab = $connec->query($requete1);

    $info = $tab->fetch();

    return $info;
}

function selectRequete($i)
{
    $connec = getPDO();

    $requete = "select id_etu
                from carnet
                where id_etu_etudiant = $i
                and statut_car = 0;";

    $tab = $connec->query($requete);

    $rep = array();

    while($reponse = $tab->fetch()){
        $rep[] = $reponse[0];
    }

    return $rep;
}

function selectCouleur($id){

    $connec = getPDO();

    $requete = "SELECT e.couleur
				FROM etudiant e
				WHERE e.id_etu = '$id'";
    $tab = $connec->query($requete);
    if($res = $tab->fetch(PDO::FETCH_OBJ)){
        $couleur=$res->couleur;
    }

    return $couleur;
}

function selectCoordonee($id){
    $connec = getPDO();

    $requete = "SELECT co.id_coordonnee,co.libelle_coordonnee,co.information
				FROM coordonnee co
				WHERE co.id_etu = '$id'";

    $tab = $connec->query($requete);

    $tableau = Array();
    while( $info = $tab->fetch()){
        $tableau[$info["id_coordonnee"]]["libel"] = $info["libelle_coordonnee"];
        $tableau[$info["id_coordonnee"]]["info"] = $info["information"];
    }

    return $tableau;

}

function selectNbNotification($id){
    return selectNbMsgNonLu($id)+selectNbRequete($id);
}

function selectVoyageDepasseRecurssif(){
    $connec = getPDO();

    $requete = "SELECT id_voy, date_aller, date_retour, recursivite 
                FROM voyage 
                WHERE date_aller<CURDATE()
                AND (date_retour='0000-00-00' 
                    OR (date_retour<CURDATE() 
                    AND date_retour<>'0000-00-00'))
                AND recursivite<>0";

    $tab = $connec->query($requete);

    $tableau = Array();
    $tableau[] = $tab->rowCount();
    while( $info = $tab->fetch()){
        $tableau["id"] = $info["id_voy"];
        $tableau["aller"] = $info["date_aller"];
        $tableau["retour"] = $info["date_retour"];
        $tableau["recursivite"] = $info["recursivite"];
    }

    return $tableau;
}