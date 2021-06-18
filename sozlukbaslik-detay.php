<?php
require_once("settings/connect.php");
if( isset($_GET["ID"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

$ID=SayfaNumarasiTemizle(Guvenlik($_GET["ID"]));
$BaslikKontrol =  $DatabaseBaglanti->prepare("SELECT uyeler.id,uyeler.KullaniciAdi as kullaniciadi, sozlukyazilar.id, sozlukyazilar.UyeId, sozlukyazilar.KategoriId, sozlukyazilar.Baslik, sozlukyazilar.Goruntulenme, sozlukyazilar.Tarih, sozlukyazilar.IpAdresi, sozlukyazilar.Durum, uyeler.SilinmeDurumu FROM sozlukyazilar INNER JOIN uyeler ON sozlukyazilar.UyeId = uyeler.id WHERE uyeler.SilinmeDurumu=? and sozlukyazilar.id=? and sozlukyazilar.Durum=? LIMIT 1");
$BaslikKontrol->execute([0,$ID,1]);
$BaslikKontrolVeri = $BaslikKontrol->rowCount();
$BaslikKontrolKayitlar = $BaslikKontrol->fetch(PDO::FETCH_ASSOC);
if ($BaslikKontrolKayitlar>0) {

		if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
			if ($BaslikKontrolKayitlar["UyeId"] != $KullaniciId) {
				$Goruntulenme = $DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET Goruntulenme=Goruntulenme+1 WHERE id=? AND Durum=? LIMIT 1");
				$Goruntulenme->execute([$ID,1]);
				$GunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE id=? AND Durum=? LIMIT 1");
				$GunlukGoruntulenme->execute([$ID,1]);
			}
		}else{
			$Goruntulenme = $DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET Goruntulenme=Goruntulenme+1 WHERE id=? AND Durum=? LIMIT 1");
			$Goruntulenme->execute([$ID,1]);
			$GunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE id=? AND Durum=? LIMIT 1");
			$GunlukGoruntulenme->execute([$ID,1]);
		}



$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi =12;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT uyeler.id, sozlukyorumlar.id, sozlukyorumlar.YaziId, sozlukyorumlar.UyeId, sozlukyorumlar.Yorum, sozlukyorumlar.Begeni, sozlukyorumlar.Tarih, sozlukyorumlar.IpAdresi, sozlukyorumlar.Durum, uyeler.SilinmeDurumu, uyeler.AdSoyad,uyeler.KullaniciAdi as kullaniciadi , uyeler.Durum FROM sozlukyorumlar INNER JOIN uyeler ON sozlukyorumlar.UyeId = uyeler.id WHERE  sozlukyorumlar.Durum=? and uyeler.SilinmeDurumu=? and sozlukyorumlar.YaziId=?  ORDER BY sozlukyorumlar.Begeni DESC");
$ToplamKayitSorgu->execute([1,0,$ID]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	

?>
<div class="col-12 mt-5" >
	<div class="row">
		<div class="col-2 d-none d-md-block">
			<div class="row">
			<?php
			$BannerSorgu2 = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
			$BannerSorgu2->execute([42,1]);
			$Data2 = $BannerSorgu2->rowCount();
			$Banner2 = $BannerSorgu2->fetch(PDO::FETCH_ASSOC);
			if ($Data2>0) {	
			?>		
				<?php echo IcerikTemizle($Banner2["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme2->execute([Guvenlik($Banner2["id"])]);	
				?>	
			<?php
			}
			?>
			</div>
		</div>
		<div class="col-12 col-md-8">
			<div class="row">
				<div class="col-12">
					<div class="row">
						<div class="col-12 mb-3">
							<div class="row">
								<div class="col-12" >
									<div class="row  align-items-center">
										<div class="col-12 col-md-6 ">
											<div class="row justify-content-center align-items-center">
												<div class="col-12 text-left"><h5 class="bold white"><?php echo IcerikTemizle($BaslikKontrolKayitlar["Baslik"]); ?></h5></div>
												<div class="col-12 agbf"><span><?php echo TarihCevir(IcerikTemizle($BaslikKontrolKayitlar["Tarih"])) ?> - <?php echo IcerikTemizle($BaslikKontrolKayitlar["kullaniciadi"]); ?> </span></div>
												
											</div>
										</div>
										<div class="col-11 col-md-6 ">
											<div class="row">
												<div class="col-12 text-right">
													
													    <button type="button"  class="btn " style="background:#3b5998;border:none; "><a  ref=”nofollow” href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $SiteLink ?>sozlukbaslik/<?php echo SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])); ?>/<?php echo IcerikTemizle($BaslikKontrolKayitlar["id"]); ?>" target="_blank" ><i class="fab fa-facebook-f white font20 pr-1 pl-1"></i></a></button>	
                                        	            <button type="button"  class="btn " style="background:#00acee ;border:none; "><a  ref=”nofollow” href="https://twitter.com/share?url=<?php echo $SiteLink ?>sozlukbaslik/<?php echo SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])); ?>/<?php echo IcerikTemizle($BaslikKontrolKayitlar["id"]); ?>" data-title="<?php echo IcerikTemizle($BaslikKontrolKayitlar["Baslik"]); ?>" target="_blank" ><i  class="fab fa-twitter white font20 p-0 "></i></a></button>
                                                        <button type="button"  class="btn " style="background:#0088cc ;border:none; "><a  ref=”nofollow” href="https://t.me/share/url?url=<?php echo $SiteLink ?>sozlukbaslik/<?php echo SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"])); ?>/<?php echo IcerikTemizle($BaslikKontrolKayitlar["id"]); ?>&text=<?php echo IcerikTemizle($BaslikKontrolKayitlar["Baslik"]); ?>" target="_blank" ><i  class="fab fa-telegram-plane white font20 p-0 "></i></a></button>

												    
												</div>
											</div>
										</div>
									</div>
								</div>	
							</div>
						</div>
						<div class="col-12 col-md-8" >
							<div class="row p-3">
								<div class="col-12" style="background: #202020">
									<div class="row">
										<div class="col-12 mb-5 mt-4">
											<div class="row  pt-1">
											<?php
											$YaziYorum = $DatabaseBaglanti->prepare("SELECT uyeler.id, sozlukyorumlar.id, sozlukyorumlar.YaziId, sozlukyorumlar.UyeId as uyeid, sozlukyorumlar.Yorum, sozlukyorumlar.Begeni, sozlukyorumlar.Tarih, sozlukyorumlar.IpAdresi, sozlukyorumlar.Durum, uyeler.SilinmeDurumu, uyeler.AdSoyad,uyeler.KullaniciAdi as kullaniciadi, uyeler.Durum FROM sozlukyorumlar INNER JOIN uyeler ON sozlukyorumlar.UyeId = uyeler.id WHERE sozlukyorumlar.Durum=? and uyeler.SilinmeDurumu=? and sozlukyorumlar.YaziId=?  ORDER BY sozlukyorumlar.Begeni DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
											$YaziYorum->execute([1,0,$ID]);
											$YaziYorumVeri = $YaziYorum->rowCount();
											$YaziYorumKayitlar = $YaziYorum->fetchAll(PDO::FETCH_ASSOC);
											if ($YaziYorumVeri>0) {
												foreach ($YaziYorumKayitlar as $yazilar) {
											
											?>	
												<div class="col-12 mt-4" id="bys<?php echo IcerikTemizle($yazilar["id"]) ?>">
													<div class="row">												
														<div class="col-12  " >
															<p class="MBzXA_Z font13"><?php echo IcerikTemizle($yazilar["Yorum"]) ?></p>
														</div>
													
														<div class="col-12 ">
															<div class="row justify-content-center align-items-center">
																<div class="col-12 ">
																	<div class="row">
																		<div class="col-12">
																			<div class="row justify-content-start align-items-center">
																			<?php
																			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
																			?>
																				<?php
																				if ($yazilar["uyeid"]!= $KullaniciId) {
																				?>
																					<?php
																					$BegeniKontrol = $DatabaseBaglanti->prepare("SELECT * FROM  sozlukyorumbegeni WHERE YorumId=? and UyeId=? LIMIT 1 " );
																					$BegeniKontrol->execute([Guvenlik($yazilar["id"]),Guvenlik($KullaniciId)]);
																					$BegeniKontrolVeri = $BegeniKontrol->rowCount();
																					$BegeniKontrolKayitlar = $BegeniKontrol->fetch(PDO::FETCH_ASSOC);
																					if ($BegeniKontrolVeri>0) {
																					?>
																						<div class="col-2" id="b<?php echo IcerikTemizle($yazilar["id"]) ?>">
																						<i  style="color: #c28f2c; cursor:pointer;" class="fas fa-chevron-up bold white yb" id="<?php echo IcerikTemizle($ID); ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($yazilar["id"]); ?>" title="Beğenmedim"></i>
																						</div>
																					<?php
																					}else{
																					?>
																						<div class="col-2" id="b<?php echo IcerikTemizle($yazilar["id"]) ?>">
																							<i style="cursor:pointer" class="fas fa-chevron-up bold white yb" id="<?php echo IcerikTemizle($ID); ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>"  data="<?php echo IcerikTemizle($yazilar["id"]); ?>"   title="Beğendim"></i>
																						</div>
																					<?php
																					}
																					?>
																				<?php
																				}
																				?>
																			<?php
																			}else{
																			?>
																				<div class="col-2">
																					<a href="girisyap"><i class="fas fa-chevron-up bold white" title="Beğendim"></i></a>	
																				</div>
																			<?php
																			}
																			?>
																			
																			<?php
																			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){

																			?>	
																				<?php
																				if ($yazilar["uyeid"]== $KullaniciId) {
																				?>
																					<div class="col-12 font10 text-right font12  ">
																						<span class="bold white ys" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($yazilar["id"]); ?>"  style="cursor:pointer;"><i style="color:#c28f2c"  class="fas fa-trash-alt white"></i> Yorumu Sil</span>
																					</div>
																				<?php
																				}else{
																				?>
																					<div class="col-10   text-right">
																						<span class="bold white font12 yse" data="<?php echo IcerikTemizle($yazilar["id"]); ?>" data-toggle="modal" data-target="#yse<?php echo IcerikTemizle($yazilar["id"]); ?>"  style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-flag white"></i> Şikayet Et</span>
																					</div>
																					<div  class="modal fade mt-5" id="yse<?php echo IcerikTemizle($yazilar["id"]); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
																					<div class="modal-dialog" role="document">
																						<div class="modal-content" style="background: #202020">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																									<span aria-hidden="true" class="white">&times;</span>
																								</button>
																							</div>
																							<div class="modal-body">
																								<div class="col-12 text-center  mt-2 yss"></div>
																								<div class="col-12 text-center ysb mt-2"></div>
																								<form class="hesabim" id="yg<?php echo IcerikTemizle($yazilar["id"]); ?>" method="post" action="javascript:void(0);" >
																									<div class="col-12 mt-2">
																										<div class="col-12 text-left p-0 white bold font13"  >Şikayetiniz <span class="red font11 bold">(Zorunlu)</span></div>      
																										<textarea type="text"class="hbdxzzb_" name="Sikayet" maxlength="250" ></textarea>
																										<input type="hidden" name="sys" value="<?php echo IcerikTemizle($yazilar["id"]); ?>">
																										<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>">
																										<span class="highlight"></span>
																										<span class="bar"></span> 
																										<div class="bold  font13"style="color:#585858" >Maksimum 250 karakter</div>
																									</div>
																									<div class="col-12  mt-3 mb-3  p-0  text-center  " >
																										<button class="call-to-action2  yseb" data="<?php echo IcerikTemizle($yazilar["id"]); ?>" >
																											<div>
																												<div>Gönder</div>
																											</div>
																										</button>
																									</div>	
																								</form>
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
																				<div class="col-10 text-right">
																					<a href="girisyap"><span class="bold white font12 " style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-flag white"></i> Şikayet Et</span></a>
																				</div>
																			<?php
																			}
																			?>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-12 ">
																	<div class="row justify-content-center align-items-center ">
																		<div class="col-12">
																			<span class="bxzj font11"><?php echo TarihCevir(IcerikTemizle($yazilar["Tarih"])); ?></span>
																			<span class="bxzj font11"> - <?php echo IcerikTemizle($yazilar["kullaniciadi"]); ?></span>
																		</div>
																	
																	</div>
																</div>
															</div>
																
															
														</div>
													</div>
												</div>
											<?php
											}
										}else{
										?>
											<div class="col-12 " >
												<div class="row justify-content-center align-items-center ">
													<div class="col-12 text-center mb-2">
														<img src="images/logo.png" class="img-fluid tznzuy7YQ">
													</div>
													<div class="col-12 position-absolute text-center mb-2">
														<div class="row justify-content-center">
															<div class="col-12 ">
																<h5 class="white">Henüz yorum yapılmamış.</h5>
															</div>
															<div class="col-12 mt-2">
																<a href="<?php echo IcerikTemizle($SiteLink);  ?>">
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
										</div>
										<?php
										if($SayfaSayisi>1){
										?>
										<div class="col-12 text-center mt-3 mb-3  p-0"  >
							 			<?php
							 			if($Sayfalar>1 ){
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukbaslikara/".SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"]))."/1/".$ID."'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
							 				$SayfaGeri = $Sayfalar-1;
 											echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukbaslikara/".SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"]))."/".$SayfaGeri."/".$ID."'> <i class='fas fa-caret-left'></i></a></span>";
							 				
							 			}
							 			for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
							 				if( ($i>0)  and ($i<=$SayfaSayisi)  ){
												if($Sayfalar==$i){
							 						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

												}else{
													echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='sozlukbaslikara/".SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"]))."/". $i . "/".$ID."'>".$i."</a></span>";
												}
							 				}
							 			}
							 					
							 			if($Sayfalar!=$SayfaSayisi){
							 				$SayfaIleri = $Sayfalar+1;
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='sozlukbaslikara/".SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"]))."/".$SayfaIleri."/".$ID."'><i class='fas fa-caret-right'></i></a></span>";	
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='sozlukbaslikara/".SEO(IcerikTemizle($BaslikKontrolKayitlar["Baslik"]))."/". $SayfaSayisi . "/".$ID."'> <i class='fas fa-caret-right'></i><i class='fas fa-caret-right'></i> </a></span>";
							 			}
							 			?>
										</div>
										<?php
										}
										?>
									</div>
								</div>
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){

								?>
								<div class="col-12 mt-4" style="background: #202020">
									<div class="row">
										<div class="col-12 mt-4">
											<span class="bold white font15"><?php echo IcerikTemizle($KullaniciAdi); ?></span>
										</div>
										<div class="col-12 mt-2 mb-4 text-center haberYorum">
											<form id="by"action="javascript:void(0);" method="post">
												<div class="group2">
													<div id="bys" class="text-left"></div>
													<textarea name="Yorum" placeholder="Yorumunuzu yazın..." ></textarea>  
													<input type="hidden" name="b" value="<?php echo IcerikTemizle($ID);?>">
													<input type="hidden" name="s" value="<?php echo IcerikTemizle($SayfaSayisi);?>"> 
													<input type="hidden" name="k" value="<?php echo IcerikTemizle($ToplamKayitSayisi);?>"> 
													<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]);?>"> 
													
													<span class="highlight"></span>
													<span class="bar"></span>
												</div>
												<div class="col-12 p-0  mt-3 text-right  ygb">
													<button class="call-to-action2 byb" type="submit">
														<div>
															<div>Gönder</div>
														</div>
													</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								<?php
								}else{
								?>
								<div class="col-12 mt-4" style="background: #202020">
									<div class="row">
										<div class="col-12 mt-4">
											<span class="bold white font15">Yorum yapmak için <a href="girisyap"><span style="color:#c28f2c">giriş</span></a> yapınız.</span>
										</div>
										<div class="col-12 mt-2 mb-4 text-center haberYorum">
											<div class="group2">
												<div class="text-left"></div>
												<textarea placeholder="Yorumunuzu yazın..." ></textarea>  
												<span class="highlight"></span>
												<span class="bar"></span>
											</div>
											<div class="col-12 p-0  mt-3 text-right  ygb">
												<a href="girisyap"><button class="call-to-action2 byb" type="submit">
													<div>
														<div>GİRİŞ YAP</div>
													</div>
												</button></a>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>	
							</div>
						</div>
						<div class="col-12 col-md-4" >
							<div class="row p-3"> 
							<?php
							$Gundem = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE Durum=? and GunlukGoruntulenme>?  ORDER BY GunlukGoruntulenme DESC  LIMIT 6" );
							$Gundem->execute([1,0]);
							$GundemVeri = $Gundem->rowCount();
							$GundemKayitlar = $Gundem->fetchAll(PDO::FETCH_ASSOC);
							if ($GundemVeri>0) {
							?>
							<div class="col-12 mb-4 " style="background: #202020">
								<div class="row ">
									<div class="col-12 mt-2 cbny">
										<h5 class="white bold p-1">Gündem </h5>
									</div>
									<?php
									foreach ($GundemKayitlar as $gundembilgiler) {
										$KategoriAdi = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=?   and Durum=? LIMIT 1" );
										$KategoriAdi->execute([Guvenlik($gundembilgiler["KategoriId"]),1]);
										$KategoriAdiVeri = $KategoriAdi->rowCount();
										$KategoriAdiKayitlar = $KategoriAdi->fetch(PDO::FETCH_ASSOC);
											
										$UyeBilgi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? LIMIT 1" );
										$UyeBilgi->execute([Guvenlik($gundembilgiler["UyeId"])]);
									    $UyeBilgiKayitlar = $UyeBilgi->fetch(PDO::FETCH_ASSOC);
									?>	
										<div class="col-12">
											<div class="row justify-content-center align-items-center mt-3 mb-3">
												<div class="col-12  ">
													<a href="sozlukbaslik/<?php echo SEO(IcerikTemizle($gundembilgiler["Baslik"])) ?>/<?php echo IcerikTemizle($gundembilgiler["id"]) ?>">
														<h6 class="bold xbzsWyT m-0"><?php echo IcerikTemizle($gundembilgiler["Baslik"]); ?></h6>
													</a>
												</div>
												<div class="col-12 text-left">
													<span class="bxzj szlbka"><?php echo TarihCevir(IcerikTemizle($gundembilgiler["Tarih"])); ?> - <?php echo IcerikTemizle($UyeBilgiKayitlar["KullaniciAdi"]); ?></span>
												</div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
							<?php
							}
							?> 
							
							<div class="col-11 col-md-12  p-0 text-center">
								<div class="fb-page " data-href="<?php echo IcerikTemizle($Facebook) ?>" data-width="400" data-hide-cover="false"data-show-facepile="false"></div>
							</div>
							<div class="col-11 col-md-12 mt-3 p-0 text-center mb-4" >
								<div class="row justify-content-start">
									<div class="col-12">
										<img src="images/twitterarka.jpg" class="img-fluid opacity07" >
									</div>
									<div class="col-12 position-absolute">
										<div class="row p-2" >
											<div class="col-12 m-0 text-left"><img src="images/twitterlogo.jpg" class="img-fluid ewrlj"> <span class="bold white font16">Roak Game</span></div>
											<div class="col-12 text-left mt-4">
												<a  ref="nofollow" href="https://twitter.com/roakgame?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Takip Et @roakgame</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
											</div>
										</div>
									</div>
									
								</div>
							</div>
								<div class="col-12 d-none d-md-block" >
									<div class="row text-center">
									<?php
									$BannerSorgu3 = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
									$BannerSorgu3->execute([46,1]);
									$Data3 = $BannerSorgu3->rowCount();
									$Banner3 = $BannerSorgu3->fetch(PDO::FETCH_ASSOC);
									if ($Data3>0) {	
									?>		
										<?php echo IcerikTemizle($Banner2["BannerKodu"]); ?> 
										<?php
										$BannerGuncelleme3=$DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
										$BannerGuncelleme3->execute([IcerikTemizle($Banner3["id"])]);	
										?>	
									<?php
									}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-2 d-none d-md-block">
			<div class="row">
			<?php
			$BannerSorgu2 = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
			$BannerSorgu2->execute([43,1]);
			$Data2 = $BannerSorgu2->rowCount();
			$Banner2 = $BannerSorgu2->fetch(PDO::FETCH_ASSOC);
			if ($Data2>0) {	
			?>		
				<?php echo IcerikTemizle($Banner2["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme2->execute([IcerikTemizle($Banner2["id"])]);	
				?>	
			<?php
			}
			?>
			</div>
		</div>
	</div>
</div>

<?php
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
	if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
		if ($Zaman>=$KullaniciYorumBanTarih) {
			$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
			$BanKaldir->execute([0,NULL,$KullaniciId]);
			$BanKaldirSayisi = $BanKaldir->rowCount();

			if ($BanKaldirSayisi>0) {
				header("Refresh:0");
				exit();

			}
		}
	}
?>
 	<script src="assets/main_s=8.1.9.js"></script>

<?php
}
?>

<script type="text/javascript">
$('body').on('click' , '.dvm', function() {
	i =  $(this).attr('data'); 
	if (i!="") {
		$('#y'+i).removeClass("sozsXzv");
		$('.d'+i).remove();
	}
});
</script>
<?php
}else{
	header("location:" .$SiteLink);
	exit();
} 
}else{
	header("location:" .$SiteLink);
	exit();
} 
?>