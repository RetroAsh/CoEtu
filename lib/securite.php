<?php

	foreach ($_POST as $key => $value) {
        $_POST[$key] = secureinput($value);
    }
    foreach ($_GET as $key => $value) {
        $_GET[$key] = secureinput($value);
    }

	session_start();

	if(!isset($_SESSION["user_id"])){
    	if(strpos($_SERVER["REQUEST_URI"],'/ajax/')===false){
    	    header("Location: ../");
    	}
    	exit("-1");
	}

	date_default_timezone_set("Europe/Paris");


	function secureinput($str){
        $str = str_replace('\\','&#92;',$str);
        $str = str_replace('\'', '&apos;', $str);
        $str = str_replace('\"', '&quot;', $str);
        $str = str_replace('<', '&lt;', $str);
        $str = str_replace('>', '&#62;', $str);
        return $str;
	}

?>
