<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ) {
	if ( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["b"]) and strlen($_POST["b"])<=11 ){
			$BaslikId =SayfaNumarasiTemizle(Guvenlik($_POST["b"]));
		}else{
			$BaslikId="";
		}
				
		if(isset($_POST["s"]) ){
			$Sayfa = SayfaNumarasiTemizle(Guvenlik($_POST["s"]));
		}else{
			$Sayfa="";
		}

		if(isset($_POST["Yorum"])){
			$Yorum = Guvenlik($_POST["Yorum"]);
			if (strlen($Yorum)>10000) {
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
		if(isset($_POST["k"])){
			$ToplamKayit = SayfaNumarasiTemizle(Guvenlik($_POST["k"]));
		}else{
			$ToplamKayit="";
		}
		if(isset($_POST["tkn"])  and strlen($_POST["tkn"])==30 ){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if( ($BaslikId!="") and  ($Sayfa!="") and  ($Yorum!="")  and  ($ToplamKayit!="")){
				$BaslikKontrol = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE id=? and Durum=? LIMIT 1 ");
				$BaslikKontrol->execute([$BaslikId,1]);
				$BaslikKontrolVeri = $BaslikKontrol->rowCount();
				$BaslikKontrolKayitlar = $BaslikKontrol->fetch(PDO::FETCH_ASSOC);
				if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
					if ($Zaman>=$KullaniciYorumBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId]);
						$BanKaldirSayisi = $BanKaldir->rowCount();
						if ($BanKaldirSayisi>0) {
							if ($BaslikKontrolVeri >0) {
								$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO sozlukyorumlar (YaziId,KategoriId,UyeId,Yorum,Tarih,IpAdresi) values (?,?,?,?,?,?) ");
								$YorumKayit->execute([$BaslikId,Guvenlik($BaslikKontrolKayitlar["KategoriId"]),Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi]);
								$YorumVeri = $YorumKayit->rowCount();
								if ($YorumVeri>0) {	
									if ($Sayfa!=0) {
										if ($ToplamKayit % 12 == 0) {
											$Sayfa+=1;
											$Data = [
										    'statu' => "success1",
										    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
										    'page' => $Sayfa,
										    'titleid' => $BaslikId,

											];
											echo json_encode($Data);
											exit();

											
										}else{
											$Data = [
										    'statu' => "success1",
										    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
										    'page' => $Sayfa,
										    'titleid' => $BaslikId,

											];
											echo json_encode($Data);
											exit();
											
										}
									}else{
										$Data = [
									    'statu' => "success",
									    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
									    'titleid' => $BaslikId,

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
					if ($BaslikKontrolVeri >0) {
						$YorumKayit = $DatabaseBaglanti->prepare("INSERT INTO sozlukyorumlar (YaziId,KategoriId,UyeId,Yorum,Tarih,IpAdresi) values (?,?,?,?,?,?) ");
						$YorumKayit->execute([$BaslikId,Guvenlik($BaslikKontrolKayitlar["KategoriId"]),Guvenlik($KullaniciId),$Yorum,$Zaman,$IpAdresi]);
						$YorumVeri = $YorumKayit->rowCount();
						if ($YorumVeri>0) {	
							if ($Sayfa!=0) {
								if ($ToplamKayit % 12 == 0) {
									$Sayfa+=1;
									$Data = [
								    'statu' => "success1",
								    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
								    'page' => $Sayfa,
								    'titleid' => $BaslikId,

									];
									echo json_encode($Data);
									exit();

									
								}else{
									$Data = [
								    'statu' => "success1",
								    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
								    'page' => $Sayfa,
								    'titleid' => $BaslikId,

									];
									echo json_encode($Data);
									exit();
									
								}
							}else{
								$Data = [
							    'statu' => "success",
							    'title' => SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])),
							    'titleid' => $BaslikId,

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

