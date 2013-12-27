<?php

    session_start();
    require_once '../lib/html.php';
    require_once '../lib/securiter.php';
    if(!isLogged()){
        header("Location: ..");
    }
    require_once '../login.inc';
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
            window.onload=function() {
                var txt = document.getElementById("rh").value;
                document.getElementById("rh").focus();
                document.getElementById("rh").value =  txt;
                recherche();
            }
        </script>
    </head>
    <body>
        <div id="titre">
            <h1>Recherche</h1>
            <span>Voyager n'a jamais été aussi simple</span>
        </div>
        <div id="recherche">
            <br />
        </div>
        <?php boxuser(selectNomPerso($_SESSION["user_id"]),$_SESSION["user_id"]); ?>
        <?php nav(); ?>
    </body>
</html>