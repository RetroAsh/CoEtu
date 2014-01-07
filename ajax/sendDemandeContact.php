<?php

    require_once '../lib/securite.php';

    require_once "../login.inc";
    require_once '../lib/sql.php';

    $statut = selectStatut($_SESSION["user_id"], $_POST["id_contact"]);


    switch ($statut) {
        case -1:
        {
            # se connaissent pas
            insertCarnet($_SESSION["user_id"], $_POST["id_contact"]);
            break;
        }

        case 0:
        {
            # il y a déjà une demande, on ne devrait pas arriver ici
            die("you cheater !!! (0)");
            break;
        }

        case 1:
        {
            # se connaissent, on devrait pas arriver ici à moins que triche
            die("you cheater !!! (1)");
            break;
        }

        case 2:
        {
            # Je mets quoi là ?
            break;
        }
        
        default:
        {
            # on devrait jamais arriver là
            die("you cheater !!! (def)");
            break;
        }
    }
?>