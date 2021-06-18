<?php
require_once("../settings/functions.php");
require_once("../settings/connect.php");

if(isset($_POST["a"])){
	$Aktivasyon = Guvenlik($_POST["a"]);
}else{
	$Aktivasyon="";
}
if(isset($_POST["m"])){
	$Mail = Guvenlik($_POST["m"]);
}else{
	$Mail="";
}
if(isset($_POST["Sifre"])){
	$Sifre = Guvenlik($_POST["Sifre"]);
}else{
	$Sifre="";
}
if(isset($_POST["SifreTekrar"])){
	$SifreTekrar = Guvenlik($_POST["SifreTekrar"]);
}else{
	$SifreTekrar="";
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

$MD5sifre=md5($Sifre);
if(   ($Mail!="") and  ($Aktivasyon!="") ){
	if (($Sifre!="") and  ($SifreTekrar!="") ) {
		if(intval($responseKeys["success"]) !== 1) {
    	$Data = [
       	'statu' => "recaptcha",
    	];
    	echo json_encode($Data); 
		exit();
		}else{
			if(strlen($Sifre)< 6 || strlen($Sifre) > 72) {
				$Data = [
		        'statu' => "password",
		    	];
				echo json_encode($Data);
				exit();	
			}else{
				if(($Sifre != $SifreTekrar)){
					$Data = [
			        'statu' => "incompatible",
			    	];
					echo json_encode($Data);
					exit();	
				}else{

					$Kontrol=$DatabaseBaglanti->prepare(" SELECT * FROM uyeler WHERE Email=? AND AktivasyonKodu=? AND SilinmeDurumu=? and Durum=? LIMIT 1");
					$Kontrol->execute([$Mail,$Aktivasyon,0,1]);
					$KontrolVeri = $Kontrol->rowCount();
					if ($KontrolVeri>0) {
							
						$UyeKontrol = $DatabaseBaglanti->prepare(" UPDATE  uyeler  SET Sifre = ? WHERE Email = ? AND AktivasyonKodu= ? LIMIT 1");
						$UyeKontrol->execute([$MD5sifre,$Mail,$Aktivasyon]);
						$Veri = $UyeKontrol->rowCount();
						$Data = [
					    'statu' => true,
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
?>	



