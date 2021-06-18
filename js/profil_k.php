<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"] )  and isset($_SESSION["Jeton"]) ) {
	if( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and  Durum=? and  SilinmeDurumu=? LIMIT 1");
		  	$UyeKontrol->execute([Guvenlik($KullaniciId),1,0]);
		 	$UyeKontrolSayisi = $UyeKontrol->rowCount();
		 	$UyeKayitlar = $UyeKontrol->fetch(PDO::FETCH_ASSOC);
		 	if($UyeKontrolSayisi>0){
				$ResimKlasorYolu= "userphoto";
				if ($UyeKayitlar["ProfilResmi"]!="") {
					$SilinecekResimYolu= "../images/".IcerikTemizle($ResimKlasorYolu)."/".IcerikTemizle($UyeKayitlar["ProfilResmi"]);
					unlink($SilinecekResimYolu);
				}
				$ResimSil = $DatabaseBaglanti->prepare("UPDATE uyeler  SET ProfilResmi=?  WHERE id=?  ");
				$ResimSil->execute([NULL,Guvenlik($KullaniciId)]);
				$ResimSilSayisi = $ResimSil->rowCount();
				if($ResimSilSayisi>0){
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
			header("location:".$SiteLink);
			exit();
		}
	}else{
		header("location:".$SiteLink);
		exit();
	}		
}else{
header("location: " .$SiteLink);
	exit();
}
?>