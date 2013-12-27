<?php
    session_start();
    require_once '../lib/securiter.php';
    if(!isLogged()){
        header("Location: ..");
    }
    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo selectNomPerso($_SESSION["user_id"]) ?> - Voyages</title>
		<?php head() ?>
        <script type="text/javascript">
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