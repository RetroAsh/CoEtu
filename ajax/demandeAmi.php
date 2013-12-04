<?php

    require_once "../login.inc";
    require_once '../lib/securiter.php';
    session_start();
    if(!isLogged()){
        header("Location: ..");
    }

    require_once '../lib/sql.php';

    $statut = getStatut($_SESSION["user_id"], $_POST["id_contact"]);


    switch ($statut) {
        case -1:
        {
            # se connaisse pas
            addInCarnet($_SESSION["user_id"], $_POST["id_contact"]);
            break;
        }

        case 0:
        {
            # il y a deja une demande, on devrai pas arriver ici
            die("you cheater !!! (0)");
            break;
        }

        case 1:
        {
            # se connaisse, on devrai pas arriver ici a moins que triche
            die("you cheater !!! (1)");
            break;
        }

        case 2:
        {
            # Je met quoi la ?
            break;
        }
        
        default:
        {
            # on devrai jamais arriver la
            die("you cheater !!! (def)");
            break;
        }
    }
?>