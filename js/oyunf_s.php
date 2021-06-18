<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"])  and isset($_SESSION["Jeton"])  and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
	if(isset($_POST["foi"]) and strlen($_POST["foi"])<=11){
		$ID = SayfaNumarasiTemizle(Guvenlik($_POST["foi"]));
	}else{
		$ID="";
	}

	if(isset($_POST["j"]) and strlen($_POST["j"])==30){
		$Jeton = Guvenlik($_POST["j"]);
	}else{
		$Jeton="";
	}

	if($ID!="" and $Jeton!=""){
		if (Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$Oyun = $DatabaseBaglanti->prepare("SELECT *  FROM oyunfavoriler WHERE id= ?  AND UyeId=? LIMIT 1 ");
			$Oyun->execute([$ID,Guvenlik($KullaniciId)]);
			$OyunVeri = $Oyun->rowCount();
			if ($OyunVeri>0) {
				$favoriSil = $DatabaseBaglanti->prepare("DELETE  FROM oyunfavoriler WHERE id= ?  AND UyeId=? LIMIT 1 ");
				$favoriSil->execute([$ID,Guvenlik($KullaniciId)]);
				$Data = $favoriSil->rowCount();
				if($Data >0){
					$Data = [
			       	'statu' => true,
			    	];
			    	echo json_encode($Data); 
					exit();	
				}else{
					$Data = [
			       	'statu' => false,
			    	];
			    	echo json_encode($Data); 
					exit();	
				}
			}else{
				$Data = [
		       	'statu' => false,
		    	];
		    	echo json_encode($Data); 
				exit();	
			}
		}else{
			header("location:" .$SiteLink);
			exit();	
		}
	}else{
		$Data = [
       	'statu' => false,
    	];
    	echo json_encode($Data); 
		exit();	
	}
}else{
	header("location: " .$SiteLink);
	exit();
}
?>