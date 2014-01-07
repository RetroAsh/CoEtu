<?php

    require_once '../lib/securite.php';

    require_once '../login.inc';
    require_once '../lib/bibli.php';
    require_once '../lib/sql.php';

    $voy = array('depart'=>"",'arrive'=>"",'recursivite'=>0);
    $aller = array(0=>date("Y"),1=>date("m"),2=>date("d")+1);
    $retour = array(0=>0,1=>0,2=>0);

    if (isset($_POST["mod_id"]) && $_POST["mod_id"]!=0) {
    	$voy = selectInfoVoyage($_POST["mod_id"]);
    	$aller = explode('-', $voy['aller']);
    	$retour = explode('-', $voy['retour']);
    }
    else {
    	$_POST["mod_id"] = 0;
    }


    if (isset($_POST["mod_id"]) && $_POST["mod_id"]!=0) {
    	echo "<form id='creationvoyage' method='post' onsubmit='modVoyage();return false;'>";
    }
    else {
    	echo "<form id='creationvoyage' method='post' onsubmit='ajoutVoyage();return false;'>";
    }

?>
	
	<input type="hidden" id="mod_id" name="mod_id" value="<?php echo $_POST["mod_id"] ?>" />
	<p id="err" class="err"></p>
	<label for="v_dep">Ville de départ :</label>
	<br />
	<input id="v_dep" type="text" name="dep" value="<?php echo $voy['depart']; ?>" />
	<br />
	<br />
	<label for="v_arr">Ville d'arrivée :</label>
	<br />
	<input id="v_arr" type="text" name="arr" value="<?php echo $voy['arrive']; ?>" />
	<br />
	<br />
	<label for="d_dep_j">Date de départ :</label>
	<br />
	<select id="d_dep_j" name="d_dep_j" >
		<?php
		for ($i=1; $i<=31; $i++) { 
			if($aller[2]==$i){
				echo "<option selected='selected'>" . $i . "</option>";
			}
			else{
				echo "<option>" . $i . "</option>";
			}
		}
		?>
	</select>
	<select id="d_dep_m" name="d_dep_j" >
		<?php
		for ($i=1; $i<=12; $i++) { 
			if($aller[1]==$i){
				echo "<option selected='selected' value='" . $i . "' >" . mois($i) . "</option>";
			}
			else{
				echo "<option value='" . $i . "' >" . mois($i) . "</option>";
			}
		}
		?>
	</select>
	<select id="d_dep_a" name="d_dep_a" >
		<?php
		for ($i=date("Y"); $i<date("Y")+2; $i++) {
			if($aller[0]==$i){
				echo "<option selected='selected'>" . $i . "</option>";
			}
			else{
				echo "<option>" . $i . "</option>";
			}
		}
		?>
	</select>
	<br />
	<br />
	<label for="d_arr_j">Date de retour :</label>
	<br />
	<select id="d_arr_j" name="d_arr_j" >
		<option value="0">-</option>
		<?php
		for ($i=1; $i<=31; $i++) { 
			if($retour[2]==$i){
				echo "<option selected='selected'>" . $i . "</option>";
			}
			else{
				echo "<option>" . $i . "</option>";
			}
		}
		?>
	</select>
	<select id="d_arr_m" name="d_arr_j" >
		<option value="0">-</option>
		<?php
		for ($i=1; $i<=12; $i++) { 
			if($retour[1]==$i){
				echo "<option selected='selected' value='" . $i . "' >" . mois($i) . "</option>";
			}
			else{
				echo "<option value='" . $i . "' >" . mois($i) . "</option>";
			}
		}
		?>
	</select>
	<select id="d_arr_a" name="d_arr_a" >
		<option value="0">-</option>
		<?php
		for ($i=date("Y"); $i<date("Y")+2; $i++) {
			if($retour[0]==$i){
				echo "<option selected='selected'>" . $i . "</option>";
			}
			else{
				echo "<option>" . $i . "</option>";
			}
		}
		?>
	</select>
	<br />
	<span class="note">Note : laissez la date de retour vide si vous ne souhaitez pas proposer de retour.</span>
	<br />
	<br />
	<label for="rec">Récurrence :</label>
	<br />
	Tous les
	<input id="rec" type="text" name="rec" type="number" min="1" value="<?php echo $voy['recursivite']; ?>" />
	jours.
	<br />
	<span class="note">Note : laissez la récurrence à zéro si vous ne proposez pas ce voyage de manière récurrente.</span>
	<br />
	<br />
	<?php
		if (isset($_POST["mod_id"]) && $_POST["mod_id"]!=0) {
			echo "<input type='submit' value='Modifier' />";
			echo "<input type='button' value='Supprimer' onclick=\"if(confirm('Etes-vous sûr de vouloir supprimer le voyage " . $voy['depart'] . " - " . $voy['arrive'] . "?')){pop_close();supprVoyage(" . $_POST['mod_id'] . ");}\" title='Supprimer ce voyage.' />";
			echo "<input type='reset' value='Annuler' onclick='voyage(" . $_POST["mod_id"] . ",\"" . $voy['depart'] . " &rarr; " . $voy['arrive'] . "\")' />";
		}
		else {
			echo "<input type='submit' value='Créer' />";
			echo "<input type='reset' value='Annuler' onclick='pop_close()' />";
		}
	?>
</form>