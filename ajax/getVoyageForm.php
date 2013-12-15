<?php

    require_once '../lib/securiter.php';
    session_start();
    if(!isLogged()){
        header("Location: ..");
    }

?>

<form id="creationvoyage" method="post">
	<p id="err" class="err"></p>
	<label for="v_dep">Ville de départ :</label>
	<br />
	<input id="v_dep" type="text" name="dep" />
	<br />
	<br />
	<label for="v_arr">ville d'arrivé :</label>
	<br />
	<input id="v_arr" type="text" name="arr" />
	<br />
	<br />
	<label for="d_dep">Date de départ :</label>
	<br />
	<input id="d_dep" type="text" name="dep" type="date"/>
	<br />
	<br />
	<label for="d_arr">Date d'arrivé :</label>
	<br />
	<input id="d_arr" type="text" name="arr" type="date" />
	<br />
	<br />
	<label for="rec">Récurence :</label>
	<br />
	<input id="rec" type="text" name="rec" type="number" min="1" value="0" />
	<br />
	<br />
	<input type="button" value="créer" onclick="ajoutVoyage()" />
	<input type="reset" value="annuler" onclick="pop_close()" />
</form>