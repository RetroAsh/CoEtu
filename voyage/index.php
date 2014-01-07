<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    $title = selectNomPerso($_SESSION["user_id"]) . " - Voyages";
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
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script type='text/javascript' src='../js/villeVoyage.js' ></script>
        <script type="text/javascript">
            var title = "<?php echo $title ?>";
            window.onload=function() {
                getVoyages();
            }
        </script>
	</head>
    <body>
        <div id="titre">
            <h1>Voyages</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="voyages"></div>
        <?php nav(); ?>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]); ?>
    </body>
</html>