<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ) {
	if ( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["yci"]) and strlen($_POST["yci"])<=11 ){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yci"]));
		}else{	
			$YorumId="";
		}

		if(isset($_POST["byi"]) and strlen($_POST["byi"])<=11){
			$KullaniciYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["byi"]));
		}else{	
			$KullaniciYorumId="";
		}
		if(isset($_POST["j"])   and strlen($_POST["j"])==30 ){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {

			if ( ($YorumId!="") ){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  sozlukyorumlar WHERE  id=? and Durum!=? and Durum!=?  LIMIT 1 ");
				$YorumKontrol->execute([$YorumId,0,2]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {		
					$BaslikId=Guvenlik($YorumKontrolKayitlar["YaziId"]);
					$Yorum= $DatabaseBaglanti->prepare("SELECT * FROM   sozlukyorumlar  WHERE id=? AND YaziId=? AND UyeId=? LIMIT 1 ");
					$Yorum->execute([$YorumId,$BaslikId,Guvenlik($KullaniciId)]);
					$YorumSayisi = $Yorum->rowCount();
					$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
					if($YorumSayisi>0){
						$YorumSilme= $DatabaseBaglanti->prepare("UPDATE sozlukyorumlar SET Durum=? WHERE id=? AND YaziId=? AND UyeId=?  LIMIT 1");
						$YorumSilme->execute([0,$YorumId,$BaslikId,Guvenlik($KullaniciId)]);
						$YorumSilmeSayisi = $YorumSilme->rowCount();
						if($YorumSilmeSayisi>0){
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
					$Data = [
			        'statu' => false,
			    	];
					echo json_encode($Data);
					exit();
				}
			}else if ($KullaniciYorumId!=""){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  sozlukyorumlar WHERE  id=? and Durum!=? and Durum!=?  LIMIT 1 ");
				$YorumKontrol->execute([$KullaniciYorumId,0,2]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {		
					$BaslikId=Guvenlik($YorumKontrolKayitlar["YaziId"]);
					$Yorum= $DatabaseBaglanti->prepare("SELECT * FROM   sozlukyorumlar  WHERE id=? AND YaziId=? AND UyeId=? LIMIT 1 ");
					$Yorum->execute([$KullaniciYorumId,$BaslikId,Guvenlik($KullaniciId)]);
					$YorumSayisi = $Yorum->rowCount();
					$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
					if($YorumSayisi>0){
						$YorumSilme= $DatabaseBaglanti->prepare("UPDATE sozlukyorumlar SET Durum=? WHERE id=? AND YaziId=? AND UyeId=?  LIMIT 1");
						$YorumSilme->execute([0,$KullaniciYorumId,$BaslikId,Guvenlik($KullaniciId)]);
						$YorumSilmeSayisi = $YorumSilme->rowCount();
						if($YorumSilmeSayisi>0){
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
	header("location:" .$SiteLink);
	exit();	
}
?>