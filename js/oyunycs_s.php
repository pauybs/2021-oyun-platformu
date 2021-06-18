<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["yci"]) and strlen($_POST["yci"])<=11){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yci"]));
		}else{	
			$YorumId="";
		}
		if(isset($_POST["o"]) and strlen($_POST["o"])<=11){
			$Oyun = SayfaNumarasiTemizle(Guvenlik($_POST["o"]));
		}else{	
			$Oyun="";
		}
		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==20){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if ( $YorumId!="" and $Oyun!="" and $Uniqid!=""){
				$OyunBaslik= $DatabaseBaglanti->prepare("SELECT * FROM   oyunyorumcevap WHERE  OyunUniqid=? and  id=? and Durum!=? and Durum!=? and OyunId=?  LIMIT 1 ");
				$OyunBaslik->execute([$Uniqid,$YorumId,3,4,$Oyun]);
				$OyunBaslikSayisi = $OyunBaslik->rowCount();
				$OyunBaslikKayitlar = $OyunBaslik->fetch(PDO::FETCH_ASSOC);
				if ($OyunBaslikSayisi>0) {		
					$OyunId=Guvenlik($OyunBaslikKayitlar["OyunId"]);
					$Yorumlar= $DatabaseBaglanti->prepare("SELECT * FROM   oyunyorumcevap  WHERE OyunUniqid=? and id=? AND OyunId=? AND UyeId=? LIMIT 1 ");
					$Yorumlar->execute([$Uniqid,$YorumId,$OyunId,Guvenlik($KullaniciId)]);
					$YorumlarSayisi = $Yorumlar->rowCount();
					$YorumlarKayitlar = $Yorumlar->fetch(PDO::FETCH_ASSOC);

					if($YorumlarSayisi>0){
						$YorumSilme= $DatabaseBaglanti->prepare("UPDATE oyunyorumcevap SET Durum=? WHERE id=? AND OyunId=? AND UyeId=?  LIMIT 1");
						$YorumSilme->execute([3,$YorumId,$OyunId,Guvenlik($KullaniciId)]);
						$YorumSilmeSayisi = $YorumSilme->rowCount();

						if($YorumSilmeSayisi>0){
							$OyunGuncelleme = $DatabaseBaglanti->prepare("UPDATE oyunlar SET YorumSayisi=YorumSayisi-1 WHERE id=? LIMIT 1");
							$OyunGuncelleme->execute([$OyunId]);
							$OyunGuncellemeSayisi = $OyunGuncelleme->rowCount();

							if ($OyunGuncellemeSayisi>0) {
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