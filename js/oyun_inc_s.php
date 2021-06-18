<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if ($KullaniciKuratorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		
		if(isset($_POST["Oyun"])){
			$Oyun = SayfaNumarasiTemizle(Guvenlik($_POST["Oyun"]));
		}else{
			$Oyun="";
		}
		if(isset($_POST["Baslik"])){
			$Baslik = Guvenlik($_POST["Baslik"]);
			if (strlen($Baslik)<100) {
				$Baslik = Guvenlik($_POST["Baslik"]);
			}else{
				$Data = [
	            'statu' => "long",
	        	];
	 			echo json_encode($Data);
				exit();
			}
		}else{
			$Baslik="";
		}
		if(isset($_POST["Inceleme"])){
			$Inceleme = Guvenlik2($_POST["Inceleme"]);
		}else{
			$Inceleme="";
		}
		if(isset($_POST["link"])){
			$link = Guvenlik($_POST["link"]);
		}else{
			$link="";
		}

		if(isset($_POST["tkn"])){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{
			$Jeton="";
		}
		
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$KuratorKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Kurator=? and Durum=? and SilinmeDurumu=? LIMIT 1 ");
			$KuratorKontrol->execute([Guvenlik($KullaniciId),1,1,0]);
			$KuratorKontrolVeri = $KuratorKontrol->rowCount();
			$KuratorKontrolKayitlar = $KuratorKontrol->fetch(PDO::FETCH_ASSOC);
			if ($KuratorKontrolVeri>0) {
				if ($Inceleme!=""){
					if( ($Oyun!="") and ($Baslik!="") and ($Inceleme!="") ){
						$OyunKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=? and Durum=? LIMIT 1 ");
						$OyunKontrol->execute([$Oyun,1]);
						$OyunKontrolVeri = $OyunKontrol->rowCount();
						if ($OyunKontrolVeri>0) {
							if ($KullaniciKuratorBan==1 and $KullaniciKuratorBanTarih!="") {
								if ($Zaman>=$KullaniciKuratorBanTarih) {
									$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET KuratorBan=?, KuratorBanTarih=?  WHERE  id=? and Kurator=?  LIMIT 1 ");
									$BanKaldir->execute([0,NULL,$KullaniciId,1]);
									$BanKaldirSayisi = $BanKaldir->rowCount();

									if ($BanKaldirSayisi>0) {
										$Resim1 = $_FILES["Resim1"];
										if (($Resim1["name"]!="")){
						 					if(($Resim1["name"]!="") and ($Resim1["type"]!="") and ($Resim1["tmp_name"]!="") and ($Resim1["error"]==0) and ($Resim1["size"]>0)){	
												$UzantiKontrol = $Resim1["type"];
												if (($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
													if ($Resim1["size"]>2048000) {
														$Data = [
												    	'statu' => "size", 
														];
														echo json_encode($Data);
														exit();
													}else{
														if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
															$fotobilgileri=Guvenlik($_POST["img"]);
															$bilgiler=explode(",",$fotobilgileri);
															$Resim1KlasorYolu= "inceleme";
															$Resim1DosyaAdi =  ResimAdi();
															$Resim1Uzantisi = substr($Resim1["name"], -4);
															if ($Resim1Uzantisi=="jpeg") {
																$Resim1Uzantisi =".".$Resim1Uzantisi;
															}
															$Resim1YeniDosyaAdi = $Resim1DosyaAdi.$Resim1Uzantisi;
															$Resim1Yukle = new \Verot\Upload\Upload($Resim1 ,"tr-TR"); 
															if ($Resim1Yukle->uploaded){
																$Resim1Yukle->mime_magic_check = true;
																$Resim1Yukle->allowed = array("image/*");
																$Resim1Yukle->file_new_name_body = $Resim1DosyaAdi;
																$Resim1Yukle->file_overwrite = true;
																$Resim1Yukle->image_background_color = "";
																$Resim1Yukle->image_resize = true;
																$Resim1Yukle->image_precrop = array($bilgiler[1],$Resim1Yukle->image_src_x - $bilgiler[2],$Resim1Yukle->image_src_y - $bilgiler[3],$bilgiler[0]);
																$Resim1Yukle->image_x = 720;
																$Resim1Yukle->image_y = 480;
																//$Resim1Yukle->image_convert = "png";
																$Resim1Yukle->quality = 50;
																$Resim1Yukle->process($VerotKlasorYolu.$Resim1KlasorYolu);
																if($Resim1Yukle->processed){
																	$Resim1Ekle = $DatabaseBaglanti->prepare("INSERT INTO incelemeler (Resim1,KuratorId,OyunId,Baslik,IncelemeYazisi,IncelemeLink,IpAdres,Durum,Begeni,Tarih) values (?,?,?,?,?,?,?,?,?,?)");
																	$Resim1Ekle->execute([$Resim1YeniDosyaAdi,Guvenlik($KullaniciId),$Oyun,$Baslik,$Inceleme,$link,$IpAdresi,4,0,$Zaman]);
																	$Resim1EkleKontrol =$Resim1Ekle->rowCount();
																	if($Resim1EkleKontrol<1){
																		$Data = [
																    	'statu' => false, 
																		];
																		echo json_encode($Data);
																		exit();
																		
																	}else{
																		$Data = [
																    	'statu' => true, 
																		];
																		echo json_encode($Data);
																		exit();
																		$Resim1Yukle->clean();	
																	}
																	 	
																}else {	
																	$Data = [
																    	'statu' => false, 
																		];
																		echo json_encode($Data);
																		exit();	
																}
															}
														}else{
															$Data = [
													    	'statu' => "imageError", 
															];
															echo json_encode($Data);
															exit();
														}
													}

												}else{
													$Data = [
											    	'statu' => "type", 
													];
													echo json_encode($Data);
													exit();
												}
							 				}else{
												$Data = [
										    	'statu' =>  "imageError", 
												];
												echo json_encode($Data);
												exit();		
							 				}
										}else{
											$IncelemeKayit = $DatabaseBaglanti->prepare("INSERT INTO incelemeler (KuratorId,OyunId,Baslik,IncelemeYazisi,IncelemeLink,IpAdres,Durum,Begeni,Tarih) values (?,?,?,?,?,?,?,?,?) ");
											$IncelemeKayit->execute([Guvenlik($KullaniciId),$Oyun,$Baslik,$Inceleme,$link,$IpAdresi,4,0,$Zaman]);
											$IncelemeVeri = $IncelemeKayit->rowCount();
											if ($IncelemeVeri>0) {
												$Data = [
										    	'statu' => true, 
												];
												echo json_encode($Data);
												exit();		
											}else{
												$Data = [
										    	'statu' => false, 
												];
												echo json_encode($Data);
												exit();	
											}
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
					           		 'date' => TarihCevir2(IcerikTemizle($KullaniciKuratorBanTarih)),
					        		];
					 				echo json_encode($Data);
								exit();	
								}
							}else{
								$Resim1 = $_FILES["Resim1"];
								if (($Resim1["name"]!="")){
				 					if(($Resim1["name"]!="") and ($Resim1["type"]!="") and ($Resim1["tmp_name"]!="") and ($Resim1["error"]==0) and ($Resim1["size"]>0)){	
										$UzantiKontrol = $Resim1["type"];
										if (($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
											if ($Resim1["size"]>2048000) {
												$Data = [
										    	'statu' => "size", 
												];
												echo json_encode($Data);
												exit();
											}else{
												if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
													$fotobilgileri=Guvenlik($_POST["img"]);
													$bilgiler=explode(",",$fotobilgileri);
													$Resim1KlasorYolu= "inceleme";
													$Resim1DosyaAdi =  ResimAdi();
													$Resim1Uzantisi = substr($Resim1["name"], -4);
													if ($Resim1Uzantisi=="jpeg") {
														$Resim1Uzantisi =".".$Resim1Uzantisi;
													}
													$Resim1YeniDosyaAdi = $Resim1DosyaAdi.$Resim1Uzantisi;
													$Resim1Yukle = new \Verot\Upload\Upload($Resim1 ,"tr-TR"); 
													if ($Resim1Yukle->uploaded){
														$Resim1Yukle->mime_magic_check = true;
														$Resim1Yukle->allowed = array("image/*");
														$Resim1Yukle->file_new_name_body = $Resim1DosyaAdi;
														$Resim1Yukle->file_overwrite = true;
														$Resim1Yukle->image_background_color = "";
														$Resim1Yukle->image_resize = true;
														$Resim1Yukle->image_precrop = array($bilgiler[1],$Resim1Yukle->image_src_x - $bilgiler[2],$Resim1Yukle->image_src_y - $bilgiler[3],$bilgiler[0]);
														$Resim1Yukle->image_x = 720;
														$Resim1Yukle->image_y = 480;
														//$Resim1Yukle->image_convert = "png";
														$Resim1Yukle->quality = 50;
														$Resim1Yukle->process($VerotKlasorYolu.$Resim1KlasorYolu);
														if($Resim1Yukle->processed){
															$Resim1Ekle = $DatabaseBaglanti->prepare("INSERT INTO incelemeler (Resim1,KuratorId,OyunId,Baslik,IncelemeYazisi,IncelemeLink,IpAdres,Durum,Begeni,Tarih) values (?,?,?,?,?,?,?,?,?,?)");
															$Resim1Ekle->execute([$Resim1YeniDosyaAdi,Guvenlik($KullaniciId),$Oyun,$Baslik,$Inceleme,$link,$IpAdresi,4,0,$Zaman]);
															$Resim1EkleKontrol =$Resim1Ekle->rowCount();
															if($Resim1EkleKontrol<1){
																$Data = [
														    	'statu' => false, 
																];
																echo json_encode($Data);
																exit();
																
															}else{
																$Data = [
														    	'statu' => true, 
																];
																echo json_encode($Data);
																exit();
																$Resim1Yukle->clean();	
															}
															 	
														}else {	
															$Data = [
														    	'statu' => false, 
																];
																echo json_encode($Data);
																exit();	
														}
													}
												}else{
													$Data = [
											    	'statu' => "imageError", 
													];
													echo json_encode($Data);
													exit();
												}
											}

										}else{
											$Data = [
									    	'statu' => "type", 
											];
											echo json_encode($Data);
											exit();
										}
					 				}else{
										$Data = [
								    	'statu' =>  "imageError", 
										];
										echo json_encode($Data);
										exit();		
					 				}
								}else{
									$IncelemeKayit = $DatabaseBaglanti->prepare("INSERT INTO incelemeler (KuratorId,OyunId,Baslik,IncelemeYazisi,IncelemeLink,IpAdres,Durum,Begeni,Tarih) values (?,?,?,?,?,?,?,?,?) ");
									$IncelemeKayit->execute([Guvenlik($KullaniciId),$Oyun,$Baslik,$Inceleme,$link,$IpAdresi,4,0,$Zaman]);
									$IncelemeVeri = $IncelemeKayit->rowCount();
									if ($IncelemeVeri>0) {
										$Data = [
								    	'statu' => true, 
										];
										echo json_encode($Data);
										exit();		
									}else{
										$Data = [
								    	'statu' => false, 
										];
										echo json_encode($Data);
										exit();	
									}
								}
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
				    	'statu' => "null", 
						];
						echo json_encode($Data);
						exit();			
					}
				}else{
					$Data = [
			    	'statu' => "textnull", 
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

