<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["k"]) and strlen($_POST["k"])<=11 ){
			$KuratorId = SayfaNumarasiTemizle(Guvenlik($_POST["k"]));
		}else{	
			$KuratorId="";
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
			if ($KuratorId!="" and $Sikayet!="") {
				if (strlen($Sikayet)>250){
					$Data = [
			    	'statu' => "character", 
					];
					echo json_encode($Data);
					exit();
				}else{
					$KuratorKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE id=? and id!=? and Kurator=? and Durum=?  LIMIT 1 ");
					$KuratorKontrol->execute([$KuratorId,Guvenlik($KullaniciId),1,1]);
					$KuratorKontrolSayisi = $KuratorKontrol->rowCount();
					$KuratorKontrolKayitlar = $KuratorKontrol->fetch(PDO::FETCH_ASSOC);
					if ($KuratorKontrolSayisi>0) {
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO kuratorsikayet (SikayetEden,SikayetEdilen,Yorum,IpAdresi) values (?,?,?,?) ");
						$SikayetEt->execute([Guvenlik($KullaniciId),$KuratorId,$Sikayet,$IpAdresi]);
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