<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["yi"]) and strlen($_POST["yi"])<=11 ){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yi"]));
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
			if ( $YorumId!="" and $Oyun!="" and $Uniqid!="" ){
				$Yorumlar= $DatabaseBaglanti->prepare("SELECT * FROM  oyunyorumlar WHERE id=? and OyunUniqid=? and UyeId=? and Durum!=? and Durum!=? and OyunId=? LIMIT 1 ");
				$Yorumlar->execute([$YorumId,$Uniqid,Guvenlik($KullaniciId),4,3,$Oyun]);
				$YorumlarSayisi = $Yorumlar->rowCount();
				$YorumlarKayitlar = $Yorumlar->fetch(PDO::FETCH_ASSOC);
				if($YorumlarSayisi>0){
					$OyunId =  Guvenlik($YorumlarKayitlar["OyunId"]);
					$YorumSilme= $DatabaseBaglanti->prepare("UPDATE oyunyorumlar SET Durum=? WHERE id=? and UyeId=? LIMIT 1");
					$YorumSilme->execute([3,$YorumId,Guvenlik($KullaniciId)]);
					$YorumSilmeSayisi = $YorumSilme->rowCount();
					if($YorumSilmeSayisi>0){
						$OyunGuncelleme = $DatabaseBaglanti->prepare("UPDATE oyunlar SET YorumSayisi=YorumSayisi-1 WHERE id=? LIMIT 1");
						$OyunGuncelleme->execute([$OyunId]);
						$OyunGuncellemeSayisi = $OyunGuncelleme->rowCount();
						if ($OyunGuncellemeSayisi>0) {
							$YorumlarCevap= $DatabaseBaglanti->prepare("SELECT * FROM   oyunyorumcevap WHERE OyunUniqid=? and OyunId=?  and  YorumId=?  ");
							$YorumlarCevap->execute([$Uniqid,$OyunId,$YorumId]);
							$YorumlarCevapSayisi = $YorumlarCevap->rowCount();
							$YorumlarCevapKayitlar = $YorumlarCevap->fetch(PDO::FETCH_ASSOC);
							if ($YorumlarCevapSayisi>0) {
								$YorumCevapSilme= $DatabaseBaglanti->prepare("UPDATE oyunyorumcevap SET Durum=? WHERE YorumId=? ");
								$YorumCevapSilme->execute([3,$YorumId]);
								$YorumCevapSilmeSayisi = $YorumCevapSilme->rowCount();
								if ($YorumCevapSilmeSayisi>0) {
									$OyunYorumGuncelleme = $DatabaseBaglanti->prepare("UPDATE oyunlar SET YorumSayisi=YorumSayisi-? WHERE id=? ");
									$OyunYorumGuncelleme->execute([$YorumCevapSilmeSayisi,$OyunId]);
									$OyunYorumGuncellemeSayisi = $OyunYorumGuncelleme->rowCount();
									if ($OyunYorumGuncellemeSayisi >0) {
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
						        	'statu' => true, 
						    		];
									echo json_encode($Data);
									exit();	
								}					
							}else{
								$Data = [
					        	'statu' => true, 
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
	header("location: " .$SiteLink);
	exit();
}
?>