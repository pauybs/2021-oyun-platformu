<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["i"])){
			$IncelemeId =SayfaNumarasiTemizle(Guvenlik($_POST["i"]));
		}else{
			$IncelemeId="";
		}
				
		if(isset($_POST["Yorum"])){
			$Yorum = Guvenlik($_POST["Yorum"]);
			if (strlen($Yorum)>2000) {
				$Data = [
        		'statu' => "long", 
		    	];
				echo json_encode($Data);
				exit();
			}else{
				$Yorum = Guvenlik($_POST["Yorum"]);
			}
		}else{
			$Yorum="";
		}

		if(isset($_POST["Tkn"])){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

	

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if( ($IncelemeId!="") and  ($Yorum!="")  ){
				$IncelemeKurator = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE IncelemeId=? and  Durum=? LIMIT 1 ");
				$IncelemeKurator->execute([$IncelemeId,1]);
				$IncelemeKuratorVeri = $IncelemeKurator->rowCount();
				$IncelemeKuratorKayitlar = $IncelemeKurator->fetch(PDO::FETCH_ASSOC);
				if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
					if ($Zaman>=$KullaniciYorumBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=? and YorumBan=? LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId,1]);
						$BanKaldirSayisi = $BanKaldir->rowCount();

						if ($BanKaldirSayisi>0) {
							if ($IncelemeKuratorVeri >0) {
								$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO incelemeyorumlar (IncelemeId,UyeId,Yorum,Tarih,IpAdres,Durum) values (?,?,?,?,?,?) ");
								$YorumKayit->execute([$IncelemeId,Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi,1]);
								$Data = $YorumKayit->rowCount();
								if ($Data>0) {
									$SonId=$DatabaseBaglanti->lastInsertId();	
									$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
									$UyeResim->execute([Guvenlik($KullaniciId),1]);
									$UyeResimVeri = $UyeResim->rowCount();
									$UyeResimKayitlar = $UyeResim->fetch(PDO::FETCH_ASSOC);
									if ($UyeResimVeri>0) {
										if ($UyeResimKayitlar["ProfilResmi"]!="" ) {
											$ProfilResmi="images/userphoto/".$UyeResimKayitlar["ProfilResmi"];
										}else{
											$ProfilResmi="images/user.png";
										}

										$AdSoyad=IcerikTemizle($UyeResimKayitlar["AdSoyad"]);
										$UyeKullaniciAdi=IcerikTemizle($UyeResimKayitlar["KullaniciAdi"]);
									}else{
										$ProfilResmi="images/user.png";
										$AdSoyad="";
										$UyeKullaniciAdi="";
									}

									$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE YorumId=? and Durum=? ");
									$Yorum->execute([Guvenlik($SonId),1]);
									$YorumVeri = $Yorum->rowCount();
									$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
									if ($YorumVeri>0) {	
										$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["Tarih"])); 
										$IncelemeYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
									}else{
										$YorumTarihi="";
										$IncelemeYorum="";
									}
									$Data = [
					        			'statu' => "success", 
					        			'commentid' => $SonId,
					        			'incid' => $IncelemeId,
					        			'profile' => $ProfilResmi,
					        			'name' => $AdSoyad,
					        			'date' => $YorumTarihi,
					        			'username' => $UyeKullaniciAdi,
					        			'comment' => $IncelemeYorum,
					        			'tkn' => $Jeton,

							    	];
									echo json_encode($Data);
									exit();		
								}else{
									$Data = [
					        		'statu' => "commentError", 
							    	];
									echo json_encode($Data);
									exit();
								}
							}else{
								$Data = [
					        	'statu' => "commentError", 
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
					if ($IncelemeKuratorVeri >0) {
						$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO incelemeyorumlar (IncelemeId,UyeId,Yorum,Tarih,IpAdres,Durum) values (?,?,?,?,?,?) ");
						$YorumKayit->execute([$IncelemeId,Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi,1]);
						$Data = $YorumKayit->rowCount();
						if ($Data>0) {
							$SonId=$DatabaseBaglanti->lastInsertId();	
							$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
							$UyeResim->execute([Guvenlik($KullaniciId),1]);
							$UyeResimVeri = $UyeResim->rowCount();
							$UyeResimKayitlar = $UyeResim->fetch(PDO::FETCH_ASSOC);
							if ($UyeResimVeri>0) {
								if ($UyeResimKayitlar["ProfilResmi"]!="" ) {
									$ProfilResmi="images/userphoto/".$UyeResimKayitlar["ProfilResmi"];
								}else{
									$ProfilResmi="images/user.png";
								}

								$AdSoyad=IcerikTemizle($UyeResimKayitlar["AdSoyad"]);
								$UyeKullaniciAdi=IcerikTemizle($UyeResimKayitlar["KullaniciAdi"]);
							}else{
								$ProfilResmi="images/user.png";
								$AdSoyad="";
								$UyeKullaniciAdi="";
							}

							$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE YorumId=? and Durum=? ");
							$Yorum->execute([Guvenlik($SonId),1]);
							$YorumVeri = $Yorum->rowCount();
							$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
							if ($YorumVeri>0) {	
								$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["Tarih"])); 
								$IncelemeYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
							}else{
								$YorumTarihi="";
								$IncelemeYorum="";
							}
							$Data = [
			        			'statu' => "success", 
			        			'commentid' => $SonId,
			        			'incid' => $IncelemeId,
			        			'profile' => $ProfilResmi,
			        			'name' => $AdSoyad,
			        			'date' => $YorumTarihi,
			        			'username' => $UyeKullaniciAdi,
			        			'comment' => $IncelemeYorum,
			        			'tkn' => $Jeton,

					    	];
							echo json_encode($Data);
							exit();	
						}else{
							$Data = [
			        		'statu' => "commentError", 
					    	];
							echo json_encode($Data);
							exit();
						}
					}else{
						$Data = [
			        	'statu' => "commentError", 
			    		];
						echo json_encode($Data);
						exit();
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

