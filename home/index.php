
<?php

	require_once '../lib/securite.php';

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
		<script type="text/javascript">
			var title = "<?php echo $title ?>";
		</script>
	</head>
	<body>
		<div id="titre" >
			<h1>Accueil</h1>
			<span>Voyager n'a jamais été aussi simple</span>
		</div>
		<div id="home">
			<div class="menu">
				<a href="../voyage">Voyages</a>
				<a href="../carnet">Contacts</a>
				<a href="../messages">Messagerie</a>
				<a href="../rechercher">Rechercher</a>
			</div>
			<?php phraseNotif(selectNbRequete($_SESSION["user_id"]),selectNbMsgNonLu($_SESSION["user_id"])); ?>
		</div>
		<?php nav(); ?>
		<?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]); ?>
	</body>
</html>