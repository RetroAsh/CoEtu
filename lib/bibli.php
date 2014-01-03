<?php

function test_chaine($str){
	if(email_valid($str)){
        return "<a href='mailto:".$str."'>$str</a>";
	}
	if(url_valid($str)){
        return "<a target='_blank' href='".$str."'>$str</a>";
	}
    return $str;
}

function mois($index){
	$index = intval($index);
	if ($index>12 || $index<=0) {
		return $index;
	}
	$mois = array("janv.","févr.","mars","avr.","mai","juin","juil.","août","sept.","oct.","nov.","déc.");
	return $mois[$index-1];
}

function jour($index){
	$index = intval($index);
	if ($index>7 || $index<=0) {
		return $index;
	}
	$jour = array("dim.","lun.","mar.","mer.","jeu.","ven.","sam.");
	return $jour[$index];
}

function smalltimestamp($format_sql){
    // 2013-12-26 19:06:06
    $format_sql = explode(" ", $format_sql);
    $date = $format_sql[0];
    $time = $format_sql[1];
    $date = explode("-", $date);
    $time = explode(":", $time);
    return $time[0].":".$time[1]." ".$date[2]."/".$date[1]."/".(intval($date[0])%100);
}

function timestamp($format_sql){
    $tmp = str_replace("/", "-", $format_sql);
    $sp = explode("-",$format_sql);
    return jour(date("w", strtotime($tmp))) . " " . $sp[2] . " " . mois($sp[1]) . " " . $sp[0];
}

function contractNom($nom, $prenom) {
    if((strlen($nom)+strlen($prenom))<15) {
        return ucfirst($prenom)." ".ucfirst($nom);
    }
    else {
        return ucfirst($prenom)." ".ucfirst($nom[0]).".";
    }
}

function hex2rgb($hex){
    $tab = array();
    if(strlen($hex)==3){
       $substr = str_split($hex,1);
       for($i =0;$i<3;$i++){
           $substr[$i]=$substr[$i].$substr[$i];
       }
    }
    else if (strlen($hex)==6){
       $substr = str_split($hex,2);
    }

    foreach($substr as $decomp){
        $tab[] = hexdec($decomp);
    }
    return $tab;
}

function jourSemaine($jour,$mois,$anne){
    $c=(14-$mois)/12;
    $a = $anne-$c;
    $m=$mois+12*$c-2;
    $j=($jour+$a+floor($a/4)-floor($a/100)+floor($a/400)+31*floor($m/12))%7;
    return $j;
}

function email_valid($email) {
    return filter_var($email,FILTER_VALIDATE_EMAIL);
}

function url_valid($url){
    return filter_var($url,FILTER_VALIDATE_URL);
}

function tel_valid($tel){
    $tel = str_replace(" ","",$tel);
    if(strlen($tel)!=10){
        return false;
    }
    return preg_match("/^[0-9]+$/",$tel);
}

function verifDateFormatNormal($date)
{
	$format = 'd/m/Y';
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function verifDateFormatCrade($date)
{
	$format = 'Y-m-d';
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}

function verifDate($date)
{
	return verifDateFormatNormal($date) || verifDateFormatCrade($date);
}

function dateNormalToCrade($date) {
	$tmp = str_replace("/", "-", $date);
	return date("Y-m-d", strtotime($tmp));
}

?>