<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"] )  and isset($_SESSION["Jeton"]) ) {
	if( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
	    
		if(isset($_POST["Mail"])){
			$Mail = Guvenlik($_POST["Mail"]);
			if (epostaKontrol($Mail)){ 
				$Mail = Guvenlik($_POST["Mail"]);
				if (strlen($Mail)<=100) {
						$Mail = Guvenlik($_POST["Mail"]);
						}else{
							$Data = [
					       	'statu' => "mail",
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
		if(isset($_POST["AdSoyad"])){
			$Name = Guvenlik($_POST["AdSoyad"]);
			if (strlen($Name)<=100) {
				$Name = Guvenlik($_POST["AdSoyad"]);
			}else{
				$Data = [
		       	'statu' => "longname",
		    	];
		    	echo json_encode($Data); 
				exit();	
			}
		}else{	
			$Name="";
		}
		if(isset($_POST["KullaniciAdi"])){
			$GelenKullaniciAdi = Guvenlik(bosluk($_POST["KullaniciAdi"]));
			if (strlen($GelenKullaniciAdi)>=4 and strlen($GelenKullaniciAdi)<=25) {
				$GelenKullaniciAdi = Guvenlik(bosluk($_POST["KullaniciAdi"]));
			}else{
				$Data = [
		       	'statu' => "lsusername",
		    	];
		    	echo json_encode($Data); 
				exit();	
			}
				}else{	
			$GelenKullaniciAdi="";
		}
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(($Name!="") and  ($Mail!="")  and  ($GelenKullaniciAdi!="")){
				if ($KullaniciMail!=$Mail) {			
					$UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ? ");
					$UyeKontrol->execute([$Mail]);
					$Veri = $UyeKontrol->rowCount();

					$UyeKontrol2 = $DatabaseBaglanti->prepare("SELECT * FROM yoneticiler WHERE Email= ? ");
					$UyeKontrol2->execute([$Mail]);
					$Veri2 = $UyeKontrol2->rowCount();

					if($Veri>0 or $Veri2>0){
						$Data = [
		            	'statu' => "registeredMail", 
		        		];
		 				echo json_encode($Data);
						exit();
					}
				}
				
				if ($KullaniciAdi!=$GelenKullaniciAdi) {			
					$UyeKullaniciAdiKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE KullaniciAdi= ? ");
					$UyeKullaniciAdiKontrol->execute([$GelenKullaniciAdi]);
					$UyeKullaniciAdiVeri = $UyeKullaniciAdiKontrol->rowCount();

					$UyeKullaniciAdiKontrol2 = $DatabaseBaglanti->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi= ? ");
					$UyeKullaniciAdiKontrol2->execute([$GelenKullaniciAdi]);
					$UyeKullaniciAdiVeri2 = $UyeKullaniciAdiKontrol2->rowCount();
					if($UyeKullaniciAdiVeri>0 or $UyeKullaniciAdiVeri2>0){
						$Data = [
		            	'statu' => "registeredUsername", 
		        		];
		 				echo json_encode($Data);
						exit();
					}
				}

				$UyeGuncelle = $DatabaseBaglanti->prepare(" UPDATE uyeler  SET Email=?,AdSoyad=?,KullaniciAdi=? WHERE id=? ");
				$UyeGuncelle->execute([$Mail,$Name,$GelenKullaniciAdi,Guvenlik($KullaniciId)]);
				$_SESSION["Kullanici"] = $Mail;
				$Data = [
				'statu' => "success", 
				];
					echo json_encode($Data);
				exit();	
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

