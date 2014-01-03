<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    $err = "";

    if(isset($_POST['couleur'])){
        updateCouleur($_SESSION['user_id'],$_POST['couleur']);
    }

	if(isset($_POST['sauvegarder'])){
		if(selectIdVille($_POST['ville'])!=false && selectIdCampus($_POST['lieu'])!=false){
			updatePerso($_SESSION['user_id'],selectIdVille($_POST['ville']),selectIdCampus($_POST['lieu']),$_POST['mois'],$_POST['annee']);
		}
        $coordonnee = selectCoordonee($_SESSION['user_id']);
        foreach ($_POST as $key => $value) {
            if ($key[0]=="i" && isset($coordonnee[substr($key,1)]) && $coordonnee[substr($key,1)]["info"]!=$value) {
                if($coordonnee[substr($key,1)]["libel"]=="tel" && !tel_valid($value)){
                    $err .= "Numero de teleohone invalide. <br />\n";
                    continue 1;
                }
                if($coordonnee[substr($key,1)]["libel"]=="email" && !email_valid($value)){
                    $err .= "Email invalide. <br />\n";
                    continue 1;
                }
                if($coordonnee[substr($key,1)]["libel"]=="site" && !url_valid($value)){
                    $err .= "URL invalide. <br />\n";
                    continue 1;
                }
                updateCoordonne(substr($key,1),$value);
            }
        }
	}
	
	if(isset($_POST['supprimer_compte'])){
		deleteCompte($_SESSION['user_id']);
		require_once '../lib/deco.php'; 
	}

    $title = selectNomPerso($_SESSION["user_id"]) . " - Vos infos";
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
            <div class="err"><?php echo $err; ?></div>
            <?php formModInfo($_SESSION["user_id"]); ?>
            <br />
        </div>
        <?php nav(); ?>
        <form id="colorpick" method="post">
            <?php echo "<input onchange='document.getElementById(\"colorpick\").submit()' name='couleur' id='couleur' class='color' value='".selectCouleur($_SESSION['user_id'])."'>"; ?>
        </form>
    </body>
</html>