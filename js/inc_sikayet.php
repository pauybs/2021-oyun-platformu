<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["in"]) and strlen($_POST["in"])<=11 ){
			$IncelemeId = SayfaNumarasiTemizle(Guvenlik($_POST["in"]));
		}else{	
			$IncelemeId="";
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
		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if ($IncelemeId!="" and $Sikayet!="") {
				if (strlen($Sikayet)>250){
					$Data = [
					'statu' => "character", 
					];
					echo json_encode($Data);
					exit();
				}else{
					$IncelemeKontrol= $DatabaseBaglanti->prepare("SELECT * FROM  incelemeler WHERE Incelemeid=? and KuratorId!=? and Durum=?  LIMIT 1 ");
					$IncelemeKontrol->execute([$IncelemeId,Guvenlik($KullaniciId),1]);
					$IncelemeKontrolSayisi = $IncelemeKontrol->rowCount();
					$IncelemeKontrolKayitlar = $IncelemeKontrol->fetch(PDO::FETCH_ASSOC);
					if ($IncelemeKontrolSayisi>0) {
						$SikayetEt = $DatabaseBaglanti->prepare("INSERT INTO incelemesikayet (SikayetEden,SikayetEdilen,IncelemeId,Yorum,IpAdresi)  values (?,?,?,?,?) ");
						$SikayetEt->execute([Guvenlik($KullaniciId),Guvenlik($IncelemeKontrolKayitlar["KuratorId"]),$IncelemeId,$Sikayet,$IpAdresi]);
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