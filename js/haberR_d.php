<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(Guvenlik($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
		
		if(isset($_POST["h"]) and strlen($_POST["h"])<=11){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{
			$HaberId="";
		}
		if(isset($_POST["Tkn"]) and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}
		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton and  ($HaberId!="")  and  ($Uniqid!="")) {
			$EditorKontrol=$DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=?  and HaberUniqid=? and Editor=? and Durum!=? and Durum!=? and Durum!=? LIMIT 1");
			$EditorKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),0,2,4]);
			$EditorKontrolSayisi = $EditorKontrol->rowCount();
			$EditorKontrolKayitlar = $EditorKontrol->fetch(PDO::FETCH_ASSOC);
			if ($EditorKontrolKayitlar>0) {
				$KapakResmi = $_FILES["KapakResmi"];
				if(  ($KapakResmi["name"]!="") ){
					if(($KapakResmi!="") and ($KapakResmi["name"]!="") and ($KapakResmi["type"]!="") and ($KapakResmi["tmp_name"]!="") and ($KapakResmi["error"]==0) and ($KapakResmi["size"]>0)){
						$UzantiKontrol = $KapakResmi["type"];
						if ( ($UzantiKontrol=="image/jpg") or ($UzantiKontrol=="image/png")  or ($UzantiKontrol=="image/jpeg") ) {
							if ($KapakResmi["size"]>2048000 ) {
								$Data = [
				        		'statu' => "size", 
						    	];
								echo json_encode($Data);
								exit();
							}else{
								if (isset($_POST["img"]) and $_POST["img"]!="0,0,0,0") {
									$fotobilgileri=Guvenlik($_POST["img"]);
									$bilgiler=explode(",",$fotobilgileri);
									$ResimKlasorYolu= "news";
									//$ResimDosyaAdi =    SEO(IcerikTemizle($EditorKontrolKayitlar["AnaBaslik"]))."-".ResimAdi();
									$IlkIslem=IcerikTemizle($EditorKontrolKayitlar["AnaBaslik"]);
									$IkinciIslem= 	Guvenlik($IlkIslem);
									$HaberBaslik = str_replace(array(',','.'),'',$IkinciIslem);

									$ResimDosyaAdi =    SEO($HaberBaslik)."-".ResimAdi();
									$ResimUzantisi = substr($KapakResmi["name"], -4);
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
									$ResimYukle = new \Verot\Upload\Upload($KapakResmi ,"tr-TR"); 
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
											if ($EditorKontrolKayitlar["AnaResim"]!="") {
												$SilinecekAnaResimYolu= "../images/".$ResimKlasorYolu."/".$EditorKontrolKayitlar["AnaResim"];
												unlink($SilinecekAnaResimYolu);
											}
											$ResimEkle = $DatabaseBaglanti->prepare("UPDATE haberler SET AnaResim=? WHERE id=? and Editor=? ");
											$ResimEkle->execute([$ResimYeniDosyaAdi,$HaberId,Guvenlik($KullaniciId)]);
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
					$Data = [
	        		'statu' => "imageError", 
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