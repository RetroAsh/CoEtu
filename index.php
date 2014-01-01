<?php

    date_default_timezone_set("Europe/Paris");

    foreach ($_POST as $key => $value) {
        $value = str_replace('\\','&#92;',$value);
        $value = str_replace('\'', '&apos;', $value);
        $value = str_replace('\"', '&quot;', $value);
        $value = str_replace('<', '&lt;', $value);
        $_POST[$key] = str_replace('>', '&#62;', $value);
    }

    session_start();
	$err = "";

	require 'login.inc';
	require_once 'lib/sql.php';
	require_once 'lib/bibli.php';

    traitementBDD();

	if(isset($_POST["em"]) && isset($_POST["mp"])){
		if(!selectVerificationConnexion($_POST["em"], $_POST["mp"])){
			$err = "Email ou mot de passe incorrect.";
		}
        else{
			$_SESSION["user_id"] = selectIdEtudiant($_POST["em"]);
			header("Location: home/");
		}
	}

	if (isset($_SESSION["user_id"])){
		header("Location: home/");
	}

	$nb_user = selectNbUtilisateur();

	$pre=NULL;
	$nom=NULL;
	$email=NULL;
	$camp=NULL;
	$ville=NULL;
	$mois=NULL;
	$annee=NULL;
	if(isset($_POST['inscription'])){
		if(!isset($_POST['pre']) or $_POST['pre']==""){
			$err=$err."Veuillez fournir le prénom.<br/>";
		}
		else{
			$pre=$_POST['pre'];
		}
		if(!isset($_POST['nom']) or $_POST['nom']==""){
			$err=$err."Veuillez fournir le nom.<br/>";
		}
		else{
			$nom=$_POST['nom'];
		}
		if(!isset($_POST['email']) or $_POST['email']==""){
			$err=$err."Veuillez fournir l'e-mail.<br/>";
		}
		elseif (selectVerifEmail($_POST['email'])) {
			$err=$err."L'email est déja utilisé.<br/>";
		}
		else{
			$email=$_POST['email'];
		}
		if(!isset($_POST['camp']) or $_POST['camp']==""){
			$err=$err."Veuillez fournir le campus.<br/>";
		}
		else{
			$camp=$_POST['camp'];
		}
		if(!isset($_POST['vil']) or $_POST['vil']==""){
			$err=$err."Veuillez fournir la ville.<br/>";
		}
		else{
			$ville=$_POST['vil'];
		}
		if(!isset($_POST['pass']) or $_POST['pass']==""){
			$err=$err."Veuillez fournir le mot de passe.<br/>";
		}
		if(!isset($_POST['pass2']) or $_POST['pass2']==""){
			$err=$err."Veuillez fournir la confimartion du mot de passe.<br/>";
		}
		if(!isset($_POST['mois']) or $_POST['mois']==""){
			$err=$err."Veuillez fournir le mois de naissance.<br/>";
		}
		else{
			$mois=$_POST['mois'];
		}
		if(!isset($_POST['annee']) or $_POST['annee']==""){
			$err=$err."Veuillez fournir l'année de naissance.<br/>";
		}
		else{
			$annee=$_POST['annee'];
		}

		if($err==""){
            if (!email_valid($_POST['email'])) {
                $err = $err . "Veuillez entrer un e-mail valide !<br/>";
            } else {
                $mail = $_POST['email'];
            }
			if($_POST['pass']!=$_POST['pass2']){
				$err=$err."Veuillez entrer un mot de passe identique dans les 2 champs.<br/>";
			}
			$idCampus = selectIdCampus($camp);
			if(!$idCampus){
				$err=$err."Veuillez entrer un nom de campus valide.<br/>";
			}
			else{
				$camp = $idCampus;
			}
			$idVille = selectIdVille($ville);
			if(!$idVille){
				$err=$err."Veuillez entrer un nom de ville valide.<br/>";
			}
			else{
				$ville = $idVille;
			}
            if(empty($err)){
                $nom = ucfirst(strtolower($nom));
                $pre = ucfirst(strtolower($pre));
            	insertInscription($_POST['pass'], $nom, $pre, $mois, $annee, $ville, $camp, $mail);
            	selectVerificationConnexion($mail, $_POST["pass"]);
            	$_SESSION["user_id"] = selectIdEtudiant($mail);
            	header("Location: home/");
            }
			
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Freetu</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link rel='stylesheet' type='text/css' href='css/connec.css' />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script type='text/javascript' src='./js/connec.js' ></script>

	</head>
	<body>
		<div class="connec">
			<?php if (!isset($_SESSION["user_id"])) { ?>
			<form name="connec" method="post">
				<table>
					<tr>
						<td>
							<input value="" placeholder="Email" class="em" id="em" name="em" type="text" />
						</td>
					</tr>
					<tr>
						<td>
							<input value="" placeholder="Mot de passe" class="mp" name="mp" id="mp" type="password" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" value="Connexion" />
						</td>
					</tr>
				</table>
			</form>
			<?php } else { ?>
			<a href='home'><?php echo selectNomPerso($_SESSION["user_id"]); ?></a>
			<br />
			<a href="lib/lib/deco.php">Déconnexion</a>
			<?php } ?>
		</div>
		<div class="titre">
			<h1>Freetu</h1>
			<span>Voyager n'a jamais été aussi simple</span>
		</div>
		<div class="err">
			<?php echo $err;?>

		</div>
		<form name="insc" method="post">
			<div class="bigbox">
				<div class="desc">
					<h2>Créer un compte</h2>
					<ol>
						<li>Un reseau fait par les étudiants pour les étudiants</li>
						<li>A l'autre bout de la region en moins de 2h</li>
						<li><?php echo $nb_user; ?> utilisateurs</li>
						<li>Sécurisé, crypté... vous n'êtes pas espionné</li>
						<li>Pas de pub</li>
					</ol>
					<input id="val" type="submit" name="inscription" value="Valider" />
				</div>
				<table>
					<tr>
						<td>
							<label for="pre">Prénom: </label>
							<input name="pre" id="pre" type="text" placeholder="Prénom" value=<?php echo("\"$pre\"");?> />
						</td>
					</tr>
					<tr>
						<td>
							<label for="nom">Nom: </label>
							<input name="nom" id="nom" type="text" placeholder="Nom" value=<?php echo("\"$nom\"");?> />
						</td>
					</tr>
					<tr>
						<td>
							<label for="email">Email: </label>
							<input name="email" id="email" type="text" placeholder="E-mail" value=<?php echo("\"$email\"");?> />
						</td>
					</tr>
					<tr>
 						<td>
							<label for="camp">Campus: </label>
							<input name="camp" id="camp" type="text" placeholder="Campus" value=<?php echo("\"$camp\"");?> />
						</td>
					</tr>
					<tr>
						<td>
							<label for="vil">Ville: </label>
							<input name="vil" id="vil" type="text" placeholder="Ville" value= <?php echo("\"$ville\"");?> />
						</td>
					</tr>
					<tr>
						<td>
							<label for="pass">Mot de passe: </label>
							<input name="pass" id="pass" type="password" placeholder="Mot de passe"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="pass2">Confirmer: </label>
							<input name="pass2" id="pass2" type="password" placeholder="Confirmation" />
						</td>
					</tr>
					<tr>
						<td>
							<label for="ine">Date de naissance: </label>
							<select name="mois" >
								<?php
								for ($i=1; $i<=12; $i++) {
									if($mois==$i){
										echo "<option value='" . $i . "'selected='selected'>" . mois($i) . "</option>";
									}
									else{
										echo "<option value='" . $i . "'>" . mois($i) . "</option>";
									}
								}
								?>
							</select>
							<select name="annee" >
								<?php
								for ($i=date("Y"); $i>=date("Y")-100; $i--) {
									if($annee==$i){
										echo "<option selected='selected'>" . $i . "</option>";
									}
									else{
										echo "<option>" . $i . "</option>";
									}
								}
								?>
							</select>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</html>