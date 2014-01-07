<?php

    require_once '../lib/securite.php';

    require_once '../lib/html.php';
    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';

    $title = selectNomPerso($_SESSION["user_id"]) . " - Contacts";
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
            var current = window.location.hash.substring(1);
            if (current=="") {
                current = -1;
            }
            window.onload = function () {
                getContacts(current);
                setInterval(function () {
                    getContacts(current)
                }, 5000);
                getInfoContact(current);
            };
            document.onkeyup = function(e){
                var liste = document.getElementById("liste");
                var listenom = liste.children;
                var select = null;
                for(var i=0;i<listenom.length;i++){
                    if(listenom[i].className == "selected"){
                        select = i;
                    }
                }
                e = e || event;
                if(e.keyCode >= 65 && e.keyCode <= 90){
                    var lettre = String.fromCharCode(e.keyCode || e.charCode);
                    for(i = 0;i<listenom.length;i++){
                        if(listenom[i].innerHTML[0]==lettre){
                            if(select != null){
                                listenom[select].removeAttribute("class");
                            }
                            listenom[i].setAttribute("class","selected");
                            current = parseInt(listenom[i].id[1]);
                            document.location.href = document.getElementById('c'+current).href;
                            getContacts(current);
                            getInfoContact(current);
                            break;
                        }
                    }
                }
                switch(e.keyCode) {
                    case 38: // up
                        if(select != null && select>0){
                            listenom[select].removeAttribute("class");
                            listenom[select-1].setAttribute("class","selected");
                            current = parseInt(listenom[select-1].id[1]);
                            document.location.href = document.getElementById('c'+current).href;
                            getContacts(current);
                            getInfoContact(current);
                        }
                        return false;
                    case 40: // down
                        if(select != null && select<listenom.length-1 && select>=0){
                            listenom[select].removeAttribute("class");
                            listenom[select+1].setAttribute("class","selected");
                            current = parseInt(listenom[select+1].id[1]);
                            document.location.href = document.getElementById('c'+current).href;
                            getContacts(current);
                            getInfoContact(current);
                        }
                        return false;
                }
                return false;
            }
        </script>
	</head>
    <body>
        <div id="titre">
            <h1>Contacts</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="carnet">
            <div id="contact">
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <?php
                    if(selectNbContacts($_SESSION["user_id"])>0){
                        echo("<span class='welcome'>Sélectionner un contact pour l'afficher.</span>");
                    }
                    else {
                        echo("<span class='welcome'>Pour ajouter une personne à vos contacts, entrez le nom de cette personne dans la <a href='../rechercher'>barre de recherche</a>.</span>");
                    }
                ?>
            </div>
            <div id="liste">

            </div>
        </div>
        <?php nav(); ?>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]) ?>
    </body>
</html>