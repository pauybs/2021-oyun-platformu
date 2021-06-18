<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Frameworks/PHPMailer/src/Exception.php';
require '../Frameworks/PHPMailer/src/PHPMailer.php';
require '../Frameworks/PHPMailer/src/SMTP.php';
require_once("../settings/functions.php");
require_once("../settings/connect.php");

if(isset($_POST["UyeMail"])){
	$Mail = Guvenlik($_POST["UyeMail"]);
	if (epostaKontrol($Mail)){ 
		$Mail = Guvenlik($_POST["UyeMail"]);
		if (strlen($Mail)<=100) {
				$Mail = Guvenlik($_POST["UyeMail"]);
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
if(isset($_POST["UyeAdSoyad"])){
	$AdSoyad = Guvenlik($_POST["UyeAdSoyad"]);
	if (strlen($AdSoyad)<=100) {
			$AdSoyad = Guvenlik($_POST["UyeAdSoyad"]);
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
if(isset($_POST["UyeKullaniciAdi"])){
	$UyeKullaniciAdi = Guvenlik(bosluk($_POST["UyeKullaniciAdi"]));
	if (strlen($UyeKullaniciAdi)>=4 and strlen($UyeKullaniciAdi)<=25) {
			$UyeKullaniciAdi = Guvenlik(bosluk($_POST["UyeKullaniciAdi"]));
	}else{
		$Data = [
       	'statu' => "lsusername",
    	];
    	echo json_encode($Data); 
		exit();	
	}
}else{			
	$UyeKullaniciAdi="";
}
if(isset($_POST["UyeSifre"])){
	$Sifre = Guvenlik($_POST["UyeSifre"]);

}else{
	$Sifre="";
}
if(isset($_POST["UyeSifreTekrar"])){
	$SifreTekrar = Guvenlik($_POST["UyeSifreTekrar"]);
}else{
	$SifreTekrar="";
}
if(isset($_POST["SozlesmeOnay"]) and ($_POST["SozlesmeOnay"]==1 || $_POST["SozlesmeOnay"]==0 )){
	$SozlesmeOnay= SayfaNumarasiTemizle(Guvenlik($_POST["SozlesmeOnay"]));
}else{
	$SozlesmeOnay="";
}
$aktivasyon = aktivasyonKod();
$MD5sifre   = md5($Sifre);
if(($AdSoyad!="") and  ($Mail!="")  and  ($Sifre!="") and  ($SifreTekrar!="")   and  ($UyeKullaniciAdi!="")){
	if($SozlesmeOnay==0 and $SozlesmeOnay==""  and $SozlesmeOnay!=1){
		$Data = [
       	'statu' => "contract",
		];
		echo json_encode($Data); 
		exit();	
	}else{

		if(($Sifre != $SifreTekrar)){
			$Data = [
	       	'statu' => "password",
			];
			echo json_encode($Data); 
			exit();	
		}else{
			if(strlen($Sifre)< 6 ||   strlen($Sifre) > 72) {
				$Data = [
		       	'statu' => "password2",
				];
				echo json_encode($Data); 
				exit();
			}else{ 
				$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ? ");
				$UyeKontrol->execute([$Mail]);
				$Veri = $UyeKontrol->rowCount();

				$UyeKontrol2 = $DatabaseBaglanti->prepare("SELECT * FROM yoneticiler WHERE Email= ? ");
				$UyeKontrol2->execute([$Mail]);
				$Veri2 = $UyeKontrol2->rowCount();

				if($Veri>0 or $Veri2>0){
					$Data = [
			       	'statu' => "registered",
					];
					echo json_encode($Data); 
					exit();
				}else{
					$UyeKullaniciAdiKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE KullaniciAdi= ? ");
					$UyeKullaniciAdiKontrol->execute([$UyeKullaniciAdi]);
					$UyeKullaniciAdiVeri = $UyeKullaniciAdiKontrol->rowCount();

					$UyeKullaniciAdiKontrol2 = $DatabaseBaglanti->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi= ? ");
					$UyeKullaniciAdiKontrol2->execute([$UyeKullaniciAdi]);
					$UyeKullaniciAdiVeri2 = $UyeKullaniciAdiKontrol2->rowCount();

					if($UyeKullaniciAdiVeri>0 or $UyeKullaniciAdiVeri2>0){
						$Data = [
				       	'statu' => "username",
						];
						echo json_encode($Data); 
						exit();
					}else{
						$UyeEkleme = $DatabaseBaglanti->prepare(" INSERT INTO uyeler (Email,AdSoyad,KullaniciAdi,Sifre,Durum,KayitTarihi,IpAdresi,AktivasyonKodu) values (?,?,?,?,?,?,?,?) ");
						$UyeEkleme->execute([$Mail,$AdSoyad,$UyeKullaniciAdi,$MD5sifre,1,$Zaman,$IpAdresi,$aktivasyon]);
						$UyeVerisi = $UyeEkleme->rowCount();

						if($UyeVerisi>0){


							/*$Icerik ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:v='urn:schemas-microsoft-com:vml'><head><meta content='text/html; charset=utf-8' http-equiv='Content-Type'/><meta content='width=device-width' name='viewport'/><meta content='IE=edge' http-equiv='X-UA-Compatible'/><link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>";
							$Icerik  .= "<style type='text/css'>body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style>";
							$Icerik.="<style id='media-query' type='text/css'>@media (max-width: 620px) {.block-grid,.col {	min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col>div {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num8 {width: 66% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num9 {width: 75% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style></head>";
							$Icerik .="<body class='clean-body' style='margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #e0e5eb;'> <table bgcolor='#e0e5eb' cellpadding='0' cellspacing='0' class='nl-container' role='presentation' style='table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e0e5eb; width: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td style='word-break: break-word; vertical-align: top;' valign='top'> <div style='background-color:transparent;'> <div class='block-grid' style='Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;'> <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'> <div class='col num12' style='min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;'> <div style='width:100% !important;'> <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;'>  </div> </div> </div> </div> </div> </div> <div style='background-color:transparent;'> <div class='block-grid' style='Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #161c24;'> <div style='border-collapse: collapse;display: table;width: 100%;background-color:#161c24;background-position:top center;background-repeat:no-repeat'> <div class='col num12' style='min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;'> <div style='width:100% !important;'> <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;'> <table border='0' cellpadding='0' cellspacing='0' class='divider' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td class='divider_inner' style='word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;' valign='top'> <table align='center' border='0' cellpadding='0' cellspacing='0' class='divider_content' height='10' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 10px; width: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td height='10' style='word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' valign='top'><span></span></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>";

							$Icerik.="<div style='color:#ffffff;font-family:Nunito, Arial, Helvetica Neue,Helvetica,sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
							<div style='line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;'>
							<p style='font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;'>Merhaba ". $AdSoyad ."</p>
							</div>
							</div>";					
							$Icerik.="<div style='color:#ffffff;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'> <div style='line-height: 1.2; font-size: 12px; font-family: Roboto, Tahoma, Verdana, Segoe, sans-serif; color: #ffffff; mso-line-height-alt: 14px;'> <p style='font-size: 26px; line-height: 1.2; word-break: break-word; text-align: center; font-family: Roboto, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 31px; margin: 0;'><span style='font-size: 26px;'><strong><span style='color: #c28f2c;'> YENİ ÜYE AKTİVASYON MAİLİ </span></strong></span></p> </div> </div>";

							$Icerik.="<div style='color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:25px;padding-bottom:20px;padding-left:25px;'>
							<div style='line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;'>
							<p style='font-size: 16px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 24px; margin: 0;'><span style='color: #ffffff; font-size: 16px;'>".$SiteName." 'e yapmış olduğunuz üyelik kaydınızı tamamlamak için lütfen aşağıdaki butona tıklayınız. </span></p>
							</div>
							</div>";
							$Icerik.="<a href='" . $SiteLink . "/aktivasyon.php?aktivasyon=" . $aktivasyon . "&email=" . $Mail . "'><div align='center' class='button-container' style='padding-top:10px;padding-right:10px;padding-bottom:20px;padding-left:10px;'><div style='text-decoration:none;display:inline-block;color:#ffffff;background-color:#c28f2c;border-radius:11px;-webkit-border-radius:11px;-moz-border-radius:11px;width:auto; width:auto;;border-top:0px solid #2B79A6;border-right:0px solid #2B79A6;border-bottom:4px solid #7b5407;border-left:0px solid #2B79A6;padding-top:5px;padding-bottom:5px;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;'><span style='padding-left:20px;padding-right:20px;font-size:24px;display:inline-block;'><span style='font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;'><strong><span data-mce-style='font-size: 24px; line-height: 48px;' style='font-size: 24px; line-height: 48px;'>AKTİVASYON</span></strong></span></span></div></div></a>";

							$Icerik.="</div> </div> </div> </div> </div> </div> </div> <div style='background-color:transparent;'> <div class='block-grid' style='Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;'> <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'> <div class='col num12' style='min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;'> <div style='width:100% !important;'> <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;'> <table cellpadding='0' cellspacing='0' class='social_icons' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td style='word-break: break-word; vertical-align: top; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;' valign='top'> <table align='center' cellpadding='0' cellspacing='0' class='social_table' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-tspace: 0; mso-table-rspace: 0; mso-table-bspace: 0; mso-table-lspace: 0;' valign='top'>  </table> </body> </html>";
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
								$MailGönder->Port       = 587;      
								$MailGönder->SMTPOptions = array(
									'ssl' => array(
										'verify_peer' => false,
										'verify_peer_name' => false,
										'allow_self_signed' => true
									)
								);

								$MailGönder->setFrom(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));
								$MailGönder->addAddress(IcerikTemizle($Mail), IcerikTemizle($AdSoyad));           
								$MailGönder->addReplyTo($SiteMail, $SiteName);

								$MailGönder->isHTML(true);                                 
								$MailGönder->Subject = $SiteName . ' Yeni Üyelik Aktivasyon';
								$MailGönder->MsgHTML($Icerik);
								$MailGönder->send();

								echo '<div class="row justify-content-center m-0  ">
										<div class="col-12 col-md-6" >
											<div class="row justify-content-center ">
												<div class="col-12   text-center mt-5">
													<i class="far fa-envelope fa-5x green" ></i>
												</div>
												<div class="col-12   text-center mt-2 mb-5 IletisimYazi white">
													<p>İlk aşama tamam.</p>
													<p>Haydi şimdi e-postana git ve bir an önce aramıza katıl.</p>
												</div>
											</div>
											
										</div>
									</div>			
									';
								exit();
							
							}catch(Exception $e){
								echo '<div class="row justify-content-center m-0  ">
									<div class="col-12 col-md-6 " >
										<div class="row justify-content-center ">
											<div class="col-12   text-center mt-5">
												<i class="fas fa-user-times fa-5x red" ></i>
											</div>
											<div class="col-12   text-center mt-2 mb-5 IletisimYazi white">
												<p>Üyelik İşleminiz Tamamlanamadı.</p>
												<p>Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</p>
											</div>
										</div>
									</div>
								</div>';
								exit();			
							}*/

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
					}
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
?>	
