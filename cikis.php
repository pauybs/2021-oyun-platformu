<?php

if (isset($_SESSION["Kullanici"])) {

	unset($_SESSION["Kullanici"]);
	session_destroy();
	header("Location:". $SiteLink);
	exit();
}else{
	header("Location:". $SiteLink);
	exit();
}
?>