<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"]) and  isset($_SESSION["Jeton"]) ) {
	if (Guvenlik($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {	
		if(isset($_POST["IcerikBaslik"])){
			$IcerikBaslik = Guvenlik($_POST["IcerikBaslik"]);
			if (strlen($IcerikBaslik)<100) {
				$IcerikBaslik = Guvenlik($_POST["IcerikBaslik"]);
			}else{
				$Data = [
	            'statu' => "long",
	        	];
	 			echo json_encode($Data);
				exit();
			}
		}else{
			$IcerikBaslik="";
		}
		if(isset($_POST["h"]) and strlen($_POST["h"])<=11 ){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{
			$HaberId="";
		}
		if(isset($_POST["Yazi"])){
			$IcerikAciklama = Guvenlik2($_POST["Yazi"]);
		}else{
			$IcerikAciklama="";
		}

		if(isset($_POST["IcerikVideo"]) and $_POST["IcerikVideo"]!=""){
			$Video = Guvenlik($_POST["IcerikVideo"]);
			if (strlen($Video)==11) {
				$Video = Guvenlik($_POST["IcerikVideo"]);
				
			}else{
				$Data = [
				'statu' => "video", 
	    		];
				echo json_encode($Data);
				exit();
			}

		}else{
			$Video="";
		}

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}
		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton  ) {
			if( ($HaberId!="")  and ($Uniqid!="")){
				if (($IcerikAciklama!="")) {
					$EditorKontrol =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  id=? and HaberUniqid=? AND Editor=? and Durum!=? and Durum!=? and Durum!=? and Durum!=? and Durum=?");
					$EditorKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),0,1,3,4,2]);
					$EditorKontrolSayi = $EditorKontrol->rowCount();
					$EditorKontrolKayit = $EditorKontrol->fetch(PDO::FETCH_ASSOC);
					if ($EditorKontrolKayit >0) {
						if ($KullaniciEditorBan==1 and $KullaniciEditorBanTarih!="") {
							if ($Zaman>=$KullaniciEditorBanTarih) {
								$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET EditorBan=?, EditorBanTarih=?  WHERE  id=? and Editor=? LIMIT 1 ");
								$BanKaldir->execute([0,NULL,$KullaniciId,1]);
								$BanKaldirSayisi = $BanKaldir->rowCount();
								if ($BanKaldirSayisi>0) {
									$IcerikResmi = $_FILES["IcerikResmi"];
									if($IcerikResmi["name"]!=""){
										if(($IcerikResmi["name"]!="") and ($IcerikResmi["type"]!="") and ($IcerikResmi["tmp_name"]!="") and ($IcerikResmi["error"]==0) and ($IcerikResmi["size"]>0)){
											$UzantiKontrol = $IcerikResmi["type"];
											if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
												if ($IcerikResmi["size"]>2048000 ) {
													$Data = [
											       	'statu' => "size",
											    	];
											    	echo json_encode($Data); 
													exit();
												}else{
													if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0" ) {
														$fotobilgileri=Guvenlik($_POST["img"]);
														$bilgiler=explode(",",$fotobilgileri);
														
														$ResimKlasorYolu= "news/contents";
														$AnaResimDosyaAdi =  ResimAdi();
														$AnaResimUzantisi = substr($IcerikResmi["name"], -4);
															if ($AnaResimUzantisi=="jpeg" || $AnaResimUzantisi=="JPEG" ) {
                            								$AnaResimUzantisi =".jpeg";
                            							}else if($AnaResimUzantisi==".jpg" || $AnaResimUzantisi==".JPG" ){
                            							    $AnaResimUzantisi =".jpg";
                            							}else if($AnaResimUzantisi==".png" || $AnaResimUzantisi==".PNG" ){
                            							    $AnaResimUzantisi =".png";
                            							}else{
                            							    $Data = [
                                        					    'statu' => "type",
                                        						];
                                        						echo json_encode($Data);
                                        						exit();
                            							}
                            							$AnaResimYeniDosyaAdi = $AnaResimDosyaAdi.$AnaResimUzantisi;
														$ResimYukle = new \Verot\Upload\Upload($IcerikResmi ,"tr-TR"); 
														if ($ResimYukle->uploaded){
															$ResimYukle->mime_magic_check = true;
															$ResimYukle->allowed = array("image/*");
															$ResimYukle->file_new_name_body = $AnaResimDosyaAdi;
															$ResimYukle->file_overwrite = true;
															$ResimYukle->image_background_color = "";
															$ResimYukle->image_resize = true;
															$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
															$ResimYukle->image_y = 480;
															$ResimYukle->image_x = 760;
											  				//$ResimYukle->image_convert = "png";
															$ResimYukle->quality = 50;
															$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
															if($ResimYukle->processed){
																$ResimEkle = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (Video,HabeUniqid,HaberId,ResimBaslik,ResimAciklama,Resim,Durum,Editor)  values (?,?,?,?,?,?,?,?) ");
																$ResimEkle->execute([$Video,$Uniqid,$HaberId,$IcerikBaslik,$IcerikAciklama,$AnaResimYeniDosyaAdi,1,Guvenlik($KullaniciId)]);
																$ResimEkleKontrol =$ResimEkle->rowCount();
																$SonId=$DatabaseBaglanti->lastInsertId();
																if($ResimEkleKontrol<1){
																	exit();	
																}else{
																	$ResimYukle->clean();
																	$HaberResim=$DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? and HaberUniqid=? and Editor=?");
																	$HaberResim->execute([$SonId,$Uniqid,Guvenlik($KullaniciId)]);
																	$HaberResimSayisi =$HaberResim->rowCount();
																	$HaberResimKayit = $HaberResim->fetch(PDO::FETCH_ASSOC);
																	if ($HaberResimSayisi>0) {
																		$Resim=$HaberResimKayit["Resim"];
																		$ResimBaslik=IcerikTemizle($HaberResimKayit["ResimBaslik"]);
																		$ResimAciklama=IcerikTemizle($HaberResimKayit["ResimAciklama"]);
																		if (IcerikTemizle($Resim) and file_exists("../images/news/contents/".$Resim."") and ($Resim!="")) {
																			$ResimYolu="images/news/contents/".$Resim."";
																		}else{
																			$ResimYolu="images/icerik.jpg";
																		}
																		$Data = [
																       		'statu' => "success",
																       		'content' => $SonId,
																       		'image' => $ResimYolu,
																       		'title' => IcerikTemizle($ResimBaslik),
																       		'article' => IcerikTemizle($ResimAciklama),
																       		'tkn' => $Jeton,
																       		'video' => $Video,
																    	];
																    	echo json_encode($Data); 
																		exit();

																	}else{
																		$ResimYolu="images/icerik.jpg";
																		$ResimBaslik="-";
																		$ResimAciklama="-";
																		$Data = [
																       		'statu' => "success",
																       		'content' => $SonId,
																       		'image' => $ResimYolu,
																       		'title' => IcerikTemizle($ResimBaslik),
																       		'article' => IcerikTemizle($ResimAciklama),
																       		'tkn' => $Jeton,
																       		'video' => $Video,
																    	];
																    	echo json_encode($Data); 
																		exit();
																	}
																	
																}
															}else {
																$SilinecekAnaResimYolu= "images/news/contents/".$AnaResimYeniDosyaAdi;
																unlink($SilinecekAnaResimYolu);

																$Data = [
														       		'statu' => "image",
														    	];
														    	echo json_encode($Data); 
																exit();	
															}
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
										       		'statu' => "type",
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
										$HaberEkleme = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (Video,HaberUniqid,HaberId,ResimBaslik,ResimAciklama,Durum,Editor)  VALUES (?,?,?,?,?,?,?)");
										$HaberEkleme->execute([$Video,$Uniqid,$HaberId,$IcerikBaslik,$IcerikAciklama,1,Guvenlik($KullaniciId)]);
										$HaberEklemeSayisi =$HaberEkleme->rowCount();
										if ($HaberEklemeSayisi>0) {

											$SonId=$DatabaseBaglanti->lastInsertId();

											$HaberResim = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? and HaberUniqid=? and Editor=?");
											$HaberResim->execute([Guvenlik($SonId),$Uniqid,Guvenlik($KullaniciId)]);
											$HaberResimSayisi =$HaberResim->rowCount();
											$HaberResimKayit = $HaberResim->fetch(PDO::FETCH_ASSOC);
											if ($HaberResimSayisi>0) {

												$ResimBaslik=IcerikTemizle($HaberResimKayit["ResimBaslik"]);
												$ResimAciklama=IcerikTemizle($HaberResimKayit["ResimAciklama"]);
												$ResimYolu="images/icerik.jpg";
												$Data = [
											       	'statu' => "success",
											       	'content' => $SonId,
											       	'image' => $ResimYolu,
											       	'title' => IcerikTemizle($ResimBaslik),
											       	'article' => IcerikTemizle($ResimAciklama),
											       	'tkn' => $Jeton,
											       	'video' => $Video,
										    	];
										    	echo json_encode($Data); 
												exit();
											}else{
												$ResimBaslik="-";
												$ResimAciklama="-";
												$ResimYolu="images/icerik.jpg";
												$Data = [
										       		'statu' => "success",
										       		'content' => $SonId,
										       		'image' => $ResimYolu,
										       		'title' => IcerikTemizle($ResimBaslik),
										       		'article' => IcerikTemizle($ResimAciklama),
										       		'tkn' => $Jeton,
										       		'video' => $Video,
										    	];
										    	echo json_encode($Data); 
												exit();
											}
										}else{
											$Data = [
									       		'statu' => "ContentError",
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
				           		 'date' => TarihCevir2(IcerikTemizle($KullaniciEditorBanTarih)),
				        		];
				 				echo json_encode($Data);
								exit();		
							}
						}else{
							$IcerikResmi = $_FILES["IcerikResmi"];
							if($IcerikResmi["name"]!=""){
								if(($IcerikResmi["name"]!="") and ($IcerikResmi["type"]!="") and ($IcerikResmi["tmp_name"]!="") and ($IcerikResmi["error"]==0) and ($IcerikResmi["size"]>0)){
									$UzantiKontrol = $IcerikResmi["type"];
									if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
										if ($IcerikResmi["size"]>2048000 ) {
											$Data = [
									       	'statu' => "size",
									    	];
									    	echo json_encode($Data); 
											exit();
										}else{
											if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0" ) {
												$fotobilgileri=Guvenlik($_POST["img"]);
												$bilgiler=explode(",",$fotobilgileri);
												
												$ResimKlasorYolu= "news/contents";
												$AnaResimDosyaAdi =  ResimAdi();
												$AnaResimUzantisi = substr($IcerikResmi["name"], -4);
                    							if ($AnaResimUzantisi=="jpeg" || $AnaResimUzantisi=="JPEG" ) {
                    								$AnaResimUzantisi =".jpeg";
                    							}else if($AnaResimUzantisi==".jpg" || $AnaResimUzantisi==".JPG" ){
                    							    $AnaResimUzantisi =".jpg";
                    							}else if($AnaResimUzantisi==".png" || $AnaResimUzantisi==".PNG" ){
                    							    $AnaResimUzantisi =".png";
                    							}else{
                    							    $Data = [
                                					    'statu' => "type",
                                						];
                                						echo json_encode($Data);
                                						exit();
                    							}
												$AnaResimYeniDosyaAdi = $AnaResimDosyaAdi.$AnaResimUzantisi;
												$ResimYukle = new \Verot\Upload\Upload($IcerikResmi ,"tr-TR"); 
												if ($ResimYukle->uploaded){
													$ResimYukle->mime_magic_check = true;
													$ResimYukle->allowed = array("image/*");
													$ResimYukle->file_new_name_body = $AnaResimDosyaAdi;
													$ResimYukle->file_overwrite = true;
													$ResimYukle->image_background_color = "";
													$ResimYukle->image_resize = true;
													$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
													$ResimYukle->image_y = 480;
													$ResimYukle->image_x = 760;
									  				//$ResimYukle->image_convert = "png";
													$ResimYukle->quality = 50;
													$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
													if($ResimYukle->processed){
														$ResimEkle = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (Video,HaberUniqid,HaberId,ResimBaslik,ResimAciklama,Resim,Durum,Editor) values (?,?,?,?,?,?,?,?) ");
														$ResimEkle->execute([$Video,$Uniqid,$HaberId,$IcerikBaslik,$IcerikAciklama,$AnaResimYeniDosyaAdi,1,Guvenlik($KullaniciId)]);
														$ResimEkleKontrol =$ResimEkle->rowCount();
														$SonId=$DatabaseBaglanti->lastInsertId();
														if($ResimEkleKontrol<1){
															exit();	
														}else{
															$ResimYukle->clean();
															$HaberResim=$DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? and HaberUniqid=? and Editor=?");
															$HaberResim->execute([$SonId,$Uniqid,Guvenlik($KullaniciId)]);
															$HaberResimSayisi =$HaberResim->rowCount();
															$HaberResimKayit = $HaberResim->fetch(PDO::FETCH_ASSOC);
															if ($HaberResimSayisi>0) {
																$Resim=$HaberResimKayit["Resim"];
																$ResimBaslik=IcerikTemizle($HaberResimKayit["ResimBaslik"]);
																$ResimAciklama=IcerikTemizle($HaberResimKayit["ResimAciklama"]);
																if (IcerikTemizle($Resim) and file_exists("../images/news/contents/".$Resim."") and ($Resim!="")) {
																	$ResimYolu="images/news/contents/".$Resim."";
																}else{
																	$ResimYolu="images/icerik.jpg";
																}
																$Data = [
														       		'statu' => "success",
														       		'content' => $SonId,
														       		'image' => $ResimYolu,
														       		'title' => IcerikTemizle($ResimBaslik),
														       		'article' => IcerikTemizle($ResimAciklama),
														       		'tkn' => $Jeton,
														       		'video' => $Video,
														    	];
														    	echo json_encode($Data); 
																exit();

															}else{
																$ResimYolu="images/icerik.jpg";
																$ResimBaslik="-";
																$ResimAciklama="-";
																$Data = [
														       		'statu' => "success",
														       		'content' => $SonId,
														       		'image' => $ResimYolu,
														       		'title' => IcerikTemizle($ResimBaslik),
														       		'article' => IcerikTemizle($ResimAciklama),
														       		'tkn' => $Jeton,
														       		'video' => $Video,
														    	];
														    	echo json_encode($Data); 
																exit();
															}
															
														}
													}else {
														$SilinecekAnaResimYolu= "images/news/contents/".$AnaResimYeniDosyaAdi;
														unlink($SilinecekAnaResimYolu);

														$Data = [
												       		'statu' => "image",
												    	];
												    	echo json_encode($Data); 
														exit();	
													}
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
								       		'statu' => "type",
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
								$HaberEkleme = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (Video,HaberUniqid,HaberId,ResimBaslik,ResimAciklama,Durum,Editor)  VALUES (?,?,?,?,?,?,?)");
								$HaberEkleme->execute([$Video,$Uniqid,$HaberId,$IcerikBaslik,$IcerikAciklama,1,Guvenlik($KullaniciId)]);
								$HaberEklemeSayisi =$HaberEkleme->rowCount();
								if ($HaberEklemeSayisi>0) {

									$SonId=$DatabaseBaglanti->lastInsertId();

									$HaberResim = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? AND HaberUniqid=? and Editor=?");
									$HaberResim->execute([$SonId,Guvenlik($Uniqid),Guvenlik($KullaniciId)]);
									$HaberResimSayisi =$HaberResim->rowCount();
									$HaberResimKayit = $HaberResim->fetch(PDO::FETCH_ASSOC);
									if ($HaberResimSayisi>0) {

										$ResimBaslik=IcerikTemizle($HaberResimKayit["ResimBaslik"]);
										$ResimAciklama=IcerikTemizle($HaberResimKayit["ResimAciklama"]);
										$ResimYolu="images/icerik.jpg";
										$Data = [
									       	'statu' => "success",
									       	'content' => $SonId,
									       	'image' => $ResimYolu,
									       	'title' => IcerikTemizle($ResimBaslik),
									       	'article' => IcerikTemizle($ResimAciklama),
									       	'tkn' => $Jeton,
									       	'video' => $Video,
								    	];
								    	echo json_encode($Data); 
										exit();
									}else{
										$ResimBaslik="-";
										$ResimAciklama="-";
										$ResimYolu="images/icerik.jpg";
										$Data = [
								       		'statu' => "success",
								       		'content' => $SonId,
								       		'image' => $ResimYolu,
								       		'title' => IcerikTemizle($ResimBaslik),
								       		'article' => IcerikTemizle($ResimAciklama),
								       		'tkn' => $Jeton,
								       		'video' => $Video,

								    	];
								    	echo json_encode($Data); 
										exit();
									}
								}else{
									$Data = [
							       		'statu' => "ContentError",
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
		           		'statu' => "content",
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

