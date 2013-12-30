<?php

    require_once '../lib/securite.php';

    require_once '../lib/bibli.php';

?>

<form id="creationvoyage" method="post" onsubmit="ajoutVoyage();return false;">
	<p id="err" class="err"></p>
	<label for="v_dep">Ville de départ :</label>
	<br />
	<input id="v_dep" type="text" name="dep" />
	<br />
	<br />
	<label for="v_arr">Ville d'arrivé :</label>
	<br />
	<input id="v_arr" type="text" name="arr" />
	<br />
	<br />
	<label for="d_dep_j">Date de départ :</label>
	<br />
	<select id="d_dep_j" name="d_dep_j" >
		<?php
		for ($i=1; $i<=31; $i++) { 
			echo "<option>" . $i . "</option>";
		}
		?>
	</select>
	<select id="d_dep_m" name="d_dep_j" >
		<?php
		for ($i=1; $i<=12; $i++) { 
			echo "<option value='" . $i . "' >" . mois($i) . "</option>";
		}
		?>
	</select>
	<select id="d_dep_a" name="d_dep_a" >
		<?php
		for ($i=date("Y"); $i<date("Y")+2; $i++) {
			// if($annee==$i){
			// 	echo "<option selected='selected'>" . $i . "</option>";
			// }
			// else{
				echo "<option>" . $i . "</option>";
			// }
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
			echo "<option>" . $i . "</option>";
		}
		?>
	</select>
	<select id="d_arr_m" name="d_arr_j" >
		<option value="0">-</option>
		<?php
		for ($i=1; $i<=12; $i++) { 
			echo "<option value='" . $i . "' >" . mois($i) . "</option>";
		}
		?>
	</select>
	<select id="d_arr_a" name="d_arr_a" >
		<option value="0">-</option>
		<?php
		for ($i=date("Y"); $i<date("Y")+2; $i++) {
			// if($annee==$i){
			// 	echo "<option selected='selected'>" . $i . "</option>";
			// }
			// else{
				echo "<option>" . $i . "</option>";
			// }
		}
		?>
	</select>
	<br />
	<span class="note">Note: laissez la date de retour vide si il n'y a pas de retour proposé.</span>
	<br />
	<br />
	<label for="rec">Récurence :</label>
	<br />
	Tout les
	<input id="rec" type="text" name="rec" type="number" min="1" value="0" />
	jours.
	<br />
	<span class="note">Note: laissez la recurence à zero si vous ne proposez pas ce voyage de manière recurente.</span>
	<br />
	<br />
	<input type="submit" value="Créer" />
	<input type="reset" value="Annuler" onclick="pop_close()" />
</form>