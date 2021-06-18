<?php

if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
?>
	<di../v class="row   m-0" >
	<?php
	if ($Sıralama== 1) {
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=1  and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 2){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=2  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 3){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=9  and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 4){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=8  and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 5){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=10  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 6){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=3  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 7){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=5  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 8){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=12  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 9){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=7  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 10){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=11  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else if ($Sıralama== 11){
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=4  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
	}else{
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=1 ORDER BY oyunlar.CikisTarihi DESC ");
	}
	
	$Oyunlar->execute();
	$OyunlarVeri = $Oyunlar->rowCount();
	$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunlarVeri>0) {
		$Oyun=0;
		$dizi[]=array();
		foreach ($OyunlarKayitlar as  $kayitlar) {
			$KullaniciIsletimSistemi =$DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
			$KullaniciIsletimSistemi->execute([$KullaniciIsletimSistemiId]);
			$KullaniciIsletimSistemiVeri = $KullaniciIsletimSistemi->rowCount();
			$KullaniciIsletimSistemiKayitlar = $KullaniciIsletimSistemi->fetch(PDO::FETCH_ASSOC);
			if ($KullaniciIsletimSistemiVeri>0) {
				if ($KullaniciIsletimSistemiKayitlar["IsletimSistemiMarka"]=="Apple") {
					$IsletimPlatform="MacOS";
					$KullaniciIsletimSistemiIds=$DatabaseBaglanti->prepare("SELECT * FROM gereksinimplatformu WHERE  PlatformAdi=? LIMIT 1");
					$KullaniciIsletimSistemiIds->execute([$IsletimPlatform]);
					$KullaniciIsletimSistemiIdsVeri=$KullaniciIsletimSistemiIds->rowCount();
					$KullaniciIsletimSistemiIdsKayitlar = $KullaniciIsletimSistemiIds->fetch(PDO::FETCH_ASSOC);
					$OyunGereksinimIsletimSistemiMarkaId=$KullaniciIsletimSistemiIdsKayitlar["id"];
				}else {

					$KullaniciIsletimSistemiIds =$DatabaseBaglanti->prepare("SELECT * FROM gereksinimplatformu WHERE  PlatformAdi=? LIMIT 1");
					$KullaniciIsletimSistemiIds->execute([$KullaniciIsletimSistemiKayitlar["IsletimSistemiMarka"]]);
					$KullaniciIsletimSistemiIdsVeri = $KullaniciIsletimSistemiIds->rowCount();
					$KullaniciIsletimSistemiIdsKayitlar = $KullaniciIsletimSistemiIds->fetch(PDO::FETCH_ASSOC);
					$OyunGereksinimIsletimSistemiMarkaId=$KullaniciIsletimSistemiIdsKayitlar["id"];
				}

				$OyunSistem=$DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim WHERE OyunId=? and IsletimSistemiAdi=? LIMIT 1");
				$OyunSistem->execute([$kayitlar["id"],$OyunGereksinimIsletimSistemiMarkaId]);
				$OyunSistemVeri = $OyunSistem->rowCount();
				$OyunSistemKayitlar = $OyunSistem->fetch(PDO::FETCH_ASSOC);
				if ($OyunSistemKayitlar >0 and $OyunSistemKayitlar["IsletimSistemiAdi"]!="" and $OyunSistemKayitlar["MinimumIsletimSistemiId"]!="" and $OyunSistemKayitlar["MinimumIslemciId"]!=""  and $OyunSistemKayitlar["MinimumEkranKartiId"]!=""  ) {

					$MinimumIsletimSistemi=$DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
					$MinimumIsletimSistemi->execute([$OyunSistemKayitlar["MinimumIsletimSistemiId"]]);
					$MinimumIsletimSistemiVeri = $MinimumIsletimSistemi->rowCount();
					$MinimumIsletimSistemiKayitlar = $MinimumIsletimSistemi->fetch(PDO::FETCH_ASSOC);
					if ($MinimumIsletimSistemiVeri>0  ) {
						$IsletimSistemiMarka= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiMarka"]);
						$IsletimSistemiPuan= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiPuan"]);
					}else{
						$IsletimSistemiMarka="";
						$IsletimSistemiPuan="";
					}

					$KullaniciIsletimSistemi =$DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
					$KullaniciIsletimSistemi->execute([Guvenlik($KullaniciIsletimSistemiId)]);
					$KullaniciIsletimSistemiVeri = $KullaniciIsletimSistemi->rowCount();
					$KullaniciIsletimSistemiKayitlar = $KullaniciIsletimSistemi->fetch(PDO::FETCH_ASSOC);
					if ($KullaniciIsletimSistemiVeri>0) {
						$KullaniciIsletimSistemiMarka= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiMarka"]);
						$KullaniciIsletimSistemiPuan= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiPuan"]);
					}else{
						$KullaniciIsletimSistemiMarka="";
						$KullaniciIsletimSistemiPuan= "";
					}

					$KullaniciIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
					$KullaniciIslemci->execute([Guvenlik($KullaniciIslemciId)]);
					$KullaniciIslemciVeri = $KullaniciIslemci->rowCount();
					$KullaniciIslemciKayitlar = $KullaniciIslemci->fetch(PDO::FETCH_ASSOC);
					if ($KullaniciIslemciVeri>0) {
						$KullaniciIslemciMarka= IcerikTemizle($KullaniciIslemciKayitlar["IslemciMarka"]);
						$KullaniciIslemciPuan= IcerikTemizle($KullaniciIslemciKayitlar["IslemciPuan"]);
					}else{
						$KullaniciIslemciMarka= "";
						$KullaniciIslemciPuan= "";
					}

					$MinimumIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
					$MinimumIslemci->execute([Guvenlik($OyunSistemKayitlar["MinimumIslemciId"])]);
					$MinimumIslemciVeri = $MinimumIslemci->rowCount();
					$MinimumIslemciKayitlar = $MinimumIslemci->fetch(PDO::FETCH_ASSOC);
					if ($MinimumIslemciVeri>0) {
						$IslemciMarka= IcerikTemizle($MinimumIslemciKayitlar["IslemciMarka"]);
						$IslemciAdi= IcerikTemizle($MinimumIslemciKayitlar["IslemciAdi"]);
						$IslemciPuan= IcerikTemizle($MinimumIslemciKayitlar["IslemciPuan"]);
					}else{
						$IslemciMarka="";
						$IslemciPuan="";
						$IslemciAdi= "";
					}

					$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
					$MinimumIslemci2->execute([Guvenlik($OyunSistemKayitlar["MinimumIslemci2Id"])]);
					$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
					$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
					if ($MinimumIslemci2Veri>0) {
						$Islemci2Marka= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciMarka"]);
						$Islemci2Adi= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
						$Islemci2Puan= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciPuan"]);
					}else{
						$Islemci2Marka="" ;
						$Islemci2Puan="" ;
						$Islemci2Adi="";
					}

					$KullaniciEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
					$KullaniciEkranKarti->execute([Guvenlik($KullaniciEkranKartiId)]);
					$KullaniciEkranKartiVeri = $KullaniciEkranKarti->rowCount();
					$KullaniciEkranKartiKayitlar = $KullaniciEkranKarti->fetch(PDO::FETCH_ASSOC);
					if ($KullaniciEkranKartiVeri>0) {
						$KullaniciEkranKartiMarka=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiMarka"]);
						$KullaniciEkranKartiPuan=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiPuan"]);
					}else{
						$KullaniciEkranKartiMarka= "";
						$KullaniciEkranKartiPuan=  "";
					}

					$MinimumEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
					$MinimumEkranKarti->execute([Guvenlik($OyunSistemKayitlar["MinimumEkranKartiId"])]);
					$MinimumEkranKartiVeri = $MinimumEkranKarti->rowCount();
					$MinimumEkranKartiKayitlar = $MinimumEkranKarti->fetch(PDO::FETCH_ASSOC);
					if ($MinimumEkranKartiVeri>0) {
						$EkranKartiMarka=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiMarka"]);
						$EkranKartiAdi=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiAdi"]);
						$EkranKartiPuan=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiPuan"]);
					}else{
						$EkranKartiMarka="";
						$EkranKartiPuan="";
						$EkranKartiAdi= "";
					}

					$MinimumEkranKarti2 =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
					$MinimumEkranKarti2->execute([Guvenlik($OyunSistemKayitlar["MinimumEkranKarti2Id"])]);
					$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
					$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
					if ($MinimumEkranKarti2Veri>0) {
						$EkranKarti2Marka=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiMarka"]);
						$EkranKarti2Adi=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiAdi"]);
						$EkranKarti2Puan=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiPuan"]);
					}else{
						$EkranKarti2Marka="" ;
						$EkranKarti2Puan="" ;
						$EkranKarti2Adi="";
					}


					$MinimumBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
					$MinimumBellek->execute([Guvenlik($OyunSistemKayitlar["MinimumRamId"])]);
					$MinimumBellekVeri = $MinimumBellek->rowCount();
					$MinimumBellekKayitlar = $MinimumBellek->fetch(PDO::FETCH_ASSOC);
					if ($MinimumBellekVeri>0){
						$MinimumBellekPuan=  IcerikTemizle($MinimumBellekKayitlar["RamPuan"]);
					}else{
						$MinimumBellekPuan="";
					}

					$KullaniciBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
					$KullaniciBellek->execute([Guvenlik($KullaniciPcRamId)]);
					$KullaniciBellekVeri = $KullaniciBellek->rowCount();
					$KullaniciBellekKayitlar = $KullaniciBellek->fetch(PDO::FETCH_ASSOC);
					if ($KullaniciBellekVeri>0) {
						$KullaniciBellekPuan=  IcerikTemizle($KullaniciBellekKayitlar["RamPuan"]);
					}else{
						$KullaniciBellekPuan="";
					}

					$MinimumDirectx =  $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
					$MinimumDirectx->execute([Guvenlik($OyunSistemKayitlar["MinimumDirectxId"])]);
					$MinimumDirectxVeri = $MinimumDirectx->rowCount();
					$MinimumDirectxKayitlar = $MinimumDirectx->fetch(PDO::FETCH_ASSOC);
					if ($MinimumDirectxVeri>0) {
						$MinimumDirectxPuan=  IcerikTemizle($MinimumDirectxKayitlar["DirectxPuan"]);
					}else{
						$MinimumDirectxPuan="";
					}
					$KullaniciDirectx=$DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
					$KullaniciDirectx->execute([Guvenlik($KullaniciPcDirectxId)]);
					$KullaniciDirectxVeri = $KullaniciDirectx->rowCount();
					$KullaniciDirectxKayitlar = $KullaniciDirectx->fetch(PDO::FETCH_ASSOC);
					if ($KullaniciDirectxVeri>0) {
						$KullaniciDirectxPuan=  IcerikTemizle($KullaniciDirectxKayitlar["DirectxPuan"]);
					}else{
						$KullaniciDirectxPuan="";

					}
					if ($IsletimSistemiMarka!="" and $IsletimSistemiPuan!="" and $KullaniciIsletimSistemiMarka!="" and
						$KullaniciIsletimSistemiPuan!= "" and $KullaniciIslemciMarka!= "" and $KullaniciIslemciPuan!= "" and $IslemciMarka!="" and $IslemciPuan!="" and $IslemciAdi!= "" and $KullaniciEkranKartiMarka!= "" and $KullaniciEkranKartiPuan!=  "" and $EkranKartiMarka!="" and $EkranKartiPuan!="" and $EkranKartiAdi!= "") {

						if ( ($KullaniciIsletimSistemiMarka == $IsletimSistemiMarka) and ($KullaniciIsletimSistemiPuan >= $IsletimSistemiPuan) ) {
							if (($KullaniciIslemciMarka == $IslemciMarka) and  ($KullaniciIslemciPuan >= $IslemciPuan) ) {
								if (($KullaniciEkranKartiMarka == $EkranKartiMarka) and $KullaniciEkranKartiPuan >= $EkranKartiPuan) {
								?>
									<?php
									if ($MinimumDirectxPuan!="") {
										if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
											if ($KullaniciBellekPuan!="") {
												if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
													$Oyun++;
													$dizi[]=$kayitlar["id"];	

												?>
													<div class="col-6 col-md-4 col-xl-3 mb-5 ">
														<div class="row p-2">
														<?php
														if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
														?>
															<div class="col-12 p-0" style="background: black">
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
																</a>
															</div>
														<?php
														}else{
														?>
															<div class="col-12 p-0  "  >
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img src="images/resim.jpg" class="img-fluid oyunlar" >
																</a>
															</div>
														<?php
														}
														?>
																
														<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
															<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
															</a>
														</div>

														<?php
														$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
														$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
														$ToplamPuanVeri = $ToplamPuan->rowCount();
														$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
														if ($ToplamPuanVeri>0) {
														?>
															<?php
															$ToplamPuan=0;
															$KisiSayisi=$ToplamPuanVeri;
															foreach ($ToplamPuanKayitlar as $Puanlar) {
																$ToplamPuan+= $Puanlar["Puan"];
															}
																$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
															?>
															
															<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
														<?php
														}else{		
														?>
															<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
														<?php
														}
														?>
														
														<?php
														$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
														$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
														$OyunPlatformSayi = $OyunPlatform->rowCount();
														$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
														if ($OyunPlatformSayi>0) {
														?>
															<div class="col-12  mt-1 p-0" >
																<?php
																foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
																?>
																	<?php echo Platform($OyunPlatform["PlatformId"])?>
																<?php		
																}
																?>
															</div>
														<?php
														}
														?>
														</div>
													</div>
												<?php
												}
											}else{
												$Oyun++;
												$dizi[]=$kayitlar["id"];
											?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold ram font20"></i>
														</div>
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}
									}else{
										if ($MinimumBellekPuan!="") {
											if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
												$Oyun++;
												$dizi[]=$kayitlar["id"];
												?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold direcxt font20"></i>
														</div>
														
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}else{
											$Oyun++;
											$dizi[]=$kayitlar["id"];
										?>

											<div class="col-6 col-md-4 col-xl-3 mb-5 ">
												<div class="row p-2">
												<?php
												if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
												?>
													<div class="col-12 p-0" style="background: black">
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
														</a>
													</div>
													<div class="col-12 mt-2 position-absolute">
													<i class="fas fa-info-circle white bold drtxram font20"></i>
													</div>
												<?php
												}else{
												?>
													<div class="col-12 p-0  "  >
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img src="images/resim.jpg" class="img-fluid oyunlar" >
														</a>
													</div>
												<?php
												}
												?>
														
												<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
													<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
														<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
													</a>
												</div>

												<?php
												$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
												$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
												$ToplamPuanVeri = $ToplamPuan->rowCount();
												$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
												if ($ToplamPuanVeri>0) {
												?>
													<?php
													$ToplamPuan=0;
													$KisiSayisi=$ToplamPuanVeri;
													foreach ($ToplamPuanKayitlar as $Puanlar) {
														$ToplamPuan+= $Puanlar["Puan"];
													}
														$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
													?>
													
													<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
												<?php
												}else{		
												?>
													<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
												<?php
												}
												?>
												
												<?php
												$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
												$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
												$OyunPlatformSayi = $OyunPlatform->rowCount();
												$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
												if ($OyunPlatformSayi>0) {
												?>
													<div class="col-12  mt-1 p-0" >
														<?php
														foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
														?>
															<?php echo Platform($OyunPlatform["PlatformId"])?>
														<?php		
														}
														?>
													</div>
												<?php
												}
												?>
											</div>
											</div>
										<?php
										}
									}

								?>
								<?php
								}else if ( ($EkranKarti2Marka!="") and ($KullaniciEkranKartiMarka == $EkranKarti2Marka) and ( $EkranKarti2Puan!="") and ($KullaniciEkranKartiPuan >= $EkranKarti2Puan) ) {
								?>
									<?php
									if ($MinimumDirectxPuan!="") {
										if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
											if ($KullaniciBellekPuan!="") {
												if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
													$Oyun++;
													$dizi[]=$kayitlar["id"];
												?>
													<div class="col-6 col-md-4 col-xl-3 mb-5 ">
														<div class="row p-2">
														<?php
														if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
														?>
															<div class="col-12 p-0" style="background: black">
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
																</a>
															</div>
														<?php
														}else{
														?>
															<div class="col-12 p-0  "  >
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img src="images/resim.jpg" class="img-fluid oyunlar" >
																</a>
															</div>
														<?php
														}
														?>
																
														<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
															<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
															</a>
														</div>

														<?php
														$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
														$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
														$ToplamPuanVeri = $ToplamPuan->rowCount();
														$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
														if ($ToplamPuanVeri>0) {
														?>
															<?php
															$ToplamPuan=0;
															$KisiSayisi=$ToplamPuanVeri;
															foreach ($ToplamPuanKayitlar as $Puanlar) {
																$ToplamPuan+= $Puanlar["Puan"];
															}
																$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
															?>
															
															<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
														<?php
														}else{		
														?>
															<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
														<?php
														}
														?>
														
														<?php
														$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
														$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
														$OyunPlatformSayi = $OyunPlatform->rowCount();
														$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
														if ($OyunPlatformSayi>0) {
														?>
															<div class="col-12  mt-1 p-0" >
																<?php
																foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
																?>
																	<?php echo Platform($OyunPlatform["PlatformId"])?>
																<?php		
																}
																?>
															</div>
														<?php
														}
														?>
														</div>
													</div>
												<?php
												}
											}else{
												$Oyun++;
												$dizi[]=$kayitlar["id"];
											?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold ram font20"></i>
														</div>
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}
									}else{
										if ($MinimumBellekPuan!="") {
											if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
												$Oyun++;
												$dizi[]=$kayitlar["id"];
												?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold direcxt font20"></i>
														</div>
														
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}else{
											$Oyun++;
											$dizi[]=$kayitlar["id"];
										?>
											<div class="col-6 col-md-4 col-xl-3 mb-5 ">
												<div class="row p-2">
												<?php
												if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
												?>
													<div class="col-12 p-0" style="background: black">
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
														</a>
													</div>
													<div class="col-12 mt-2 position-absolute">
													<i class="fas fa-info-circle white bold drtxram font20"></i>
													</div>
												<?php
												}else{
												?>
													<div class="col-12 p-0  "  >
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img src="images/resim.jpg" class="img-fluid oyunlar" >
														</a>
													</div>
												<?php
												}
												?>
														
												<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
													<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
														<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
													</a>
												</div>

												<?php
												$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
												$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
												$ToplamPuanVeri = $ToplamPuan->rowCount();
												$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
												if ($ToplamPuanVeri>0) {
												?>
													<?php
													$ToplamPuan=0;
													$KisiSayisi=$ToplamPuanVeri;
													foreach ($ToplamPuanKayitlar as $Puanlar) {
														$ToplamPuan+= $Puanlar["Puan"];
													}
														$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
													?>
													
													<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
												<?php
												}else{		
												?>
													<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
												<?php
												}
												?>
												
												<?php
												$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
												$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
												$OyunPlatformSayi = $OyunPlatform->rowCount();
												$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
												if ($OyunPlatformSayi>0) {
												?>
													<div class="col-12  mt-1 p-0" >
														<?php
														foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
														?>
															<?php echo Platform($OyunPlatform["PlatformId"])?>
														<?php		
														}
														?>
													</div>
												<?php
												}
												?>
											</div>
											</div>
										<?php
										}
									}

								?>
								<?php
								}
								
							}else if (($Islemci2Marka!="") and ($KullaniciIslemciMarka == $Islemci2Marka) and ($Islemci2Puan!="") and  ($KullaniciIslemciPuan >= $Islemci2Puan) ) {
								if (($KullaniciEkranKartiMarka == $EkranKartiMarka) and $KullaniciEkranKartiPuan >= $EkranKartiPuan) {
								?>
									<?php
									if ($MinimumDirectxPuan!="") {
										if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
											if ($KullaniciBellekPuan!="") {
												if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
													$Oyun++;
													$dizi[]=$kayitlar["id"];
												?>
													<div class="col-6 col-md-4 col-xl-3 mb-5 ">
														<div class="row p-2">
														<?php
														if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
														?>
															<div class="col-12 p-0" style="background: black">
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
																</a>
															</div>
														<?php
														}else{
														?>
															<div class="col-12 p-0  "  >
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img src="images/resim.jpg" class="img-fluid oyunlar" >
																</a>
															</div>
														<?php
														}
														?>
																
														<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
															<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
															</a>
														</div>

														<?php
														$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
														$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
														$ToplamPuanVeri = $ToplamPuan->rowCount();
														$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
														if ($ToplamPuanVeri>0) {
														?>
															<?php
															$ToplamPuan=0;
															$KisiSayisi=$ToplamPuanVeri;
															foreach ($ToplamPuanKayitlar as $Puanlar) {
																$ToplamPuan+= $Puanlar["Puan"];
															}
																$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
															?>
															
															<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
														<?php
														}else{		
														?>
															<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
														<?php
														}
														?>
														
														<?php
														$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
														$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
														$OyunPlatformSayi = $OyunPlatform->rowCount();
														$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
														if ($OyunPlatformSayi>0) {
														?>
															<div class="col-12  mt-1 p-0" >
																<?php
																foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
																?>
																	<?php echo Platform($OyunPlatform["PlatformId"])?>
																<?php		
																}
																?>
															</div>
														<?php
														}
														?>
														</div>
													</div>
												<?php
												}
											}else{
												$Oyun++;
												$dizi[]=$kayitlar["id"];
											?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold ram font20"></i>
														</div>
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}
									}else{
										if ($MinimumBellekPuan!="") {
											if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
												$Oyun++;
												$dizi[]=$kayitlar["id"];
												?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold direcxt font20"></i>
														</div>
														
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}else{
											$Oyun++;
											$dizi[]=$kayitlar["id"];
										?>
											<div class="col-6 col-md-4 col-xl-3 mb-5 ">
												<div class="row p-2">
												<?php
												if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
												?>
													<div class="col-12 p-0" style="background: black">
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
														</a>
													</div>
													<div class="col-12 mt-2 position-absolute">
													<i class="fas fa-info-circle white bold drtxram font20"></i>
													</div>
												<?php
												}else{
												?>
													<div class="col-12 p-0  "  >
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img src="images/resim.jpg" class="img-fluid oyunlar" >
														</a>
													</div>
												<?php
												}
												?>
														
												<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
													<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
														<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
													</a>
												</div>

												<?php
												$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
												$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
												$ToplamPuanVeri = $ToplamPuan->rowCount();
												$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
												if ($ToplamPuanVeri>0) {
												?>
													<?php
													$ToplamPuan=0;
													$KisiSayisi=$ToplamPuanVeri;
													foreach ($ToplamPuanKayitlar as $Puanlar) {
														$ToplamPuan+= $Puanlar["Puan"];
													}
														$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
													?>
													
													<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
												<?php
												}else{		
												?>
													<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
												<?php
												}
												?>
												
												<?php
												$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
												$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
												$OyunPlatformSayi = $OyunPlatform->rowCount();
												$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
												if ($OyunPlatformSayi>0) {
												?>
													<div class="col-12  mt-1 p-0" >
														<?php
														foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
														?>
															<?php echo Platform($OyunPlatform["PlatformId"])?>
														<?php		
														}
														?>
													</div>
												<?php
												}
												?>
											</div>
											</div>
										<?php
										}
									}

								?>
								<?php
							}else if ( ($EkranKarti2Marka!="") and ($KullaniciEkranKartiMarka == $EkranKarti2Marka) and ( $EkranKarti2Puan!="") and ($KullaniciEkranKartiPuan >= $EkranKarti2Puan) ) {
								?>
									<?php
									if ($MinimumDirectxPuan!="") {
										if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
											if ($KullaniciBellekPuan!="") {
												if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
													$Oyun++;
													$dizi[]=$kayitlar["id"];
												?>
													<div class="col-6 col-md-4 col-xl-3 mb-5 ">
														<div class="row p-2">
														<?php
														if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
														?>
															<div class="col-12 p-0" style="background: black">
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
																</a>
															</div>
														<?php
														}else{
														?>
															<div class="col-12 p-0  "  >
																<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																	<img src="images/resim.jpg" class="img-fluid oyunlar" >
																</a>
															</div>
														<?php
														}
														?>
																
														<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
															<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
															</a>
														</div>

														<?php
														$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
														$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
														$ToplamPuanVeri = $ToplamPuan->rowCount();
														$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
														if ($ToplamPuanVeri>0) {
														?>
															<?php
															$ToplamPuan=0;
															$KisiSayisi=$ToplamPuanVeri;
															foreach ($ToplamPuanKayitlar as $Puanlar) {
																$ToplamPuan+= $Puanlar["Puan"];
															}
																$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
															?>
															
															<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
														<?php
														}else{		
														?>
															<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
														<?php
														}
														?>
														
														<?php
														$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
														$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
														$OyunPlatformSayi = $OyunPlatform->rowCount();
														$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
														if ($OyunPlatformSayi>0) {
														?>
															<div class="col-12  mt-1 p-0" >
																<?php
																foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
																?>
																	<?php echo Platform($OyunPlatform["PlatformId"])?>
																<?php		
																}
																?>
															</div>
														<?php
														}
														?>
														</div>
													</div>
												<?php
												}
											}else{
												$Oyun++;
												$dizi[]=$kayitlar["id"];
											?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold ram font20"></i>
														</div>
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}
									}else{
										if ($MinimumBellekPuan!="") {
											if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
												$Oyun++;
												$dizi[]=$kayitlar["id"];
												?>
												<div class="col-6 col-md-4 col-xl-3 mb-5 ">
													<div class="row p-2">
													<?php
													if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
													?>
														<div class="col-12 p-0" style="background: black">
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
															</a>
														</div>
														<div class="col-12 mt-2 position-absolute">
														<i class="fas fa-info-circle white bold direcxt font20"></i>
														</div>
														
													<?php
													}else{
													?>
														<div class="col-12 p-0  "  >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
																<img src="images/resim.jpg" class="img-fluid oyunlar" >
															</a>
														</div>
													<?php
													}
													?>
															
													<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
														<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
														</a>
													</div>

													<?php
													$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
													$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
													$ToplamPuanVeri = $ToplamPuan->rowCount();
													$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
													if ($ToplamPuanVeri>0) {
													?>
														<?php
														$ToplamPuan=0;
														$KisiSayisi=$ToplamPuanVeri;
														foreach ($ToplamPuanKayitlar as $Puanlar) {
															$ToplamPuan+= $Puanlar["Puan"];
														}
															$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
														?>
														
														<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
													<?php
													}else{		
													?>
														<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
													<?php
													}
													?>
													
													<?php
													$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
													$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
													$OyunPlatformSayi = $OyunPlatform->rowCount();
													$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
													if ($OyunPlatformSayi>0) {
													?>
														<div class="col-12  mt-1 p-0" >
															<?php
															foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
															?>
																<?php echo Platform($OyunPlatform["PlatformId"])?>
															<?php		
															}
															?>
														</div>
													<?php
													}
													?>
												</div>
												</div>
											<?php
											}
										}else{
											$Oyun++;
											$dizi[]=$kayitlar["id"];
										
										?>
											<div class="col-5 col-md-4 col-xl-3 mb-5 ">
												<div class="row p-2">
												<?php
												if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
												?>
													<div class="col-12 p-0" style="background: black">
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img  src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]); ?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid lazy oyunlar wWfVCA a">
														</a>
													</div>
													<div class="col-12 mt-2 position-absolute">
													<i class="fas fa-info-circle white bold drtxram font20"></i>
													</div>
												<?php
												}else{
												?>
													<div class="col-12 p-0  "  >
														<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
															<img src="images/resim.jpg" class="img-fluid oyunlar" >
														</a>
													</div>
												<?php
												}
												?>
														
												<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
													<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
														<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
													</a>
												</div>

												<?php
												$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
												$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
												$ToplamPuanVeri = $ToplamPuan->rowCount();
												$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
												if ($ToplamPuanVeri>0) {
												?>
													<?php
													$ToplamPuan=0;
													$KisiSayisi=$ToplamPuanVeri;
													foreach ($ToplamPuanKayitlar as $Puanlar) {
														$ToplamPuan+= $Puanlar["Puan"];
													}
														$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
													?>
													
													<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
												<?php
												}else{		
												?>
													<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
												<?php
												}
												?>
												
												<?php
												$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
												$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
												$OyunPlatformSayi = $OyunPlatform->rowCount();
												$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
												if ($OyunPlatformSayi>0) {
												?>
													<div class="col-12  mt-1 p-0" >
														<?php
														foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
														?>
															<?php echo Platform($OyunPlatform["PlatformId"])?>
														<?php		
														}
														?>
													</div>
												<?php
												}
												?>
											</div>
											</div>
										<?php
										}
									}

								?>
								<?php
								}
							}
						}
					}
				}
			}
		}
		?>

		
		
		<?php
		if($Oyun==0){
		?>
		<div class="col-12 col-xl-11"  >
			<div class="row justify-content-center  align-items-center  wWfVCA ">
				<div class="col-12  text-center  mb-2" >
					<img src="images/logo.png" class="img-fluid" style="opacity: 0.1; width: 350px;height: 350px">
				</div>
				<div class="col-12 position-absolute text-center  mb-2" >
					<div class="row justify-content-center">
						<div class="col-12 col-xl-8">
							<h5 class="white">Sisteminize uygun oyun bulamadık. Umarım gözden kaçırmıyoruzdur. Gözden kaçırdığımız bir şey varsa bunu bize iletişim kısmından bildirebilirsin.</h5>
						</div>
						<div class="col-12 mt-2">
							<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
								<button class="call-to-action2 p-0" style="height: 50px " >
									<div>
									    <div>Anasayfa</div>
									</div>
								</button>
							</a>
						</div>
					</div>
				</div>						
			</div>
		</div>
		<?php
		}
		?>

	<?php
	}else{
	?>

	<div class="col-11 col-xl-11"  >
		<div class="row justify-content-center  align-items-center ml-1 wWfVCA ">
			<div class="col-12  text-center  mb-2" >
				<img src="images/logo.png" class="img-fluid" style="opacity: 0.1; width: 350px;height: 350px">
			</div>
			<div class="col-12 position-absolute text-center  mb-2" >
				<div class="row justify-content-center">
					<div class="col-12 col-xl-8">
						<h5 class="white">Sisteminize uygun oyun bulamadık. Umarım gözden kaçırmıyoruzdur. Gözden kaçırdığımız bir şey varsa bunu bize iletişim kısmından bildirebilirsin.</h5>
					</div>
					<div class="col-12 mt-2">
						<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
							<button class="call-to-action2 p-0" style="height: 50px " >
								<div>
								    <div>Anasayfa</div>
								</div>
							</button>
						</a>
					</div>
				</div>
			</div>						
		</div>
	</div>
	<?php
	}
	?>
	</div>
<?php
}else{
include '../../settings/connect.php';
	header("location:" .$SiteLink);
  exit();
}
}else{
include '../../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
?>






