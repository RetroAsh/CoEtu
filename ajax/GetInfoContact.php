<?php

require_once '../lib/securiter.php';
session_start();
if(!isLogged()){
    header("Location: ..");
}
require_once "../login.inc";
require_once '../lib/sql.php';
require_once '../lib/html.php';


if (isset($_POST["id_etu"])) {
    if (selectVerificationContact($_SESSION['user_id'], $_POST["id_etu"])) {
        $voy = selectAllVoyages($_POST["id_etu"]);
        echo "<h2>" . selectNomPerso($_POST["id_etu"]) . "</h2>";
        printInfoContact($_POST["id_etu"]);
        print("<div class='voyage_carnet'>");
        foreach ($voy as $value) {
            print("<a href='#" . $_POST["id_etu"] . "' onclick='voyage(" . $value["id"] . ",\"" . $value["depart"] . " &rarr; " . $value["arrive"] . "\")' >" . $value["depart"] . " &rarr; " . $value["arrive"] . "</a><br />");
        }
        print("</div>");
        print "<div class=\"option\">";
        print "<a href=\"../messages/#" . $_POST["id_etu"] . "\">messages </a>";
        print "<a href=\"#\" onclick='supprContact(\"";
        print($_POST["id_etu"]);
        print "\")'> oublier</a></div>";
    }else{
        print("<p class=\"err\">Modifier le javascript, c'est mal, m'voyer.</p>");
    }
}