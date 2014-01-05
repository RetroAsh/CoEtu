<?php

require_once '../lib/securite.php';

require_once "../login.inc";
require_once '../lib/sql.php';
require_once "../lib/sql/select.php";

if (isset($_POST["id"])) {
    $tabInfo = selectInfoVille($_POST["id"]);
    echo $tabInfo[2].",".$tabInfo[3];
}