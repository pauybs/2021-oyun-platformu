<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if (  Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		if(isset($_POST["tkn"]) and strlen($_POST["tkn"])==30){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{	
			$Jeton="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(isset($_POST["Kategori"]) and strlen($_POST["Kategori"])<=11){
				$Kategori = SayfaNumarasiTemizle(Guvenlik($_POST["Kategori"]));
			}else{	
				$Kategori="";
			}
			
			if(isset($_POST["Baslik"])){
				$Baslik = Guvenlik($_POST["Baslik"]);
			}else{	
				$Baslik="";
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
				if ($Kategori!=""   and $Baslik!="" ) {
					if (strlen($Baslik)>150){
						$Data = [
				    	'statu' => "character", 
						];
						echo json_encode($Data);
						exit();	
					}else{
						$BaslikKontrol=$DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE Baslik=? and Durum=?" );
						$BaslikKontrol->execute([$Baslik,1]);
						$BaslikKontrolVeri=$BaslikKontrol->rowCount();
						if ($BaslikKontrolVeri>0) {
							$Data = [
				    			'statu' => "registered", 
								];
								echo json_encode($Data);
								exit();
						}else{
							$KategoriKontrol=$DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? and Durum=? LIMIT 1");
							$KategoriKontrol->execute([$Kategori,1]);
							$KategoriKontrolSayisi=$KategoriKontrol->rowCount();
							if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
								if ($Zaman>=$KullaniciYorumBanTarih) {
									$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
									$BanKaldir->execute([0,NULL,$KullaniciId]);
									$BanKaldirSayisi = $BanKaldir->rowCount();

									if ($BanKaldirSayisi>0) {
										if ($KategoriKontrolSayisi>0) {
											$BaslikEkle = $DatabaseBaglanti->prepare("INSERT INTO sozlukyazilar (UyeId,KategoriId,Baslik,Goruntulenme,GunlukGoruntulenme,Tarih,IpAdresi,Durum) values (?,?,?,?,?,?,?,?)");
											$BaslikEkle->execute([Guvenlik($KullaniciId),$Kategori,$Baslik,0,0,$Zaman,$IpAdresi,0]);
											$BaslikEkleVeri = $BaslikEkle->rowCount();
											if ($BaslikEkleVeri>0) {
												$Data = [
												'statu' => "success", 
												];
												echo json_encode($Data);
												exit();
											}else{
												$Data = [
								    			'statu' => "titleError", 
												];
												echo json_encode($Data);
												exit();
											}
										}else{
											$Data = [
							    			'statu' => "titleError", 
											];
											echo json_encode($Data);
											exit();
										}

									}else{
										$Data = [
						           		 'statu' => "block",
						           		 'date' => TarihCevir2(IcerikTemizle($KullaniciYorumBanTarih)),
						        		];
						 				echo json_encode($Data);
										exit();
									}
								}else{
									$Data = [
					           		 'statu' => "block",
					           		 'date' => TarihCevir2(IcerikTemizle($KullaniciYorumBanTarih)),
					        		];
					 				echo json_encode($Data);
									exit();
								}
							}else{
								if ($KategoriKontrolSayisi>0) {
									$BaslikEkle = $DatabaseBaglanti->prepare("INSERT INTO sozlukyazilar (UyeId,KategoriId,Baslik,Goruntulenme,GunlukGoruntulenme,Tarih,IpAdresi,Durum) values (?,?,?,?,?,?,?,?)");
									$BaslikEkle->execute([Guvenlik($KullaniciId),$Kategori,$Baslik,0,0,$Zaman,$IpAdresi,0]);
									$BaslikEkleVeri = $BaslikEkle->rowCount();
									if ($BaslikEkleVeri>0) {
										$Data = [
										'statu' => "success", 
										];
										echo json_encode($Data);
										exit();
									}else{
										$Data = [
						    			'statu' => "titleError", 
										];
										echo json_encode($Data);
										exit();
									}
								}else{
									$Data = [
					    			'statu' => "titleError", 
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
	header("location: " .$SiteLink);
	exit();
}
?>