<?php

    require_once '../lib/securite.php';

    require_once '../lib/html.php';
    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

    $title = selectNomPerso($_SESSION["user_id"]) . " - Messages";
    $real = selectNbNotification($_SESSION['user_id']);
    if ($real>0) {
        $real = "(" . $real . ") " . $title;
    }
    else {
        $real = $title;
    }

?>

<!DOCTYPE html>
<html>
	<head>
        <title><?php echo $real ?></title>
        <?php head() ?>
        <script type="text/javascript">
            var title = "<?php echo $title ?>";
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
                    <br />
                    <br />
                    <span class="welcome">Selectionner une conversation pour l'afficher.</span>
                </div>
                <form id="form_tchat" onsubmit="sendMsg(current);return false;" >
                    <textarea placeholder=" Votre message" id="buffer" type="text" autocomplete="off" ></textarea>
                    <label for="enter_tchat" >appuyer sur entrée pour envoyer</label>
                    <input id="enter_tchat" type='checkbox' />
                    <input value='Envoyer' type='submit' />
                </form>
            </div>
            <div id="liste">
            </div>
        </div>
        <?php nav(); ?>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]) ?>
    </body>
</html>