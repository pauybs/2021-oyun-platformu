<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["fei"]) and strlen($_POST["fei"])<=11 ){
			$OyunId = SayfaNumarasiTemizle(Guvenlik($_POST["fei"]));
		}else{	
			$OyunId="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}
		if(isset($_POST["ui"]) and strlen($_POST["ui"])==20){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($OyunId!="" and $Uniqid!=""){
				$Oyun = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=?  and OyunUniqid=?  and Durum=? LIMIT 1 ");
				$Oyun->execute([$OyunId,$Uniqid,1]);
				$OyunVeri = $Oyun->rowCount();
				$OyunKayitlar = $Oyun->fetch(PDO::FETCH_ASSOC);
				if ($OyunVeri>0) {
					$FavoriTekrarlanan = $DatabaseBaglanti->prepare("SELECT * FROM oyunfavoriler  WHERE  OyunId=?  AND UyeId=? LIMIT 1");
					$FavoriTekrarlanan->execute([$OyunId,Guvenlik($KullaniciId)]);
					$FavoriTekrarlananSayisi = $FavoriTekrarlanan->rowCount();
					if($FavoriTekrarlananSayisi>0){
						$FavoriKaldir = $DatabaseBaglanti->prepare("DELETE  FROM oyunfavoriler WHERE OyunId= ?  AND UyeId=? LIMIT 1 ");
						$FavoriKaldir->execute([$OyunId,Guvenlik($KullaniciId)]);
						$FavoriKaldirVeri = $FavoriKaldir->rowCount();
						if ($FavoriKaldirVeri>0) {
							$Data = [
					    	'statu' => "delete", 
					    	'game' => $OyunId
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
						$FavoriEkle = $DatabaseBaglanti->prepare("INSERT INTO oyunfavoriler (OyunId,UyeId) values (?,?)");
						$FavoriEkle->execute([$OyunId,Guvenlik($KullaniciId)]);
						$Data = $FavoriEkle->rowCount();
						if($Data > 0){
							$Data = [
					    	'statu' => "add", 
					    	'game' => $OyunId
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