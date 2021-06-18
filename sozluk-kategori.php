<?php
require_once("settings/connect.php");
if( isset($_GET["ID"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){


$KategoriId=SayfaNumarasiTemizle(Guvenlik($_GET["ID"]));
$KategoriKontrol =  $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? and Durum=? LIMIT 1");
$KategoriKontrol->execute([$KategoriId,1]);
$KategoriKontrolVeri = $KategoriKontrol->rowCount();
$KategoriKontrolKayitlar = $KategoriKontrol->fetch(PDO::FETCH_ASSOC);
if ($KategoriKontrolVeri>0) {
	
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND (sozlukyazilar.Baslik LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
}

$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi =12;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT sozlukkategoriler.id  as sozlukkategorilerid, sozlukkategoriler.KategoriAdi,  sozlukkategoriler.Durum, sozlukyazilar.KategoriId, sozlukyazilar.UyeId, sozlukyazilar.id as yaziid, sozlukyazilar.Durum, uyeler.id as uyelerid, sozlukyazilar.Baslik, sozlukyazilar.Goruntulenme, sozlukyazilar.Tarih, sozlukyazilar.IpAdresi, uyeler.SilinmeDurumu FROM uyeler INNER JOIN sozlukyazilar ON uyeler.id = sozlukyazilar.UyeId INNER JOIN sozlukkategoriler ON sozlukyazilar.KategoriId = sozlukkategoriler.id WHERE sozlukyazilar.Durum=? and uyeler.SilinmeDurumu=? and  sozlukkategoriler.id=?  $AramaSecimi ORDER BY sozlukyazilar.id DESC");
$ToplamKayitSorgu->execute([1,0,$KategoriId]);
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
			$BannerSorgu2->execute([44,1]);
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
									<div class="row justify-content-center align-items-center">
										<div class="col-12  text-left">
											<h6 class="bold white">Sözlük > 
												<span style="color: #c28f2c"><?php echo IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]); ?></span>
											</h6>
										</div>
									</div>
								</div>	
							</div>
						</div>
						<div class="col-12 col-md-8" >
							<div class="row p-3">

								<div class="col-12" style="background: #202020">
									<div class="row">
										<div class="col-12 mt-3 mb-4 text-right">
											<form action="sozlukkategori/<?php echo SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"])) ?>/<?php echo IcerikTemizle($KategoriId) ?>" method="post" > 
												<input placeholder="Kategoride Başlık Ara..." type="search" name="Ara" class="p-3 sadvAz" >
											</form>
										</div>
										<div class="col-12 mb-5">
											<div class="row  pt-1">
											<?php
											$SonYazilar = $DatabaseBaglanti->prepare("SELECT sozlukkategoriler.id  as sozlukkategorilerid, sozlukkategoriler.KategoriAdi, sozlukkategoriler.Durum, sozlukyazilar.KategoriId, sozlukyazilar.UyeId, sozlukyazilar.id as yaziid, sozlukyazilar.Durum, uyeler.id as uyelerid, sozlukyazilar.Baslik, sozlukyazilar.Goruntulenme, sozlukyazilar.Tarih, sozlukyazilar.IpAdresi,uyeler.KullaniciAdi as kullaniciadi, uyeler.SilinmeDurumu FROM uyeler INNER JOIN sozlukyazilar ON uyeler.id = sozlukyazilar.UyeId INNER JOIN sozlukkategoriler ON sozlukyazilar.KategoriId = sozlukkategoriler.id WHERE sozlukyazilar.Durum=? and uyeler.SilinmeDurumu=? and  sozlukkategoriler.id=?  $AramaSecimi ORDER BY sozlukyazilar.id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
											$SonYazilar->execute([1,0,$KategoriId]);
											$SonYazilarVeri = $SonYazilar->rowCount();
											$SonYazilarKayitlar = $SonYazilar->fetchAll(PDO::FETCH_ASSOC);
											if ($SonYazilarVeri>0) {
												foreach ($SonYazilarKayitlar as $yazilar) {
												$KategoriAdi = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? LIMIT 1 ");
												$KategoriAdi->execute([Guvenlik($yazilar["KategoriId"])]);
												$KategoriAdiKayitlar = $KategoriAdi->fetch(PDO::FETCH_ASSOC);
											?>	
												<div class="col-12 mt-4">
													<div class="row">
														<div class="col-12" >
															<a href="sozlukbaslik/<?php echo SEO(IcerikTemizle($yazilar["Baslik"])) ?>/<?php echo IcerikTemizle($yazilar["yaziid"]) ?>">
																<h6 class="bold xbzsWyT m-0"><?php echo IcerikTemizle($yazilar["Baslik"]); ?></h6>
															</a>
														</div>
														<div class="col-12 font11 mb-2" >
														    <span class="bxzj ">
															<?php echo TarihCevir(IcerikTemizle($yazilar["Tarih"])); ?> - <?php echo IcerikTemizle($yazilar["kullaniciadi"]); ?>	
															</span>
														</div>
														<?php
														$YaziYorum = $DatabaseBaglanti->prepare("SELECT uyeler.id,sozlukyorumlar.id,sozlukyorumlar.YaziId, sozlukyorumlar.UyeId,sozlukyorumlar.Yorum,sozlukyorumlar.Begeni,sozlukyorumlar.Tarih, sozlukyorumlar.IpAdresi,sozlukyorumlar.Durum,uyeler.SilinmeDurumu, uyeler.AdSoyad,uyeler.KullaniciAdi as kullaniciadi, uyeler.Durum FROM sozlukyorumlar INNER JOIN uyeler ON sozlukyorumlar.UyeId = uyeler.id WHERE sozlukyorumlar.YaziId=? and sozlukyorumlar.Durum=? and uyeler.SilinmeDurumu=? ORDER BY sozlukyorumlar.Begeni DESC  LIMIT 1" );
														$YaziYorum->execute([Guvenlik($yazilar["yaziid"]),1,0]);
														$YaziYorumVeri = $YaziYorum->rowCount();
														$YaziYorumKayitlar = $YaziYorum->fetch(PDO::FETCH_ASSOC);
														if ($YaziYorumVeri>0) {
														?>															
															<div class="col-12  " >
																<p class="MBzXA_Z font13 "><?php echo IcerikTemizle($YaziYorumKayitlar["Yorum"]) ?></p>
															</div>
															
														
															<div class="col-12">
																<div class="row justify-content-center align-items-center">
																	<div class="col-12 text-right">
																		<div class="row justify-content-end align-items-center">
																			<div class="col-12 text-right">
																				<span class="bmaqX">Kategori:</span> 
																				<span class="orqzA font13">
																					<?php  echo IcerikTemizle($KategoriAdiKayitlar["KategoriAdi"]); ?> 
																				</span>
																			</div>
																			<div class="col-12">
																				<span class="bxzj font13">
																					<?php echo TarihCevir(IcerikTemizle($YaziYorumKayitlar["Tarih"])); ?>
																				</span>
																				<span class="white">-</span> 
																				<span class="bxzj font13">
																					<?php echo IcerikTemizle($YaziYorumKayitlar["kullaniciadi"]); ?>	
																				</span>
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
											}


										if($SayfaSayisi>1){
										?>
										<div class="col-12 text-center mt-3  mb-3  p-0"  >
											<?php
											if($Sayfalar>1 ){
												echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukkategoriara/".SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]))."/". $SayfalamaSecimi ."/1/". $KategoriId ."'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
								 				$SayfaGeri = $Sayfalar-1;
	 											echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukkategoriara/".SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]))."/". $SayfalamaSecimi ."/".$SayfaGeri."/". $KategoriId ."'><i class='fas fa-caret-left'></i></a></span>";
											}
											for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
												if( ($i>0)  and ($i<=$SayfaSayisi)  ){
													if($Sayfalar==$i){
							 						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

													}else{
														echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='sozlukkategoriara/".SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]))."/". $SayfalamaSecimi ."/". $i . "/". $KategoriId ."'>".$i."</a></span>";
													}
												}
											}
											if($Sayfalar!=$SayfaSayisi){
												
							 				$SayfaIleri = $Sayfalar+1;
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='sozlukkategoriara/".SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]))."/". $SayfalamaSecimi ."/".$SayfaIleri."/". $KategoriId ."'><i class='fas fa-caret-right  '></i> </a></span>";	
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='sozlukkategoriara/".SEO(IcerikTemizle($KategoriKontrolKayitlar["KategoriAdi"]))."/". $SayfalamaSecimi ."/". $SayfaSayisi . "/". $KategoriId ."'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
											}
											?>
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
																<h5 class="white">Bu kategoride açılmış başlık bulunamadı. Umarız en kısa zamanda başlık oluştururlar.</h5>
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
									</div>
								</div>
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
									<div class="col-12 mt-2 cbny" >
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
													<h6 class="bold xbzsWyT m-0 "><?php echo IcerikTemizle($gundembilgiler["Baslik"]); ?></h6>
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
											<div class="col-12 m-0 text-left"><img src="images/twitterlogo.jpg" class="img-fluid ewrlj" > <span class="ncbk">Roak Game</span></div>
											<div class="col-12 text-left mt-4">
												<a href="https://twitter.com/roakgame?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Takip Et @roakgame</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
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
										$BannerGuncelleme3 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
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
			$BannerSorgu2->execute([45,1]);
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
}else{
	header("location:" .$SiteLink);
	exit();
} 
}else{
	header("location:" .$SiteLink);
	exit();
} 
?>