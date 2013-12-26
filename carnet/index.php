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
		<title><?php echo selectNomPerso($_SESSION["user_id"]) ?> - Contacts</title>
        <?php head() ?>
        <script type="text/javascript">
            var current = window.location.hash.substring(1);
            if (current=="") {
                current = -1;
            };
            window.onload=function() {
                getContacts(current);
                setInterval(function(){getContacts(current)},5000);
                getInfoContact(current);
            }
        </script>
	</head>
    <body>
        <div id="titre">
            <h1>Contacts</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="carnet">
            <div id="contact">
                <br />
                <br />
                <br />
                <br />
                <span class="welcome">Selectionner un contact pour l'afficher.</span>
            </div>
            <div id="liste">

            </div>
        </div>
        <?php nav(); ?>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]) ?>
    </body>
</html>