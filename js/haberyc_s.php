<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])) {
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
	    
		if(isset($_POST["hc"]) and strlen($_POST["hc"])<=11 ){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["hc"]));
		}else{
			$HaberId="";
		}
		if(isset($_POST["yc"]) and strlen($_POST["yc"])<=11 ){
			$YorumId = SayfaNumarasiTemizle(Guvenlik($_POST["yc"]));
		}else{
			$YorumId="";
		}

		if(isset($_POST["YorumCevap"])){
			$YorumCevap = Guvenlik($_POST["YorumCevap"]);
			if (strlen($YorumCevap)>2000) {
				$Data = [
        		'statu' => "long", 
		    	];
				echo json_encode($Data);
				exit();
			}else{
				$YorumCevap = Guvenlik($_POST["YorumCevap"]);
			}
		}else{
			$YorumCevap="";
		}

		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if( ($HaberId!="") and  ($YorumId!="") and  ($YorumCevap!="")  and  ($Uniqid!="")){
				$HaberEditor = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? LIMIT 1 ");
				$HaberEditor->execute([$HaberId,$Uniqid]);
				$HaberEditorVeri = $HaberEditor->rowCount();
				$HaberEditorKayitlar = $HaberEditor->fetch(PDO::FETCH_ASSOC);
				if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
					if ($Zaman>=$KullaniciYorumBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId]);
						$BanKaldirSayisi = $BanKaldir->rowCount();

						if ($BanKaldirSayisi>0) {
							if ($HaberEditorVeri >0) {
								$Editor =Guvenlik($HaberEditorKayitlar["Editor"]);
								$YorumCevapKayit = $DatabaseBaglanti->prepare("INSERT INTO haberyorumcevap (HaberId,HaberUniqid,UyeId,YorumId,Yorum,YorumTarihi,Editor,YorumIp,Durum) values (?,?,?,?,?,?,?,?,?) ");
								$YorumCevapKayit->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),$YorumId,$YorumCevap,$Zaman,$Editor,$IpAdresi,1]);
								$Veri = $YorumCevapKayit->rowCount();
								if ($Veri>0) {
									$SonId=$DatabaseBaglanti->lastInsertId();
									$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
									$HaberGuncelleme->execute([$HaberId]);

									$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
									$UyeResim->execute([$KullaniciId,1]);
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

									$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumcevap WHERE id=? and HaberUniqid=? and Durum=? ");
									$Yorum->execute([Guvenlik($SonId),$Uniqid,1]);
									$YorumVeri = $Yorum->rowCount();
									$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
									if ($YorumVeri>0) {
										$YorumTarihi= time_ago($YorumKayitlar["YorumTarihi"]); 
										$HaberYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
									}else{
										$YorumTarihi="";
										$HaberYorum="";
									}

									$Data = [
						        		'statu' => "success", 
						        		'newsid' => $HaberId,
					        			'commentid' => $SonId,
					        			'profile' => $ProfilResmi,
					        			'name' => $AdSoyad,
					        			'date' => $YorumTarihi,
					        			'username' => $UyeKullaniciAdi,
					        			'comment' => $HaberYorum,
					        			'tkn' => $Jeton,
					        			'ui' => $Uniqid,
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
							}else{
								$Data = [
					        	'statu' => "error", 
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
					if ($HaberEditorVeri >0) {
						$Editor =Guvenlik($HaberEditorKayitlar["Editor"]);
						$YorumCevapKayit = $DatabaseBaglanti->prepare("INSERT INTO haberyorumcevap (HaberId,HaberUniqid,UyeId,YorumId,Yorum,YorumTarihi,Editor,YorumIp,Durum) values (?,?,?,?,?,?,?,?,?) ");
						$YorumCevapKayit->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),$YorumId,$YorumCevap,$Zaman,$Editor,$IpAdresi,1]);
						$Veri = $YorumCevapKayit->rowCount();
						if ($Veri>0) {
							$SonId=$DatabaseBaglanti->lastInsertId();
							$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
							$HaberGuncelleme->execute([$HaberId]);

							$UyeResim = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? ");
							$UyeResim->execute([$KullaniciId,1]);
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

							$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumcevap WHERE id=? and HaberUniqid=? and Durum=? ");
							$Yorum->execute([Guvenlik($SonId),$Uniqid,1]);
							$YorumVeri = $Yorum->rowCount();
							$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
							if ($YorumVeri>0) {
								$YorumTarihi= time_ago($YorumKayitlar["YorumTarihi"]); 
								$HaberYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
							}else{
								$YorumTarihi="";
								$HaberYorum="";
							}

							$Data = [
				        		'statu' => "success", 
				        		'newsid' => $HaberId,
			        			'commentid' => $SonId,
			        			'profile' => $ProfilResmi,
			        			'name' => $AdSoyad,
			        			'date' => $YorumTarihi,
			        			'username' => $UyeKullaniciAdi,
			        			'comment' => $HaberYorum,
			        			'tkn' => $Jeton,
			        			'ui' => $Uniqid,
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
					}else{
						$Data = [
			        	'statu' => "error", 
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

