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
		if(isset($_POST["j"]) and strlen($_POST["j"])==30 ){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["h"]) and strlen($_POST["h"])<=11 ){
			$Haber = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{	
			$Haber="";
		}

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if (($YorumId!="" and $Haber!="")  and  ($Uniqid!="")){
				$Yorumlar= $DatabaseBaglanti->prepare("SELECT * FROM  haberyorumlar WHERE id=? and HaberUniqid=? and UyeId=? and Durum!=?  and Durum!=? and HaberId=? LIMIT 1 ");
				$Yorumlar->execute([$YorumId,$Uniqid,Guvenlik($KullaniciId),4,3,$Haber]);
				$YorumlarSayisi = $Yorumlar->rowCount();
				$YorumlarKayitlar = $Yorumlar->fetch(PDO::FETCH_ASSOC);
				if($YorumlarSayisi>0){
					$HaberId =  Guvenlik($YorumlarKayitlar["HaberId"]);
					$YorumSilme= $DatabaseBaglanti->prepare("UPDATE haberyorumlar SET Durum=? WHERE id=? and UyeId=? LIMIT 1");
					$YorumSilme->execute([3,$YorumId,Guvenlik($KullaniciId)]);
					$YorumSilmeSayisi = $YorumSilme->rowCount();
					if($YorumSilmeSayisi>0){
						$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi-1 WHERE id=? LIMIT 1");
						$HaberGuncelleme->execute([$HaberId]);
						$HaberGuncellemeSayisi = $HaberGuncelleme->rowCount();
						if ($HaberGuncellemeSayisi>0) {
							$YorumlarCevap= $DatabaseBaglanti->prepare("SELECT * FROM   haberyorumcevap WHERE   HaberId=? and HaberUniqid=?  and  YorumId=?  ");
							$YorumlarCevap->execute([$HaberId,$Uniqid,$YorumId]);
							$YorumlarCevapSayisi = $YorumlarCevap->rowCount();
							$YorumlarCevapKayitlar = $YorumlarCevap->fetch(PDO::FETCH_ASSOC);
							if ($YorumlarCevapSayisi>0) {
								$YorumCevapSilme= $DatabaseBaglanti->prepare("UPDATE haberyorumcevap SET Durum=? WHERE YorumId=? ");
								$YorumCevapSilme->execute([3,$YorumId]);
								$YorumCevapSilmeSayisi = $YorumCevapSilme->rowCount();
								if ($YorumCevapSilmeSayisi>0) {
									$HaberYorumGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi-? WHERE id=? ");
									$HaberYorumGuncelleme->execute([$YorumCevapSilmeSayisi,$HaberId]);
									$HaberYorumGuncellemeSayisi = $HaberYorumGuncelleme->rowCount();
									if ($HaberYorumGuncellemeSayisi > 0) {
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
	header("location:" .$SiteLink);
	exit();	
}
?>