<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ) {
	if (Guvenlik($KullaniciEditorDurumu)==1 and  Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
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
		if( isset($_POST["Oyun"]) and strlen($_POST["Oyun"])==20){
			$OyunId = Guvenlik($_POST["Oyun"]);
			$OyunKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? and OyunUniqid=?");
			$OyunKontrol->execute([1,$OyunId]);
			$OyunKontrolSayisi = $OyunKontrol->rowCount();
			if ($OyunKontrolSayisi>0) {
				$OyunId = Guvenlik($_POST["Oyun"]);
			}else{
				$OyunId=NULL;
			}
		}else{
			$OyunId=NULL;
		}
		if( isset($_POST["Haber"]) and strlen($_POST["Haber"])==22){
			$HaberId = Guvenlik($_POST["Haber"]);
			$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? and HaberUniqid=?");
			$HaberKontrol->execute([1,$HaberId]);
			$HaberKontrolSayisi = $HaberKontrol->rowCount();
			if ($HaberKontrolSayisi>0) {
				$HaberId = Guvenlik($_POST["Haber"]);
			}else{
				$HaberId=NULL;
			}
		}else{
			$HaberId=NULL;
		}


		if(isset($_POST["KapakResmiA"])){
			$KapakResmiAciklama = Guvenlik2($_POST["KapakResmiA"]);
		}else{
			$KapakResmiAciklama="";
		}
		if(isset($_POST["Etiketler"])){
			$Etiketler = Guvenlik($_POST["Etiketler"]);
		}else{
			$Etiketler="";
		}
		if(isset($_POST["KaynakUrl"])){
			$KaynakUrl = Guvenlik($_POST["KaynakUrl"]);
		}else{
			$KaynakUrl="";
		}
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}
		
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if( ($Baslik!="")  and ($KapakResmiAciklama!="") and 	$Etiketler!=""  ){

				if ($KullaniciEditorBan==1 and $KullaniciEditorBanTarih!="") {
					if ($Zaman>=$KullaniciEditorBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET EditorBan=?, EditorBanTarih=?  WHERE  id=? and Editor=?  LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId,1]);
						$BanKaldirSayisi = $BanKaldir->rowCount();
						if ($BanKaldirSayisi>0) {
							$AnaResim = $_FILES["KapakResmi"];
							if( ($AnaResim["name"]!="") and ($AnaResim["type"]!="") and ($AnaResim["tmp_name"]!="") and ($AnaResim["error"]==0) and ($AnaResim["size"]>0)){
								$UzantiKontrol = $AnaResim["type"];
								if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
									if ($AnaResim["size"]>2048000 ) {
										$Data = [
							            'statu' => "size",
							        	];
							 			echo json_encode($Data);
										exit();
									}else{
										$Sonuc=0;
										do {
											$uniqid=haber_uniq();
										  	$KontrolKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE  HaberUniqid=?");
											$KontrolKontrol->execute([$uniqid]);
											$KontrolVeri = $KontrolKontrol->rowCount();
											if ($KontrolVeri>0) {
												$Sonuc=0;
											}else{
												$Sonuc++;
												
											}
										} while ($Sonuc <= 0);

										if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
											$fotobilgileri=Guvenlik($_POST["img"]);
											$bilgiler=explode(",",$fotobilgileri);
											$ResimKlasorYolu= "news";
											//$AnaResimDosyaAdi = SEO($_POST["Baslik"])."-".ResimAdi();
											
											$HaberBaslik = str_replace(array(',','.'),'',$Baslik);
                                            $AnaResimDosyaAdi = SEO($HaberBaslik)."-".ResimAdi();
											$AnaResimUzantisi = substr($AnaResim["name"], -4);
												if ($AnaResimUzantisi=="jpeg" || $AnaResimUzantisi=="JPEG" ) {
                								$AnaResimUzantisi =".jpeg";
                							}else if($AnaResimUzantisi==".jpg" || $AnaResimUzantisi==".JPG" ){
                							    $AnaResimUzantisi =".jpg";
                							}else if($AnaResimUzantisi==".png" || $AnaResimUzantisi==".PNG" ){
                							    $AnaResimUzantisi =".png";
                							}else{
                							    $Data = [
                            					    'statu' => "imageType",
                            						];
                            						echo json_encode($Data);
                            						exit();
                							}
											$AnaResimYeniDosyaAdi = $AnaResimDosyaAdi.$AnaResimUzantisi;
											$HaberEkleme = $DatabaseBaglanti->prepare("INSERT INTO haberler (HaberUniqid,AnaBaslik,AnaResim,AnaAciklama,KaynakUrl,KayitTarihi,YorumSayisi,Goruntulenme,Etiketler,Durum,Editor,EditorIp,IlgiliOyun,IlgiliHaber)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
											$HaberEkleme->execute([$uniqid,$Baslik,$AnaResimYeniDosyaAdi,$KapakResmiAciklama,$KaynakUrl,$Zaman,0,0,$Etiketler,2,Guvenlik($KullaniciId),$IpAdresi,$OyunId,$HaberId]);
											$HaberEklemeSayisi =$HaberEkleme->rowCount();
											if ($HaberEklemeSayisi>0) {
												$SonHaberId=$DatabaseBaglanti->lastInsertId();
												$AnaResimYukle = new \Verot\Upload\Upload($AnaResim ,"tr-TR"); 
												if ($AnaResimYukle->uploaded){
													$AnaResimYukle->mime_magic_check = true;
													$AnaResimYukle->allowed = array("image/*");
													$AnaResimYukle->file_new_name_body = $AnaResimDosyaAdi;
													$AnaResimYukle->file_overwrite = true;
													$AnaResimYukle->image_background_color = "";
													$AnaResimYukle->image_resize = true;
													$AnaResimYukle->image_precrop = array($bilgiler[1],$AnaResimYukle->image_src_x - $bilgiler[2],$AnaResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
													$AnaResimYukle->image_y = 480;
												  	$AnaResimYukle->image_x = 760;
												  	//$AnaResimYukle->image_convert = "png";
												  	$AnaResimYukle->quality = 50;
												   	$AnaResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
												    if($AnaResimYukle->processed){
												     	$AnaResimYukle->clean();
												     	$Data = [
											            'statu' => "success",
											            'url'=> "habericerik/",
											            'username'=> IcerikTemizle($KullaniciAdi),
											            'news'=> $uniqid,
											        	];
											 			echo json_encode($Data);
														exit();		 	
												   		
												   	}else {
												     	$Data = [
											            'statu' => "image",
											        	];
											 			echo json_encode($Data);
														exit();	
												   	} 	
												}
											}else{
												$Data = [
									            'statu' => "newsError",
									        	];
									 			echo json_encode($Data);
												exit();	
											}
										}else{
											$Data = [
								            'statu' => "image",
								        	];
								 			echo json_encode($Data);
											exit();
										}
									}
								}else{
									$Data = [
						            'statu' => "imageType",
						        	];
						 			echo json_encode($Data);
									exit();
								}
							}else{
								$Data = [
					            'statu' => "image",
					        	];
					 			echo json_encode($Data);
								exit();		
							}

						}else{
							$Data = [
			           		 'statu' => "newsError",
			        		];
			 				echo json_encode($Data);
							exit();	
						}
					}else{
						

						$Data = [
		           		 'statu' => "block",
		           		 'date' => TarihCevir2(IcerikTemizle($KullaniciEditorBanTarih)),
		        		];
		 				echo json_encode($Data);
						exit();	
					}
				}else{
					$AnaResim = $_FILES["KapakResmi"];
					if( ($AnaResim["name"]!="") and ($AnaResim["type"]!="") and ($AnaResim["tmp_name"]!="") and ($AnaResim["error"]==0) and ($AnaResim["size"]>0)){
						$UzantiKontrol = $AnaResim["type"];
						if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
							if ($AnaResim["size"]>2048000 ) {
								$Data = [
					            'statu' => "size",
					        	];
					 			echo json_encode($Data);
								exit();
							}else{
								$Sonuc=0;
								do {
									$uniqid=haber_uniq();
								  	$KontrolKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE  HaberUniqid=?");
									$KontrolKontrol->execute([$uniqid]);
									$KontrolVeri = $KontrolKontrol->rowCount();
									if ($KontrolVeri>0) {
										$Sonuc=0;
									}else{
										$Sonuc++;
										
									}
								} while ($Sonuc <= 0);
								if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
									$fotobilgileri=Guvenlik($_POST["img"]);
									$bilgiler=explode(",",$fotobilgileri);
									$ResimKlasorYolu= "news";
									//$AnaResimDosyaAdi =  SEO($_POST["Baslik"])."-".ResimAdi();
									$HaberBaslik = str_replace(array(',','.'),'',$Baslik);
                                    $AnaResimDosyaAdi = SEO($HaberBaslik)."-".ResimAdi();
									$AnaResimUzantisi = substr($AnaResim["name"], -4);
										if ($AnaResimUzantisi=="jpeg" || $AnaResimUzantisi=="JPEG" ) {
        								$AnaResimUzantisi =".jpeg";
        							}else if($AnaResimUzantisi==".jpg" || $AnaResimUzantisi==".JPG" ){
        							    $AnaResimUzantisi =".jpg";
        							}else if($AnaResimUzantisi==".png" || $AnaResimUzantisi==".PNG" ){
        							    $AnaResimUzantisi =".png";
        							}else{
        							    $Data = [
                    					    'statu' => "imageType",
                    						];
                    						echo json_encode($Data);
                    						exit();
        							}
									$AnaResimYeniDosyaAdi = $AnaResimDosyaAdi.$AnaResimUzantisi;
									$HaberEkleme = $DatabaseBaglanti->prepare("INSERT INTO haberler (HaberUniqid,AnaBaslik,AnaResim,AnaAciklama,KaynakUrl,KayitTarihi,YorumSayisi,Goruntulenme,Etiketler,Durum,Editor,EditorIp,IlgiliOyun,IlgiliHaber)  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
									$HaberEkleme->execute([$uniqid,$Baslik,$AnaResimYeniDosyaAdi,$KapakResmiAciklama,$KaynakUrl,$Zaman,0,0,$Etiketler,2,Guvenlik($KullaniciId),$IpAdresi,$OyunId,$HaberId]);
									$HaberEklemeSayisi =$HaberEkleme->rowCount();
									if ($HaberEklemeSayisi>0) {
										$SonHaberId=$DatabaseBaglanti->lastInsertId();
										$AnaResimYukle = new \Verot\Upload\Upload($AnaResim ,"tr-TR"); 
										if ($AnaResimYukle->uploaded){
											$AnaResimYukle->mime_magic_check = true;
											$AnaResimYukle->allowed = array("image/*");
											$AnaResimYukle->file_new_name_body = $AnaResimDosyaAdi;
											$AnaResimYukle->file_overwrite = true;
											$AnaResimYukle->image_background_color = "";
											$AnaResimYukle->image_resize = true;
											$AnaResimYukle->image_precrop = array($bilgiler[1],$AnaResimYukle->image_src_x - $bilgiler[2],$AnaResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
											$AnaResimYukle->image_y = 480;
										  	$AnaResimYukle->image_x = 760;
										  	//$AnaResimYukle->image_convert = "png";
										  	$AnaResimYukle->quality = 50;
										   	$AnaResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
										    if($AnaResimYukle->processed){
										     	$AnaResimYukle->clean();
										     	$Data = [
									            'statu' => "success",
									            'url'=> "habericerik/",
									            'username'=> IcerikTemizle($KullaniciAdi),
									            'news'=> $uniqid,
									        	];
									 			echo json_encode($Data);
												exit();		 	
										   		
										   	}else {
										     	$Data = [
									            'statu' => "image",
									        	];
									 			echo json_encode($Data);
												exit();	
										   	} 	
										}
									}else{
										$Data = [
							            'statu' => "newsError",
							        	];
							 			echo json_encode($Data);
										exit();	
									}
								}else{
									$Data = [
						            'statu' => "image",
						        	];
						 			echo json_encode($Data);
									exit();
								}
							}
						}else{
							$Data = [
				            'statu' => "imageType",
				        	];
				 			echo json_encode($Data);
							exit();
						}
					}else{
						$Data = [
			            'statu' => "image",
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

