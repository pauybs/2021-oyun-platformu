<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"] ) ){
	if(Guvenlik($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
		if(isset($_POST["hiy"])  and strlen($_POST["hiy"])<=30){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["hiy"]));
		}else{	
			$HaberId="";
		}
		if(isset($_POST["j"])   and strlen($_POST["j"])==30 ){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["ui"])  and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}


		
		if($HaberId!="" and $Jeton!="" and $Uniqid!=""){
			if (Guvenlik($_SESSION["Jeton"])== $Jeton) {
				$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? and Editor=? and Durum!=? and Durum!=? and Durum!=?");
				$HaberKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),0,4,2]);
				$HaberKontrolVeri = $HaberKontrol->rowCount();
				$HaberKontrolKayitlar = $HaberKontrol->fetch(PDO::FETCH_ASSOC);
				if ($HaberKontrolVeri>0) {
					$HaberYayinda = $DatabaseBaglanti->prepare("SELECT * FROM haberler  WHERE  id=?  AND Editor=? and Durum=?");
					$HaberYayinda->execute([$HaberId,Guvenlik($KullaniciId),1]);
					$HaberYayindaSayisi = $HaberYayinda->rowCount();
					if($HaberYayindaSayisi>0){
						$YayindanKaldir = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?  ");
						$YayindanKaldir->execute([3,$HaberId]);
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
						$Yayinla = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?");
						$Yayinla->execute([1,$HaberId]);
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