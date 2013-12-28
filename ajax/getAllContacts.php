<?php
    require_once '../lib/securiter.php';
    session_start();
    if(!isLogged()){
        header("Location: ..");
    }
    require_once "../login.inc";
    require_once '../lib/sql.php';
    require_once '../lib/html.php';
    if ($_SESSION["user_id"]==3) {
        $contact = selectAllContact();
    }
    else {
        $contact = selectContactsSQL($_SESSION["user_id"]);
    }
    if (!isset($_POST['id'])) {
        $_POST['id'] = '';
    }
    foreach($contact as $key => $value) {
        $select = '';
        if ($_POST['id']==$value[0]) {
            $select = "class='selected'";
        }
        print("<a href=\"#".$value[0]."\" " . $select . " id=\"c".$value[0]."\" onclick=\"getInfoContact(".$value[0].")\">".contractNom($value[1], $value[2])."</a>\n");
    }
