<?php

	require_once '../lib/securiter.php';
    session_start();
    if(!isLogged()){
        header("Location: ..");
    }

    require_once '../lib/sql.php';
    require_once '../login.inc';

    $voy = getInfoVoyage(1);
    $liee = verifContactSQL($voy["conduc"],$_SESSION["user_id"]);

?>

<div id="map" style="background-color:rgb(223,220,215);text-align:center;color:white;">
	MAP
</div>
<div id="mapinfo">
	<span class="label">Départ :</span><br />
	<span class="info"><?php echo $voy['depart']; ?></span><br />
	<span class="label">Arrivé :</span><br />
	<span class="info"><?php echo $voy['arrive']; ?></span><br />
	<span class="label">Temps :</span><br />
	<span class="info">3h 15min</span><br />
	<span class="label">Aller :</span><br />
	<span class="info"><?php echo $voy['aller']; ?></span><br />
	<span class="label">Retour :</span><br />
	<span class="info"><?php echo $voy['retour']; ?></span><br />
	<span class="label">Conducteur :</span><br />
	<span class="info"><?php echo $voy['pre'] . " " . $voy['nom']; ?></span><br />
	<?php
		if ($liee) {
			?>
			<input type='button' value="voir" onclick="window.location = '../carnet/#<?php echo $voy['conduc']; ?>';" title="Afficher dans le carnet d'adresse." />
			<input type='button' value="message" onclick="window.location = '../messages/#<?php echo $voy['conduc']; ?>';" title="Envoyer un message." />
			<?php
		}
		else {
			?>
			<span id="textAdd"></span>
			<input type='button' id="buttonAdd" value="ajouter" onclick="faireDemandeAmis(<?php echo $voy["conduc"] ?>)" title="Ajouter <?php echo getNom($voy["conduc"]) ?> dans mes contacs." />
			<?php
		}
	?>
</div>	