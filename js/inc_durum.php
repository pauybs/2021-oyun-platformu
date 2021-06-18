<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if ($KullaniciKuratorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		if(isset($_POST["oiy"]) and strlen($_POST["oiy"])<=11){
			$IncelemeId = SayfaNumarasiTemizle(Guvenlik($_POST["oiy"]));
		}else{	
			$IncelemeId="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($IncelemeId!=""){
				$IncelemeKontrol=$DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE Incelemeid=? and KuratorId=? and Durum!=? and Durum!=?");
				$IncelemeKontrol->execute([$IncelemeId,Guvenlik($KullaniciId),0,3]);
				$IncelemeKontrolVeri = $IncelemeKontrol->rowCount();
				$IncelemeKontrolKayitlar = $IncelemeKontrol->fetch(PDO::FETCH_ASSOC);
				if ($IncelemeKontrolVeri>0) {
					$IncelemeYayinda = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler  WHERE  Incelemeid=?  AND KuratorId=? and Durum=?");
					$IncelemeYayinda->execute([$IncelemeId,Guvenlik($KullaniciId),1]);
					$IncelemeYayindaSayisi = $IncelemeYayinda->rowCount();
					if($IncelemeYayindaSayisi>0){
						$YayindanKaldir = $DatabaseBaglanti->prepare("UPDATE incelemeler SET Durum=? WHERE Incelemeid=?  ");
						$YayindanKaldir->execute([2,$IncelemeId]);
						$YayindanKaldirVeri = $YayindanKaldir->rowCount();
						if ($YayindanKaldirVeri>0) {
							$Data = [
					    	'statu' => "success1", 
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
						$Yayinla = $DatabaseBaglanti->prepare("UPDATE incelemeler SET Durum=? WHERE Incelemeid=?");
						$Yayinla->execute([1,$IncelemeId]);
						$Data = $Yayinla->rowCount();
						if($Data > 0){
							$Data = [
					    	'statu' => "success2", 
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