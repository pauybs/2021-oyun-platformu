<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"] )  and isset($_SESSION["Jeton"]) ) {
	if( Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
	    
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			$Resim=NULL;
			$ResimKlasorYolu= "userphoto";
			$ResimYuklendi=0;
			if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0" ) {
				$fotobilgileri=Guvenlik($_POST["img"]);
				$bilgiler=explode(",",$fotobilgileri);
			}else{
				$Data = [
            	'statu' => "imageError", 
        		];
 				echo json_encode($Data);
				exit();
			}
			$ProfilResmiKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? and Durum=? and SilinmeDurumu=?  LIMIT 1");
		  	$ProfilResmiKontrol->execute([Guvenlik($KullaniciId),1,0]);
		 	$ProfilResmiKontrolSayisi = $ProfilResmiKontrol->rowCount();	
		 	$ProfilResmiKontrolKayitlar = $ProfilResmiKontrol->fetch(PDO::FETCH_ASSOC);
		 	if ($ProfilResmiKontrolSayisi>0) {
		 		if ($KullaniciProfilResimBan==1 and $KullaniciProfilResimBanTarih!="") {
					if ($Zaman>=$KullaniciProfilResimBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResimBan=?, ProfilResimBanTarih=?  WHERE  id=?  LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId]);
						$BanKaldirSayisi = $BanKaldir->rowCount();
						if ($BanKaldirSayisi>0) {
							$ProfilResim = $_FILES["ProfilResim"];
					 		if ($ProfilResmiKontrolKayitlar["ProfilResmi"]==NULL OR $ProfilResmiKontrolKayitlar["ProfilResmi"]=="") {
					 			if(($ProfilResim["name"]!="") and ($ProfilResim["type"]!="") and ($ProfilResim["tmp_name"]!="") and ($ProfilResim["error"]==0) and ($ProfilResim["size"]>0)){
					 				$UzantiKontrol = $ProfilResim["type"];
									if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
										if ($ProfilResim["size"]>2048000 ) {
											$Data = [
							            	'statu' => "size", 
							        		];
							 				echo json_encode($Data);
											exit();
										}else{
											$ResimDosyaAdi =  ResimAdi();
											$ResimUzantisi = substr($ProfilResim["name"], -4);
											if ($ResimUzantisi=="jpeg" || $ResimUzantisi=="JPEG" ) {
                								$ResimUzantisi =".jpeg";
                							}else if($ResimUzantisi==".jpg" || $ResimUzantisi==".JPG" ){
                							    $ResimUzantisi =".jpg";
                							}else if($ResimUzantisi==".png" || $ResimUzantisi==".PNG" ){
                							    $ResimUzantisi =".png";
                							}else{
                							    $Data = [
                            					    'statu' => "type",
                            						];
                            						echo json_encode($Data);
                            						exit();
                							}
											$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
											$ResimYukle = new \Verot\Upload\Upload($ProfilResim ,"tr-TR"); 
											if ($ResimYukle->uploaded){
												$ResimYukle->mime_magic_check = true;
												$ResimYukle->allowed = array("image/*");
												$ResimYukle->file_new_name_body = $ResimDosyaAdi;
												$ResimYukle->file_overwrite = true;
												$ResimYukle->image_background_color = "";
												$ResimYukle->image_resize = true;
												$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
												$ResimYukle->image_y = 300;
										  		$ResimYukle->image_x = 300;
										  		//$ResimYukle->image_convert = "jpg";
										  		$ResimYukle->quality = 100;
										   		$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
										    	if($ResimYukle->processed){
											    	$ResimEkle = $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResmi=? WHERE id=? LIMIT 1");
													$ResimEkle->execute([$ResimYeniDosyaAdi,Guvenlik($KullaniciId)]);
													$ResimEkleKontrol =$ResimEkle->rowCount();
													if($ResimEkleKontrol<1){
														$Data = [
										            	'statu' => "imageError", 
										        		];
										 				echo json_encode($Data);
														exit();
													}else{
														$ResimYukle->clean();
														$Data = [
										            	'statu' => "success", 
										        		];
										 				echo json_encode($Data);
														exit();
											     		
													}
											   	}else {
											     	$Data = [
									            	'statu' => "imageError", 
									        		];
									 				echo json_encode($Data);
													exit();
											   	}
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
						            'statu' => "imageError", 
						        	];
						 			echo json_encode($Data);
									exit();
								}
					 		}else{
				 				$ProfilResim = $_FILES["ProfilResim"];
						 		if(($ProfilResim["name"]!="") and ($ProfilResim["type"]!="") and ($ProfilResim["tmp_name"]!="") and ($ProfilResim["error"]==0) and ($ProfilResim["size"]>0)){
									$UzantiKontrol = $ProfilResim["type"];
									if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg")  ) {
										if ($ProfilResim["size"]>2048000) {
											$Data = [
							            	'statu' => "size", 
							        		];
							 				echo json_encode($Data);
											exit();
										}else{
											$ResimDosyaAdi =  ResimAdi();
											$ResimUzantisi = substr($ProfilResim["name"], -4);
											if ($ResimUzantisi=="jpeg" || $ResimUzantisi=="JPEG" ) {
                								$ResimUzantisi =".jpeg";
                							}else if($ResimUzantisi==".jpg" || $ResimUzantisi==".JPG" ){
                							    $ResimUzantisi =".jpg";
                							}else if($ResimUzantisi==".png" || $ResimUzantisi==".PNG" ){
                							    $ResimUzantisi =".png";
                							}else{
                							    $Data = [
                            					    'statu' => "type",
                            						];
                            						echo json_encode($Data);
                            						exit();
                							}
											$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
											$ResimYukle = new \Verot\Upload\Upload($ProfilResim ,"tr-TR"); 
											if ($ResimYukle->uploaded){
												$ResimYukle->mime_magic_check = true;
												$ResimYukle->allowed = array("image/*");
												$ResimYukle->file_new_name_body = $ResimDosyaAdi;
												$ResimYukle->file_overwrite = true;
												$ResimYukle->image_background_color = "";
												$ResimYukle->image_resize = true;
												$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
												$ResimYukle->image_y = 300;
										  		$ResimYukle->image_x = 300;
										  		//$ResimYukle->image_convert = "jpg";
										  		$ResimYukle->quality = 100;

										   		$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
										   		if($ResimYukle->processed){
											   		$ResimKlasorYolu= "userphoto";
											   		if ($ProfilResmiKontrolKayitlar["ProfilResmi"]!="") {
											   			$SilinecekResimYolu= "../images/".IcerikTemizle($ResimKlasorYolu)."/".IcerikTemizle($ProfilResmiKontrolKayitlar["ProfilResmi"]);
														unlink($SilinecekResimYolu);
											   		}
												
											    	$ResimEkle = $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResmi=? WHERE id=? LIMIT 1");
													$ResimEkle->execute([$ResimYeniDosyaAdi,Guvenlik($KullaniciId)]);
													$ResimEkleKontrol =$ResimEkle->rowCount();
													if($ResimEkleKontrol<1){
														$Data = [
											            'statu' => "imageError", 
											        	];
											 			echo json_encode($Data);
														exit();	
													}else{
														$ResimYukle->clean();	
														$Data = [
										            	'statu' => "success", 
										        		];
										 				echo json_encode($Data);
														exit();
													}
											   	}else{
											     	$Data = [
										            'statu' => "imageError", 
										        	];
										 			echo json_encode($Data);
													exit();
											   	}
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
						            'statu' => "imageError", 
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
		           		 'date' => TarihCevir2(IcerikTemizle($KullaniciProfilResimBanTarih)),
		        		];
		 				echo json_encode($Data);
						exit();	
					}
				}else{
					$ProfilResim = $_FILES["ProfilResim"];
			 		if ($ProfilResmiKontrolKayitlar["ProfilResmi"]==NULL OR $ProfilResmiKontrolKayitlar["ProfilResmi"]=="") {
			 			if(($ProfilResim["name"]!="") and ($ProfilResim["type"]!="") and ($ProfilResim["tmp_name"]!="") and ($ProfilResim["error"]==0) and ($ProfilResim["size"]>0)){
			 				$UzantiKontrol = $ProfilResim["type"];
							if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
								if ($ProfilResim["size"]>2048000 ) {
									$Data = [
					            	'statu' => "size", 
					        		];
					 				echo json_encode($Data);
									exit();
								}else{
									$ResimDosyaAdi =  ResimAdi();
									$ResimUzantisi = substr($ProfilResim["name"], -4);
									if ($ResimUzantisi=="jpeg" || $ResimUzantisi=="JPEG" ) {
        								$ResimUzantisi =".jpeg";
        							}else if($ResimUzantisi==".jpg" || $ResimUzantisi==".JPG" ){
        							    $ResimUzantisi =".jpg";
        							}else if($ResimUzantisi==".png" || $ResimUzantisi==".PNG" ){
        							    $ResimUzantisi =".png";
        							}else{
        							    $Data = [
                    					    'statu' => "type",
                    						];
                    						echo json_encode($Data);
                    						exit();
        							}
									$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
									$ResimYukle = new \Verot\Upload\Upload($ProfilResim ,"tr-TR"); 
									if ($ResimYukle->uploaded){
										$ResimYukle->mime_magic_check = true;
										$ResimYukle->allowed = array("image/*");
										$ResimYukle->file_new_name_body = $ResimDosyaAdi;
										$ResimYukle->file_overwrite = true;
										$ResimYukle->image_background_color = "";
										$ResimYukle->image_resize = true;
										$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
										$ResimYukle->image_y = 300;
								  		$ResimYukle->image_x = 300;
								  		//$ResimYukle->image_convert = "jpg";
								  		$ResimYukle->quality = 100;
								   		$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
								    	if($ResimYukle->processed){
									    	$ResimEkle = $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResmi=? WHERE id=? LIMIT 1");
											$ResimEkle->execute([$ResimYeniDosyaAdi,Guvenlik($KullaniciId)]);
											$ResimEkleKontrol =$ResimEkle->rowCount();
											if($ResimEkleKontrol<1){
												$Data = [
								            	'statu' => "imageError", 
								        		];
								 				echo json_encode($Data);
												exit();
											}else{
												$ResimYukle->clean();
												$Data = [
								            	'statu' => "success", 
								        		];
								 				echo json_encode($Data);
												exit();
									     		
											}
									   	}else {
									     	$Data = [
							            	'statu' => "imageError", 
							        		];
							 				echo json_encode($Data);
											exit();
									   	}
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
				            'statu' => "imageError", 
				        	];
				 			echo json_encode($Data);
							exit();
						}
			 		}else{
		 				$ProfilResim = $_FILES["ProfilResim"];
				 		if(($ProfilResim["name"]!="") and ($ProfilResim["type"]!="") and ($ProfilResim["tmp_name"]!="") and ($ProfilResim["error"]==0) and ($ProfilResim["size"]>0)){
							$UzantiKontrol = $ProfilResim["type"];
							if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg")  ) {
								if ($ProfilResim["size"]>2048000) {
									$Data = [
					            	'statu' => "size", 
					        		];
					 				echo json_encode($Data);
									exit();
								}else{
									$ResimDosyaAdi =  ResimAdi();
									$ResimUzantisi = substr($ProfilResim["name"], -4);
									if ($ResimUzantisi=="jpeg" || $ResimUzantisi=="JPEG" ) {
        								$ResimUzantisi =".jpeg";
        							}else if($ResimUzantisi==".jpg" || $ResimUzantisi==".JPG" ){
        							    $ResimUzantisi =".jpg";
        							}else if($ResimUzantisi==".png" || $ResimUzantisi==".PNG" ){
        							    $ResimUzantisi =".png";
        							}else{
        							    $Data = [
                    					    'statu' => "type",
                    						];
                    						echo json_encode($Data);
                    						exit();
        							}
									$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
									$ResimYukle = new \Verot\Upload\Upload($ProfilResim ,"tr-TR"); 
									if ($ResimYukle->uploaded){
										$ResimYukle->mime_magic_check = true;
										$ResimYukle->allowed = array("image/*");
										$ResimYukle->file_new_name_body = $ResimDosyaAdi;
										$ResimYukle->file_overwrite = true;
										$ResimYukle->image_background_color = "";
										$ResimYukle->image_resize = true;
										$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
										$ResimYukle->image_y = 300;
								  		$ResimYukle->image_x = 300;
								  		//$ResimYukle->image_convert = "jpg";
								  		$ResimYukle->quality = 100;

								   		$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
								   		if($ResimYukle->processed){
									   		$ResimKlasorYolu= "userphoto";
									   		if ($ProfilResmiKontrolKayitlar["ProfilResmi"]!="") {
									   			$SilinecekResimYolu= "../images/".IcerikTemizle($ResimKlasorYolu)."/".IcerikTemizle($ProfilResmiKontrolKayitlar["ProfilResmi"]);
												unlink($SilinecekResimYolu);
									   		}
										
									    	$ResimEkle = $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResmi=? WHERE id=? LIMIT 1");
											$ResimEkle->execute([$ResimYeniDosyaAdi,Guvenlik($KullaniciId)]);
											$ResimEkleKontrol =$ResimEkle->rowCount();
											if($ResimEkleKontrol<1){
												$Data = [
									            'statu' => "imageError", 
									        	];
									 			echo json_encode($Data);
												exit();	
											}else{
												$ResimYukle->clean();	
												$Data = [
								            	'statu' => "success", 
								        		];
								 				echo json_encode($Data);
												exit();
											}
									   	}else{
									     	$Data = [
								            'statu' => "imageError", 
								        	];
								 			echo json_encode($Data);
											exit();
									   	}
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
				            'statu' => "imageError", 
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

