<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["h"]) and strlen($_POST["h"])<=11 ){
			$HaberId =SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{
			$HaberId="";
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

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if( ($HaberId!="") and  ($Yorum!="") and  ($Uniqid!="") ){
				$HaberEditor = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? and Durum=? LIMIT 1 ");
				$HaberEditor->execute([$HaberId,$Uniqid,1]);
				$HaberEditorVeri = $HaberEditor->rowCount();
				$HaberEditorKayitlar = $HaberEditor->fetch(PDO::FETCH_ASSOC);
				if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
					if ($Zaman>=$KullaniciYorumBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=? and YorumBan=? LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId,1]);
						$BanKaldirSayisi = $BanKaldir->rowCount();

						if ($BanKaldirSayisi>0) {
							if ($HaberEditorVeri >0) {
								$Editor =Guvenlik($HaberEditorKayitlar["Editor"]);
								$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO haberyorumlar (HaberId,HaberUniqid,UyeId,Yorum,YorumTarihi,Editor,YorumIp,Durum) values (?,?,?,?,?,?,?,?) ");
								$YorumKayit->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),$Yorum,$Zaman,$Editor,$IpAdresi,1]);
								$Data = $YorumKayit->rowCount();
								if ($Data>0) {
									$SonId=$DatabaseBaglanti->lastInsertId();
									$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
									$HaberGuncelleme->execute([$HaberId]);
										
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

									$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumlar WHERE id=? and Durum=? ");
									$Yorum->execute([Guvenlik($SonId),1]);
									$YorumVeri = $Yorum->rowCount();
									$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
									if ($YorumVeri>0) {	
										$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["YorumTarihi"])); 
										$HaberYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
									}else{
										$YorumTarihi="";
										$HaberYorum="";
									}
									$Data = [
					        			'statu' => "success", 
					        			'commentid' => $SonId,
					        			'newsid' => $HaberId,
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
					if ($HaberEditorVeri >0) {
						$Editor =Guvenlik($HaberEditorKayitlar["Editor"]);
						$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO haberyorumlar (HaberId,HaberUniqid,UyeId,Yorum,YorumTarihi,Editor,YorumIp,Durum) values (?,?,?,?,?,?,?,?) ");
						$YorumKayit->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),$Yorum,$Zaman,$Editor,$IpAdresi,1]);
						$Data = $YorumKayit->rowCount();
						if ($Data>0) {
							$SonId=$DatabaseBaglanti->lastInsertId();
							$HaberGuncelleme = $DatabaseBaglanti->prepare("UPDATE haberler SET YorumSayisi=YorumSayisi+1 WHERE id=? LIMIT 1");
							$HaberGuncelleme->execute([$HaberId]);
								
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

							$Yorum = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumlar WHERE id=? and Durum=? ");
							$Yorum->execute([Guvenlik($SonId),1]);
							$YorumVeri = $Yorum->rowCount();
							$YorumKayitlar = $Yorum->fetch(PDO::FETCH_ASSOC);
							if ($YorumVeri>0) {	
								$YorumTarihi= time_ago(IcerikTemizle($YorumKayitlar["YorumTarihi"])); 
								$HaberYorum=IcerikTemizle($YorumKayitlar["Yorum"]);
							}else{
								$YorumTarihi="";
								$HaberYorum="";
							}
							$Data = [
			        			'statu' => "success", 
			        			'commentid' => $SonId,
			        			'newsid' => $HaberId,
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

