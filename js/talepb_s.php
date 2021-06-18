<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["i"]) and strlen($_POST["i"])==10){
			$destekid = Guvenlik($_POST["i"]);
			if (strlen($destekid)==10) {
				$destekid = Guvenlik($_POST["i"]);
			}else{
				$destekid="";
			}
		}else{	
			$destekid="";
		}
		if(isset($_POST["di"]) and strlen($_POST["di"])<=11){
			$Id = SayfaNumarasiTemizle(Guvenlik($_POST["di"]));
		}else{	
			$Id="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($Id!="" and $destekid!=""){
				$Uye = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  and Durum=? and SilinmeDurumu=? LIMIT 1 ");
				$Uye->execute([$KullaniciId,1,0]);
				$UyeVeri = $Uye->rowCount();
				$UyeKayitlar = $Uye->fetch(PDO::FETCH_ASSOC);
				if ($UyeVeri>0) {
						
						$Talep = $DatabaseBaglanti->prepare("SELECT * FROM destek WHERE UyeId=?  and id=? and destekid=? and Durum=? LIMIT 1 ");
						$Talep->execute([$KullaniciId,$Id,$destekid,0]);
						$TalepVeri = $Talep->rowCount();
						$TalepKayitlar = $Talep->fetch(PDO::FETCH_ASSOC);
						if($TalepVeri>0){
							$Data = [
					    	'statu' => "success", 
					    	'title'=> IcerikTemizle($TalepKayitlar["Baslik"]),
					    	'text'=> IcerikTemizle($TalepKayitlar["Konu"]),
					    	
							];
							echo json_encode($Data);
							exit();
						}else{
							$Data = [
					    	'statu' => "error", 
							];
							echo json_encode($Data);
							exit();
						}
					
				}else{
					$Data = [
			    	'statu' => "error", 
					];
					echo json_encode($Data);
					exit();
				}
			}else{
				$Data = [
		    	'statu' => "error", 
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
	header("location:" .$SiteLink);
	exit();	
}
?>