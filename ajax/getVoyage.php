<?php

	require_once '../lib/securite.php';

    require_once '../lib/sql.php';
    require_once '../login.inc';

    $voy = selectInfoVoyage($_POST["id"]);
    $liee = selectVerificationContact($voy["conduc"],$_SESSION["user_id"]);

?>

<div id="map">
	MAP
</div>
<div id="mapinfo">
	<span class="label">Départ :</span><br />
	<span class="info"><?php echo $voy['depart']; ?></span><br />
	<span class="label">Arrivé :</span><br />
	<span class="info"><?php echo $voy['arrive']; ?></span><br />
	<span class="label">Temps :</span><br />
	<span class="info" id="infotemps"></span><br />
	<span class="label">Aller :</span><br />
	<span class="info"><?php echo $voy['aller']; ?></span><br />
	<span class="label">Retour :</span><br />
	<span class="info"><?php echo $voy['retour']; ?></span><br />
	<span class="label">Conducteur :</span><br />
	<span class="info"><?php echo $voy['pre'] . " " . $voy['nom']; ?></span><br />
	<?php
		if ($voy['conduc']==$_SESSION["user_id"]) {
			?>
			<input type='button' value="Modifier" onclick="" title="Modifier ce voyage." />
			<input type='button' value="Supprimer" onclick="if(confirm('Etes-vous sur de supprimer le voyage <?php echo $voy['depart'] ?> <?php echo $voy['arrive']; ?>?')){pop_close();supprVoyage(<?php echo $_POST["id"]; ?>);}" title="Supprimer ce voyage." />
			<?php	
		}
		elseif ($liee) {
			?>
			<input type='button' value="Voir" onclick="window.location = '../carnet/#<?php echo $voy['conduc']; ?>';pop_close();" title="Afficher dans le carnet d'adresse." />
			<input type='button' value="Message" onclick="window.location = '../messages/#<?php echo $voy['conduc']; ?>';pop_close();" title="Envoyer un message." />
			<?php
		}
		else {
			
			?>
			<span id="textAdd"></span>
			<input type='button' id="buttonAdd" value="ajouter" onclick="faireDemandeAmis(<?php echo $voy["conduc"] ?>)" title="Ajouter <?php echo selectNomPerso($voy["conduc"]) ?> dans mes contacs." />
			<?php
		}
	?>
</div>	