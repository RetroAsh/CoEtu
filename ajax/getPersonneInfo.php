<?php

    require_once '../lib/securite.php';

    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    echo "<div class='infoautreperso' >";
    if ($_POST["id"]==$_SESSION["user_id"]) {
    	echo "C'est vous.";
    }
    elseif (selectVerificationContact($_POST["id"],$_SESSION["user_id"])) {
    	printInfoContact($_POST["id"]);
        echo "<input type='button' value='Voir' onclick=\"window.location = '../carnet/#" . $_POST["id"] . "';pop_close();\" title=\"Afficher dans le carnet d'adresse.\" />
            <input type='button' value='Message' onclick=\"window.location = '../messages/#" . $_POST["id"] . "';pop_close();\" title='Envoyer un message.' />";
    }
    else {
    	printMinimalInfoContact($_POST["id"]);
        if(selectStatut($_POST["id"],$_SESSION["user_id"]) != 0){
    	   echo "<p id=\"textAdd\" class='msg'>Cette personne ne fait parti de vos contacte. Ajouter la pour voir ses informations.</p>";
    	   echo "<input id=\"buttonAdd\" type='button' value='Ajouter' onclick=\"faireDemandeAmis(".$_POST["id"].")\" />";
        }else{
            echo "<p class='msg'>Demande de contact en cours</p>";
        }
    }
    echo "</div>";

?>