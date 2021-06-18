<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( sozlukyazilar.Baslik LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
} 

$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 7;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT sozlukyazilar.UyeId, sozlukyazilar.id as yaziid, sozlukyazilar.Durum, sozlukyazilar.IpAdresi, sozlukyazilar.Tarih, sozlukyazilar.Goruntulenme, sozlukyazilar.Baslik, sozlukyazilar.KategoriId, uyeler.id, uyeler.SilinmeDurumu FROM sozlukyazilar INNER JOIN uyeler ON sozlukyazilar.UyeId = uyeler.id WHERE sozlukyazilar.Durum=? and uyeler.SilinmeDurumu=?  $AramaSecimi ORDER BY sozlukyazilar.id DESC   ");
$ToplamKayitSorgu->execute([1,0]);
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
			$BannerSorgu2->execute([40,1]);
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
									<div class="row justify-content-center align-items-center ">
										<div class="col-12 col-md-9 text-left mt-1">
											<h5 class="bold white">RoakGame <span style="color: #c28f2c">Sözlük</span></h5>
										</div>
										<div class="col-12 col-md-3 text-right mt-1 " >
										<?php
										if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
										?>
											<button data-toggle="modal" data-target="#baslik" type="button" class="btn btn-warning sbzXz bold font13"><i class="fas fa-edit"></i> Başlık Oluştur</button>
										<?php
										}
										?>
										</div>
									</div>
								</div>	
							</div>
						</div>
						<div class="col-12 col-md-8" >
							<div class="row p-1">
								<div class="col-12" style="background: #202020">
									<div class="row">
										<div class="col-12 mt-3 mb-2 text-right">
											<form action="sozluk" method="post" > 
												<input placeholder="Başlık Ara..." type="search" name="Ara" class="p-3 sadvAz" >
											</form>
										</div>
										<div class="col-12 mb-5">
											<div class="row p-1 pt-1" >
											<?php
											$SonYazilar = $DatabaseBaglanti->prepare("SELECT sozlukyazilar.UyeId, sozlukyazilar.id as yaziid, sozlukyazilar.Durum, sozlukyazilar.IpAdresi, sozlukyazilar.Tarih, sozlukyazilar.Goruntulenme, sozlukyazilar.Baslik, sozlukyazilar.KategoriId, uyeler.id,uyeler.KullaniciAdi as kullaniciadi, uyeler.SilinmeDurumu FROM sozlukyazilar INNER JOIN uyeler ON sozlukyazilar.UyeId = uyeler.id WHERE sozlukyazilar.Durum=? and uyeler.SilinmeDurumu=?  $AramaSecimi ORDER BY sozlukyazilar.id DESC   LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
											$SonYazilar->execute([1,0]);
											$SonYazilarVeri = $SonYazilar->rowCount();
											$SonYazilarKayitlar = $SonYazilar->fetchAll(PDO::FETCH_ASSOC);
											if ($SonYazilarVeri>0) {
												foreach ($SonYazilarKayitlar as $yazilar) {
												$KategoriAdi = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? LIMIT 1 ");
												$KategoriAdi->execute([Guvenlik($yazilar["KategoriId"])]);
												$KategoriAdiKayitlar = $KategoriAdi->fetch(PDO::FETCH_ASSOC);
											?>	
												<div class="col-12 mt-5">
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
														$YaziYorum = $DatabaseBaglanti->prepare("SELECT uyeler.id, sozlukyorumlar.id, sozlukyorumlar.YaziId, sozlukyorumlar.UyeId, sozlukyorumlar.Yorum, sozlukyorumlar.Begeni, sozlukyorumlar.Tarih, sozlukyorumlar.IpAdresi, sozlukyorumlar.Durum, uyeler.SilinmeDurumu, uyeler.AdSoyad, uyeler.KullaniciAdi as kullaniciadi, uyeler.Durum FROM sozlukyorumlar INNER JOIN uyeler ON sozlukyorumlar.UyeId = uyeler.id WHERE sozlukyorumlar.YaziId=? and sozlukyorumlar.Durum=? and uyeler.SilinmeDurumu=? ORDER BY sozlukyorumlar.Begeni DESC  LIMIT 1" );
														$YaziYorum->execute([Guvenlik($yazilar["yaziid"]),1,0]);
														$YaziYorumVeri = $YaziYorum->rowCount();
														$YaziYorumKayitlar = $YaziYorum->fetch(PDO::FETCH_ASSOC);
														if ($YaziYorumVeri>0) {
														?>															
															<div class="col-12 ">
																<p class="MBzXA_Z font13"><?php echo IcerikTemizle($YaziYorumKayitlar["Yorum"]) ?></p>
															</div>
														
															<div class="col-12">
																<div class="row justify-content-center align-items-center">
																	<div class="col-12 text-right">
																		<div class="row justify-content-end align-items-center">
																			<div class="col-12 text-right font13" >
																				<span class="bmaqX">Kategori:</span> 
																				<span class="orqzA">
																					<?php  echo IcerikTemizle($KategoriAdiKayitlar["KategoriAdi"]); ?>	
																				</span>
																			</div>
																			<div class="col-12 font13">
																				<span class="bxzj mr-2 font13">
																					<?php echo TarihCevir(IcerikTemizle($YaziYorumKayitlar["Tarih"])); ?>
																				</span>
																				<span class="white">-</span> 
																				<span class="bxzj">
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
																<h5 class="white">Hiçbir başlık bulunamadı. Umarız en kısa zamanda başlık oluştururlar.</h5>
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
												echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukara/". $SayfalamaSecimi ."/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
								 				$SayfaGeri = $Sayfalar-1;
	 											echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='sozlukara/". $SayfalamaSecimi ."/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
											}
											for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
												if( ($i>0)  and ($i<=$SayfaSayisi)  ){
													if($Sayfalar==$i){
							 						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

													}else{
														echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='sozlukara/". $SayfalamaSecimi ."/". $i . "'>".$i."</a></span>";
													}
												}
											}
											if($Sayfalar!=$SayfaSayisi){
												
							 				$SayfaIleri = $Sayfalar+1;
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='sozlukara/". $SayfalamaSecimi ."/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
							 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='sozlukara/". $SayfalamaSecimi ."/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
											}
											?>
										</div>
										<?php
										}
										?>
									</div>
								</div>
								
								<?php
								$Kategoriler = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE Durum=?  ORDER BY id ASC  " );
								$Kategoriler->execute([1]);
								$KategorilerVeri = $Kategoriler->rowCount();
								$KategorilerKayitlar = $Kategoriler->fetchAll(PDO::FETCH_ASSOC);
								if ($KategorilerVeri>0) {
									foreach ($KategorilerKayitlar as $kategoriler) {
								?>
								<div class="col-12 mb-4 mt-4" style="background: #202020">
									<div class="row justify-content-center align-items-center ">
										<div class="col-12 text-left p-2 xzcm" >
											<a href="sozlukkategori/<?php echo SEO(IcerikTemizle($kategoriler["KategoriAdi"])) ?>/<?php echo IcerikTemizle($kategoriler["id"]) ?>">
												<h5 class="CXzda">
													<?php echo IcerikTemizle($kategoriler["KategoriAdi"]); ?>
												</h5>
											</a>
										</div>
										<?php
										$KategoriYorum=$DatabaseBaglanti->prepare("SELECT * FROM sozlukyorumlar WHERE KategoriId=? and Durum=?" );
										$KategoriYorum->execute([Guvenlik($kategoriler["id"]),1]);
										$KategoriYorumVeri=$KategoriYorum->rowCount();
										$KategoriYorumKayitlar=$KategoriYorum->fetchAll(PDO::FETCH_ASSOC);
										if ($KategoriYorumVeri>0) {
											$KategoriToplamYorum=0;
											foreach ($KategoriYorumKayitlar as $KategoriYorumlar) {
												$KategoriToplamYorum+=1;
											}
										}else{
											$KategoriToplamYorum=0;
										}
										?>	
										<div class="col-12 cbny" >
											<div class="row justify-content-center align-items-center p-2">
												<div class="col-12">
													<div class="row ">
														<div class="col-12">
															<div class="row justify-content-center align-items-center">
																<div class="col-12 col-md-6">
																	<div class="row">
																		<div class="col-12" >
																			<div class="row">
																				<div class="col-5 text-left">
																					<span class="cvxxzR">Başlık: </span>
																					<?php
																					$KategoriBaslik = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE KategoriId=? and Durum=?" );
																					$KategoriBaslik->execute([Guvenlik($kategoriler["id"]),1]);
																					$KategoriBaslikVeri = $KategoriBaslik->rowCount();
																					?>
																					<span class="cxby">
																						<?php echo IcerikTemizle(number_format_short($KategoriBaslikVeri)); ?>	
																					</span>
																				</div>
																				<div class="col-5 text-left">
																					<span class="cvxxzR">Yorum:</span>
																					<span class="cxby"><?php echo IcerikTemizle(number_format_short($KategoriToplamYorum)); ?></span>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-12 col-md-6">
																	<div class="row justify-content-center align-items-center">
																		<div class="col-12">
																			<div class="row">
																			<?php
																			$KategoriSonYorum=$DatabaseBaglanti->prepare("SELECT * FROM  sozlukyazilar WHERE KategoriId=? and Durum=? ORDER BY id DESC LIMIT 1" );
																			$KategoriSonYorum->execute([Guvenlik($kategoriler["id"]),1]);
																			$KategoriSonYorumVeri = $KategoriSonYorum->rowCount();
																			$KategoriSonYorumKayitlar = $KategoriSonYorum->fetch(PDO::FETCH_ASSOC);
																			if ($KategoriSonYorumVeri>0) {
																			    	$UyeBilgi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? LIMIT 1" );
                                            										$UyeBilgi->execute([Guvenlik($KategoriSonYorumKayitlar["UyeId"])]);
                                            									    $UyeBilgiKayitlar = $UyeBilgi->fetch(PDO::FETCH_ASSOC);
																			?>	
																				<div class="col-12">
																					<a href="sozlukbaslik/<?php echo SEO(IcerikTemizle($KategoriSonYorumKayitlar["Baslik"])) ?>/<?php echo IcerikTemizle($KategoriSonYorumKayitlar["id"]) ?>">
																						<h6 class="bold m-0 xbzsWyT">
																							<?php echo IcerikTemizle($KategoriSonYorumKayitlar["Baslik"]); ?>	
																						</h6>
																					</a>
																				</div>
																				<div class="col-12 text-left">
                                													<span class="bxzj szlbka"><?php echo TarihCevir(IcerikTemizle($KategoriSonYorumKayitlar["Tarih"])); ?> - <?php echo IcerikTemizle($UyeBilgiKayitlar["KullaniciAdi"]); ?></span>
                                												</div>
																			
																			<?php
																			}else{
																			?>
																				<div class="col-12">
																					<span class="basdX" >Henüz başlık açılmamış</span>
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
													</div>
												</div>	
											</div>
										</div>
									</div>
								</div>
								<?php
									}
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
							<div class="col-12 mb-5 " style="background: #202020">
								<div class="row ">
									<div class="col-12 mt-2 cbny" >
										<h5 class="white bold p-1">Gündem </h5>
									</div>
									<?php
									foreach ($GundemKayitlar as $gundembilgiler) {
										$KategoriAdi = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? and Durum=? LIMIT 1" );
										$KategoriAdi->execute([Guvenlik($gundembilgiler["KategoriId"]),1]);
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
						
							<div class=" col-md-12 mt-3 p-0 text-center">
								<div class="fb-page " data-href="<?php echo IcerikTemizle($Facebook) ?>" data-width="400" data-hide-cover="false"data-show-facepile="false"></div>
							</div>
							<div class=" col-md-12 mt-3 p-0 text-center mb-4" >
								<div class="row justify-content-start">
									<div class="col-12">
										<img src="images/twitterarka.jpg" class="img-fluid opacity07" >
									</div>
									<div class="col-12 position-absolute">
										<div class="row p-2" >
											<div class="col-12 m-0 text-left">
												<img src="images/twitterlogo.jpg" class="img-fluid ewrlj"> <span class="ncbk">Roak Game</span>
											</div>
											<div class="col-12 text-left mt-4">
												<a  ref=”nofollow” href="https://twitter.com/roakgame?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Takip Et @roakgame</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 d-none d-md-block" >
								<div class="row justify-content-center text-center">
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
	<div class="col-2 d-none d-md-block" >
		<div class="row">
		<?php
		$BannerSorgu2 = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
		$BannerSorgu2->execute([41,1]);
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
<div class="modal fade mt-5" id="baslik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="background: #202020">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="white">&times;</span>
				</button>
			</div>
			<div class="modal-body sbpfs">
				<div class="row justify-content-center align-items-center text-center sbps mt-2 mb-2"></div>
				<form class=" sbpf " method="post" action="javascript:void(0);">
					<div class="col-12 text-left  white bold font13" >Kategori <span class="red font11 bold">(Zorunlu)</span></div>  
					<div class="col-12 mb-3">
						<select  class="p-3 xzzeW"  name="Kategori" >
                			<option  value="">Lütfen Kategori Seçiniz.</option>
                			<?php
							$AnaKategori=$DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE  Durum=? ORDER BY id" );
							$AnaKategori->execute([1]);
							$AnaKategoriVeri = $AnaKategori->rowCount();
							$AnaKategoriKayitlar = $AnaKategori->fetchAll(PDO::FETCH_ASSOC);
							if ($AnaKategoriVeri>0) {
								foreach ($AnaKategoriKayitlar as $anakategori) {
							?>
								<option value="<?php echo IcerikTemizle($anakategori["id"])?>"><?php echo IcerikTemizle($anakategori["KategoriAdi"]);  ?></option>
							<?php
								}
							}
							?>
        				</select>
        				<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
					</div>
					<div class="col-12 text-left  white bold font13" >Başlık <span class="red font11 bold">(Zorunlu)</span></div>  
					<div class="col-12 ">
						<input type="text" class="p-3 xzzeW"  placeholder="Başlık" maxlength="150" name="Baslik">
					</div>
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center mt-2 mb-2">
							<div class="bold red font12 aa"></div>
						</div>
						<div class="col-10 ">
							<div class="g-recaptcha mb-2 text-center rpcHAZ" data-sitekey="6Lf5VHoaAAAAAMyNXUg7K_Ne6T7dzGK96o4tRnIT"></div>
						</div>
					</div>
					
					<div class="col-12 mt-3 mb-3 p-0 text-center sb">
						<button class="call-to-action2 sbp">
							<div>
								<div>Oluştur</div>
							</div>
						</button>
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>
<script src="assets/main_s=8.1.9.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>

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
?>