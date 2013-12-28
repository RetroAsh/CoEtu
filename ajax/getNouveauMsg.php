<?php

	require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

    $ajax = "";

    if (selectVerificationContact($_POST["id"],$_SESSION["user_id"])) {
    	foreach (selectNewMsg($_POST["id"],$_SESSION["user_id"]) as $msg) {
            if ($ajax!="") {
                $ajax .= "#\n";
            }
            $ajax .= ucfirst($msg["pre_emeteur"]) . " " . ucfirst($msg["nom_emeteur"]) . "|";
            $ajax .= smalltimestamp($msg["time"]) . "|";
            $ajax .= $msg["msg"];
    	}
    }

    echo $ajax;

?>