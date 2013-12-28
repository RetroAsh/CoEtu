<?php

	require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

    $msgs = selectUnreadMsg($_SESSION["user_id"]);

    foreach (selectOpenConversations($_SESSION["user_id"]) as $conver) {
    	$select = "";
    	if ($conver["id"]==$_POST["selected"]) {
    		$select = "class='selected'";
    	}
        elseif(isset($msgs[$conver["id"]])){
            $select = "class='unread'";
        }
        print("<a href='#".$conver["id"]."' " . $select . " id='c".$conver["id"]."' onclick='openConversation(".$conver["id"].")'>".contractNom($conver["nom"],$conver["pre"])."</a>\n");
    }


?>
