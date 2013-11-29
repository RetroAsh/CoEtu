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
        setCouleur($_SESSION['user_id'],$_POST['couleur']);
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Votre Profil</title>
		<?php head() ?>
        <script type="text/javascript" src="../js/jscolor/jscolor.js"></script>
	</head>
    <body>
        <div id="titre">
            <h1>Votre Profil</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="cont">
            <form method="post">
               <label for='couleur'>Couleur</label>
               <?php echo "<input name='couleur' id='couleur' class='color' value='".getCouleur($_SESSION['user_id'])."'>"; ?>
               <input type="submit">
            </form>
        </div>
        <?php boxuser(getNom($_SESSION["user_id"]),$_SESSION["user_id"]); ?>
        <?php nav(); ?>
    </body>
</html>