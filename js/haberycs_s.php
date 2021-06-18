<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["yci"]) and strlen($_POST["yci"])<=11 ){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yci"]));
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

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}


		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if ( $YorumId!="" and $Haber!=""  and  $Uniqid!=""){
				$HaberBaslik= $DatabaseBaglanti->prepare("SELECT * FROM   haberyorumcevap WHERE  id=? and HaberUniqid=? and Durum!=? and Durum!=? and HaberId=?  LIMIT 1 ");
				$HaberBaslik->execute([$YorumId,$Uniqid,4,3,$Haber]);
				$HaberBaslikSayisi = $HaberBaslik->rowCount();
				$HaberBaslikKayitlar = $HaberBaslik->fetch(PDO::FETCH_ASSOC);
				if ($HaberBaslikSayisi>0) {		
					$HaberId=Guvenlik($HaberBaslikKayitlar["HaberId"]);
					$Yorumlar= $DatabaseBaglanti->prepare("SELECT * FROM   haberyorumcevap  WHERE id=?  and HaberUniqid=? AND HaberId=? AND UyeId=? LIMIT 1 ");
					$Yorumlar->execute([$YorumId,$Uniqid,$HaberId,Guvenlik($KullaniciId)]);
					$YorumlarSayisi = $Yorumlar->rowCount();
					$YorumlarKayitlar = $Yorumlar->fetch(PDO::FETCH_ASSOC);
					if($YorumlarSayisi>0){
						$YorumSilme= $DatabaseBaglanti->prepare("UPDATE haberyorumcevap SET Durum=? WHERE id=? AND HaberId=? AND UyeId=?  LIMIT 1");
						$YorumSilme->execute([3,$YorumId,$HaberId,Guvenlik($KullaniciId)]);
						$YorumSilmeSayisi = $YorumSilme->rowCount();
						if($YorumSilmeSayisi>0){
							$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi-1 WHERE id=? LIMIT 1");
							$HaberGuncelleme->execute([$HaberId]);
							$HaberGuncellemeSayisi = $HaberGuncelleme->rowCount();
							if ($HaberGuncellemeSayisi>0) {
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