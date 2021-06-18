<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ) {
	if ( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["y"]) and strlen($_POST["y"])<=11){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["y"]));
		}else{	
			$YorumId="";
		}
		if(isset($_POST["y"])){
			$Baslik = SayfaNumarasiTemizle(Guvenlik($_POST["b"]));
		}else{	
			$Baslik="";
		}
		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($YorumId!="" and $Baslik!=""){
				$YorumKontrol = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyorumlar WHERE id=? and YaziId=? and Durum=?  and UyeId!=? ");
				$YorumKontrol->execute([$YorumId,$Baslik,1,Guvenlik($KullaniciId)]);
				$YorumKontrolVeri = $YorumKontrol->rowCount();
				$YorumKontrolKayitlar = $YorumKontrol->fetch(PDO::FETCH_ASSOC);
				if ($YorumKontrolVeri>0) {
					if($YorumKontrolKayitlar["UyeId"]!=$KullaniciId){
						$BegeniKontrol = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyorumbegeni  WHERE  YorumId=?  AND UyeId=? ");
						$BegeniKontrol->execute([$YorumId,Guvenlik($KullaniciId)]);
						$BegeniKontrolSayi = $BegeniKontrol->rowCount();
						if($BegeniKontrolSayi>0){    
							$Begenmektenvazgeç =$DatabaseBaglanti->prepare(" UPDATE sozlukyorumlar SET Begeni=Begeni-1  WHERE  id=? AND Durum=? and YaziId=? ");
							$Begenmektenvazgeç->execute([$YorumId,1,$Baslik]);
							$BegenmektenvazgeçVeri = $Begenmektenvazgeç->rowCount();
							if ($BegenmektenvazgeçVeri>0) {
								$BegeniKaldir = $DatabaseBaglanti->prepare("DELETE  FROM sozlukyorumbegeni WHERE YorumId=?  AND UyeId=? ");
								$BegeniKaldir->execute([$YorumId,Guvenlik($KullaniciId)]);
								$BegeniKaldirVeri = $BegeniKaldir->rowCount();
								if ($BegeniKaldirVeri>0) {
									$Data = [
								    'statu' => "unlike",
								    'comment' => $YorumId,
								    'tkn' => $Jeton,
								    'title' => $Baslik,
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
							$Begen = $DatabaseBaglanti->prepare("UPDATE sozlukyorumlar SET Begeni=Begeni+1  WHERE  id=? AND Durum=? and YaziId=?");
							$Begen->execute([$YorumId,1,$Baslik]);
							$BegenVeri = $Begen->rowCount();
							if($BegenVeri> 0){		
								$BegeniEkle = $DatabaseBaglanti->prepare("INSERT INTO sozlukyorumbegeni  (YorumId,UyeId)  values(?,?)  ");
								$BegeniEkle->execute([$YorumId,Guvenlik($KullaniciId)]);
								$BegeniEkleVeri = $BegeniEkle->rowCount();
								if ($BegeniEkleVeri>0) {
									$Data = [
								    'statu' => "like",
								    'comment' => $YorumId,
								    'tkn' => $Jeton,
								    'title' => $Baslik,
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
	header("location:".$SiteLink);
	exit();
}
?>