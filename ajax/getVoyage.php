<?php

	require_once '../lib/securite.php';

    require_once '../lib/sql.php';
    require_once '../login.inc';

    $voy = selectInfoVoyage($_POST["id"]);
    $liee = selectVerificationContact($voy["conduc"],$_SESSION["user_id"]);

?>

<div id="map">
	<img src="../img/loading.gif" alt="loading" />
</div>
<div id="mapinfo">
	<span class="label">Départ (A) :</span><br />
	<span class="info"><?php echo $voy['depart']; ?></span><br />
	<span class="label">Arrivé (B) :</span><br />
	<span class="info"><?php echo $voy['arrive']; ?></span><br />
	<span class="label">Temps :</span><br />
	<span class="info" id="infotemps"></span><br />
	<span class="label">Aller :</span><br />
	<span class="info"><?php echo $voy['aller']; ?></span><br />
	<?php if($voy['retour']!="0000-00-00"){ ?>
		<span class="label">Retour :</span><br />
		<span class="info"><?php echo $voy['retour']; ?></span><br />
	<?php } if($voy['recursivite']>0){ ?>
		<span class="label">Récurrence :</span><br />
		<span class="info">Tous les <?php echo $voy['recursivite']; ?> jours</span><br />
	<?php } ?>
	<span class="label">Conducteur :</span><br />
	<span class="info"><?php echo $voy['pre'] . " " . $voy['nom']; ?></span><br />
	<?php
		if ($voy['conduc']==$_SESSION["user_id"]) {
			?>
			<input type='button' value="Modifier" onclick="getModVoyageForm(<?php echo $_POST["id"] ?>)" title="Modifier ce voyage." />
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