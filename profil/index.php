<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/html.php';
    require_once '../lib/sql.php';

    $err = "";

    if(isset($_POST['couleur'])){
        updateCouleur($_SESSION['user_id'],$_POST['couleur']);
    }
	
	
	
	
	if(isset($_POST['ville']) && isset($_POST['univ'])){
		if(selectIdVille($_POST['ville'])!=false && selectIdUniversite($_POST['univ'])!=false){
			updatePerso($_SESSION['user_id'],selectIdVille($_POST['ville']),selectIdUniversite($_POST['univ']),$_POST['mois'],$_POST['annee']);
		}
        else {
            $err .= "Ville ou université invalide. <br />\n";
        }
        $coordonnee = selectCoordonee($_SESSION['user_id']);
        foreach ($_POST as $key => $value) {
            if ($key[0]=="i" && isset($coordonnee[substr($key,1)]) && $coordonnee[substr($key,1)]["info"]!=$value) {
                if($coordonnee[substr($key,1)]["libel"]=="tel" && !tel_valid($value)){
                    $err .= "Numero de teleohone invalide. <br />\n";
                    continue 1;
                }
                if($coordonnee[substr($key,1)]["libel"]=="email" && (selectVerifDispoEmail($value) || !email_valid($value))){
                    $err .= "Email invalide ou déja utilisé. <br />\n";
                    continue 1;
                }
                if($coordonnee[substr($key,1)]["libel"]=="site" && !url_valid($value)){
                    $err .= "URL invalide. <br />\n";
                    continue 1;
                }
                updateCoordonne(substr($key,1),$value);
            }
        }
        if(!empty($_POST["new_info"])){
            $ok = true;
            if($_POST["new_label"]=="email" && (selectVerifDispoEmail($_POST["new_info"]) || !email_valid($_POST["new_info"]))){
                $ok = false;
                $err .= "Email ivalide ou déja utilisé.<br />\n";
            }
            if($_POST["new_label"]=="tel" && !tel_valid($value)){
                $ok = false;
                $err .= "Numero de télèphone invalide.<br />\n";
            }
            if(($_POST["new_label"]=="site" || $_POST["new_label"]=="facebook") && !url_valid($value)){
                $ok = false;
                $err .= "URL (" . $_POST["new_label"] . ") invalide.<br />\n";
            }
            if($ok){
                insertCordonne($_SESSION["user_id"],$_POST["new_info"],$_POST["new_label"]);
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
	
	
	if(isset($_POST['actuel']) && isset($_POST['new1']) && isset($_POST['new2'])){
		if(empty($_POST['actuel'])){
			$err.="Veuillez renseigner le mot de passe actuel<br />\n";
		}
		if(empty($_POST['new1'])){
			$err.="Veuillez renseigner le nouveau mot de passe<br />\n";
		}
		if(empty($_POST['new2']) && !empty($_POST['new1'])){
			$err.="Veuillez renseigner la confirmation du nouveau mot de passe<br />\n";
		}
		
		
		
		
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
			<form id="mdp" method="post" style="display:none" >
				<label for="actuel" type="text">Mot de passe actuel :</label>
				<input id="actuel" name="actuel" type="password" /></br>
				<label for="actuel" type="text">Nouveau mot de passe :</label>
				<input id="new1" name="new1" type="password" /></br>
				<label for="actuel" type="text">Confirmer :</label>
				<input id="new2" name="new2" type="password" /></br>
				<input type="submit" value="Valider"/>
				<input type="reset" value="Annuler" onclick="document.getElementById('mdp').style.display='none'"/>
			</form>
        </div>
        <?php nav(); ?>
        <form id="colorpick" method="post">
            <?php echo "<input onchange='document.getElementById(\"colorpick\").submit()' name='couleur' id='couleur' class='color' value='".selectCouleur($_SESSION['user_id'])."'>"; ?>
        </form>
        <form id="form_del_compte" >
            <input type='hidden' value="Supprimer ce compte" name='supprimer_compte'  />
            <a onclick="document.getElementById('new').style.display='inline'" >Ajouter une info</a>
            <br />
            <br />
			<a onclick="document.getElementById('mdp').style.display='inline'" >Modifier le mot de passe</a>
			<br />
            <br />
            <a onclick="if(confirm('Etes-vous sur de vouloir supprimer définitevement votre compte?\nIl sera impossible de le récuperer.')){document.getElementById('form_del_compte').submit()};" >Supprimer ce compte</a>
        </form>
    </body>
</html>