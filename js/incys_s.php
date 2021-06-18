<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["yi"])){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yi"]));
		}else{	
			$YorumId="";
		}
		if(isset($_POST["j"])){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["inc"])){
			$Inceleme = SayfaNumarasiTemizle(Guvenlik($_POST["inc"]));
		}else{	
			$Inceleme="";
		}


		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if (($YorumId!="" and $Inceleme!="")  ){
				$Yorumlar= $DatabaseBaglanti->prepare("SELECT * FROM  incelemeyorumlar WHERE YorumId=?  and UyeId=? and Durum!=?  and Durum!=? and IncelemeId=? LIMIT 1 ");
				$Yorumlar->execute([$YorumId,Guvenlik($KullaniciId),2,3,$Inceleme]);
				$YorumlarSayisi = $Yorumlar->rowCount();
				$YorumlarKayitlar = $Yorumlar->fetch(PDO::FETCH_ASSOC);
				if($YorumlarSayisi>0){
					$IncelemeId =  Guvenlik($YorumlarKayitlar["IncelemeId"]);
					$YorumSilme= $DatabaseBaglanti->prepare("UPDATE incelemeyorumlar SET Durum=? WHERE YorumId=? and UyeId=? LIMIT 1");
					$YorumSilme->execute([2,$YorumId,Guvenlik($KullaniciId)]);
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