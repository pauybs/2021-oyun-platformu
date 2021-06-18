<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["ib"]) and strlen($_POST["ib"])<=11 ){
			$IncelemeId = SayfaNumarasiTemizle(Guvenlik($_POST["ib"]));
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
				$IncelemeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE Incelemeid=? and Durum=? and KuratorId!=?   ");
				$IncelemeKontrol->execute([$IncelemeId,1,Guvenlik($KullaniciId)]);
				$IncelemeKontrolVeri = $IncelemeKontrol->rowCount();
				$IncelemeKontrolKayitlar = $IncelemeKontrol->fetch(PDO::FETCH_ASSOC);
				if ($IncelemeKontrolVeri>0) {
					if($IncelemeKontrolKayitlar["KuratorId"]!=$KullaniciId){
						$KuratorId= IcerikTemizle($IncelemeKontrolKayitlar["KuratorId"]);
						$BegeniKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemebegeni  WHERE  IncelemeId=?  AND UyeId=? ");
						$BegeniKontrol->execute([$IncelemeId,Guvenlik($KullaniciId)]);
						$BegeniKontrolSayi = $BegeniKontrol->rowCount();
						if($BegeniKontrolSayi>0){    
							$Begenmektenvazgeç = $DatabaseBaglanti->prepare(" UPDATE incelemeler SET Begeni=Begeni-1  WHERE  IncelemeId=? AND Durum=?  ");
							$Begenmektenvazgeç->execute([$IncelemeId,1]);
							$BegenmektenvazgeçVeri = $Begenmektenvazgeç->rowCount();
							if ($BegenmektenvazgeçVeri>0) {
								$BegeniKaldır = $DatabaseBaglanti->prepare("DELETE  FROM incelemebegeni WHERE IncelemeId=?  AND UyeId=? ");
								$BegeniKaldır->execute([$IncelemeId,Guvenlik($KullaniciId)]);
								$BegeniKaldırVeri = $BegeniKaldır->rowCount();
								if ($BegeniKaldırVeri>0) {
									$GuncelBegeniKontrol=$DatabaseBaglanti->prepare("SELECT * FROM incelemebegeni  WHERE  IncelemeId=?   ");
									$GuncelBegeniKontrol->execute([$IncelemeId]);
									$GuncelBegeniKontrolSayi = $GuncelBegeniKontrol->rowCount();
									$Data = [
									'statu' => "unlike",
									'like' => IcerikTemizle(number_format_short($GuncelBegeniKontrolSayi)),  
									'examination' => IcerikTemizle($IncelemeId),
									'link' => IcerikTemizle($IncelemeKontrolKayitlar["IncelemeLink"]),
									'tkn' =>  $Jeton
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
							}else{
								$Data = [
								'statu' => false, 
								];
								echo json_encode($Data);
								exit();
							}
						}else{
							$Begen = $DatabaseBaglanti->prepare(" UPDATE incelemeler SET Begeni=Begeni+1  WHERE  IncelemeId=? AND Durum=? ");
							$Begen->execute([$IncelemeId,1]);
							$BegenVeri = $Begen->rowCount();
							if($BegenVeri> 0){		
								$BegeniEkle = $DatabaseBaglanti->prepare("INSERT INTO incelemebegeni  (IncelemeId,UyeId)  values(?,?)  ");
								$BegeniEkle->execute([$IncelemeId,Guvenlik($KullaniciId)]);
								$BegeniEkleVeri = $BegeniEkle->rowCount();
								if ($BegeniEkleVeri>0) {
									$GuncelBegeniKontrol=$DatabaseBaglanti->prepare("SELECT * FROM incelemebegeni  WHERE IncelemeId=?");
									$GuncelBegeniKontrol->execute([$IncelemeId]);
									$GuncelBegeniKontrolSayi = $GuncelBegeniKontrol->rowCount();
									$Data = [
									'statu' => "like",
									'like' => IcerikTemizle(number_format_short($GuncelBegeniKontrolSayi)),  
									'examination' => IcerikTemizle($IncelemeId),
									'link' => IcerikTemizle($IncelemeKontrolKayitlar["IncelemeLink"]),
									'tkn' =>  $Jeton
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
							}else{
								$Data = [
								'statu' => false, 
								];
								echo json_encode($Data);
								exit();
							}
						}
					}else {
						$Data = [
						'statu' => false, 
						];
						echo json_encode($Data);
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