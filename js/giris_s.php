<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"])   ) {
	header("location: " .$SiteLink);
	exit();
}else{
	if(isset($_POST["Mail"])){
		$Mail = Guvenlik($_POST["Mail"]);
		
		if (epostaKontrol($Mail)){ 
			$Mail = Guvenlik($_POST["Mail"]);
			if (strlen($Mail)<=86) {
				$Mail = Guvenlik($_POST["Mail"]);
			}else{
				$Data = [
		       	'statu' => "LoginError",
		    	];
		    	echo json_encode($Data); 
				exit();	
			}
		}else{ 
			$Data = [
	       	'statu' => "mail",
	    	];
	    	echo json_encode($Data); 
			exit();	
		}

	}else{
		$Mail="";
	}
	if(isset($_POST["Sifre"])){
		$Sifre = Guvenlik($_POST["Sifre"]);
		if (strlen($Sifre)>=6 and strlen($Sifre)<=72 ) {
			$Sifre = Guvenlik($_POST["Sifre"]);
		}else{
			$Data = [
		       	'statu' => "LoginError",
		    	];
		    	echo json_encode($Data); 
				exit();	
		}
	}else{
		$Sifre="";
	}
	if(isset($_POST["g-recaptcha-response"])){
		$captcha = $_POST["g-recaptcha-response"];
	}else{
 		$captcha="";
	}

	$secretKey = "6Lf5VHoaAAAAAFZtf21La9WXcL7ReHRLSTqFO98k";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
    $responseKeys = json_decode($response,true);
  
	$MD5sifre = md5($Sifre);
	if(($Mail!="") and  ($Sifre!="") ){
		 if(intval($responseKeys["success"]) !== 1) {
	    	$Data = [
	       	'statu' => "recaptcha",
	    	];
	    	echo json_encode($Data); 
			exit();	
    
		}else{
			$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ?  AND Sifre= ? AND SilinmeDurumu=?");
			$UyeKontrol->execute([$Mail,$MD5sifre,0]);
			$Veri = $UyeKontrol->rowCount();
			$Kayitlar = $UyeKontrol->fetch(PDO::FETCH_ASSOC);
			if ($Veri>0) {
				/*if($Kayitlar["Durum"]==1){*/
					$_SESSION["Kullanici"] = Guvenlik($Kayitlar["Email"]);
					$_SESSION["warning"]=0;
					if ($_SESSION["Kullanici"] == $Mail) {
						$Sonuc=0;
						do {
							$_SESSION['Jeton']=Jeton();
						  	$JetonKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  Jeton=?");
							$JetonKontrol->execute([Guvenlik($_SESSION['Jeton'])]);
							$JetonVeri = $JetonKontrol->rowCount();
							if ($JetonVeri>0) {
								unset($_SESSION['Jeton']);
								$Sonuc=0;
							}else{
								$JetonGuncelle = $DatabaseBaglanti->prepare("UPDATE uyeler SET Jeton=?,SonGirisTarihi=?,SonGirisIpAdres=? WHERE id=? LIMIT 1");
								$JetonGuncelle->execute([Guvenlik($_SESSION['Jeton']),$Zaman,$IpAdresi,Guvenlik($Kayitlar["id"])]);
								$JetonGuncelleVeri = $JetonGuncelle->rowCount();
								if ($JetonGuncelleVeri>0) {
									$Sonuc++;
								}else{
									unset($_SESSION['Jeton']);
									$Sonuc=0;
								}
							}
						} while ($Sonuc <= 0);
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
				/*}else{
					
				 		echo '<div class="row text-center mb-1" style="background:#D54841; max-width: 380px;height: 90px;">
	            			<div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:13px">Aktivasyonsuz Hesap</span> </div>
	            			<div class="col-12"><span style="color:white;font-size:12px">Hesabınızı aktif etmek için e-posta adresinize gönderilen  linke tıklayınız.</span> </div>	
	            		</div>';
				 		exit();
						
				}*/
			}else{
				$Data = [
		       		'statu' => "null",
		    	];
		    	echo json_encode($Data); 
				exit();
			}
		}
	}else{
		$Data = [
   			'statu' => "LoginError",
    	];
    	echo json_encode($Data); 
		exit();
	}
	
}
?>	
	