<?php


    require_once '../lib/securiter.php';
    session_start();
    if(!isLogged()){
        header("Location: ..");
    }
    require_once "../login.inc";
    require_once '../lib/sql.php';

    if (selectNbNotification($_SESSION["user_id"])>0) {
        $listRequete = selectRequete($_SESSION["user_id"]);
        $msgs = selectUnreadMsg($_SESSION["user_id"]);
        echo "<table id='notif' >";
        foreach ($msgs as $value) {
            echo "<tr>";
            echo "<td>";
            echo "<h6>Message de " . $value['pre'] . " " . $value['nom'] . "</h6>";
            echo $value['msg'];
            echo "</td>";
            echo "<td>";
            echo "<input type='button' value='voir' onclick='window.location = \"../messages/#" . $value['id'] . "\";pop_close();' />";
            echo "</td>";
            echo "</tr>";
        }
        foreach ($listRequete as $value) {
            echo "<tr id='r$value'>";
            echo "<td>";
            echo "<h6>Demande de contat</h6>";
            echo selectNomPerso($value)." veut etre votre amis";
            echo "</td>";
            echo "<td>";
            echo "<input type='button' value='accepter' onclick='acceptRequest($value)' />";
            echo "<input type='button' value='refuser' onclick='deleteRequest($value)' />";
            echo "</td>";
            echo "</tr>";
        }    
        echo "</table>";
    }
    else {
        echo "<br /><br /><br /><p class='nonotif'>Pas de nouvelle notification.</p>";
    }


?>
