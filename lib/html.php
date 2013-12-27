<?php

require_once 'bibli.php';
require_once 'sql.php';
require_once("../login.inc");

function head(){
	echo file_get_contents("../cont/head.html");
}

function boxuser($nom, $id){
	echo "<div id='perso'><h2>". $nom . "</h2>";
    printInfoContact($id);
	echo "<div class='option'><a href='../profil/index.php' title='Parametres'><img src='../img/param.png' alt='Parametres' /></a><a href='../lib/deco.php' title='Déconnexion'><img src='../img/out.png' alt='Déconnexion' /></a></div></div>\n";
}

function printInfoContact($id){
    $infos = selectInfoEtu($id);
    $coordonnee = selectCoordonee($id);
    $info_ville = selectInfoVille($infos[1]);
    echo "<span class='label'>Université</span>";
    echo "<span class='carac'>".$infos[4]."</span>";
    echo "<span class='label'>Lieu d'études</span>";
    echo "<span class='carac'>".$infos[0]."</span>";
    echo "<span class='label'>Habite</span>";
    echo "<span class='carac' onclick='afficheCarte(".$info_ville[1].",".$info_ville[2].");'>".$info_ville[0]."</span>";

    for($i=1;$i<$coordonnee[0]*2;$i+=2){
        echo "<span class='label'>".ucfirst($coordonnee[$i])."</span>";
        echo "<span class='carac'>".test_chaine($coordonnee[$i+1])."</span>";
    }

    echo "<span class='label'>Né</span>";
    echo "<span class='carac'>".mois($infos[3])." ".$infos[2]."</span>";
}

function printPerson($id,$pre,$nom,$univ,$ville){
    ?>
    <div class="personne" onclick="peronneInfo(<?php echo $id; ?>,'<?php echo  $pre . " " . $nom; ?>')">
        <img src="../img/buddy.png" />
        <h5><?php echo  $pre . " " . $nom; ?></h5>
        <span class="univ"><?php echo $univ; ?></span>
        <br />
        <span class="ville"><?php echo $ville; ?></span>
    </div>
    <?php
}

function printVoyage($id,$depart,$arrive,$aller,$retour="",$conduc=""){
    ?>
    <div class="voyage" onclick="voyage(<?php echo $id . ",'" . $depart . " ⟷ " . $arrive . "'";?>)"  >
        <img src="../img/car.png" />
        <h5><?php echo $depart ?> ⟷ <?php echo $arrive ?></h5>
        <span class="date"><?php echo $aller;
        if (!empty($retour)) {
            echo " / ";
            echo $retour;
        }
        ?></span>
        <?php
        if (!empty($conduc)) {
            ?>
            <br />
            <span class="conduc"><?php echo $conduc ?></span>
            <?php
        }
        ?>
    </div>

    <?php
}

function printMinimalInfoContact($id){
    $infos = selectInfoEtu($id);
    $info_ville = selectInfoVille($infos[1]);
    echo "<span class='label'>Université:</span>";
    echo "<span class='carac'>".$infos[4]."</span>";
    echo "<span class='label'>Lieu d'études:</span>";
    echo "<span class='carac'>".$infos[0]."</span>";
    echo "<span class='label'>Habite:</span>";
    echo "<span class='carac'>".$info_ville[0]."</span>";
}

function phraseNotif($demande,$msg){
    ?>
        <a href="#" onclick="getNotification()" class="activity">
            <?php  
            if ($msg>0) {
                ?>
                <span><?php echo $msg ?></span> message<?php if ($msg>1) { echo "s"; } ?> non lu.
                <br />
                <?php
            }
            if ($demande>0) {
                ?>
                <span><?php echo $demande ?></span> demande<?php if ($demande>1) { echo "s"; } ?> d'ami.
                <?php
            }
            ?>
        </a>
    <?php
}

function formModInfo($id){
	$infos = selectInfoEtu($id);
    $coordonnee = selectCoordonee($id);
    $info_ville = selectInfoVille($infos[1]);
    echo "<form method='post' class='modinfo' >";
    echo "<label for='univ'>Université: </label>";
    echo "<input id='univ' disabled='disabled' name='univ' value='" . $infos[4] . "' /><br /><br />";
    echo "<label for='lieu'>Lieu d'études: </label>";
    echo "<input id='lieu' name='lieu' value='".$infos[0]."'><br /><br />";
    echo "<label for='ville'>Habite: </label>";
    echo "<input id='ville' name='ville' value='".$info_ville[0]."' /><br /><br />";
    for($i=1;$i<$coordonnee[0]*2;$i+=2){
        echo "<label for='i" . $i . "'>".ucfirst($coordonnee[$i]).": </label>";
        echo "<input id='i" . $i . "' name='".$coordonnee[$i]."' value='".$coordonnee[$i+1]."'/><br /><br />";
    }
    echo "<label for='ne'>Né: </label>";
    echo "<select name='mois' class='mois'>";
    for ($i=1; $i<=12;$i++) { 
    	echo "<option ";
    	if ($i==$infos[3]) {
    		echo "selected='selected' ";
    	}
    	echo " value='".$i."'>".mois($i)."</option>";
    }
    echo "</select>";
    echo "<select name='annee' >";
    for ($i=date("Y");$i>=date("Y")-100;$i--) {
    	if($infos[2]==$i){
    		echo "<option selected='selected'>" . $i . "</option>";
    	}
    	else{
    		echo "<option>" . $i . "</option>";
    	}
    }
	echo "</select><span id='push'></span>";
	echo "<br /><br /><input type='submit' value='Sauvegarder' name='sauvegarder' />";
	echo "<input type='reset' value='Annuler' />";
	echo "</form>\n"; 
}

function nav(){
	?>
	<div id='nav'>
		<a href='../home' title="Home">
			<img src="../img/home.png" alt="Home" />
		</a><a href='../voyage' title="Voyages">
			<img src="../img/car.png" alt="Voyage" />
		</a><a href='../carnet' title="Carnet d'adresse" onclick="getContacts()">
			<img src="../img/buddy.png" alt="Carnet" />
		</a><a href='../messages' title="Messages">
            <img src="../img/mail.png" alt="Messages" />
        </a>
		<form id="form_search" action="../rechercher">
			<input onkeyup="trysearch()" type="search" results placeholder=" Rechercher" name="r" value="<?php if(isset($_GET['r'])){ echo $_GET['r']; } ?>" id="rh" />
		</form>
		<a href='#' onclick="getNotification()" title="Notifications" />
            <?php
                if (selectNbNotification($_SESSION['user_id'])>0) {
                    echo '<img src="../img/bell.gif" id="notif_img" alt="Notifications" />';
                }
                else {
                    echo '<img src="../img/bell.png" id="notif_img" alt="Notifications" />';
                }
            ?>
		</a>
	</div>
    <div id='pop' style='display:none;' ><div id='pop_fen'><h3><span id='pop_titre'></span><a onclick='pop_close()'><img src='../img/close.png' style='height:17px;'/></a></h3><div id='pop_cont'></div></div></div>
	<img src="../img/loading.gif" alt="Loading" id="loading" style="display:none;" />
	<?php
}

?>
