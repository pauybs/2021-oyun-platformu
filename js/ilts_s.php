<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Frameworks/PHPMailer/src/Exception.php';
require '../Frameworks/PHPMailer/src/PHPMailer.php';
require '../Frameworks/PHPMailer/src/SMTP.php';
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_POST["AdSoyad"])){
	$AdSoyad = Guvenlik($_POST["AdSoyad"]);
	$AdSoyad = Guvenlik($_POST["AdSoyad"]);
	if (strlen($AdSoyad)<=100) {
			$AdSoyad = Guvenlik($_POST["AdSoyad"]);
	}else{
		$Data = [
       	'statu' => "longname",
    	];
    	echo json_encode($Data); 
		exit();	
	}
}else{
	$AdSoyad="";
}

if(isset($_POST["Mail"])){
	$Mail = Guvenlik($_POST["Mail"]);
	if (epostaKontrol($Mail)){ 
		$Mail = Guvenlik($_POST["Mail"]);
		if (strlen($Mail)<=100) {
				$Mail = Guvenlik($_POST["Mail"]);
		}else{
			$Data = [
	       	'statu' => "longmail",
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

if(isset($_POST["Konu"])){
	$Konu = Guvenlik($_POST["Konu"]);
	if (strlen($Konu)<=100) {
			$Konu = Guvenlik($_POST["Konu"]);
	}else{
		$Data = [
       	'statu' => "konu",
    	];
    	echo json_encode($Data); 
		exit();	
	}
}else{
	$Konu="";
}

if(isset($_POST["Mesaj"])){
	$Mesaj= Guvenlik($_POST["Mesaj"]);
	if (strlen($Mesaj)<=11000) {
			$Mesaj = Guvenlik($_POST["Mesaj"]);
	}else{
		$Data = [
       	'statu' => "mesaj",
    	];
    	echo json_encode($Data); 
		exit();	
	}
}else{
	$Mesaj="";
}

if(isset($_POST["g-recaptcha-response"])){
	$captcha = $_POST["g-recaptcha-response"];
}else{
	$Data = [
	'statu' => "recaptcha", 
	];
	echo json_encode($Data);
	exit();
}

$secretKey = "6Lf5VHoaAAAAAFZtf21La9WXcL7ReHRLSTqFO98k";
$ip = $_SERVER['REMOTE_ADDR'];
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);
if(intval($responseKeys["success"]) !== 1) {
	$Data = [
	'statu' => "recaptcha", 
	];
	echo json_encode($Data);
	exit();
}else {
	if(($AdSoyad!="") and  ($Mail!="") and  ($Konu!="") and  ($Mesaj!="") ){
		$Icerik = "Ad Soyad: " .$AdSoyad ."<br/> E-Posta Adresi: " . $Mail . "<br/> Konu: " . $Konu ."<br/> Mesaj: ". $Mesaj ;
		$MailGönder = new PHPMailer(true);
		try {
    		$MailGönder->SMTPDebug = 0;                      
    		$MailGönder->isSMTP();                                            
   			$MailGönder->Host       = IcerikTemizle($SiteMailHost);           
   			$MailGönder->SMTPAuth   = true;  
   			$MailGönder->CharSet   = "UTF-8";                       
    		$MailGönder->Username   =IcerikTemizle($SiteMail);                 
    		$MailGönder->Password   = IcerikTemizle($SiteMailPassword);                 
    		$MailGönder->SMTPSecure = "tls";
    		$MailGönder->Port       = 80;    
    		//$MailGönder->SMTPOptions = array(
   					 // 'ssl' => array(
        			 // 'verify_peer' => false,
         			 //'verify_peer_name' => false,
        			  //'allow_self_signed' => true
     				//	)
			//);
    		$MailGönder->setFrom(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));
   			$MailGönder->addAddress(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));            
    		$MailGönder->addReplyTo($Mail, $AdSoyad);
   			$MailGönder->isHTML(true);                                  
   	 		$MailGönder->Subject = IcerikTemizle($SiteName) . ' İletişim Formu Mesajı';
    		$MailGönder->MsgHTML($Icerik);
    		$MailGönder->send();

    		$Data = [
			'statu' => "success", 
			];
			echo json_encode($Data);
			exit();
		}catch(Exception $e){
			$Data = [
			'statu' => "error", 
			];
			echo json_encode($Data);
			exit();
		}		
	}else{
		$Data = [
		'statu' => "null", 
		];
		echo json_encode($Data);
		exit();	
	}
}
?>	
	