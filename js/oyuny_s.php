<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["o"]) and strlen($_POST["o"])<=11){
			$OyunId = SayfaNumarasiTemizle(Guvenlik($_POST["o"]));
		}else{
			$OyunId="";
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
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}
		if(isset($_POST["ui"]) and strlen($_POST["ui"])==20){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton and ($Uniqid!="")) {
			$Oyun = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=? and OyunUniqid=? and Durum=?  LIMIT 1 ");
			$Oyun->execute([$OyunId,$Uniqid,1]);
			$OyunVeri = $Oyun->rowCount();
			$OyunKayitlar = $Oyun->fetch(PDO::FETCH_ASSOC);
			if ($OyunVeri>0) {
				$OyunAdi =IcerikTemizle($OyunKayitlar["OyunAdi"]);
				if( ($OyunId!="") and  ($Yorum!="") ){
					if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
						if ($Zaman>=$KullaniciYorumBanTarih) {
							$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
							$BanKaldir->execute([0,NULL,$KullaniciId]);
							$BanKaldirSayisi = $BanKaldir->rowCount();
							if ($BanKaldirSayisi>0) {
								$YorumKayit=$DatabaseBaglanti->prepare("INSERT INTO oyunyorumlar (OyunId,OyunUniqid,UyeId,Yorum,YorumTarihi,YorumIp,Durum) values (?,?,?,?,?,?,?)");
								$YorumKayit->execute([$OyunId,$Uniqid,Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi,1]);
								$Data = $YorumKayit->rowCount();
								if ($Data>0) {
									$SonId=$DatabaseBaglanti->lastInsertId();
									$OyunGuncelle = $DatabaseBaglanti->prepare("UPDATE oyunlar SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
									$OyunGuncelle->execute([$OyunId]);

									$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
									$UyeResim->execute([Guvenlik($KullaniciId),1]);
									$UyeResimVeri = $UyeResim->rowCount();
									$UyeResimKayitlar = $UyeResim->fetch(PDO::FETCH_ASSOC);
									if ($UyeResimVeri>0) {
										if ($UyeResimKayitlar["ProfilResmi"]!="" ) {
											$ProfilResmi="images/userphoto/".IcerikTemizle($UyeResimKayitlar["ProfilResmi"]);
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

									$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM oyunyorumlar WHERE id=? and Durum=? ");
									$Yorum->execute([Guvenlik($SonId),1]);
									$YorumVeri = $Yorum->rowCount();
									$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
									if ($YorumVeri>0) {
										$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["YorumTarihi"])); 
										$OyunYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
									}else{
										$YorumTarihi="";
										$OyunYorum="";
									}

									$Data = [
					        			'statu' => "success",
					        			'commentid' => $SonId, 
					        			'game' => $OyunId,
					        			'gameid' => $OyunId,
					        			'profile' => $ProfilResmi,
					        			'name' => $AdSoyad,
					        			'date' => $YorumTarihi,
					        			'username' => $UyeKullaniciAdi,
					        			'comment' => $OyunYorum,
					        			'tkn' => $Jeton,
					        			'ui' => $Uniqid,
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
						$YorumKayit=$DatabaseBaglanti->prepare("INSERT INTO oyunyorumlar (OyunId,OyunUniqid,UyeId,Yorum,YorumTarihi,YorumIp,Durum) values (?,?,?,?,?,?,?)");
						$YorumKayit->execute([$OyunId,$Uniqid,Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi,1]);
						$Data = $YorumKayit->rowCount();
						if ($Data>0) {
							$SonId=$DatabaseBaglanti->lastInsertId();
							$OyunGuncelle = $DatabaseBaglanti->prepare("UPDATE oyunlar SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
							$OyunGuncelle->execute([$OyunId]);

							$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
							$UyeResim->execute([Guvenlik($KullaniciId),1]);
							$UyeResimVeri = $UyeResim->rowCount();
							$UyeResimKayitlar = $UyeResim->fetch(PDO::FETCH_ASSOC);
							if ($UyeResimVeri>0) {
								if ($UyeResimKayitlar["ProfilResmi"]!="" ) {
									$ProfilResmi="images/userphoto/".IcerikTemizle($UyeResimKayitlar["ProfilResmi"]);
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

							$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM oyunyorumlar WHERE id=? and Durum=? ");
							$Yorum->execute([Guvenlik($SonId),1]);
							$YorumVeri = $Yorum->rowCount();
							$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
							if ($YorumVeri>0) {
								$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["YorumTarihi"])); 
								$OyunYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
							}else{
								$YorumTarihi="";
								$OyunYorum="";
							}

							$Data = [
			        			'statu' => "success",
			        			'commentid' => $SonId, 
			        			'game' => $OyunId,
			        			'gameid' => $OyunId,
			        			'profile' => $ProfilResmi,
			        			'name' => $AdSoyad,
			        			'date' => $YorumTarihi,
			        			'username' => $UyeKullaniciAdi,
			        			'comment' => $OyunYorum,
			        			'tkn' => $Jeton,
			        			'ui' => $Uniqid,
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
					}
				}else{
					$Data = [
			        	'statu' => "null", 
			    	];
					echo json_encode($Data);
					exit();		
				}
			}else{
				$Data = [
	        	'statu' => "error", 
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

