<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
	if(isset($_POST["fhi"]) and strlen($_POST["fhi"])<=11){
		$ID = SayfaNumarasiTemizle(Guvenlik($_POST["fhi"]));
	}else{
		$ID="";
	}

	if(isset($_POST["j"]) and strlen($_POST["j"])==30 ){
		$Jeton = Guvenlik($_POST["j"]);
	}else{
		$Jeton="";
	}

	if($ID!="" and $Jeton!=""){
		if (Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$Haber = $DatabaseBaglanti->prepare("SELECT *  FROM haberfavoriler WHERE id= ?  AND UyeId=? LIMIT 1 ");
			$Haber->execute([$ID,Guvenlik($KullaniciId)]);
			$HaberVeri = $Haber->rowCount();
			if ($HaberVeri>0) {
				$favoriSil = $DatabaseBaglanti->prepare("DELETE  FROM haberfavoriler WHERE id= ?  AND UyeId=? LIMIT 1 ");
				$favoriSil->execute([$ID,Guvenlik($KullaniciId)]);
				$Veri = $favoriSil->rowCount();
				if($Veri >0){
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
		header("location:" .$SiteLink);
		exit();
	}
}else{
	header("location: " .$SiteLink);
	exit();
}
?>