<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if ($KullaniciKuratorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		
		if(isset($_POST["oi"])){
			$IncelemeId = SayfaNumarasiTemizle(Guvenlik($_POST["oi"]));
		}else{	
			$IncelemeId="";
		}
		if(isset($_POST["Baslik"])){
			$IncelemeBaslik = Guvenlik($_POST["Baslik"]);
			if (strlen($IncelemeBaslik)<100) {
				$IncelemeBaslik = Guvenlik($_POST["Baslik"]);
			}else{
				$Data = [
	            'statu' => "long",
	        	];
	 			echo json_encode($Data);
				exit();
			}
		}else{	
			$IncelemeBaslik="";
		}
		if(isset($_POST["Inceleme"])){
			$yazi = Guvenlik2($_POST["Inceleme"]);
		}else{	
			$yazi="";
		}
		if(isset($_POST["OyunAdi"])){
			$oyun = Guvenlik($_POST["OyunAdi"]);
		}else{	
			$oyun="";
		}
		if(isset($_POST["Link"])){
			$link = Guvenlik($_POST["Link"]);
		}else{	
			$link="";
		}
		if(isset($_POST["tkn"])){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{	
			$Jeton="";
		}

		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(($IncelemeId!="") ){
				if (($IncelemeBaslik!="") and ($oyun!="")) {
					$OyunKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=? and Durum=? LIMIT 1 ");
					$OyunKontrol->execute([$oyun,1]);
					$OyunKontrolVeri = $OyunKontrol->rowCount();
					if ($OyunKontrolVeri>0) {
						if (($yazi!="")){
							$Resim1 = $_FILES["Resim1"];
							$IncelemeKontrol=$DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? and  Durum!=? and Durum!=? and Incelemeid=? ");
							$IncelemeKontrol->execute([Guvenlik($KullaniciId),0,3,$IncelemeId]);
							$IncelemeKontrolVeri = $IncelemeKontrol->rowCount();
							$IncelemeKontrolVeriKayitlar = $IncelemeKontrol->fetch(PDO::FETCH_ASSOC);
							if($IncelemeKontrolVeri>0){
								$OyunKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? and id=? ");
								$OyunKontrol->execute([1,$oyun]);
								$OyunKontrolVeri = $OyunKontrol->rowCount();
								$OyunKayitlar = $OyunKontrol->fetch(PDO::FETCH_ASSOC);
								if ($OyunKontrolVeri>0) {
									if ($Resim1["name"]!="") {
										$ResimKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE IncelemeId=?  ");
										$ResimKontrol->execute([$IncelemeId]);
										$ResimKontrolVeri = $ResimKontrol->rowCount();
										$ResimKontrol = $ResimKontrol->fetch(PDO::FETCH_ASSOC);
										if ($ResimKontrolVeri>0) {
											if ($ResimKontrol["Resim1"]!="") {
												if(($Resim1!="") and ($Resim1["name"]!="") and ($Resim1["type"]!="") and ($Resim1["tmp_name"]!="") and ($Resim1["error"]==0) and ($Resim1["size"]>0)){
													$UzantiKontrol = $Resim1["type"];
													if (($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png") or ($UzantiKontrol=="image/jpeg")) {
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
																$ResimKlasorYolu= "inceleme";
																$ResimDosyaAdi =  ResimAdi();
																$ResimUzantisi = substr($Resim1["name"], -4);
																if ($ResimUzantisi=="jpeg") {
																	$ResimUzantisi =".".$ResimUzantisi;
																}
																$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
																$ResimYukle = new \Verot\Upload\Upload($Resim1 ,"tr-TR"); 
																if ($ResimYukle->uploaded){
																	$ResimYukle->mime_magic_check = true;
																	$ResimYukle->allowed = array("image/*");
																	$ResimYukle->file_new_name_body = $ResimDosyaAdi;
																	$ResimYukle->file_overwrite = true;
																	$ResimYukle->image_background_color = "";
																	$ResimYukle->image_resize = true;
																	$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
																	$ResimYukle->image_y = 480;
																	$ResimYukle->image_x = 720;
																	//$ResimYukle->image_convert = "png";
																	$ResimYukle->quality = 50;
																	$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
																	if($ResimYukle->processed){
																		if ($IncelemeKontrolVeriKayitlar["Resim1"]!="") {
																			$SilinecekAnaResimYolu= "../images/".$ResimKlasorYolu."/".$IncelemeKontrolVeriKayitlar["Resim1"];
																			unlink($SilinecekAnaResimYolu);
																		}
																		
																		$ResimEkle = $DatabaseBaglanti->prepare("UPDATE incelemeler SET OyunId=?,Resim1=?,Baslik=?,IncelemeYazisi=?,IncelemeLink=? WHERE Incelemeid=?  ");
																		$ResimEkle->execute([$oyun,$ResimYeniDosyaAdi,$IncelemeBaslik,$yazi,$link,$IncelemeId]);
																		$ResimEkleKontrol =$ResimEkle->rowCount();
																		if($ResimEkleKontrol<1){
																			$Data = [
																			'statu' => "error", 
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
														echo"image2";
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
												if(($Resim1!="") and ($Resim1["name"]!="") and ($Resim1["type"]!="") and ($Resim1["tmp_name"]!="") and ($Resim1["error"]==0) and ($Resim1["size"]>0)){
													$UzantiKontrol = $Resim1["type"];
													if (($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png") or ($UzantiKontrol=="image/jpeg")) {
														if ($Resim1["size"]>2048000) {
															$Data = [
															'statu' => "size", 
															];
															echo json_encode($Data);
															exit();
														}else{
															if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0" ) {
																$fotobilgileri=Guvenlik($_POST["img"]);
																$bilgiler=explode(",",$fotobilgileri);

																$ResimKlasorYolu= "inceleme";
																$ResimDosyaAdi =  ResimAdi();
																$ResimUzantisi = substr($Resim1["name"], -4);
																if ($ResimUzantisi=="jpeg") {
																	$ResimUzantisi =".".$ResimUzantisi;
																}
																$ResimYeniDosyaAdi = $ResimDosyaAdi.$ResimUzantisi;
																$ResimYukle = new \Verot\Upload\Upload($Resim1 ,"tr-TR"); 
																if ($ResimYukle->uploaded){
																	$ResimYukle->mime_magic_check = true;
																	$ResimYukle->allowed = array("image/*");
																	$ResimYukle->file_new_name_body = $ResimDosyaAdi;
																	$ResimYukle->file_overwrite = true;
																	$ResimYukle->image_background_color = "";
																	$ResimYukle->image_resize = true;
																	$ResimYukle->image_precrop = array($bilgiler[1],$ResimYukle->image_src_x - $bilgiler[2],$ResimYukle->image_src_y - $bilgiler[3],$bilgiler[0]);
																	$ResimYukle->image_y = 480;
																	$ResimYukle->image_x = 720;
																	//$ResimYukle->image_convert = "png";
																	$ResimYukle->quality = 50;
																	$ResimYukle->process($VerotKlasorYolu.$ResimKlasorYolu);
																	if($ResimYukle->processed){ 
																		$ResimEkle = $DatabaseBaglanti->prepare("UPDATE incelemeler SET OyunId=?, Resim1=?,Baslik=?,IncelemeYazisi=?,IncelemeLink=? WHERE Incelemeid=?  ");
																		$ResimEkle->execute([$oyun,$ResimYeniDosyaAdi,$IncelemeBaslik,$yazi,$link,$IncelemeId]);
																		$ResimEkleKontrol =$ResimEkle->rowCount();
																		if($ResimEkleKontrol<1){
																			$Data = [
																			'statu' => "error", 
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
																			'statu' => "error", 
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
										$Guncelle = $DatabaseBaglanti->prepare("UPDATE incelemeler SET OyunId=?,Baslik=?,IncelemeYazisi=?,IncelemeLink=? WHERE Incelemeid=?  ");
										$Guncelle->execute([$oyun,$IncelemeBaslik,$yazi,$link,$IncelemeId]);
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
							'statu' => "writenull", 
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

