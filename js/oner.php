<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if(Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		$SistemKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar WHERE UyeId=? LIMIT 1");
		$SistemKontrol->execute([Guvenlik($KullaniciId)]);
		$SistemKontrolVeri = $SistemKontrol->rowCount();
		$SistemKontrolKayitlar = $SistemKontrol->fetch(PDO::FETCH_ASSOC);
		if ($SistemKontrolVeri>0) {
			if ($SistemKontrolKayitlar["IsletimSistemiId"]!="" and $SistemKontrolKayitlar["IslemciId"]!="" and $SistemKontrolKayitlar["EkranKartiId"]!=""  and $SistemKontrolKayitlar["RamId"]!=""  and $SistemKontrolKayitlar["DirectxId"]!="") {
	
		
				if(isset($_POST["j"])){
					$Jeton = Guvenlik($_POST["j"]);
				}else{	
					$Jeton="";
				}
				if(isset($_POST["i"])){
					$Sıralama = Guvenlik($_POST["i"]);
				}else{	
					$Sıralama="";
				}

				if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
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
						$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=12  and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC ");
					}else if ($Sıralama== 9){
						$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=7  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
					}else if ($Sıralama== 10){
						$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=11 and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC ");
					}else if ($Sıralama== 11){
						$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE oyunkategorileri.KategoriId=4  and oyunlar.Durum=1   ORDER BY oyunlar.CikisTarihi DESC ");
					}else{
						$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=1 ORDER BY oyunlar.CikisTarihi DESC ");
					}
					$Oyunlar->execute();
					$OyunlarVeri = $Oyunlar->rowCount();
					$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
					$Oyun=0;
					$dizi =array();
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
										$KullaniciIsletimSistemiPuan!= "" and $KullaniciIslemciMarka!= "" and $KullaniciIslemciPuan!= "" and $IslemciMarka!="" and $IslemciPuan!="" and $IslemciAdi!= "" and $KullaniciEkranKartiMarka!= "" and $KullaniciEkranKartiPuan!= "" and $EkranKartiMarka!="" and $EkranKartiPuan!="" and $EkranKartiAdi!="") {

										if ( ($KullaniciIsletimSistemiMarka == $IsletimSistemiMarka) and ($KullaniciIsletimSistemiPuan >= $IsletimSistemiPuan) ) {
											if (($KullaniciIslemciMarka == $IslemciMarka) and  ($KullaniciIslemciPuan >= $IslemciPuan) ) {
												if (($KullaniciEkranKartiMarka == $EkranKartiMarka) and ($KullaniciEkranKartiPuan >= $EkranKartiPuan)) {
													if ($MinimumDirectxPuan!="") {
														if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
															if ($KullaniciBellekPuan!="") {
																if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																	$Oyun++;
																	$dizi[]=$kayitlar["id"];	
																}
															}else{
																$Oyun++;
																$dizi[]=$kayitlar["id"];
															}
														}
													}else{
														if ($MinimumBellekPuan!="") {
															if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																$Oyun++;
																$dizi[]=$kayitlar["id"];
																
															}
														}else{
															$Oyun++;
															$dizi[]=$kayitlar["id"];
														
														}
													}

												
												}else if ( ($EkranKarti2Marka!="") and ($KullaniciEkranKartiMarka == $EkranKarti2Marka) and ( $EkranKarti2Puan!="") and ($KullaniciEkranKartiPuan >= $EkranKarti2Puan) ) {
												
													if ($MinimumDirectxPuan!="") {
														if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
															if ($KullaniciBellekPuan!="") {
																if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																	$Oyun++;
																	$dizi[]=$kayitlar["id"];
																
																}
															}else{
																$Oyun++;
																$dizi[]=$kayitlar["id"];
															
															}
														}
													}else{
														if ($MinimumBellekPuan!="") {
															if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																$Oyun++;
																$dizi[]=$kayitlar["id"];
																
															}
														}else{
															$Oyun++;
															$dizi[]=$kayitlar["id"];
														
														}
													}

												
												}
												
											}else if (($Islemci2Marka!="") and ($KullaniciIslemciMarka == $Islemci2Marka) and ($Islemci2Puan!="") and  ($KullaniciIslemciPuan >= $Islemci2Puan) ) {
												if (($KullaniciEkranKartiMarka == $EkranKartiMarka) and $KullaniciEkranKartiPuan >= $EkranKartiPuan) {
												
													if ($MinimumDirectxPuan!="") {
														if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
															if ($KullaniciBellekPuan!="") {
																if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																	$Oyun++;
																	$dizi[]=$kayitlar["id"];
																
																}
															}else{
																$Oyun++;
																$dizi[]=$kayitlar["id"];
															
															}
														}
													}else{
														if ($MinimumBellekPuan!="") {
															if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																$Oyun++;
																$dizi[]=$kayitlar["id"];
																
															}
														}else{
															$Oyun++;
															$dizi[]=$kayitlar["id"];
														
														}
													}

												
											}else if ( ($EkranKarti2Marka!="") and ($KullaniciEkranKartiMarka == $EkranKarti2Marka) and ( $EkranKarti2Puan!="") and ($KullaniciEkranKartiPuan >= $EkranKarti2Puan) ) {
												
													if ($MinimumDirectxPuan!="") {
														if ($KullaniciDirectxPuan>=$MinimumDirectxPuan) {
															if ($KullaniciBellekPuan!="") {
																if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																	$Oyun++;
																	$dizi[]=$kayitlar["id"];
																
																}
															}else{
																$Oyun++;
																$dizi[]=$kayitlar["id"];
															
															}
														}
													}else{
														if ($MinimumBellekPuan!="") {
															if ($KullaniciBellekPuan>=$MinimumBellekPuan) {
																$Oyun++;
																$dizi[]=$kayitlar["id"];
																
															}
														}else{
															$Oyun++;
															$dizi[]=$kayitlar["id"];
														
														
														}
													}

												
												}
											}
										}
									}
								}
							}
						}
						if ($Oyun>0) {
								
							$sonuc= mt_rand(1,count($dizi)-1);
							$ID= $dizi[$sonuc];

							$OneriOyun = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=? and Durum=1  LIMIT 1");	
							$OneriOyun->execute([$ID]);
							$OneriOyunVeri = $OneriOyun->rowCount();
							$OneriOyunKayitlar = $OneriOyun->fetch(PDO::FETCH_ASSOC);
							if ($OneriOyunVeri>0) {
								$Data = [
									'statu' => "success",
									'game' => $OneriOyunKayitlar["OyunUniqid"],
									'img' => $OneriOyunKayitlar["AnaResim"],
									'name' => SEO(IcerikTemizle($OneriOyunKayitlar["OyunAdi"])),
									'gamename' => IcerikTemizle($OneriOyunKayitlar["OyunAdi"]),

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
								'statu' => "null",
							];
							echo json_encode($Data); 
							exit();	
					}
				}else{
		
				}
				
			}else{
		
			}

		}else{
		
		}	
	}else{
		
	}
}else{
	
}			

?>