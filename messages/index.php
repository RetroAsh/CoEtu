<?php
 
    session_start();
    require_once '../lib/securiter.php';
    if(!isLogged()){
        header("Location: ..");
    }
    require_once '../lib/html.php';
    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

?>

<!DOCTYPE html>
<html>
	<head>
        <title><?php echo selectNomPerso($_SESSION["user_id"]) ?> - Messagerie</title>
        <?php head() ?>
        <script type="text/javascript">
            var current = window.location.hash.substring(1);
            if (current=="") {
                current = -1;
            };
            window.onload=function() {
                getConversation(current);
                openConversation(current);
                setInterval(function(){getNewMsg(current)},1000);
                setInterval(function(){getConversation(current)},5000);
                document.getElementById("buffer").focus();
            }
        </script>
	</head>
    <body>
        <div id="titre">
            <h1>Messagerie</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="messagerie">
            <div id="conversation">
                <div id='scrollpane'>
                    <br />
                    <br />
                    <br />
                    <br />
                    <span class="label">Selectionner une conversation pour l'afficher.</span>
                </div>
                <form onsubmit="sendMsg(current);return false;" >
                    <input placeholder="Votre message" id="buffer" type="text" autocomplete="off" />
                </form>
            </div>
            <div id="liste">
            </div>
        </div>
        <?php nav(); ?>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]) ?>
    </body>
</html>