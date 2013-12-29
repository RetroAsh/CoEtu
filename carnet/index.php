<?php

    require_once '../lib/securite.php';

    require_once '../lib/html.php';
    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

    $title = selectNomPerso($_SESSION["user_id"]) . " - Contacts";
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