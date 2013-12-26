<?php
require_once '../lib/securiter.php';
session_start();
if(!isLogged()){
    header("Location: ..");
}
require_once "../login.inc";
require_once '../lib/sql.php';
require_once "../lib/sql/select.php";

if (isset($_POST["id_voyage"])) {
    $tabInfo = selectInfoVoyage($_POST["id_voyage"]);
    echo $tabInfo["depart_lat"].",".$tabInfo["depart_lng"].",".$tabInfo["arrive_lat"].",".$tabInfo["arrive_lng"];
}