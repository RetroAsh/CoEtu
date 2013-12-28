<?php

    require_once '../lib/securite.php';

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
        <script type="text/javascript" src="../js/jscolor/jscolor.js"></script>
        <script type="text/javascript">
            var title = "<?php echo $title ?>";
        </script>
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