<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ) {
	if ( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["sys"]) and strlen($_POST["sys"])<=11){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["sys"]));
		}else{	
			$YorumId="";
		}

		if(isset($_POST["Sikayet"])){
			$Sikayet = Guvenlik($_POST["Sikayet"]);
		}else{	
			$Sikayet="";
		}

		if(isset($_POST["tkn"]) and strlen($_POST["tkn"])==30){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if ($YorumId!="" and $Sikayet!="" ) {
				$YorumKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  sozlukyorumlar WHERE id=?  and UyeId!=?  and Durum=? LIMIT 1");
				$YorumKontrol->execute([$YorumId,Guvenlik($KullaniciId),1]);
				$YorumKontrolSayisi = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolSayisi>0) {
					if (strlen($Sikayet)>250){
						$Data = [
				        'statu' => "character",
				    	];
						echo json_encode($Data);
						exit();	
					}else{
						$YorumSahibi=Guvenlik($YorumKontrolKayitlar["UyeId"]);
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO sozlukyorumsikayet (SikayetEden,SikayetEdilen,YorumId,SikayetYorum,SikayetEdenIp)  values (?,?,?,?,?) ");
						$SikayetEt->execute([Guvenlik($KullaniciId),$YorumSahibi,$YorumId,$Sikayet,$IpAdresi]);
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
	header("location: " .$SiteLink);
	exit();
}
?>