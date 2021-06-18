<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
    if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])) {
    	if ( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ) {
    		
    		unset($_SESSION["Kullanici"]);
    		unset($_SESSION["Jeton"]);
    		unset($_SESSION["warning"]);
    		session_destroy();
    		header("Location: " .$SiteLink);
    		exit();
    		
    	}else{
    		header("Location: " .$SiteLink);
    		exit();
    	}
    }else{
    	header("Location: " .$SiteLink);
    		exit();
    }
}else{
	header("Location: " .$SiteLink);
		exit();
}
?>