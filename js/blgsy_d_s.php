<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Jeton"])) {
	if (isset($_SESSION["Kullanici"] )) {
		if (Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
			$KullaniciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler Where id=? and Durum=? and SilinmeDurumu=? LIMIT 1");
			$KullaniciKontrol->execute([Guvenlik($KullaniciId),1,0]);
			$KullaniciKontrolVerisi = $KullaniciKontrol->rowCount();
			if ($KullaniciKontrolVerisi>0) {
				if( isset($_POST["Bellek"]) and strlen($_POST["Bellek"])<=11 ){
					$BellekId = SayfaNumarasiTemizle(Guvenlik($_POST["Bellek"]));
					$BellekKontrol = $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE id=?");
					$BellekKontrol->execute([$BellekId]);
					$BellekKontrolSayisi = $BellekKontrol->rowCount();
					if ($BellekKontrolSayisi>0) {
						$BellekId = SayfaNumarasiTemizle(Guvenlik($_POST["Bellek"]));
					}else{
						$BellekId= NULL;
					}
				}else{
					$BellekId= NULL;	
				}

				if( isset($_POST["IsletimSistemi"])  and strlen($_POST["IsletimSistemi"])<=11 ){
					$IsletimSistemiId = SayfaNumarasiTemizle(Guvenlik($_POST["IsletimSistemi"]));
					$IsletimSistemiKontrol = $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE id=?");
					$IsletimSistemiKontrol->execute([$IsletimSistemiId]);
					$IsletimSistemiKontrolSayisi = $IsletimSistemiKontrol->rowCount();
					if ($IsletimSistemiKontrolSayisi>0) {
						$IsletimSistemiId = SayfaNumarasiTemizle(Guvenlik($_POST["IsletimSistemi"]));
					}else{
						$IsletimSistemiId=NULL;
					}
				}else{
					$IsletimSistemiId=NULL;
				}

				if( isset($_POST["Islemci"])  and strlen($_POST["Islemci"])<=11 ){
					$IslemciId = SayfaNumarasiTemizle(Guvenlik($_POST["Islemci"]));
					$IslemciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE id=?");
					$IslemciKontrol->execute([$IslemciId]);
					$IslemciKontrolSayisi = $IslemciKontrol->rowCount();
					if ($IslemciKontrolSayisi>0) {
						$IslemciId = SayfaNumarasiTemizle(Guvenlik($_POST["Islemci"]));
					}else{
						$IslemciId=NULL;
					}
				}else{
					$IslemciId=NULL;
				}

				if( isset($_POST["EkranKarti"]) and strlen($_POST["EkranKarti"])<=11 ){
					$EkranKartiId = SayfaNumarasiTemizle(Guvenlik($_POST["EkranKarti"]));	
					$EkranKartiKontrol = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE id=?");
					$EkranKartiKontrol->execute([$EkranKartiId]);
					$EkranKartiKontrolSayisi = $EkranKartiKontrol->rowCount();
					if ($EkranKartiKontrolSayisi>0) {
						$EkranKartiId = SayfaNumarasiTemizle(Guvenlik($_POST["EkranKarti"]));	
					}else{
						$EkranKartiId=NULL;
					}
				}else{
					$EkranKartiId=NULL;
				}

				if(isset($_POST["DirectX"])  and strlen($_POST["DirectX"])<=11){
					$DirectXId = SayfaNumarasiTemizle(Guvenlik($_POST["DirectX"]));
					$DirectXKontrol = $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=?");
					$DirectXKontrol->execute([$DirectXId]);
					$DirectXKontrolSayisi = $DirectXKontrol->rowCount();
					if ($DirectXKontrolSayisi>0) {
						$DirectXId = SayfaNumarasiTemizle(Guvenlik($_POST["DirectX"]));
					}else{
						$DirectXId= NULL;
					}
				}else{
					$DirectXId= NULL;
				}

				if(isset($_POST["Tkn"])  and strlen($_POST["Tkn"])==30){
					$Jeton = Guvenlik($_POST["Tkn"]);
				}else{
					$Jeton="";
				}
				
				if (Guvenlik($_SESSION["Jeton"])== $Jeton) {
					$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar Where UyeId=? LIMIT 1");
					$UyeKontrol->execute([Guvenlik($KullaniciId)]);
					$UyeKontrolVerisi = $UyeKontrol->rowCount();
					if ($UyeKontrolVerisi>0) {
						$UyeGuncelle = $DatabaseBaglanti->prepare("UPDATE uyebilgisayar SET IsletimSistemiId=?,IslemciId=?,EkranKartiId=?,RamId=?,DirectxId=? WHERE UyeId=? LIMIT 1");
						$UyeGuncelle->execute([$IsletimSistemiId,$IslemciId,$EkranKartiId,$BellekId,$DirectXId,Guvenlik($KullaniciId)]);
						$UyeVeri = $UyeGuncelle->rowCount();
						$Data = [
			            'statu' => true,
			        	];
			 			echo json_encode($Data);
						exit();
					}else{
						$UyeEkle = $DatabaseBaglanti->prepare("INSERT INTO uyebilgisayar (UyeId,IsletimSistemiId,IslemciId,EkranKartiId,RamId,DirectxId) values (?,?,?,?,?,?)");
						$UyeEkle->execute([Guvenlik($KullaniciId),$IsletimSistemiId,$IslemciId,$EkranKartiId,$BellekId,$DirectXId]);
						$UyeEkleVeri = $UyeEkle->rowCount();
						
						if($UyeEkleVeri>0){
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
					header("location:".$SiteLink);
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

