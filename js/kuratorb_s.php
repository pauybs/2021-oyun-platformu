<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Frameworks/PHPMailer/src/Exception.php';
require '../Frameworks/PHPMailer/src/PHPMailer.php';
require '../Frameworks/PHPMailer/src/SMTP.php';
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ){
	if ($KullaniciKuratorDurumu==0 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
			

		if(isset($_POST["Mesaj"])){
			$Mesaj = Guvenlik($_POST["Mesaj"]);
		}else{
			$Mesaj="";
		}

		if(isset($_POST["link1"])){
			$link1 = Guvenlik($_POST["link1"]);
		}else{
			$link1="";
		}

		if(isset($_POST["link2"])){
			$link2 = Guvenlik($_POST["link2"]);
		}else{
			$link2="";
		}

		if(isset($_POST["link3"])){
			$link3= Guvenlik($_POST["link3"]);
		}else{
			$link3="";
		}

		if(isset($_POST["tkn"]) and strlen($_POST["tkn"])==30){
			$Jeton= Guvenlik($_POST["tkn"]);
		}else{
			$Jeton="";
		}

		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(($Mesaj!="") ){
				$Icerik = "E-Posta Adresi: " .$KullaniciMail ."<br/> Ad Soyad: " .IcerikTemizle($KullaniciAdiSoyadi) ."<br/> Kullanıcı Adı: " .IcerikTemizle($KullaniciAdi) ."<br/>Mesaj: " .$Mesaj ."<br/> Youtube: " . $link1 . "<br/> Yayın Kanalı: " . $link2 ."<br/> Web Sitesi : ". $link3;
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
		         			 // 'verify_peer_name' => false,
		        			  //'allow_self_signed' => true
		     				//	)
				    //	);
		    		$MailGönder->setFrom(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));
		   			$MailGönder->addAddress(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));            
		    		$MailGönder->addReplyTo($KullaniciMail, $KullaniciAdiSoyadi);
		   			$MailGönder->isHTML(true);                                  
		   	 		$MailGönder->Subject = IcerikTemizle($SiteName) . ' Kurator Başvuru Formu';
		    		$MailGönder->MsgHTML($Icerik);
		    		$MailGönder->send();
		    		$Data = [
					'statu' => true, 
					];
					echo json_encode($Data);
					exit();		
				}catch(Exception $e){
					$Data = [
					'statu' => false, 
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
	