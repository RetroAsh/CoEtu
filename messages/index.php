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
            var isEnter = false;
            var current = window.location.hash.substring(1);
            if (current=="") {
                current = -1;
            };
            window.onload=function() {
                getConversation(current);
                openConversation(current);
                setInterval(function(){getNewMsg(current)},1500);
                setInterval(function(){getConversation(current)},5000);
                document.getElementById("buffer").focus();

                document.getElementById("buffer").onkeyup=function(e){ 
                    if(e.which == 13 && isEnter == true && document.getElementById("enter_tchat").checked) {
                        document.getElementById("buffer").value="";
                    }
                    if(e.which == 13) {
                        isEnter=false; 
                    }
                }

                document.getElementById("buffer").onkeydown=function(e){
                    if(e.which == 13) {
                        isEnter=true;
                    }
                    if(e.which == 13 && isEnter == true && document.getElementById("buffer") && document.getElementById("enter_tchat").checked) {
                        sendMsg(current);
                    }
                }
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
                    <?php
                    if(selectNbOpenConversations($_SESSION["user_id"])>0){
                        echo("<span class='welcome'>Selectionner une conversation pour l'afficher.</span>");
                    }
                    else {
                        echo("<span class='welcome'>Pour ouvrir une nouvelle conversation, allez dans vos <a href='../carnet' >contacts</a>, sélectionnez une personne et cliquez sur \"Message\".</span>");
                    }
                    ?>
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