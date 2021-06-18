<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"] )  and isset($_SESSION["Jeton"]) ) {
	if( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["j"])){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["i"])){
			$ID = Guvenlik($_POST["i"]);
		}else{	
			$ID="";
		}


		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE Incelemeid=? and KuratorId=? and (Durum=? or Durum=?)  LIMIT 1");
		  	$UyeKontrol->execute([$ID,Guvenlik($KullaniciId),1,2]);
		 	$UyeKontrolSayisi = $UyeKontrol->rowCount();
		 	$UyeKayitlar = $UyeKontrol->fetch(PDO::FETCH_ASSOC);
		 	if($UyeKontrolSayisi>0){
				$ResimKlasorYolu= "inceleme";
				if ($UyeKayitlar["Resim1"]!="") {
					$SilinecekResimYolu= "../images/".IcerikTemizle($ResimKlasorYolu)."/".IcerikTemizle($UyeKayitlar["Resim1"]);
					unlink($SilinecekResimYolu);
				}
				$ResimSil = $DatabaseBaglanti->prepare("UPDATE incelemeler  SET Resim1=?  WHERE Incelemeid=?  ");
				$ResimSil->execute([NULL,$ID]);
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