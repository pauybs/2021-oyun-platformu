<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if ( isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"]) ) {

	if (Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		if(isset($_POST["MevcutSifre"])){
			$MevcutSifre = Guvenlik($_POST["MevcutSifre"]);
		}else{
			$MevcutSifre="";
		}

		if(isset($_POST["Sifre"])){
			$Password = Guvenlik($_POST["Sifre"]);
		}else{
			$Password="";
		}

		if(isset($_POST["SifreTekrar"])){
			$PasswordRepeat = Guvenlik($_POST["SifreTekrar"]);
		}else{
			$PasswordRepeat="";
		}

		if(isset($_POST["Tkn"])   and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

		$MD5MevcutSifre  = md5($MevcutSifre);
		$MD5sifre  = md5($Password);
		if (Guvenlik($_SESSION["Jeton"])== $Jeton) {
			if( ($Password!="") and  ($PasswordRepeat!="") and  ($MevcutSifre!="") and ($Jeton!="") ){

			
				if(strlen($Password)< 6 ||   strlen($Password) > 72) {
					$Data = [
			        'statu' => "password",
					];
					echo json_encode($Data); 
					exit();	
				}else{
					if ($KullaniciSifre != $MD5MevcutSifre) {
						$Data = [
				        'statu' => "CurrentPassword",
						];
						echo json_encode($Data); 
						exit();	
					}else{
						if(($Password != $PasswordRepeat)){
							$Data = [
					        'statu' => "incompatible",
							];
							echo json_encode($Data); 
							exit();
						}else{
							$UyeGuncelle = $DatabaseBaglanti->prepare(" UPDATE uyeler  SET Sifre=? WHERE id=? and SilinmeDurumu=? and Durum=? LIMIT 1");
							$UyeGuncelle->execute([$MD5sifre,Guvenlik($KullaniciId),0,1]);
							$UyeVeri = $UyeGuncelle->rowCount();
							
								$Data = [
						        	'statu' => "success",
								];
								echo json_encode($Data); 
								exit();
								
						}
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

