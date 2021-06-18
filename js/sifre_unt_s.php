<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../Frameworks/PHPMailer/src/Exception.php';
require '../Frameworks/PHPMailer/src/PHPMailer.php';
require '../Frameworks/PHPMailer/src/SMTP.php';
require_once("../settings/functions.php");
require_once("../settings/connect.php");

if(isset($_POST["Mail"])){
  $Mail = Guvenlik($_POST["Mail"]);
  if (epostaKontrol($Mail)){ 
    $Mail = Guvenlik($_POST["Mail"]);
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
}else{

 if(($Mail!="")  ){
  $UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ?  AND SilinmeDurumu=? AND Durum=?");
  $UyeKontrol->execute([$Mail,0,1]);
  $Veri = $UyeKontrol->rowCount();
  $Kayitlar = $UyeKontrol->fetch(PDO::FETCH_ASSOC);

    if ($Veri>0) {
      $Icerik ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional //EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:v='urn:schemas-microsoft-com:vml'><head><meta content='text/html; charset=utf-8' http-equiv='Content-Type'/><meta content='width=device-width' name='viewport'/><meta content='IE=edge' http-equiv='X-UA-Compatible'/><link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'/>";
      $Icerik  .= "<style type='text/css'>body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style>";
      $Icerik.="<style id='media-query' type='text/css'>@media (max-width: 620px) {.block-grid,.col { min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col>div {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num8 {width: 66% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num9 {width: 75% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style></head>";
      $Icerik .="<body class='clean-body' style='margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #e0e5eb;'> <table bgcolor='#e0e5eb' cellpadding='0' cellspacing='0' class='nl-container' role='presentation' style='table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e0e5eb; width: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td style='word-break: break-word; vertical-align: top;' valign='top'> <div style='background-color:transparent;'> <div class='block-grid' style='Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;'> <div style='border-collapse: collapse;display: table;width: 100%;background-color:transparent;'> <div class='col num12' style='min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;'> <div style='width:100% !important;'> <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;'>  </div> </div> </div> </div> </div> </div> <div style='background-color:transparent;'> <div class='block-grid' style='Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #161c24;'> <div style='border-collapse: collapse;display: table;width: 100%;background-color:#161c24;background-position:top center;background-repeat:no-repeat'> <div class='col num12' style='min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;'> <div style='width:100% !important;'> <div style='border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;'> <table border='0' cellpadding='0' cellspacing='0' class='divider' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td class='divider_inner' style='word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;' valign='top'> <table align='center' border='0' cellpadding='0' cellspacing='0' class='divider_content' height='10' role='presentation' style='table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; height: 10px; width: 100%;' valign='top' width='100%'> <tbody> <tr style='vertical-align: top;' valign='top'> <td height='10' style='word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;' valign='top'><span></span></td> </tr> </tbody> </table> </td> </tr> </tbody> </table>";
      $Icerik.="<div style='color:#ffffff;font-family:Nunito, Arial, Helvetica Neue,Helvetica,sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'>
      <div style='line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;'>
      <p style='font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin: 0;'>Merhaba ". $Kayitlar["AdSoyad"] ."</p>
      </div>
      </div>";          
      $Icerik.="<div style='color:#ffffff;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;'> <div style='line-height: 1.2; font-size: 12px; font-family: Roboto, Tahoma, Verdana, Segoe, sans-serif; color: #ffffff; mso-line-height-alt: 14px;'> <p style='font-size: 26px; line-height: 1.2; word-break: break-word; text-align: center; font-family: Roboto, Tahoma, Verdana, Segoe, sans-serif; mso-line-height-alt: 31px; margin: 0;'><span style='font-size: 26px;'><strong><span style='color: #c28f2c;'> ŞİFRE SIFIRLAMA MAİLİ </span></strong></span></p> </div> </div>";

      $Icerik.="<div style='color:#555555;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:25px;padding-bottom:20px;padding-left:25px;'>
      <div style='line-height: 1.5; font-size: 12px; color: #555555; font-family: Nunito, Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 18px;'>
      <p style='font-size: 16px; line-height: 1.5; word-break: break-word; text-align: center; mso-line-height-alt: 24px; margin: 0;'><span style='color: #ffffff; font-size: 16px;'>Şifrenizi unuttuysanız üzülmeyin, aşağıdaki butona basarak yeni şifre oluşturabilirsiniz.</span></p>
      </div>
      </div>";

      $Icerik.="<a href='" . $SiteLink . "yenisifreolustur/" . $Kayitlar["AktivasyonKodu"] . "/" . $Kayitlar["Email"] . "'><div align='center' class='button-container' style='padding-top:10px;padding-right:10px;padding-bottom:20px;padding-left:10px;'><div style='text-decoration:none;display:inline-block;color:#ffffff;background-color:#c28f2c;border-radius:11px;-webkit-border-radius:11px;-moz-border-radius:11px;width:auto; width:auto;;border-top:0px solid #2B79A6;border-right:0px solid #2B79A6;border-bottom:4px solid #7b5407;border-left:0px solid #2B79A6;padding-top:5px;padding-bottom:5px;font-family:Nunito, Arial, Helvetica Neue, Helvetica, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;'><span style='padding-left:20px;padding-right:20px;font-size:24px;display:inline-block;'><span style='font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;'><strong><span data-mce-style='font-size: 24px; line-height: 48px;' style='font-size: 24px; line-height: 48px;'>ŞİFRE SIFIRLAMA</span></strong></span></span></div></div></a>";

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
    	$MailGönder->Port       = 80;    
		//$MailGönder->SMTPOptions = array(
   				 // 'ssl' => array(
    			 // 'verify_peer' => false,
     			 //'verify_peer_name' => false,
    			  //'allow_self_signed' => true
 				//	)
		//);

        $MailGönder->setFrom(IcerikTemizle($SiteMail), IcerikTemizle($SiteName));
        $MailGönder->addAddress(IcerikTemizle($Kayitlar["Email"]), IcerikTemizle( $Kayitlar["AdSoyad"] ));     
        $MailGönder->addReplyTo($SiteMail, $SiteName);
        $MailGönder->isHTML(true);                                  
        $MailGönder->Subject = $SiteName . ' Şifre Sıfırlama Talebi  ';
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
        'statu' => "registered", 
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