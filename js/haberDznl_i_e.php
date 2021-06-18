<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(IcerikTemizle($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){

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

		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

		if(isset($_POST["IcerikVideo"]) and $_POST["IcerikVideo"]!="" ){
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
		
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton and $Uniqid!="") {
			if( ($HaberId!="")  ){
				if (($IcerikAciklama!="")) {
					$EditorKontrol=$DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  id=? and HaberUniqid=? AND Editor=? and Durum!=? and Durum!=? and Durum!=? ");
					$EditorKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),0,2,4]);
					$EditorKontrolSayi = $EditorKontrol->rowCount();
					$EditorKontrolKayit = $EditorKontrol->fetch(PDO::FETCH_ASSOC);
					if ($EditorKontrolKayit >0) {
						$HaberBaslik= SEO(IcerikTemizle($EditorKontrolKayit["AnaBaslik"]));
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
										if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
											$fotobilgileri=Guvenlik($_POST["img"]);
											$bilgiler=explode(",",$fotobilgileri);
											$ResimKlasorYolu= "news/contents";
											$AnaResimDosyaAdi =  ResimAdi();
											$AnaResimUzantisi = substr($IcerikResmi["name"], -4);
											if ($AnaResimUzantisi=="jpeg") {
												$AnaResimUzantisi =".".$AnaResimUzantisi;
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
												$ResimYukle->quality = 100;
												$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
												if($ResimYukle->processed){
													$ResimEkle = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (HaberId,Video,HaberUniqid,ResimBaslik,ResimAciklama,Resim,Durum,Editor)  values (?,?,?,?,?,?,?,?) ");
													$ResimEkle->execute([$HaberId,$Video,$Uniqid,$IcerikBaslik,$IcerikAciklama,$AnaResimYeniDosyaAdi,1,Guvenlik($KullaniciId)]);
													$ResimEkleKontrol =$ResimEkle->rowCount();
													$SonId=$DatabaseBaglanti->lastInsertId();
													if($ResimEkleKontrol<1){
														exit();	
													}else{
														$ResimYukle->clean();
														$HaberResim = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? and Editor=?");
														$HaberResim->execute([$SonId,$KullaniciId]);
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
														}else{
															$ResimYolu="images/icerik.jpg";
															$ResimBaslik="";
															$ResimAciklama="";
														}

														$Data = [
														'statu' => "imagesuccess",
														'contentid' => $SonId, 
														'image' => $ResimYolu, 
														'username' => IcerikTemizle($KullaniciAdi), 
														'newsid' => $Uniqid,
														'title' => SEO(IcerikTemizle($HaberBaslik)),
														'tkn' => $Jeton,

											    		];
														echo json_encode($Data);
														exit();
													}
												}else {
													$SilinecekAnaResimYolu= "../images/news/contents/".$AnaResimYeniDosyaAdi;
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
							$HaberEkleme = $DatabaseBaglanti->prepare("INSERT INTO haberresimler (HaberId,Video,HaberUniqid,ResimBaslik,ResimAciklama,Durum,Editor)  VALUES (?,?,?,?,?,?,?)");
							$HaberEkleme->execute([$HaberId,$Video,$Uniqid,$IcerikBaslik,$IcerikAciklama,1,Guvenlik($KullaniciId)]);
							$HaberEklemeSayisi =$HaberEkleme->rowCount();
							if ($HaberEklemeSayisi>0) {
								$HaberBaslik= SEO(IcerikTemizle($EditorKontrolKayit["AnaBaslik"]));
								$SonId=$DatabaseBaglanti->lastInsertId();
								$HaberResim = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler Where id=? and Editor=?");
								$HaberResim->execute([$SonId,Guvenlik($KullaniciId)]);
								$HaberResimSayisi =$HaberResim->rowCount();
								$HaberResimKayit = $HaberResim->fetch(PDO::FETCH_ASSOC);
								if ($HaberResimSayisi>0) {
									$ResimBaslik=IcerikTemizle($HaberResimKayit["ResimBaslik"]);
									$ResimAciklama=IcerikTemizle($HaberResimKayit["ResimAciklama"]);
									$ResimYolu="images/icerik.jpg";
								}else{
									$ResimBaslik="";
									$ResimAciklama="";
									$ResimYolu="images/icerik.jpg";
								}

								$Data = [
									'statu' => "success",
									'contentid' => $SonId, 
									'image' => $ResimYolu, 
									'username' => IcerikTemizle($KullaniciAdi), 
									'newsid' => $Uniqid,
									'title' => SEO(IcerikTemizle($HaberBaslik)),
									'tkn' => $Jeton,

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
					'statu' => "contentnull", 
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

