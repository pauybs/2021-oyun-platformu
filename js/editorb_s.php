<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Frameworks/PHPMailer/src/Exception.php';
require '../Frameworks/PHPMailer/src/PHPMailer.php';
require '../Frameworks/PHPMailer/src/SMTP.php';
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"])   ) {
	if (Guvenlik($KullaniciEditorDurumu)==0  and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ) {
		if(isset($_POST["Mesaj"])){
			$Mesaj = Guvenlik($_POST["Mesaj"]);
		}else{
			$Mesaj="";
		}
		if(isset($_POST["Tkn"])   and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

		if(($Mesaj!="") ){
			if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
				$Icerik = " E-Posta: " .$KullaniciMail."<br/> Ad Soyad: " .IcerikTemizle($KullaniciAdiSoyadi) ."<br/> Kullanıcı Adı: " .IcerikTemizle($KullaniciAdi) ."<br/> Mesaj: " .$Mesaj ;
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
	   					  //'ssl' => array(
	        			  //'verify_peer' => false,
	         			  //'verify_peer_name' => false,
	        			  //'allow_self_signed' => true
	     				//	)
					//);
		    		$MailGönder->setFrom(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));
		   			$MailGönder->addAddress(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));            
		    		$MailGönder->addReplyTo($KullaniciMail, $KullaniciAdiSoyadi);
		   			$MailGönder->isHTML(true);                                  
		   	 		$MailGönder->Subject = IcerikTemizle($SiteName) . ' Editor Başvuru Formu';
		    		$MailGönder->MsgHTML($Icerik);
		    		$MailGönder->send();
		    		$Data = [
		           	'statu' => "true",
		        	];
		        	echo json_encode($Data); 
					exit();	
				}catch(Exception $e){
					$Data = [
		           	'statu' => "false",
		        	];
		        	echo json_encode($Data); 
					exit();	
				}
			}else{
				header("location:".$SiteLink);
				exit();
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
	header("location" .$SiteLink);
	exit();
}
?>	
	