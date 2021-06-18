<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["te"]) and strlen($_POST["te"])<=11){
			$KuratorId = SayfaNumarasiTemizle(Guvenlik($_POST["te"]));
		}else{	
			$KuratorId="";
		}
		if(isset($_POST["kdte"]) and strlen($_POST["kdte"])<=11){
			$KuratorDetayId = SayfaNumarasiTemizle(Guvenlik($_POST["kdte"]));
		}else{	
			$KuratorDetayId="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($KuratorId!=""){
				$KuratorKontrol=$DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and id!=? and Durum=? and Kurator=?  and SilinmeDurumu=? LIMIT 1 ");
				$KuratorKontrol->execute([$KuratorId,Guvenlik($KullaniciId),1,1,0]);
				$KuratorKontrolVeri = $KuratorKontrol->rowCount();
				$KuratorKontrolKayitlar = $KuratorKontrol->fetch(PDO::FETCH_ASSOC);
				if ($KuratorKontrolVeri>0) {
					$Profil=IcerikTemizle($KuratorKontrolKayitlar["ProfilResmi"]);
					$KullaniciAdi=IcerikTemizle($KuratorKontrolKayitlar["KullaniciAdi"]);
					if ($Profil!="") {
						$klasor="images/userphoto/".$Profil;
					}else{
						$klasor="images/user.png";
					}
					if($KuratorId!=$KullaniciId){
						$KuratorKullaniciAdi= IcerikTemizle($KuratorKontrolKayitlar["KullaniciAdi"]);
						$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip  WHERE  KuratorId=?  AND TakipciId=? LIMIT 1");
						$TakipKontrol->execute([$KuratorId,Guvenlik($KullaniciId)]);
						$TakipKontrolSayi = $TakipKontrol->rowCount();
						if($TakipKontrolSayi>0){
							$TakiptenCik = $DatabaseBaglanti->prepare("DELETE  FROM kuratortakip WHERE KuratorId= ?  AND TakipciId=? LIMIT 1 ");
							$TakiptenCik->execute([$KuratorId,Guvenlik($KullaniciId)]);
							$TakiptenCikVeri = $TakiptenCik->rowCount();
							if ($TakiptenCikVeri>0) {
								$Data = [
								'statu' => "unfollow",
								'username' => $KuratorKullaniciAdi, 
								'image' => $klasor,
								'curator' => $KuratorId,
								'tkn' => $Jeton,
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
							$TakipEt = $DatabaseBaglanti->prepare("INSERT INTO kuratortakip (KuratorId,TakipciId) values (?,?)");
							$TakipEt->execute([$KuratorId,Guvenlik($KullaniciId)]);
							$TakipEtVeri = $TakipEt->rowCount();
							if($TakipEtVeri > 0){

								$Data = [
								'statu' => "follow",
								'username' => $KuratorKullaniciAdi, 
								'image' => $klasor,
								'curator' => $KuratorId,
								'tkn' => $Jeton,
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
					}else {
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
			}else if ($KuratorDetayId!="") {
				$KuratorKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and id!=? and Durum=? and Kurator=? LIMIT 1 ");
				$KuratorKontrol->execute([$KuratorDetayId,Guvenlik($KullaniciId),1,1]);
				$KuratorKontrolVeri = $KuratorKontrol->rowCount();
				$KuratorKontrolKayitlar = $KuratorKontrol->fetch(PDO::FETCH_ASSOC);
				if ($KuratorKontrolVeri>0) {
					$KullaniciAdi=IcerikTemizle($KuratorKontrolKayitlar["KullaniciAdi"]);
					if($KuratorDetayId!=$KullaniciId){
						$KuratorKullaniciAdi= IcerikTemizle($KuratorKontrolKayitlar["KullaniciAdi"]);
						$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip  WHERE  KuratorId=?  AND TakipciId=? LIMIT 1");
						$TakipKontrol->execute([$KuratorDetayId,Guvenlik($KullaniciId)]);
						$TakipKontrolSayi = $TakipKontrol->rowCount();
						if($TakipKontrolSayi>0){
							$TakiptenCik = $DatabaseBaglanti->prepare("DELETE  FROM kuratortakip WHERE KuratorId= ?  AND TakipciId=? LIMIT 1 ");
							$TakiptenCik->execute([$KuratorDetayId,$KullaniciId]);
							$TakiptenCikVeri = $TakiptenCik->rowCount();
							if ($TakiptenCikVeri>0) {
								$Data = [
								'statu' => "unfollow",
								'curator' => $KuratorDetayId,
								'tkn' => $Jeton,
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
							$TakipEt = $DatabaseBaglanti->prepare("INSERT INTO kuratortakip (KuratorId,TakipciId) values (?,?)");
							$TakipEt->execute([$KuratorDetayId,Guvenlik($KullaniciId)]);
							$TakipEtVeri = $TakipEt->rowCount();
							if($TakipEtVeri > 0){

								$Data = [
								'statu' => "follow",
								'curator' => $KuratorDetayId,
								'tkn' => $Jeton,
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
					}else {
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