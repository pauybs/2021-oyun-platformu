<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){

	if(isset($_POST["puan"]) and ($_POST["puan"]==5 ||  $_POST["puan"]==4 || $_POST["puan"]==3 || $_POST["puan"]==2 || $_POST["puan"]==1) ){
		$Puan = SayfaNumarasiTemizle(Guvenlik($_POST["puan"]));
	}else{
		$Puan="";
	}
	if(isset($_POST["oyun"]) and strlen($_POST["oyun"])<=11 ) {
		$OyunId = SayfaNumarasiTemizle(Guvenlik($_POST["oyun"]));
	}else{
		$OyunId="";
	}
	if(isset($_POST["j"]) and strlen($_POST["j"])==30){
		$Jeton = Guvenlik($_POST["j"]);
	}else{
		$Jeton="";
	}

	if( $Jeton!="" and Guvenlik($_SESSION["Jeton"])==$Jeton){
		if( ($Puan!="") and  ($OyunId!="") ){
			$Oyun = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  id=? and Durum=? LIMIT 1 ");
			$Oyun->execute([$OyunId,1]);
			$OyunVeri = $Oyun->rowCount();
			if ($OyunVeri >0) {
					
				$KullaniciOyKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunpuan WHERE  UyeId=? and OyunId=? LIMIT 1 ");
				$KullaniciOyKontrol->execute([Guvenlik($KullaniciId),$OyunId]);
				$KullaniciOyKontrolVeri = $KullaniciOyKontrol->rowCount();
				if ($KullaniciOyKontrolVeri >0) {
					$PuanKayit = $DatabaseBaglanti->prepare("UPDATE oyunpuan SET Puan=? WHERE UyeId=? and OyunId=?  ");
					$PuanKayit->execute([$Puan,Guvenlik($KullaniciId),$OyunId]);
					$Data = [
				       	'statu' => true,
				    	];
				    	echo json_encode($Data); 
						exit();
					
				}else{
					$PuanKayit = $DatabaseBaglanti->prepare("INSERT INTO oyunpuan (OyunId,UyeId,Puan) values (?,?,?) ");
					$PuanKayit->execute([$OyunId,Guvenlik($KullaniciId),$Puan]);
					$Data = $PuanKayit->rowCount();
					if ($Data>0) {
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
				}
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
	header("location:" .$SiteLink);
	exit();	
}
?>	