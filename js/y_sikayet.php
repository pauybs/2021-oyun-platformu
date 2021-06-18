<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["hys"])){
			$HaberYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["hys"]));
		}else{	
			$HaberYorumId="";
		}
		if(isset($_POST["HSikayet"])){
			$HaberSikayet = Guvenlik($_POST["HSikayet"]);
		}else{	
			$HaberSikayet="";
		}
		if(isset($_POST["hcys"])){
			$HaberCevapYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["hcys"]));
		}else{	
			$HaberCevapYorumId="";
		}
		if(isset($_POST["HcSikayet"])){
			$HaberCevapSikayet = Guvenlik($_POST["HcSikayet"]);
		}else{	
			$HaberCevapSikayet="";
		}
		if(isset($_POST["oys"])){
			$OyunYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["oys"]));
		}else{	
			$OyunYorumId="";
		}
		if(isset($_POST["OSikayet"])){
			$OyunSikayet = Guvenlik($_POST["OSikayet"]);
		}else{	
			$OyunSikayet="";
		}

		if(isset($_POST["ocys"])){
			$OyunCevapYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["ocys"]));
		}else{	
			$OyunCevapYorumId="";
		}
		if(isset($_POST["OcSikayet"])){
			$OyunCevapSikayet = Guvenlik($_POST["OcSikayet"]);
		}else{	
			$OyunCevapSikayet="";
		}
		if(isset($_POST["Tkn"])){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["iys"])){
			$IncelemeYorumId = SayfaNumarasiTemizle(Guvenlik($_POST["iys"]));
		}else{	
			$IncelemeYorumId="";
		}
		if(isset($_POST["IncSikayet"])){
			$IncelemeSikayet = Guvenlik($_POST["IncSikayet"]);
		}else{	
			$IncelemeSikayet="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if ($HaberYorumId!="" and $HaberSikayet!="") {
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  haberyorumlar WHERE id=?  and UyeId!=? LIMIT 1 ");
				$YorumKontrol->execute([$HaberYorumId,Guvenlik($KullaniciId)]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					if (strlen($HaberSikayet)>250){
						$Data = [
			        		'statu' => "character", 
			    		];
						echo json_encode($Data);
						exit();	
					}else{
						$YorumSahibi=Guvenlik($YorumKontrolKayitlar["UyeId"]);
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO yorumsikayet (YorumTuru,SikayetEden,SikayetEdilen,Yorum,SikayetYorum,SikayetEdenIp)  values (?,?,?,?,?,?) ");
						$SikayetEt->execute([0,Guvenlik($KullaniciId),$YorumSahibi,$HaberYorumId,$HaberSikayet,$IpAdresi]);
						$SikayetEtKontrol =$SikayetEt->rowCount();
						if ($SikayetEtKontrol>0) {
							$Data = [
				        		'statu' => "success", 
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
					}
				}else{
					$Data = [
		        		'statu' => "error", 
		    		];
					echo json_encode($Data);
					exit();		
				}
			}else if($HaberCevapYorumId!="" and $HaberCevapSikayet!=""){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  haberyorumcevap WHERE id=?  and UyeId!=? LIMIT 1 ");
				$YorumKontrol->execute([$HaberCevapYorumId,Guvenlik($KullaniciId)]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					$YorumSahibi=Guvenlik($YorumKontrolKayitlar["UyeId"]);
					if (strlen($HaberCevapSikayet)>250){
						$Data = [
			        		'statu' => "character", 
			    		];
						echo json_encode($Data);
						exit();	
					}else{
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO yorumsikayet (YorumTuru,SikayetEden,SikayetEdilen,YorumCevap,SikayetYorum,SikayetEdenIp) values (?,?,?,?,?,?) ");
						$SikayetEt->execute([1,Guvenlik($KullaniciId),$YorumSahibi,$HaberCevapYorumId,$HaberCevapSikayet,$IpAdresi]);
						$SikayetEtKontrol =$SikayetEt->rowCount();
						if ($SikayetEtKontrol>0) {
							$Data = [
				        	'statu' => "success", 
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
					}	
				}else{
					$Data = [
		        	'statu' => "error", 
		    		];
					echo json_encode($Data);
					exit();	
				}
			}else if($OyunYorumId!="" and $OyunSikayet!=""){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  oyunyorumlar WHERE id=?  and UyeId!=? LIMIT 1 ");
				$YorumKontrol->execute([$OyunYorumId,Guvenlik($KullaniciId)]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					$YorumSahibi=$YorumKontrolKayitlar["UyeId"];
					if (strlen($OyunSikayet)>250){
						$Data = [
			        		'statu' => "character", 
			    		];
						echo json_encode($Data);
						exit();	

					}else{
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO yorumsikayet (YorumTuru,SikayetEden,SikayetEdilen,Yorum,SikayetYorum,SikayetEdenIp)  values (?,?,?,?,?,?) ");
						$SikayetEt->execute([2,Guvenlik($KullaniciId),$YorumSahibi,$OyunYorumId,$OyunSikayet,$IpAdresi]);
						$SikayetEtKontrol =$SikayetEt->rowCount();
						if ($SikayetEtKontrol>0) {
							$Data = [
				        	'statu' => "success", 
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
					}
				}else{
					$Data = [
		        	'statu' => "error", 
		    		];
					echo json_encode($Data);
					exit();	
				}
			}else if($OyunCevapYorumId!="" and $OyunCevapSikayet!=""){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  oyunyorumcevap WHERE id=?  and UyeId!=? LIMIT 1 ");
				$YorumKontrol->execute([$OyunCevapYorumId,Guvenlik($KullaniciId)]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					$YorumSahibi=$YorumKontrolKayitlar["UyeId"];
					if (strlen($OyunCevapSikayet)>250){
						$Data = [
			        		'statu' => "character", 
			    		];
						echo json_encode($Data);
						exit();		
					}else{
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO yorumsikayet (YorumTuru,SikayetEden,SikayetEdilen,YorumCevap,SikayetYorum,SikayetEdenIp)  values (?,?,?,?,?,?) ");
						$SikayetEt->execute([3,Guvenlik($KullaniciId),$YorumSahibi,$OyunCevapYorumId,$OyunCevapSikayet,$IpAdresi]);
						$SikayetEtKontrol =$SikayetEt->rowCount();
						if ($SikayetEtKontrol>0) {
							$Data = [
				        	'statu' => "success", 
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
					}
				}else{
					$Data = [
		        	'statu' => "error", 
		    		];
					echo json_encode($Data);
					exit();	
				}
			}else if($IncelemeYorumId!="" and $IncelemeSikayet!=""){
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  incelemeyorumlar WHERE YorumId=?  and UyeId!=? LIMIT 1 ");
				$YorumKontrol->execute([$IncelemeYorumId,Guvenlik($KullaniciId)]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					if (strlen($IncelemeSikayet)>250){
						$Data = [
			        		'statu' => "character", 
			    		];
						echo json_encode($Data);
						exit();	
					}else{
						$YorumSahibi=Guvenlik($YorumKontrolKayitlar["UyeId"]);
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO yorumsikayet (YorumTuru,SikayetEden,SikayetEdilen,Yorum,SikayetYorum,SikayetEdenIp)  values (?,?,?,?,?,?) ");
						$SikayetEt->execute([4,Guvenlik($KullaniciId),$YorumSahibi,$IncelemeYorumId,$IncelemeSikayet,$IpAdresi]);
						$SikayetEtKontrol =$SikayetEt->rowCount();
						if ($SikayetEtKontrol>0) {
							$Data = [
				        		'statu' => "success", 
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
	        	'statu' => "null", 
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
	header("location: " .$SiteLink );
	exit();
}
?>