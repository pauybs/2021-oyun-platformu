<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["Konu"])){
			$Konu = Guvenlik($_POST["Konu"]);
			if (strlen($Konu) <=100 ) {
				$Konu = Guvenlik($_POST["Konu"]);
			}else{
				$Data = [
		    	'statu' => "character", 
				];
				echo json_encode($Data);
				exit();
			}
		}else{	
			$Konu="";
		}

		if(isset($_POST["Icerik"])){
			$Icerik = Guvenlik($_POST["Icerik"]);
			if (strlen($Icerik)>10000) {
				$Data = [
        		'statu' => "long", 
		    	];
				echo json_encode($Data);
				exit();
			}else{
				$Icerik = Guvenlik($_POST["Icerik"]);
			}

		}else{	
			$Icerik="";
		}

		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($Konu!="" and $Icerik!=""){
				$Uye = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  and Durum=? and SilinmeDurumu=? LIMIT 1 ");
				$Uye->execute([$KullaniciId,1,0]);
				$UyeVeri = $Uye->rowCount();
				$UyeKayitlar = $Uye->fetch(PDO::FETCH_ASSOC);
				if ($UyeVeri>0) {
						$id=destek_uniq();
						$Sonuc=0;
						do {
							$id=destek_uniq();
						  	$Kontrol = $DatabaseBaglanti->prepare("SELECT * FROM destek WHERE  destekid=?");
							$Kontrol->execute([$id]);
							$KontrolVeri = $Kontrol->rowCount();
							if ($KontrolVeri>0) {
								$Sonuc=0;
							}else{
								$Sonuc++;	
							}
						} while ($Sonuc <= 0);

						$TalepEkle = $DatabaseBaglanti->prepare("INSERT INTO destek (UyeId,destekid,Baslik,Konu,Tarih,IpAdresi,Durum) values (?,?,?,?,?,?,?)");
						$TalepEkle->execute([Guvenlik($KullaniciId),$id,$Konu,$Icerik,$Zaman,$IpAdresi,0]);
						$Data = $TalepEkle->rowCount();
						if($Data > 0){
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
	header("location:" .$SiteLink);
	exit();	
}
?>