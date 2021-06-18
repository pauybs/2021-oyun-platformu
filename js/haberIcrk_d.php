<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"] )  and isset($_SESSION["Jeton"]) ) {
	if(Guvenlik($KullaniciEditorDurumu)==1  and  Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {

		if(isset($_POST["h"]) and strlen($_POST["h"])<=11){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{	
			$HaberId="";
		}
		if(isset($_POST["i"]) and strlen($_POST["i"])<=11 ){
			$IcerikId = SayfaNumarasiTemizle(Guvenlik($_POST["i"]));
		}else{	
			$IcerikId="";
		}
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
		if(isset($_POST["Yazi"])){
			$IcerikAciklama = Guvenlik2($_POST["Yazi"]);
		}else{	
			$IcerikAciklama="";
		}
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
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

		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(($HaberId!="") and ($IcerikId!="")  and ($Uniqid!="")){
				if (($IcerikAciklama!="")){
					$IcerikKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler WHERE Editor=? and  Durum=? and id=? and HaberId=? and HaberUniqid=? ");
					$IcerikKontrol->execute([Guvenlik($KullaniciId),1,$IcerikId,$HaberId,$Uniqid]);
					$IcerikKontrolVeri = $IcerikKontrol->rowCount();
					$IcerikKontrolKayitlar = $IcerikKontrol->fetch(PDO::FETCH_ASSOC);
					if($IcerikKontrolVeri>0){
						$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE (Durum=? or Durum=?) and Editor=? ");
						$HaberKontrol->execute([1,3,Guvenlik($KullaniciId)]);
						$HaberKontrolVeri = $HaberKontrol->rowCount();
						$HaberKayitlar = $HaberKontrol->fetch(PDO::FETCH_ASSOC);
						if ($HaberKontrolVeri>0) {
							$IcerikResmi = $_FILES["IcerikResmi"];
							if ($IcerikResmi["name"]!="") {
								$ResimKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler WHERE id=?  ");
								$ResimKontrol->execute([$IcerikId]);
								$ResimKontrolVeri = $ResimKontrol->rowCount();
								$ResimKontrol = $ResimKontrol->fetch(PDO::FETCH_ASSOC);
								if ($ResimKontrolVeri>0) {
									if ($ResimKontrol["Resim"]!="") {
										if(($IcerikResmi!="") and ($IcerikResmi["name"]!="") and ($IcerikResmi["type"]!="") and ($IcerikResmi["tmp_name"]!="") and ($IcerikResmi["error"]==0) and ($IcerikResmi["size"]>0)){
											$UzantiKontrol = $IcerikResmi["type"];
											if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
												if ($IcerikResmi["size"]>2048000 ) {
													$Data = [
										            	'statu' => "size", 
										        	];
										 			echo json_encode($Data);
													exit();	
												}else{
													if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
														$fotobilgileri=Guvenlik($_POST["img"]);
														$bilgiler=explode(",",$fotobilgileri);
														$ResimKlasorYolu= "news/contents";
														$ResimDosyaAdi =  ResimAdi();
														$ResimUzantisi = substr($IcerikResmi["name"], -4);
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
														$ResimYukle = new \Verot\Upload\Upload($IcerikResmi ,"tr-TR"); 
														if ($ResimYukle->uploaded){
															$ResimYukle->mime_magic_check = true;
															$ResimYukle->allowed = array("image/*");
															$ResimYukle->file_new_name_body = $ResimDosyaAdi;
															$ResimYukle->file_overwrite = true;
															$ResimYukle->image_background_color = "";
															$ResimYukle->image_resize = true;
															$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
															$ResimYukle->image_y = 480;
															$ResimYukle->image_x = 760;
															//$ResimYukle->image_convert = "png";
															$ResimYukle->quality = 100;
															$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
															if($ResimYukle->processed){
																if ($ResimKontrol["Resim"]!="") {
																	$SilinecekAnaResimYolu= "../images/".$ResimKlasorYolu."/".$ResimKontrol["Resim"];
																	unlink($SilinecekAnaResimYolu);
																}
															
																$ResimEkle = $DatabaseBaglanti->prepare("UPDATE haberresimler SET Video=?,Resim=?,ResimBaslik=?,ResimAciklama=? WHERE id=?  ");
																$ResimEkle->execute([$Video,$ResimYeniDosyaAdi,$IcerikBaslik,$IcerikAciklama,$IcerikId]);
																$ResimEkleKontrol =$ResimEkle->rowCount();
																if($ResimEkleKontrol<1){
																	$Data = [
													           			'statu' => "error", 
														        	];
														        	echo json_encode($Data);
														        	exit();
																}
																$ResimYukle->clean();
																$Data = [
													            	'statu' => "success", 
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
										}else {
											$Data = [
								            	'statu' => "imageError", 
								        	];
								 			echo json_encode($Data);
											exit();
										}
									}else{
										$IcerikResmi = $_FILES["IcerikResmi"];
										if(($IcerikResmi!="") and ($IcerikResmi["name"]!="") and ($IcerikResmi["type"]!="") and ($IcerikResmi["tmp_name"]!="") and ($IcerikResmi["error"]==0) and ($IcerikResmi["size"]>0)){
												$UzantiKontrol = $IcerikResmi["type"];
											if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
												if ($IcerikResmi["size"]>2048000 ) {
													$Data = [
										            	'statu' => "size", 
										        	];
										 			echo json_encode($Data);
													exit();	
												}else{
													if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
														$fotobilgileri=Guvenlik($_POST["img"]);
														$bilgiler=explode(",",$fotobilgileri);
														$ResimKlasorYolu= "news/contents";
														$ResimDosyaAdi =  ResimAdi();
														$ResimUzantisi = substr($IcerikResmi["name"], -4);
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
														$ResimYukle = new \Verot\Upload\Upload($IcerikResmi ,"tr-TR"); 
														if ($ResimYukle->uploaded){
															$ResimYukle->mime_magic_check = true;
															$ResimYukle->allowed = array("image/*");
															$ResimYukle->file_new_name_body = $ResimDosyaAdi;
															$ResimYukle->file_overwrite = true;
															$ResimYukle->image_background_color = "";
															$ResimYukle->image_resize = true;
															$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
															$ResimYukle->image_y = 480;
															$ResimYukle->image_x = 760;
															//$ResimYukle->image_convert = "png";
															$ResimYukle->quality = 100;
															$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
															if($ResimYukle->processed){
																$ResimEkle = $DatabaseBaglanti->prepare("UPDATE haberresimler SET Video=?,Resim=?,ResimBaslik=?,ResimAciklama=? WHERE id=?  ");
																$ResimEkle->execute([$Video,$ResimYeniDosyaAdi,$IcerikBaslik,$IcerikAciklama,$IcerikId]);
																$ResimEkleKontrol =$ResimEkle->rowCount();
																if($ResimEkleKontrol<1){
																	$Data = [
													           			'statu' => "error", 
													        		];
													        		echo json_encode($Data);
													        		exit();
																}
																$ResimYukle->clean();
																$Data = [
													           		'statu' => "success", 
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
										}else {
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
								$Guncelle = $DatabaseBaglanti->prepare("UPDATE haberresimler SET Video=?,ResimBaslik=?,ResimAciklama=? WHERE id=?  ");
								$Guncelle->execute([$Video,$IcerikBaslik,$IcerikAciklama,$IcerikId]);
								$GuncelleKontrol =$Guncelle->rowCount();
								$Data = [
						            'statu' => "success", 
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

