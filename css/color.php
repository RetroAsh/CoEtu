<?php
    session_start();
    require_once '../lib/securiter.php';
    if(!isLogged()){
        header("Location: ..");
    }

    require_once '../login.inc';
    require_once '../lib/sql.php';
    require_once '../lib/bibli.php';
	header('Content-type: text/css');

	$inter = hex2rgb(selectCouleur($_SESSION["user_id"]));
	
    $r = $inter[0];
    $g = $inter[1];
    $b = $inter[2];

	function color(){
		global $r,$g,$b;
		return "rgb(" . $r . "," . $g . "," . $b . ")";
	}

	function darck(){
		global $r,$g,$b;
		$r -= 30;
		$g -= 30;
		$b -= 30;
		if ($r<0) { $r = 0; }
		if ($g<0) { $g = 0; }
		if ($b<0) { $b = 0; }
		return "rgb(" . $r . "," . $g . "," . $b . ")";
	}

    function light(){
        global $r,$g,$b;
        $r += 60;
        $g += 60;
        $b += 60;
        if ($r>255) { $r = 255; }
        if ($g>255) { $g = 255; }
        if ($b>255) { $b = 255; }
        return "rgb(" . $r . "," . $g . "," . $b . ")";
    }

    $default = color();
    $darck = darck();
    $light = light();

?>

a:active {
    color: <?php echo $default ?>; 
}

input[type=submit],
input[type=reset],
input[type=button] {
    background-color: <?php echo $default ?>;
    box-shadow: 0px 0px 5px <?php echo $default ?>;
    border: 1px solid <?php echo $default ?>;
}

input[type=submit]:hover,
input[type=reset]:hover,
input[type=button]:hover,
input[type=submit]:focus,
input[type=reset]:focus,
input[type=button]:focus {
    border-color: <?php echo $darck ?>;
}

div#nav {
    background-color: <?php echo $default ?>;
    box-shadow: 0px 0px 7px <?php echo $default ?>;
}

div#nav:hover {
    box-shadow: 0px 0px 10px <?php echo $default ?>;
}

div#nav a:hover {
    background-color: <?php echo $darck ?>;
}

div#pop h3 {
    background-color: <?php echo $default ?>;
}

div#perso {
    background-color: <?php echo $default ?>;
    box-shadow: 0px 0px 7px <?php echo $default ?>;
}

div#carnet>div:last-of-type a.selected,
div#messagerie>div:last-of-type a.selected {
    border-right: solid 3px <?php echo $darck ?>;
}

div#messagerie>div:last-of-type a.unread  {
    border-right: dotted 3px <?php echo $light ?>;
}

div#carnet>div:last-of-type a:hover, 
div#carnet>div:last-of-type a:focus,
div#messagerie>div:last-of-type a:hover, 
div#messagerie>div:last-of-type a:focus  {
    border-right: solid 3px <?php echo $light ?>;
}

div#param input:focus,
div#param select:focus {
    border: 1px solid <?php echo $light ?>;
    box-shadow: 0px 0px 3px <?php echo $light ?>;
}

div#messagerie span.perso {
    color: <?php echo $default ?>;
}
