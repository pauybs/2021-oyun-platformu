<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

	
		if(isset($_POST["fei"]) and strlen($_POST["fei"])<=11 ){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["fei"]));
		}else{	
			$HaberId="";
		}
		if(isset($_POST["j"]) and strlen($_POST["j"])==30 ){
			$Jeton = Guvenlik($_POST["j"]);
		}else{	
			$Jeton="";
		}

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($HaberId!="" and $Uniqid!=""){
				$HaberBaslik = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=?  and Durum=? LIMIT 1 ");
				$HaberBaslik->execute([$HaberId,$Uniqid,1]);
				$HaberBaslikVeri = $HaberBaslik->rowCount();
				$HaberBaslikKayitlar = $HaberBaslik->fetch(PDO::FETCH_ASSOC);
				if ($HaberBaslikVeri>0) {
					$FavoriTekrarlanan = $DatabaseBaglanti->prepare("SELECT * FROM haberfavoriler  WHERE  HaberId=?  AND UyeId=? LIMIT 1");
					$FavoriTekrarlanan->execute([$HaberId,Guvenlik($KullaniciId)]);
					$FavoriTekrarlananSayisi = $FavoriTekrarlanan->rowCount();
					if($FavoriTekrarlananSayisi>0){
						$FavoriKaldir = $DatabaseBaglanti->prepare("DELETE  FROM haberfavoriler WHERE HaberId= ?  AND UyeId=? LIMIT 1 ");
						$FavoriKaldir->execute([$HaberId,Guvenlik($KullaniciId)]);
						$FavoriKaldirVeri = $FavoriKaldir->rowCount();
						if ($FavoriKaldirVeri>0) {
							$Data = [
					    	'statu' => "delete", 
					    	'news'=> $HaberId
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
						$FavoriEkle = $DatabaseBaglanti->prepare("INSERT INTO haberfavoriler (HaberId,UyeId) values (?,?)");
						$FavoriEkle->execute([$HaberId,Guvenlik($KullaniciId)]);
						$Data = $FavoriEkle->rowCount();
						if($Data > 0){
							$Data = [
					    	'statu' => "add", 
					    	'news' => $HaberId
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