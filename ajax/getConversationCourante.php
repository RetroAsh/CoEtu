<?php

require_once '../lib/securite.php';

require_once '../lib/html.php';
require_once '../login.inc';
require_once '../lib/sql.php';
require_once '../lib/bibli.php';	

$ajax = "";
$id = -1;

if (isset($_POST["id"]) && selectVerifPerso($_POST["id"])==1 && (selectVerificationContact($_POST["id"],$_SESSION['user_id']) || $_POST["id"]==3)) {
	$id = $_POST["id"];
	$all = selectConversation($_SESSION['user_id'],$id);
	updateMsgRead($id,$_SESSION['user_id']);
	$perso = selectOpenConversations($_SESSION['user_id']);
	$ajax = selectNomPerso($id);
	foreach ($all as $msg) {
		$ajax .= "#\n";
		if ($msg["id_emeteur"]==$_SESSION["user_id"]) {
			$ajax .= "Vous|";
		}
		else {
			$ajax .= ucfirst($msg["pre_emeteur"]) . " " . ucfirst($msg["nom_emeteur"]) . "|";
		}
		$ajax .= smalltimestamp($msg["time"]) . "|";
		$ajax .= insertSmiley($msg["msg"]);
	}
}

echo $ajax;

?>
