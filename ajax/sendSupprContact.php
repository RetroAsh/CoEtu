<?php
    require_once '../lib/securite.php';

    require_once "../login.inc";
    require_once '../lib/sql.php';
    require_once '../lib/html.php';

    if(isset($_POST["id_contact"]))
    {
        print(deleteContact($_POST["id_contact"]));
    }

?>