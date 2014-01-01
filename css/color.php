<?php

    require_once '../lib/securite.php';

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
		$ro = $r-30;
		$go = $g-30;
		$bo = $b-30;
		if ($ro<0) { $ro = 0; }
		if ($go<0) { $go = 0; }
		if ($bo<0) { $bo = 0; }
		return "rgb(" . $ro . "," . $go . "," . $bo . ")";
	}

    function light(){
        global $r,$g,$b;
        $ro = $r+30;
        $go = $g+30;
        $bo = $b+30;
        if ($ro>255) { $ro = 255; }
        if ($go>255) { $go = 255; }
        if ($bo>255) { $bo = 255; }
        return "rgb(" . $ro . "," . $go . "," . $bo . ")";
    }

    function blanc(){
        global $r,$g,$b;
        $ro = intval($r*1200/255);
        $go = intval($g*1200/255);
        $bo = intval($b*1200/255);
        return "rgb(" . $ro . "," . $go . "," . $bo . ")";
    }

    $default = color();
    $darck   = darck();
    $light   = light();
    $blanc   = blanc();

?>

* {
    outline-color: <?php echo $light ?>; 
}

a:focus,
a:hover {
    color: <?php echo $default ?>;
}

a:active {
    color: <?php echo $darck ?>; 
}

input[type=submit],
input[type=reset],
input[type=button] {
    background-color: <?php echo $default ?>;
    box-shadow: 0px 0px 3px <?php echo $default ?>;
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

div#nav:hover,
div#nav:focus {
    box-shadow: 0px 0px 10px <?php echo $default ?>;
}

div#nav a:hover,
div#nav a:focus
{
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