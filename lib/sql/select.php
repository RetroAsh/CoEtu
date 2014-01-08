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

function selectNbEmailUser($id){
    $connec = getPDO();
    $requete = "SELECT COUNT( * ) AS nb
                FROM  coordonnee
                WHERE  libelle_coordonnee =  'email'
                AND  id_etu = :id";

    $q = $connec->prepare($requete);
    $q->bindParam('id', $id, PDO::PARAM_INT);
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

    // On considère le mot de passe comme juste
    $rep = true;

    // On récupère l'étudiant correspondant à l'identifiant fourni
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

    // Si on trouve l'étudiant
    if (isset($tab['mot_de_passe'])) {
        // On vérifie si le hash du mdp fourni et le même que celui stocké
        if (hash("sha256", $mdp, null) != $tab['mot_de_passe']) {
            $rep = false;
        }
        // Si on ne trouve pas l'étudiant
    }else{
        $rep = false;
    }

    return $rep;
}

function selectVerificationMdp($id,$mdp){
    $connec = getPDO();

    // On considère le mot de passe comme juste
    $rep = true;

    // On récupère l'étudiant correspondant à l'identifiant fourni
    $requete = "SELECT E.mot_de_passe
				FROM etudiant E
				WHERE E.id_etu=$id";

    try{
        $select = $connec->query($requete);
    }catch(Exception $e) {
        die($e->getMessage());
    }

    $tab = $select->fetch();

    // Si on trouve l'étudiant
    if (isset($tab['mot_de_passe'])) {
        // On v&rifie si le hash du mdp fourni et le même que celui stock&
        if (hash("sha256", $mdp, null) != $tab['mot_de_passe']) {
            $rep = false;
        }
        // Si on ne trouve pas l'étudiant
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

function selectAllVoyagesAdmin(){
    $connec = getPDO();
    $requete = "SELECT V.id_voy,V.date_aller,V.date_retour,VD.nom_ville,VA.nom_ville,E.prenom_etu,E.nom_etu
				FROM voyage V, ville VD, ville VA, etudiant E
				WHERE V.ville_depart=VD.id_ville
				AND V.id_etu=E.id_etu;
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
        $voy[$tab["id_voy"]]["pre"] = $tab["prenom_etu"];
        $voy[$tab["id_voy"]]["nom"] = $tab["nom_etu"];
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
    $requete = "SELECT E.id_etu, E.prenom_etu, E.nom_etu, U.libelle, V.nom_ville
				FROM etudiant E
				JOIN universite U ON E.id_univ = U.id_univ
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

// renvoie le prénom et nom de l'id en paramètre
function selectNomPerso($id){
    $connec = getPDO();

    $requete = "SELECT E.prenom_etu, E.nom_etu
				FROM etudiant E
				WHERE E.id_etu = '$id';";

    $rep = $connec->query($requete);

    $tab = $rep->fetch();

    return ucfirst($tab[0]) . " " . ucfirst($tab[1]);
}

// Fonction permettant de récupérer l'ID correspondant à l'email
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

// retourne l'ID du campus si le libellé fourni existe ou false si il n'existe pas
function selectIdUniversite($nomUniv){

    $connec = getPDO();

    $nomUniv = str_replace("&apos;", "''", $nomUniv);

    $requete = "SELECT id_univ FROM universite WHERE libelle = '$nomUniv' ;";
    $tab = $connec->query($requete);

    if($res = $tab->fetch(PDO::FETCH_OBJ)){
        return $res->id_univ;
    }
    else{
        return false;
    }
}

// retourne l'ID de la ville si le nom de ville fourni existe ou false si il n'existe pas
function selectIdVille($nomVille){

    $connec = getPDO();

    $nomVille = str_replace("&apos;", "''", $nomVille);

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
    $requete = "SELECT u.libelle,v.id_ville,e.annee_ne_etu,e.mois_ne_etu,a.nom_acad
				FROM etudiant e,universite u,ville v,academie a
				WHERE e.id_etu = '$id'
				AND e.id_univ = u.id_univ
				AND e.id_ville = v.id_ville
				AND u.id_acad = a.id_acad;";

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

function selectStatut($etu1, $etu2){
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

    $requete1 = "SELECT v.id_ville, v.nom_ville, v.lat_ville, v.lng_ville
				FROM ville v
				WHERE v.id_ville = '$id';";

    $tab = $connec->query($requete1);

    $info = $tab->fetch();

    return $info;
}

function selectRequete($i){
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

/*
 * On récupère touq les contacts de chaque étudiant et on
 * regarde les contacts en commun.
 */
function selectNbContactCommun($id1, $id2){
    $connec = getPDO();

    $query1 = "select id_etu_etudiant
               from carnet
               where id_etu = ".$id1."
               and  statut_car = 1;";

    $query2 = "select id_etu
               from carnet
               where id_etu_etudiant = ".$id1."
               and  statut_car = 1;";

    $query3 = "select id_etu_etudiant
               from carnet
               where id_etu = ".$id2."
               and  statut_car = 1;";

    $query4 = "select id_etu
               from carnet
               where id_etu_etudiant = ".$id2."
               and  statut_car = 1;";

    $listContactEtu1 = array();
    $listContactEtu2 = array();

    $res = $connec->query($query1);
    while($elem = $res->fetch()){
        $listContactEtu1[] = $elem[0];
    }

    $res = $connec->query($query2);
    while($elem = $res->fetch()){
        $listContactEtu1[] = $elem[0];
    }

    $res = $connec->query($query3);
    while($elem = $res->fetch()){
        $listContactEtu2[] = $elem[0];
    }

    $res = $connec->query($query4);
    while($elem = $res->fetch()){
        $listContactEtu2[] = $elem[0];
    }

    $rep = 0;
    foreach ($listContactEtu1 as $key => $value){
        if(in_array($value, $listContactEtu2)){
            $rep += 1;
        }
    }

    return $rep;
}


function selectNomVilleLike($code){
    $connec = getPDO();
    $requete = "SELECT nom_ville FROM ville 
				WHERE nom_ville like '".addslashes($code)."%' LIMIT 5;";

    $array=array();
	$select = $connec->query($requete);

	while($ligne = $select->fetch()){
	  array_push($array, $ligne['nom_ville']);
	}
	return $array;
}

function selectNomUniversiteLike($code){
	$connec = getPDO();
	$requete = "SELECT u.libelle FROM universite u
				JOIN ville v ON u.id_ville=v.id_ville
				WHERE v.nom_ville like '%".addslashes($code)."%' 
				OR u.libelle like '%".addslashes($code)."%' LIMIT 5;";
				
	$array=array();
	$select = $connec->query($requete);
	
	while($ligne = $select->fetch()){
	  array_push($array, $ligne['libelle']);
	}
	return $array;
}
