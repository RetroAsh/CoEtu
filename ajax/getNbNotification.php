<?php

    require_once '../lib/securite.php';

    require_once "../login.inc";
    require_once '../lib/sql.php';

    echo selectNbNotification($_SESSION['user_id']);

?>