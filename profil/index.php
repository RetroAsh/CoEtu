<?php
    session_start();
    require_once '../lib/securiter.php';
    if(!isLogged()){
        header("Location: ..");
    }
    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    if(isset($_POST['couleur'])){
        updateCouleur($_SESSION['user_id'],$_POST['couleur']);
    }
	if(isset($_POST['sauvegarder'])){
		if(selectIdVille($_POST['ville'])!=false && selectIdCampus($_POST['lieu'])!=false){
			updatePerso($_SESSION['user_id'],selectIdVille($_POST['ville']),selectIdCampus($_POST['lieu']),$_POST['mois'],$_POST['annee']);
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo "(" . selectNbNotification($_SESSION['user_id']) . ") " . selectNomPerso($_SESSION["user_id"]) ?> - vos infos</title>
		<?php head() ?>
        <script type="text/javascript" src="../js/jscolor/jscolor.js"></script>
	</head>
    <body>
        <div id="titre">
            <h1>Vos infos</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="param">
            <?php formModInfo($_SESSION["user_id"]); ?>
            <br />
        </div>
        <?php nav(); ?>
        <form id="colorpick" method="post">
            <?php echo "<input onchange='document.getElementById(\"colorpick\").submit()' name='couleur' id='couleur' class='color' value='".selectCouleur($_SESSION['user_id'])."'>"; ?>
        </form>
    </body>
</html>