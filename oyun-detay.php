<?php
if(isset($_GET["ID"])){

	$OyunId =SayfaNumarasiTemizle(Guvenlik($_GET["ID"]));	
	$OyunSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  id=? AND Durum=? LIMIT 1 ");
	$OyunSorgusu->execute([$OyunId,1]);
	$OyunSorgusuSayi = $OyunSorgusu->rowCount();
	$OyunSorgusuKayit = $OyunSorgusu->fetch(PDO::FETCH_ASSOC);

	if($OyunSorgusuSayi>0){
		$OyunGoruntulenme =  $DatabaseBaglanti->prepare("UPDATE oyunlar SET Goruntulenme=Goruntulenme+1  WHERE  id=? AND Durum=? LIMIT 1 ");
		$OyunGoruntulenme->execute([$OyunId,1]);
		$OyunGoruntulenmeSayisi = $OyunGoruntulenme->rowCount();
	?>

	<?php
	$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=?");
	$BannerUst->execute([13,1]);
	$BannerUstVeri = $BannerUst->rowCount();
	$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
	if ($BannerUstVeri>0) {	
	?>
	<div class="col-12  mb-5  mt-5">
		<div class="row justify-content-center align-items-center text-center"  >	
			<div class="col-12">			
				<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 			
				<?php
				$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme->execute([13]);	
				?>		
			</div>	
		</div>
	</div>
	<?php
	}
	?>	

	<?php
	$OyunResimler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunresimler WHERE  OyunId=? ");
	$OyunResimler->execute([$OyunId]);
	$OyunResimlerVeri = $OyunResimler->rowCount();
	$OyunResimlerKayitlar = $OyunResimler->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunResimlerVeri>0) {
	?>
	<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
		<div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
			<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="images/spin.svg" />
		</div>
		<div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
			<?php
			foreach ($OyunResimlerKayitlar as  $Resimler) {
			?>
				<?php
				if (IcerikTemizle($Resimler["Resim"]!="") and IcerikTemizle(isset($Resimler["Resim"])) and file_exists("images/games/".$Resimler["Resim"]) ) {
				?>	
					<div>
						<a href="images/games/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" style="overflow: hidden;"  data-lightbox="image-1" >	<img  data-u="image" src="images/games/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" class="img-fluid "/>
						</a>
					</div>
				<?php
				}else{
				?>	
					<div>
						<img  data-u="image" src="images/hata2.jpg" class="img-fluid "/>
					</div>
				<?php
				}
				?>
			<?php
			}
			?>
		</div>

		<div data-u="navigator" class="jssorb051" style="position:absolute;bottom:16px;right:16px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
			<div data-u="prototype" class="i" style="width:12px;height:12px;">
				<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
					<circle class="b" cx="8000" cy="8000" r="5800"></circle>
				</svg>
			</div>
		</div>

		<div data-u="arrowleft" class="jssora051" style="width:50px;height:50px;top:0px;left:35px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:-20;width:100%;height:100%;">
				<polyline class="a" points="11040,1920 4960,8000 11040,14080 "style="width:30px;height:30px !important"></polyline>
			</svg>
		</div>
		<div data-u="arrowright" class="jssora051" style="width:50px;height:50px;top:0px;right:35px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
			<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;
					right:-35px;width:100%;height:100%;">
				<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
			</svg>
		</div>
	</div>
	<?php
	}else{
	?>

	<?php
	}
	?>

	<div class="row m-0 justify-content-center mt-5 mb-5">
		<div class="col-xl-9 text-right mb-1">
			<div class="row">
				<div class="col-12">
				<?php
				if (IcerikTemizle($OyunSorgusuKayit["OyunSitesi"])) {
				?>
					<a class="white" target="_blank" style="color: #c28f2c" href="<?php echo IcerikTemizle($OyunSorgusuKayit["OyunSitesi"]); ?>">
						<button type="button" class="btn btn-warning bold" style="padding:3px">
						 	<span class="websitesi bold">Web Sitesine Git</span>
						</button>
					</a>
				<?php
				}else{
				?>

				<?php
				}
				?>
					<?php
					if (isset($_SESSION["Kullanici"])) {
					?>
						<?php
						$Favoriler= $DatabaseBaglanti->prepare("SELECT * FROM oyunfavoriler WHERE OyunId=? AND UyeId=? LIMIT 1");
						$Favoriler->execute([$OyunId,$KullaniciId]);
						$FavorilerSayisi = $Favoriler->rowCount();
						if ($FavorilerSayisi>0) {
						?>
							<span class="ofes<?php echo $OyunId; ?>">
								<button type="button" class="btn btn-warning ofe" style="padding:3px" data="<?php echo IcerikTemizle($OyunId); ?>" title="Favorilerden Çıkar">
									<i class="fas fa-heart bold "  style="color: white"></i>
								</button>
							</span>
							<?php
						}else{
						?>
							<span class="ofes<?php echo IcerikTemizle($OyunId); ?>">
								<button title="Favorilere Ekle" type="button" style="padding:3px" class="btn btn-warning favoriEkle  ofe" data="<?php echo $OyunId; ?>">
									<i class="far fa-heart bold"></i>
								</button>
							</span>
						<?php
						}
						?>
					<?php
					}else{
					?>
						<a class="favoriEkle" href="girisyap">
							<button type="button" style="padding:3px" class="btn btn-warning" title="Favorilere Ekle">
								<i class="far fa-heart bold"></i>
							</button>
						</a>
					<?php
					}
					?>	
				</div>
			</div>				
		</div>

		<div class="col-11 col-xl-9 aaYTbZHa">
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-12 col-xl-2 mb-4">
					<div class="row justify-content-center text-center">
					<?php
					if (file_exists("images/games/".$OyunSorgusuKayit["AnaResim"]) and ($OyunSorgusuKayit["AnaResim"])) {
					?>
						<div class="col-12 " >
							<img src="images/games/<?php echo IcerikTemizle($OyunSorgusuKayit["AnaResim"]) ?>" class="img-fluid loYtzXw odr"  >
						</div>
					<?php
					}else{
					?>
						<div class="col-12">
							<img src="images/resim.jpg" class="img-fluid loYtzXw" >
						</div>
					<?php
					}
					?>
						<div class="col-12 text-center mt-3">
							<h1 class="bold white oyunname" ><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?></h1>
						</div>
						<?php
						$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
						$ToplamPuan->execute([$OyunSorgusuKayit["id"]]);
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
					</div>
				</div>

				<div class="col-11 col-xl-9 p-0 m-0" >
					<div class="row">
						<div class="col-12 text-center"  >
						<?php
						if (IcerikTemizle($OyunSorgusuKayit["OyunHakkinda"])) {
						?>
							<p class="bold white oyunYazi">
								<?php echo IcerikTemizle($OyunSorgusuKayit["OyunHakkinda"]);?> 
							</p>
						<?php
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS">
					<div class="row justify-content-center p-3 p-xl-5">
						<div class="col-12  SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Oyun Hakkında</span>
						</div>
						<div class="col-12 mt-5" >
							<div class="row">
								<div class="col-12 col-xl-4 mb-4">
									<div class="row">
										<div class="col-12 white oyunYazi" >
											<span class="opacity05">Geliştirici</span>
										</div>
										<div class="col-12 white oyunYazi">
										<?php
										if (IcerikTemizle($OyunSorgusuKayit["Gelistirici"])){
										?>
											<span>
												<?php echo IcerikTemizle($OyunSorgusuKayit["Gelistirici"]);?>			
											</span>
										<?php
										}else{
										?>
											<span>-</span>
										<?php
										}
										?>
										</div>
									</div>
								</div>

								<div class="col-12 col-xl-4 mb-4">
									<div class="row">
										<div class="col-12 white oyunYazi" >
											<span class="opacity05 ">Yayıncı</span>
										</div>
										<div class="col-12 white oyunYazi">
										<?php
										if (IcerikTemizle($OyunSorgusuKayit["Yayinci"])) {
										?>
											<span>
												<?php echo IcerikTemizle($OyunSorgusuKayit["Yayinci"]);?>
											</span>
										<?php
										}else{
										?>
											<span>-</span>
										<?php
										}
										?>
										</div>
									</div>
								</div>

								<div class="col-12 col-xl-4 mb-4">
									<div class="row">
										<div class="col-12 white oyunYazi" >
											<span class="opacity05 ">Çıkış Tarihi</span>
										</div>
										<div class="col-12 white oyunYazi">
										<?php
										if (IcerikTemizle($OyunSorgusuKayit["CikisTarihi"])) {
										?>
											<span>
												<?php echo IcerikTemizle($OyunSorgusuKayit["CikisTarihi"]);?>
											</span>
										<?php
										}else{
										?>
											<span>-</span>
										<?php
										}
										?>
										</div>
									</div>
								</div>

								<div class="col-12 col-xl-4 mb-4">
									<div class="row">
										<div class="col-12 white oyunYazi" >
											<span class="opacity05 ">Platform</span>
										</div>
										<div class="col-12 white oyunYazi">				
										<?php
										$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
										$OyunPlatform->execute([$OyunId]);
										$OyunPlatformSayi = $OyunPlatform->rowCount();
										$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);

										if ($OyunPlatformSayi>0) {
										?>
											<div class="col-12 mt-1 p-0">
												<?php
												foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
												?>
													<?php echo Platform($OyunPlatform["PlatformId"])?>
												<?php		
												}
												?>
											</div>
										<?php
										}else{
										?>	
										<?php
										}
										?>
										</div>
									</div>
								</div>

								<?php
								$OyunHakkinda =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunaciklama WHERE  OyunId=? ");
								$OyunHakkinda->execute([$OyunId]);
								$OyunHakkindaSayi = $OyunHakkinda->rowCount();
								$OyunHakkindaKayitlar = $OyunHakkinda->fetchAll(PDO::FETCH_ASSOC);
								if ($OyunHakkindaSayi>0) {
									foreach ($OyunHakkindaKayitlar as  $Hakkinda) {
								?>
								<div class="col-12 ">
									<div class="row">
									<?php
									if ( IcerikTemizle($Hakkinda["OyunHakkindaBaslik"]) ) {
									?>	
										<div class="col-12  mt-5" >
											<h1 class="white oyunYazi bold" >
												<?php echo IcerikTemizle($Hakkinda["OyunHakkindaBaslik"]);?>
											</h1>	
										</div>
									<?php
									}
									?>
									
									<?php
									if(IcerikTemizle($Hakkinda["OyunHakkindaAciklama"]) ) {
									?>	
										<div class="col-12 white oyunYazi mt-1">
											<p style="opacity: 0.5"><?php echo IcerikTemizle($Hakkinda["OyunHakkindaAciklama"]);?></p>
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		$OyunVideolar = $DatabaseBaglanti->prepare("SELECT * FROM  oyunvideo WHERE  OyunId=? ");
		$OyunVideolar->execute([$OyunId]);
		$OyunVideolarSayi = $OyunVideolar->rowCount();
		$OyunVideolarKayitlar = $OyunVideolar->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunVideolarSayi>0) {
		?>
		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Videolar</span>
						</div>
						<div class="col-12 mt-5">
							<div class="row justify-content-center align-items-center text-center">
								<div id="demo" class="carousel slide" data-ride="carousel">
									<div class="carousel-inner">
									<?php
									$i=0;
									foreach ($OyunVideolarKayitlar as  $Video) {
									$i++;
									?>
										<?php
										if ($i==1) {
										?>
											<?php
											if ((IcerikTemizle($Video["VideoUrl"])!="") and IcerikTemizle(isset($Video["VideoUrl"]))) {
											?>
												<div class="carousel-item active">
													<iframe class="example" <?php  echo IcerikTemizle($Video["VideoUrl"]); ?> ></iframe>
												</div>
											<?php
											}	
											?>	
										<?php
										}else{
										?>
											<?php
											if ((IcerikTemizle($Video["VideoUrl"])!="") and IcerikTemizle(isset($Video["VideoUrl"]))) {
											?>
												<div class="carousel-item ">
													<iframe class="example" <?php  echo IcerikTemizle($Video["VideoUrl"]); ?> ></iframe>
												</div>
											<?php
											}	
											?>
										<?php
										}
										?>
									<?php
									}
									?>  
									</div>
									<a class="carousel-control-prev" href="#demo" data-slide="prev" >
										<span class="carousel-control-prev-icon"></span>
									</a>
									<a class="carousel-control-next" href="#demo" data-slide="next">
										<span class="carousel-control-next-icon"></span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>

		<?php
		$OyunKarakter =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=? LIMIT 4 ");
		$OyunKarakter->execute([$OyunId]);
		$OyunKarakterSayi = $OyunKarakter->rowCount();
		$OyunKarakterKayitlar = $OyunKarakter->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunKarakterSayi>0) {
		?>
		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Karakterler</span>
						</div>

						<?php
						$OyunKarakterSayisi =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=? ");
						$OyunKarakterSayisi->execute([$OyunId]);
						$KarakterVerisi = $OyunKarakterSayisi->rowCount();
						if ($KarakterVerisi>4) {
						?>
						<div class="col-12  mt-3 ">
							<div class="row p-0 justify-content-end">
								<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL  WrGYT__Xx"  >
									<a href="oyunkarakterler/<?php echo IcerikTemizle($OyunId) ?>" >
										<span class=" gxPpxXo_">DAHA FAZLA GÖSTER</span>
									</a>
								</div>
							</div>
						</div>
						<?php
						}
						?>
						<div class="col-12 mt-4" >
							<div class="row justify-content-center  text-center">
							<?php
							foreach ($OyunKarakterKayitlar as $Karakter) {
							?>
								<div class="col-6 col-xl-3 mb-4">
									<div class="row p-1">	
										<div class="col-12 p-0">
										<?php
										if (file_exists("images/games/".$Karakter["KarakterResim"]) and (isset($Karakter["KarakterResim"])) and ($Karakter["KarakterResim"]!="") ){
										?>
											<div class="col-12">
													<a  href="karakterdetay/<?php echo  SEO(IcerikTemizle($OyunId));?>/<?php echo  SEO(IcerikTemizle($Karakter["id"]));?>">
														<img src="images/games/<?php echo IcerikTemizle($Karakter["KarakterResim"]); ?>"style="border-radius: 5px" class="img-fluid "/> 
													</a>
											</div>		
										<?php
										}else{
										?>
											<div class="col-12"></div>
										<?php
										}
										?>

										<?php
										if (isset($Karakter["KarakterAdi"])) {
										?>
											<div class="col-12 mt-2 mb-1">
												<a href="karakterdetay/<?php echo  SEO(IcerikTemizle($OyunId));?>/<?php echo  SEO(IcerikTemizle($Karakter["id"]));?>">
													<span class="bold white oyunYazi "><?php echo IcerikTemizle($Karakter["KarakterAdi"]) ?></span>
												</a>
											</div>
										<?php			
										}
										?>
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
		<?php
		}
		?>

		<?php
		$OyunOduller =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunoduller WHERE  OyunId=? ");
		$OyunOduller->execute([$OyunId]);
		$OyunOdullerVerisi = $OyunOduller->rowCount();
		$OyunOdullerKayitlar = $OyunOduller->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunOdullerVerisi>0) {
		?>
		<div class="col-11 col-xl-9">
			<div class="row justify-content-center align-items-center mt-5">
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center align-items-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Ödüller</span>
						</div>
						<div class="col-12 mt-3">
							<div class="row justify-content-center align-items-center">
							<?php
							foreach ($OyunOdullerKayitlar as $Odul) {
							?>
								<div class="col-12">
									<span>
										<i class="fas fa-trophy" style="color: #c28f2c"></i> 
									</span> 
									<span class="bold white oyunYazi">
										<?php echo IcerikTemizle($Odul["Odul"]); ?>
									</span>
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
		<?php
		}
		?>

		<?php
		$OyunSistemGereksinim =  $DatabaseBaglanti->prepare("SELECT * FROM  oyungereksinim WHERE  OyunId=? ");
		$OyunSistemGereksinim->execute([$OyunId]);
		$OyunSistemGereksinimVerisi = $OyunSistemGereksinim->rowCount();
		$OyunSistemGereksinimKayitlar = $OyunSistemGereksinim->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunSistemGereksinimVerisi>0) {
		?>
		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9 m-0 ksayXtAS">
					<div class="row justify-content-center p-3 p-xl-5 ">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Gereksinimler</span>
						</div>

						<?php
						foreach ($OyunSistemGereksinimKayitlar as $Gereksinim) {
						$MinimumDepolama=IcerikTemizle($Gereksinim["MinimumDepolama"]);
						$MinimumNotlar=IcerikTemizle($Gereksinim["MinimumNotlar"]);
						$OnerilenIsletimSistemi=IcerikTemizle($Gereksinim["OnerilenIsletimSistemi"]);
						$OnerilenIslemci=IcerikTemizle($Gereksinim["OnerilenIslemci"]);
						$OnerilenEkranKarti=IcerikTemizle($Gereksinim["OnerilenEkranKarti"]);
						$OnerilenDirectx=IcerikTemizle($Gereksinim["OnerilenDirectx"]);
						$OnerilenRam=IcerikTemizle($Gereksinim["OnerilenRam"]);
						$OnerilenDepolama=IcerikTemizle($Gereksinim["OnerilenDepolama"]);
						$OnerilenNotlar=IcerikTemizle($Gereksinim["OnerilenNotlar"]);
						?>

						<?php
						$PlatformAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  gereksinimplatformu WHERE  id=? LIMIT 1");
						$PlatformAdi->execute([IcerikTemizle($Gereksinim["IsletimSistemiAdi"])]);
						$PlatformAdiVeri = $PlatformAdi->rowCount();
						$PlatformAdiKayitlar = $PlatformAdi->fetch(PDO::FETCH_ASSOC);
						if ($PlatformAdiVeri>0) {
						?>
						<div class="col-12">
							<div class="row"> 
								<div class="col-12 mt-4  p-2 asatuZADXH" id="<?php echo IcerikTemizle($Gereksinim["id"]);?>" onClick="$.Sistem(<?php echo IcerikTemizle($Gereksinim["id"]);?>)">
									<div class="row">
										<div class="col-10 col-xl-11">
											<span class="bold white oyunYazi">
												<?php echo IcerikTemizle($PlatformAdiKayitlar["PlatformAdi"]); ?>	
											</span>
										</div>
										<div class="col-2 col-xl-1">
											<span class="bold white font20">
												<i class="fas fa-chevron-down"></i>
											</span>
										</div>
									</div>
								</div>

								<div class="col-12 Goster<?php echo IcerikTemizle($Gereksinim["id"]); ?> ayznmaUAZ">	
									<div class="col-12 mt-5" >
										<div class="row justify-content-center">
											<div class="col-12 col-xl-6 mb-5">
												<div class="row">
													<div class="col-12">
														<span class="white oyunYazi bold oyunYazi opacity05" >Minimum</span>
													</div>
												</div>

												<div class="row mt-4 ">
													<div class="col-12">
														<span class="white oyunYazi opacity05" >İşletim Sistemi</span>
													</div>
													<div class="col-12">
													<?php
													$MinimumIsletimSistemi =  $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
													$MinimumIsletimSistemi->execute([IcerikTemizle($Gereksinim["MinimumIsletimSistemiId"])]);
													$MinimumIsletimSistemiVeri = $MinimumIsletimSistemi->rowCount();
													$MinimumIsletimSistemiKayitlar = $MinimumIsletimSistemi->fetch(PDO::FETCH_ASSOC);
													if ($MinimumIsletimSistemiVeri>0) {
														$IsletimSistemiMarka= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiMarka"]);
														$IsletimSistemiPuan= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiPuan"]);
													?>
														<span class="UYtbbzXxZ oyunYazi" >
															<?php echo  IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiAdi"]); ?>
														</span>

														<?php
														$KullaniciIsletimSistemi =$DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
														$KullaniciIsletimSistemi->execute([$KullaniciIsletimSistemiId]);
														$KullaniciIsletimSistemiVeri = $KullaniciIsletimSistemi->rowCount();
														$KullaniciIsletimSistemiKayitlar = $KullaniciIsletimSistemi->fetch(PDO::FETCH_ASSOC);
														if ($KullaniciIsletimSistemiVeri>0) {
															$KullaniciIsletimSistemiMarka= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiMarka"]);
															$KullaniciIsletimSistemiPuan= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiPuan"]);
														?>	
															<?php
															if ($KullaniciIsletimSistemiMarka == $IsletimSistemiMarka) {
															?>
																<?php
																if ($KullaniciIsletimSistemiPuan >= $IsletimSistemiPuan) {
																?>
																	<span style="color: green"><i class="fas fa-check-circle"></i></span>
																<?php
																}else{
																?>
																	<span style="color: red"><i class="fas fa-times-circle"></i></span>
																<?php
																}
																?>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >-</span>
													<?php
													}
													?>		
													</div>	
												</div>

												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05" >İşlemci</span>
													</div>
													<div class="col-12">
													<?php
													$KullaniciIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
													$KullaniciIslemci->execute([$KullaniciIslemciId]);
													$KullaniciIslemciVeri = $KullaniciIslemci->rowCount();
													$KullaniciIslemciKayitlar = $KullaniciIslemci->fetch(PDO::FETCH_ASSOC);

													if ($KullaniciIslemciVeri>0) {
														$KullaniciIslemciMarka= IcerikTemizle($KullaniciIslemciKayitlar["IslemciMarka"]);
														$KullaniciIslemciPuan= IcerikTemizle($KullaniciIslemciKayitlar["IslemciPuan"]);
													?>	
														<?php
														$MinimumIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
														$MinimumIslemci->execute([IcerikTemizle($Gereksinim["MinimumIslemciId"])]);
														$MinimumIslemciVeri = $MinimumIslemci->rowCount();
														$MinimumIslemciKayitlar = $MinimumIslemci->fetch(PDO::FETCH_ASSOC);
														if ($MinimumIslemciVeri>0) {
															$IslemciMarka= IcerikTemizle($MinimumIslemciKayitlar["IslemciMarka"]);
															$IslemciAdi= IcerikTemizle($MinimumIslemciKayitlar["IslemciAdi"]);
															$IslemciPuan= IcerikTemizle($MinimumIslemciKayitlar["IslemciPuan"]);
														?>

														<?php
														}else{
															$IslemciMarka="";
															$IslemciPuan="";
															$IslemciAdi= "";
														}
														?>
														
														<?php	
														$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
														$MinimumIslemci2->execute([IcerikTemizle($Gereksinim["MinimumIslemci2Id"])]);
														$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
														$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
														if ($MinimumIslemci2Veri>0) {
															$Islemci2Marka= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciMarka"]);
															$Islemci2Adi= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
															$Islemci2Puan= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciPuan"]);
														?>
														<?php
														}else{
															$Islemci2Marka="" ;
															$Islemci2Puan="" ;
															$Islemci2Adi="";
														}
														?>

														<?php
														if($KullaniciIslemciMarka == $IslemciMarka){
														?>
															<span class="UYtbbzXxZ oyunYazi" ><?php echo  IcerikTemizle($IslemciAdi); ?></span>
															<?php
															if ($KullaniciIslemciPuan >= $IslemciPuan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
															<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}else if($KullaniciIslemciMarka == $Islemci2Marka){
														?>
															<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
															<?php
															if ($KullaniciIslemciPuan >= $Islemci2Puan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
															<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}else{
														?>
															<?php
															if ($IslemciAdi!="") {
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($IslemciAdi); ?>/</span>
															<?php
															} 
															?>

															<?php
															if($Islemci2Adi!=""){
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}else{
													?>
														<?php
														$MinimumIslemci = $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE id=? LIMIT 1");
														$MinimumIslemci->execute([IcerikTemizle($Gereksinim["MinimumIslemciId"])]);
														$MinimumIslemciVeri = $MinimumIslemci->rowCount();
														$MinimumIslemciKayitlar = $MinimumIslemci->fetch(PDO::FETCH_ASSOC);
														if ($MinimumIslemciVeri>0) {
															$IslemciAdi= $MinimumIslemciKayitlar["IslemciAdi"];
														?>
															<span class="UYtbbzXxZ oyunYazi"><?php echo  $IslemciAdi; ?>/</span>
															<?php	
															$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
															$MinimumIslemci2->execute([IcerikTemizle($Gereksinim["MinimumIslemci2Id"])]);
															$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
															$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
															if ($MinimumIslemci2Veri>0) {
																$Islemci2Adi=  IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
															<?php
															}else{
															?>

															<?php
															}
															?>
														<?php
														}else{
														?>
															<?php	
															$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
															$MinimumIslemci2->execute([IcerikTemizle($Gereksinim["MinimumIslemci2Id"])]);
															$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
															$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
															if ($MinimumIslemci2Veri>0) {
																$Islemci2Adi=  IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
															<?php
															}else{
															?>
																<span class="UYtbbzXxZ oyunYazi" >-</span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}
													?>
													</div>
												</div>

												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05">Bellek</span>
													</div>
													<div class="col-12">
													<?php
													$MinimumBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
													$MinimumBellek->execute([IcerikTemizle($Gereksinim["MinimumRamId"])]);
													$MinimumBellekVeri = $MinimumBellek->rowCount();
													$MinimumBellekKayitlar = $MinimumBellek->fetch(PDO::FETCH_ASSOC);
													if ($MinimumBellekVeri>0){
														$MinimumBellekPuan=  IcerikTemizle($MinimumBellekKayitlar["RamPuan"]);
													?>
														<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($MinimumBellekKayitlar["RamTuru"]); ?></span>

														<?php
														$KullaniciBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
														$KullaniciBellek->execute([$KullaniciPcRamId]);
														$KullaniciBellekVeri = $KullaniciBellek->rowCount();
														$KullaniciBellekKayitlar = $KullaniciBellek->fetch(PDO::FETCH_ASSOC);
														if ($KullaniciBellekVeri>0) {
															$KullaniciBellekPuan=  IcerikTemizle($KullaniciBellekKayitlar["RamPuan"]);
														?>	
															<?php
															if ($KullaniciBellekPuan >= $MinimumBellekPuan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
																<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >-</span>
													<?php
													}
													?>	
													</div>
												</div>
												
												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05" >Ekran Kartı</span>
													</div>
													<div class="col-12">
													<?php
													$KullaniciEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
													$KullaniciEkranKarti->execute([$KullaniciEkranKartiId]);
													$KullaniciEkranKartiVeri = $KullaniciEkranKarti->rowCount();
													$KullaniciEkranKartiKayitlar = $KullaniciEkranKarti->fetch(PDO::FETCH_ASSOC);
													if ($KullaniciEkranKartiVeri>0) {
														$KullaniciEkranKartiMarka=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiMarka"]);
														$KullaniciEkranKartiPuan=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiPuan"]);
													?>	
														<?php
														$MinimumEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
														$MinimumEkranKarti->execute([IcerikTemizle($Gereksinim["MinimumEkranKartiId"])]);
														$MinimumEkranKartiVeri = $MinimumEkranKarti->rowCount();
														$MinimumEkranKartiKayitlar = $MinimumEkranKarti->fetch(PDO::FETCH_ASSOC);
														if ($MinimumEkranKartiVeri>0) {
															$EkranKartiMarka=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiMarka"]);
															$EkranKartiAdi=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiAdi"]);
															$EkranKartiPuan=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiPuan"]);
														?>
														<?php
														}else{
															$EkranKartiMarka="";
															$EkranKartiPuan="";
															$EkranKartiAdi= "";
														}
														?>
														
														<?php	
														$MinimumEkranKarti2 =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
														$MinimumEkranKarti2->execute([IcerikTemizle($Gereksinim["MinimumEkranKarti2Id"])]);
														$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
														$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
														if ($MinimumEkranKarti2Veri>0) {
															$EkranKarti2Marka=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiMarka"]);
															$EkranKarti2Adi=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiAdi"]);
															$EkranKarti2Puan=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiPuan"]);
														?>
														<?php
														}else{
															$EkranKarti2Marka="" ;
															$EkranKarti2Puan="" ;
															$EkranKarti2Adi="";
														}
														?>

														<?php
														if($KullaniciEkranKartiMarka == $EkranKartiMarka){
														?>
															<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?></span>
															<?php
															if ($KullaniciEkranKartiPuan >= $EkranKartiPuan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
															<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}else if($KullaniciEkranKartiMarka == $EkranKarti2Marka){
														?>
															<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
															
															<?php
															if ($KullaniciEkranKartiPuan >= $EkranKarti2Puan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
															<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}else{
														?>
															<?php
															if ($EkranKartiAdi!=""){
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?>/</span>
															<?php
															} 
															?>

															<?php
															if($EkranKarti2Adi!=""){
															?>
																<span class="UYtbbzXxZ oyunYazi" ><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
															<?php
															}
															?>
														<?php
														}
														?>																
													<?php
													}else{
													?>
														<?php
														$MinimumEkranKarti=$DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
														$MinimumEkranKarti->execute([IcerikTemizle($Gereksinim["MinimumEkranKartiId"])]);
														$MinimumEkranKartiVeri = $MinimumEkranKarti->rowCount();
														$MinimumEkranKartiKayitlar = $MinimumEkranKarti->fetch(PDO::FETCH_ASSOC);
														if ($MinimumEkranKartiVeri>0) {
															$EkranKartiAdi= IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiAdi"]);
														?>
															<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?>/</span>
															<?php	
															$MinimumEkranKarti2 =$DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
															$MinimumEkranKarti2->execute([IcerikTemizle($Gereksinim["MinimumEkranKarti2Id"])]);
															$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
															$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
															if ($MinimumEkranKarti2Veri>0) {
																$EkranKarti2Adi= $MinimumEkranKarti2Kayitlar["EkranKartiAdi"];	
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
															<?php
															}else{
															?>

															<?php
															}
															?>
														<?php
														}else{
														?>
															<?php	
															$MinimumEkranKarti2 = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
															$MinimumEkranKarti2->execute([IcerikTemizle($Gereksinim["MinimumEkranKarti2Id"])]);
															$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
															$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
															if ($MinimumEkranKarti2Veri>0) {
																$EkranKarti2Adi= IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiAdi"]);	
															?>
																<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
															<?php
															}else{
															?>
																<span class="UYtbbzXxZ oyunYazi" >-</span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}
													?>	
													</div>
												</div>

												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05" >Direct X</span>
													</div>
													<div class="col-12">
													<?php
													$MinimumDirectx =  $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
													$MinimumDirectx->execute([IcerikTemizle($Gereksinim["MinimumDirectxId"])]);
													$MinimumDirectxVeri = $MinimumDirectx->rowCount();
													$MinimumDirectxKayitlar = $MinimumDirectx->fetch(PDO::FETCH_ASSOC);
													if ($MinimumDirectxVeri>0) {
														$MinimumDirectxPuan=  IcerikTemizle($MinimumDirectxKayitlar["DirectxPuan"]);
													?>
														<span class="UYtbbzXxZ oyunYazi" ><?php echo $MinimumDirectxKayitlar["DirectxAdi"]; ?></span>

														<?php
														$KullaniciDirectx=$DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
														$KullaniciDirectx->execute([$KullaniciPcDirectxId]);
														$KullaniciDirectxVeri = $KullaniciDirectx->rowCount();
														$KullaniciDirectxKayitlar = $KullaniciDirectx->fetch(PDO::FETCH_ASSOC);
														if ($KullaniciDirectxVeri>0) {
															$KullaniciDirectxPuan=  IcerikTemizle($KullaniciDirectxKayitlar["DirectxPuan"]);
														?>	
															<?php
															if ($KullaniciDirectxPuan >= $MinimumDirectxPuan) {
															?>
																<span style="color: green"><i class="fas fa-check-circle"></i></span>
															<?php
															}else{
															?>
																<span style="color: red"><i class="fas fa-times-circle"></i></span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >-</span>
													<?php
													}
													?>
													</div>
												</div>
												
												<div class="row mt-3">
													<div class="col-12">
														<span class="white  oyunYazi opacity05">Depolama</span>
													</div>
													<div class="col-12">
													<?php
													if ($MinimumDepolama!="") {
													?>
														<span class="UYtbbzXxZ oyunYazi" ><?php echo $MinimumDepolama; ?></span>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >- </span>
													<?php
													}
													?>		
													</div>
												</div>

												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05" >Notlar</span>
													</div>
													<div class="col-12">
													<?php
													if ($MinimumNotlar!="") {
													?>
														<span class="UYtbbzXxZ oyunYazi"><?php echo $MinimumNotlar; ?></span>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >- </span>
													<?php
													}
													?>
													</div>
												</div>
											</div>

											<div class="col-12 col-xl-6">
												<div class="row">
													<div class="col-12">
														<span class="white oyunYazi bold opacity05" >Önerilen</span>
													</div>
												</div>

												<?php
												$Onerilen= array(
													array('Adi' =>"İşletim Sistemi",'Bilgi'=> $OnerilenIsletimSistemi),
													array('Adi' =>"İşlemci",'Bilgi'=> $OnerilenIslemci),
													array('Adi' =>"Bellek",'Bilgi'=> $OnerilenRam),
													array('Adi' =>"Ekran Kartı",'Bilgi'=> $OnerilenEkranKarti),
													array('Adi' =>"Direct X",'Bilgi'=> $OnerilenDirectx),
													array('Adi' =>"Depolama",'Bilgi'=> $OnerilenDepolama),
													array('Adi' =>"Notlar",'Bilgi'=> $OnerilenNotlar),
													);	
												?>

												<?php
												for($i=0;$i<count($Onerilen);$i++){
												?>
												<div class="row mt-3">
													<div class="col-12">
														<span class="white oyunYazi opacity05" ><?php echo IcerikTemizle($Onerilen[$i]["Adi"]); ?></span>
													</div>
													<div class="col-12">
													<?php
													if (IcerikTemizle($Onerilen[$i]["Bilgi"])!="") {
													?>
														<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Onerilen[$i]["Bilgi"]); ?></span>
													<?php
													}else{
													?>
														<span class="UYtbbzXxZ oyunYazi" >-</span>
													<?php
													}
													?>
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
						<?php	
						}else{
						?>
						<?php
						}
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
		?>
		
		<?php
		}
		?>

		<?php
		$OyunDiller = $DatabaseBaglanti->prepare("SELECT * FROM oyundiller WHERE OyunId=?");
		$OyunDiller->execute([$OyunId]);
		$OyunDillerVerisi = $OyunDiller->rowCount();
		$OyunDillerKayitlar = $OyunDiller->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunDillerVerisi>0){
		?>
		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center align-items-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz  bGAfxXE" >
							<span class="bold white oyunYazi">Diller</span>
						</div>
						<div class="col-12 mt-5 saUZNXA2WAQ" >
							<div class="row text-center">
								<div class="col-12 SASZaz" >
									<div class="row p-2">
										<div class="col-4 "></div>
										<div class="col-2 bold white dil ">Arayüz</div>
										<div class="col-4  bold white dil" >Seslendirme</div>
										<div class="col-2 p-0 bold white dil" >Altyazi</div>
									</div>
								</div>
								<?php
								foreach ($OyunDillerKayitlar as $Diller) {
									$DilId= IcerikTemizle($Diller["DilId"]);
								?>
									<?php
									$DilAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  diller WHERE  id=? ");
									$DilAdi->execute([$DilId]);
									$DilAdiVerisi = $DilAdi->rowCount();
									$DilAdiKayitlar = $DilAdi->fetch(PDO::FETCH_ASSOC);
									if ($DilAdiVerisi>0) {
									?>
									<div class="col-12 _PaQqpL_AZxZxXQDXC" >
										<div class="row justify-content-center align-items-center p-2"> 
											<div class="col-4  bold white dil"><?php echo  IcerikTemizle($DilAdiKayitlar["DilAdi"]); ?></div>
											<div class="col-2 bold white dil">
												<?php
												if ($Diller["Arayuz"]!=0) {
												?>
													<i class="fas fa-check green"></i>
												<?php
												}else{
												?>
													<span>-</span>
												<?php
												}
												?>
											</div>

											<div class="col-4 bold white dil">
												<?php
												if ($Diller["Seslendirme"]!=0) {
												?>
													<i class="fas fa-check green"></i>
												<?php
												}else{
												?>
													<span>-</span>
												<?php
												}
												?>
											</div>
												
											<div class="col-2 bold white dil">
												<?php
												if ($Diller["Altyazi"]!=0) {
												?>
													<i class="fas fa-check green"></i>
												<?php
												}else{
												?>
													<span>-</span>
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
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>


		<?php
		$BannerAlt = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
		$BannerAlt->execute([18,1]);
		$BannerAltVeri = $BannerAlt->rowCount();
		$BannerAltKayitlar = $BannerAlt->fetch(PDO::FETCH_ASSOC);
		if ($BannerAltVeri>0){
		?>
		<div class="col-11 col-xl-9 mt-5"  >
			<div class="row justify-content-center align-items-center" >
				<div class=" col-2"></div>
				<div class="col-11 col-xl-9">
					<div class="row">
						<?php echo IcerikTemizle($BannerAltKayitlar["BannerKodu"]); ?> 
						<?php
						$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
						$BannerGuncelleme2->execute([18]);	
						?>	
					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>

		<?php
		$OyunSatisBaglanti =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunsatisplatformlari WHERE  OyunId=? ");
		$OyunSatisBaglanti->execute([$OyunId]);
		$OyunSatisBaglantiVerisi = $OyunSatisBaglanti->rowCount();
		$OyunSatisBaglantiKayitlar = $OyunSatisBaglanti->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunSatisBaglantiVerisi>0) {
			?>
			<div class="col-11 col-xl-9">
				<div class="row justify-content-center align-items-center mt-5">
					<div class=" col-2"></div>
					<div class="col-12 col-xl-9 m-0 ksayXtAS">
						<div class="row justify-content-center p-3 p-xl-5">
							<div class="col-12 SAFfXxAERz bGAfxXE">
								<span class="bold white oyunYazi">Oyun Satış Bağlantıları</span>
							</div>
							<div class="col-12 mt-5">
								<div class="row align-items-center text-center">
									<?php
									foreach($OyunSatisBaglantiKayitlar as $Satis) {
									?>
										<?php
										$SatisPlatformAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  satisplatformlari WHERE  id=? LIMIT 1");
										$SatisPlatformAdi->execute([$Satis["PlatformId"]]);
										$SatisPlatformAdiVerisi = $SatisPlatformAdi->rowCount();
										$SatisPlatformAdiKayitlar = $SatisPlatformAdi->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="col-3 col-xl-3 mb-5">
											<div class="row  align-items-center">
												<div class="col-12 mb-2">
													<a target="_blank" href="<?php echo IcerikTemizle($Satis["PlatformLink"])  ?>">
														<?php echo IcerikTemizle(SatisPlatform($SatisPlatformAdiKayitlar["id"])); ?>
													</a>
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
		<?php
		}
		?>

		<?php
		$OyunInceleme =  $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.OyunId=?  and incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 ORDER BY incelemeler.Goruntulenme DESC LIMIT 4 ");
		$OyunInceleme->execute([$OyunId]);
		$OyunIncelemeVeri = $OyunInceleme->rowCount();
		$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunIncelemeVeri>0) {
		?>
		<div class="col-11 col-xl-9"  >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">İncelemeler</span>
						</div>
						<div class="col-12 mt-1">
							<div class="row justify-content-center align-items-center ">
							<?php
							$OyunIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.OyunId=?  and incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1");
							$OyunIncelemeKontrol->execute([$OyunId]);
							$OyunIncelemeKontrolVeri = $OyunIncelemeKontrol->rowCount();
							if ($OyunIncelemeKontrolVeri>4) {
							?>	
								<div class="col-12 mb-2">
									<div class="row justify-content-end">
										<div class="col-6 col-xl-3 p-1 text-center ErYTIxKL WrGYT__Xx">
											<a href="oyunincelemeler/&Ara=<?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]) ?>/1">
												<span class="gxPpxXo_">DAHA FAZLA GÖSTER</span>
											</a>
										</div>
									</div>
								</div>
							<?php
							}
							?>

							<?php
							foreach ($OyunIncelemeKayitlar as  $IncelemeKayitlar) {
							$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
							$OyunAdi->execute([$IncelemeKayitlar["OyunId"]]);
							$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

							$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
							$KuratorAdi->execute([$IncelemeKayitlar["KuratorId"]]);
							$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
							?>
							<div class="col-6 col-md-6 col-xl-3  mb-3">
								<div class="row p-1">
									<div class="col-12">
										<div class="row align-items-end">
											<div class="col-12 p-0" style="background: black">
											<?php
											if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
											?>
												<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
													<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05"  >	  
												</a>
											<?php
											}else{
											?>	
												<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
													<img src="images/resim.jpg" class="img-fluid">		 
												 </a> 
											<?php
											}
											?>
											</div>

											<div class="col-12 position-absolute p-0 asjfhete">
												<div class="row align-items-center p-2 ">
													<div class="col-12 mt-5 " >
														<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
															<p  class="bold white odib mb-1 fgdfyXx" >
																<?php echo  IcerikTemizle($IncelemeKayitlar["Baslik"]); ?> 
															</p> 
														</a>
														<p class="p-0 m-0">
															<a style="color: white" href="kurator/<?php echo $KuratorAdiKayitlar["KullaniciAdi"]; ?>">
															<?php 
															if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid bvvbcvb" >
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid" style="width: 25px;height: 25px">
															<?php
															}
															?>
																<span class="bold white odib">
																	<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?> 
																</span>
															</a>
														</p>
													</div>
												</div>										
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
		<?php
		}
		?>

		<div class="col-11 col-xl-9" >
			<div class="row justify-content-center align-items-center mt-5" >
				<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 "  style="background: #202020">
					<div class="row justify-content-center  p-3 p-xl-5  ">
						<div class="col-12 SAFfXxAERz bGAfxXE" style="" >
							<span class="bold white oyunYazi">Kullanıcı Değerlendirmesi</span>
						</div>
						<div class="col-12 mt-5 zxZXxbstvc">
							<div class="row justify-content-center align-items-center">
								<div class="col-12 col-xl-6 mb-4"  >
									<div class="row p-4 puan grafik">
									<?php
									if(isset($_SESSION["Kullanici"] )){
									?>
										<?php
										$KullaniciPuan= $DatabaseBaglanti->prepare("SELECT * FROM oyunpuan WHERE OyunId=? AND UyeId=? LIMIT 1 ");
										$KullaniciPuan->execute([$OyunId,$KullaniciId]);
										$KullaniciPuanSayisi = $KullaniciPuan->rowCount();
										$KullaniciPuanKayitlar = $KullaniciPuan->fetch(PDO::FETCH_ASSOC);
										if ($KullaniciPuanSayisi>0){
										?>
											<div class="col-12 text-left mb-2 p-0">
												<span class="bold white font15"><?php echo IcerikTemizle($KullaniciAdiSoyadi) ?></span>
												<span class="white oyunYazi bold opacity07"><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?>  için kullandığınız oy:</span>
											</div>
											<div class="col-12 text-center mt-2 mb-3">
												<?php echo IcerikTemizle(Oy($KullaniciPuanKayitlar["Puan"]));?>
											</div>
										<?php
										}else{
										?>
											<div class="col-12 text-left mb-2  p-0">
												<span class="bold white oyunYazi"><?php echo  IcerikTemizle($KullaniciAdiSoyadi) ?></span> 
												<span class="white oyunYazi bold opacity07"><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?>  için oy kullan:</span>
											</div>
											<div class="col-12 text-center star-rating p-2" >
												<input id="star-5x"  type="radio" data="<?php echo $OyunId ?>" value="5" />
												<label for="star-5x"  >
													<i class="fa fa-star font25" alt="Çok Olumlu" ></i>
												</label>
												<input id="star-4x" type="radio" data="<?php echo $OyunId ?>" value="4"/>
												<label for="star-4x" >
													<i class="fa fa-star font25"></i>
												</label>
												<input id="star-3x" type="radio" data="<?php echo $OyunId ?>"  value="3"  />
												<label for="star-3x" >
													<i class="fa fa-star font25  "></i>
												</label>
												<input id="star-2x" type="radio"  data="<?php echo $OyunId ?>" value="2" />
												<label for="star-2x" >
													<i class="fa fa-star font25  "></i>
												</label>
												<input id="star-1x" type="radio" data="<?php echo $OyunId ?>"  value="1" checked/>
												<label for="star-1x" >
													<i class="fa fa-star font25  "></i>
												</label>    
											</div>
											<div class="col-12 text-center "></div>

										<?php
										}
										?>

									<?php
									}else{
									?>
										<div class="col-12 text-left mb-2 p-0">
											<span class="bold white oyunYazi">Oy vermek için giriş yapınız. </span>
										</div>
										<?php
										$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
										$ToplamPuan->execute([$OyunId]);
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
											<div class="col-12 mt-2 mb-2 p-0" ><?php echo OyunPuan($OrtalamaPuan);?></div>
										<?php
										}else{		
											$OrtalamaPuan=0;
										?>
											<div class="col-12  mt-2 mb-2p-0" ><?php echo OyunPuan(0);?></div>
										<?php
										}
										?>
									<?php
									}
									?>
									<div class="col-12 p-0">
										<div class="row">
											<div class="col-12">
												<div class="row">
													<div class="col-12">
														<span class="white bold font13" style=""> Toplam İnceleme:</span>
													</div>
													<div class="col-12">
					
													<?php
													if ($ToplamPuanVeri==0 ) {
													?>
														<span class="bold white oyunYazi ">-</span>	
													<?php
													}else{
													?>
														<span class="bold font18" style="color:#c28f2c">
															<?php echo IcerikTemizle(OyunOrtPuan($OrtalamaPuan)) ?>
														</span> 
														<span class="font14 white opacity07">
															( <?php echo $ToplamPuanVeri; ?> İnceleme )
														</span>
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

							<div class="col-12 col-xl-6 mb-4 mt-3">
							<?php
							$ToplamOySayisi =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunpuan WHERE  OyunId=? ");
							$ToplamOySayisi->execute([$OyunId]);
							$ToplamOySayisiVerisi = $ToplamOySayisi->rowCount();
							$ToplamOySayisiKayitlar = $ToplamOySayisi->fetchAll(PDO::FETCH_ASSOC);

							if ($ToplamOySayisiVerisi>0) {
								$CokOlumsuz=0;
								$Olumsuz=0;
								$Kararsiz=0;
								$Olumlu=0;
								$CokOlumlu=0;
								foreach ($ToplamOySayisiKayitlar as  $Oylar) {
								?>
									<?php
									if ($Oylar["Puan"]==1) {
										$CokOlumsuz+=1;
									}else if ($Oylar["Puan"]==2) {
										$Olumsuz+=1;
									}else if($Oylar["Puan"]==3){
										$Kararsiz+=1;
									}else if($Oylar["Puan"]==4){
										$Olumlu+=1;
									}else if ($Oylar["Puan"]==5) {
										$CokOlumlu+=1;
									}

									?>
								<?php
								}
								$CokOlumsuzOrtalama= number_format(($CokOlumsuz/$ToplamOySayisiVerisi)*100, 2,".","");
								$OlumsuzOrtalama= number_format(($Olumsuz/$ToplamOySayisiVerisi)*100, 2,".","");
								$KararsizOrtalama= number_format(($Kararsiz/$ToplamOySayisiVerisi)*100, 2,".","");		
								$OlumluOrtalama= number_format(($Olumlu/$ToplamOySayisiVerisi)*100, 2,".","");
								$CokOlumluOrtalama= number_format(($CokOlumlu/$ToplamOySayisiVerisi)*100, 2,".","");
								?>
							<?php
							}else{
								$CokOlumsuzOrtalama=0.00;
								$OlumsuzOrtalama=0.00;
								$KararsizOrtalama=0.00;
								$OlumluOrtalama=0.00;
								$CokOlumluOrtalama=0.00;
							}
							?>
								<div class="row justify-content-center align-items-center">
									<div class="col-12 text-center "> 
										<canvas  id="myChart" ></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-11 col-xl-9">
		<div class="row justify-content-center align-items-center mt-5" >
			<div class=" col-2"></div>
				<div class="col-12 col-xl-9  m-0 ksayXtAS" >
					<div class="row justify-content-center  p-3 p-xl-5">
						<div class="col-12 SAFfXxAERz bGAfxXE" >
							<span class="bold white oyunYazi">Yorumlar (<?php echo IcerikTemizle($OyunSorgusuKayit["YorumSayisi"]);  ?>)</span>
						</div>
						<div class="col-12  " >
							<div class="row justify-content-center align-items-center text-center">
							<?php
							if (isset($_SESSION["Kullanici"])) {
							?>
								<div class="col-12 mt-4">
									<form class="text-center haberYorum" id="oyuny" action="javascript:void(0);" method="post">
										<div class="group2">
											<div class="row  align-items-center mb-3">
												<div class="ml-2 col-2 col-md-1 text-center p-0 white">
													<?php
													if(file_exists("images/userphoto/".$KullaniciProfilResmi) and (isset($KullaniciProfilResmi)) and ($KullaniciProfilResmi!="") ){
													?>
														<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?> " class="img-fluid userp" style="border-radius: 50%">
													<?php
													}else{
													?>
														<img src="images/user.png" class="img-fluid userp" style="border-radius: 50%">
													<?php
													}
													?> 
												</div>
												<div class="col-8 col-md-9 text-left p-0 white bold  oyunYazi">
													<span><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
												</div>
											</div>
											<div class="col-12" id="oys"></div>
											<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."></textarea>  
											<input type="hidden" name="o"  value="<?php echo  IcerikTemizle($OyunId); ?>">    
											<span class="highlight"></span>
											<span class="bar"></span>
										</div>
										<div class="col-12 p-0  mt-3 text-right ">
											<button class="call-to-action2" type="submit" id="oyg"  >
												<div>
													<div class="">Gönder</div>
												</div>
											</button>
										</div>
									</form>
								</div>
							<?php	
							}else{
							?>
								<div class="col-12 mt-4 haberYorum">
									<div class="group2">
										<div class="col-12 mb-2 p-0 lıyTQMZLD text-left white oyunYazi" >
											<span>Yorum yapmak için</span> 
											<a href="girisyap"  style="color: #c28f2c">
												<span class="oyunYazi" style="">giriş yap.</span>
											</a>
										</div> 
										<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
									<div class="col-12  mt-3  p-0  text-right " >
										<button class="call-to-action2 " >
											<div>
												<div>Gönder</div>
											</div>
										</button>
									</div>
								</div>
							<?php
							}
							?>
							</div>
						</div>
						
						<div class="col-12  mb-5 ">
							<div class="yorumlar"></div>
							<?php
							$Yorumlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunyorumlar WHERE OyunId=? AND (Durum=? or Durum=?)   ORDER BY YorumTarihi DESC LIMIT 5");
							$Yorumlar->execute([IcerikTemizle($OyunSorgusuKayit["id"]),1,4]);
							$YorumSayisi = $Yorumlar->rowCount();
							$Yorum = $Yorumlar->fetchAll(PDO::FETCH_ASSOC);
							if($YorumSayisi>0){
								foreach ($Yorum as $YorumKayit) {
								$YorumId=$YorumKayit["id"];
								$YorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
								$YorumUyeAdi->execute([IcerikTemizle($YorumKayit["UyeId"])]);
								$YorumUye = $YorumUyeAdi->fetch(PDO::FETCH_ASSOC);
							?>
							<div <?php if(isset($_SESSION["Kullanici"])){ ?> id="oy<?php echo IcerikTemizle($YorumId) ?>" <?php }else{ ?> <?php } ?> ></div>
								<div class="row p-2 ody" <?php if(isset($_SESSION["Kullanici"])){ ?> id="y<?php echo IcerikTemizle($YorumId) ?>"   <?php }else{ ?> <?php } ?>>
									<div class=" col-12">
										<div  class="row">
											<div class="col-12 mb-1 BackgroundBlack" style="border-radius: 5px" >
												<div class="row p-0 justify-content-start align-items-center ">
													<div class="col-12 ">
														<div class="row p-2 justify-content-start align-items-center">
														<?php
														if (isset($_SESSION["Kullanici"])) {
														?>
															<div class="col-2 col-md-1 p-0 qweyasqz">
															<?php
															if(file_exists("images/userphoto/".$YorumUye["ProfilResmi"]) and (isset($YorumUye["ProfilResmi"])) and ($YorumUye["ProfilResmi"]!="") ){
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($YorumUye["ProfilResmi"]) ?> " class="img-fluid userp" style="border-radius: 50%;">
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid userp " style="border-radius: 50%;">
															<?php
															}
															?>
															</div>
															<div class="col-10 col-md-11   text-left ">
																<div class="row align-items-center p-0">
																	<div class="col-12 p-0 bvrtyrxX" >
																		<span class="yorumk bold white">
																			<?php echo IcerikTemizle($YorumUye["AdSoyad"]);?>
																		</span> 
																		<span class=" yorumk white opacity05">
																		 <?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?>
																		 </span>
																	</div>
																	<div class="col-12 p-0 VBzxc">
																		<span class="white yorumk opacity05  ">
																			(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)
																		</span>
																	</div>
																</div>
															</div>
															<?php
															if ($YorumKayit["Durum"]==4) {
															?>
															<div class="col-12 mt-1">
																<span class="ASewrQz yorumk">
																	<i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i>
																	 Bu yorum <a class="bold white" style="color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a> ihlali nedeniyle kısıtlanmıştır.
																	</span>
															</div>
															<?php
															}else{
															?>
															<div class="col-12 mt-1 ">
																<span class="rzrkWzXv yorumk">
																	<?php echo IcerikTemizle($YorumKayit["Yorum"]);?>
																</span>
															</div>
															<div class="col-12 text-right mt-1 "   >
															<?php
															if (isset($_SESSION["Kullanici"])) {
																if ($KullaniciId != $YorumKayit["UyeId"] ) {
															?>
																<span class="bold white yorumk ys" data="<?php echo IcerikTemizle($YorumId); ?>" data-toggle="modal" data-target="#ys<?php echo IcerikTemizle($YorumId); ?>"  style="cursor:pointer;">
																		<i style="color:#c28f2c" class="fas fa-flag white"></i> Yorumu Şikayet Et
																</span>
																<div  class="modal fade" id="ys<?php echo IcerikTemizle($YorumId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
																				<form class="hesabim " id="yg<?php echo IcerikTemizle($YorumId); ?>" method="post" action="javascript:void(0);" >
																					<div class="col-12 mt-2">
																						<div class="col-12 text-left p-0 white bold" >Şikayet nedeniniz nedir?</div>      
																						<textarea type="text"  style="background: black;color:white" name="OSikayet"  ></textarea>
																						<input type="hidden" name="oys" value="<?php echo IcerikTemizle($YorumId); ?>">
																						<span class="highlight"></span>
																						<span class="bar"></span> 
																						<div class="bold red font13 ">Maksimum 250 Karakter</div>
																					</div>
																					<div class="col-12  mt-3 mb-3  p-0  text-center  " >
																						<button class="call-to-action2  yseb" data="<?php echo IcerikTemizle($YorumId); ?>" >
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
															}
															?>
															<?php
															if (isset($_SESSION["Kullanici"])) {
																if ($KullaniciId == $YorumKayit["UyeId"] ) {
															?>
																<span class="bold  white yorumk oysb" data="<?php echo  IcerikTemizle($YorumId); ?>" style="cursor:pointer;">
																	<i style="color:#c28f2c"  class="fas fa-trash-alt white"></i> Yorumu Sil
																</span>
															<?php
																}
															}
															?>	   			
															</div>
															<?php
															}
															?>
														<?php
														}else{
														?>
															<div  class="col-2 col-md-1    p-0  qweyasqz" >
															<?php
															if(file_exists("images/userphoto/".$YorumUye["ProfilResmi"]) and (isset($YorumUye["ProfilResmi"])) and ($YorumUye["ProfilResmi"]!="") ){
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($YorumUye["ProfilResmi"]) ?> " class="img-fluid userp" style="border-radius: 50%;">
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid userp " style="border-radius: 50%;">
															<?php
															}
															?>
															</div>
															
															<div class="col-10 col-md-11   text-left ">
																<div class="row align-items-center p-0">
																	<div class="col-12 p-0 bvrtyrxX">
																		<span class="yorumk bold white">
																			<?php echo IcerikTemizle($YorumUye["AdSoyad"]);?>
																		</span> 
																		<span class=" yorumk white opacity05"> 
																			<?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?>
																		</span>
																	</div>
																	<div class="col-12 p-0 VBzxc">
																		<span class="white yorumk opacity05  ">
																			(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)
																		</span>
																	</div>
																</div>
															</div>

															<?php
															if ($YorumKayit["Durum"]==4) {
															?>
																<div class="col-12 mt-1">
																	<span class="ASewrQz yorumk"><i class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="text-decoration: none;color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
																</div>
															<?php
															}else{
															?>
																<div class="col-12 mt-1 ">
																	<span class="rzrkWzXv yorumk">
																		<?php echo IcerikTemizle($YorumKayit["Yorum"]);?>
																	</span>
																</div>
															<?php
															}
															?>
														<?php
														}
														?>
														</div>
													</div>
												</div>
											</div>

											<div class="col-12 mt-1">
												<div class="row">
													<div class="col-4 col-xl-2 mt-1" style="cursor: pointer;" id="<?php echo IcerikTemizle($YorumKayit["id"]);?>" onClick="$.Cevap(<?php echo IcerikTemizle($YorumKayit["id"]);?>)">
														<span class="bold white yorumk" >
															<i class="fas fa-comments"></i>Yanıtla
														</span>
													</div>
													<div class="col-12 mt-2" id="cg<?php echo IcerikTemizle($YorumKayit["id"]); ?>" style="display:none;">					
													<?php
													if (isset($_SESSION["Kullanici"])) {
													?>
														<div class="row justify-content-center">
															<div class="col-12 mt-4  haberYorum">
																<form  id="oyc<?php echo IcerikTemizle($YorumId) ?>" action="javascript:void(0);" method="post"   >
																	<div class="group2">
																		<div  id="c<?php echo IcerikTemizle($YorumKayit["id"]);?>"  ></div>
																		<textarea name="YorumCevap"  placeholder="Yorumunuzu yazın..."  ></textarea> 
																		<input type="hidden" name="oc" value="<?php echo  IcerikTemizle($OyunId); ?>">
																		<input type="hidden" name="yc" value="<?php echo  IcerikTemizle($YorumId); ?>">
																		<span class="highlight"></span>
																		<span class="bar"></span>
																	</div>

																	<div class="col-12 p-0  mt-3 text-right ">
																		<button class="call-to-action2 oycg" type="submit" data="<?php echo  IcerikTemizle($YorumKayit["id"]);?>"  >
																			<div>
																				<div class="yorumk">Yanıtla</div>
																			</div>
																		</button>
																	</div>
																</form>
															</div>
														</div>
													<?php	
													}else{
													?>
														<div class="col-12 mt-4 haberYorum">
															<div class="group2">
																<div class="col-12 mb-2 p-0 white bold yorumk" >
																	<span>Yorum yapmak için</span> <a href="girisyap"  style="text-decoration: none;color: #c28f2c"><span style="">giriş yap</span></a>.
																</div> 
																<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
																<span class="highlight"></span>
																<span class="bar"></span>
															</div>
															<div class="col-12  mt-3  p-0  text-right " >
																<button class="call-to-action2" disabled>
																	<div>
																		<div class="yorumk">Yanıtla</div>
																	</div>
																</button>
															</div>		
														</div>
														<?php
														}
														?>		
													</div>

													<div class="col-12 mt-1 ">
													<?php
													$YorumlarCevap = $DatabaseBaglanti->prepare("SELECT * FROM oyunyorumcevap WHERE OyunId=? AND YorumId=? AND (Durum=? or Durum=?)   ORDER BY YorumTarihi ASC  ");
													$YorumlarCevap->execute([IcerikTemizle($OyunSorgusuKayit["id"]),$YorumKayit["id"],1,4]);
													$YorumCevapSayisi = $YorumlarCevap->rowCount();
													$YorumCevap = $YorumlarCevap->fetchAll(PDO::FETCH_ASSOC);
													if($YorumCevapSayisi>0){
														foreach ($YorumCevap as $YorumCevapKayit) {
														$YorumCevapId=$YorumCevapKayit["id"];
														$CevapYorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
														$CevapYorumUyeAdi->execute([IcerikTemizle($YorumCevapKayit["UyeId"])]);
														$CevapYorumUye = $CevapYorumUyeAdi->fetch(PDO::FETCH_ASSOC);
													?>
														<div class="row odyc justify-content-center align-items-center pb-3 mt-1" <?php if(isset($_SESSION["Kullanici"])){ ?> id="cs<?php echo IcerikTemizle($YorumCevapId) ?>" <?php }else{ ?> <?php } ?> >
															<div class="col-11 col-xl-6 text center" <?php if(isset($_SESSION["Kullanici"])){ ?>  id="ss<?php echo IcerikTemizle($YorumCevapId) ?>" <?php }else{ ?> <?php } ?>></div>
																<div class=" offset-1 col-11 asdRzwcZ">
																	<div class="row p-2 justify-content-start align-items-center">
																	<?php
																	if (isset($_SESSION["Kullanici"])) {
																	?>
																		<div class="col-2 col-md-1 p-0 ">
																		<?php
																		if(file_exists("images/userphoto/".$CevapYorumUye["ProfilResmi"]) and (isset($CevapYorumUye["ProfilResmi"])) and ($CevapYorumUye["ProfilResmi"]!="") ){
																		?>
																			<img src="images/userphoto/<?php echo IcerikTemizle($CevapYorumUye["ProfilResmi"]) ?> " class="img-fluid userp" style="border-radius: 50%;">
																		<?php
																		}else{
																		?>
																			<img src="images/user.png" class="img-fluid userp" style="border-radius: 50%;">
																		<?php
																		}
																		?>
																		</div>
																		<div class="col-10 col-md-11   text-left ">
																			<div class="row align-items-center p-0">
																				<div class="col-12 p-0 bvrtyrxX">
																					<span class="yorumk bold white">
																						<?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?>
																					</span>
																					<span class=" yorumk white opacity05"> 
																					 	<?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?>
																					</span>
																				</div>
																				<div class="col-12 p-0 VBzxc" >
																					<span class="white yorumk opacity05  ">
																						(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)
																					</span>
																				</div>
																			</div>
																		</div>

																		<?php
																		if ($YorumCevapKayit["Durum"]==4) {
																		?>
																			<div class="col-12 mt-2 " >
																				<span class="ASewrQz yorumk"><i class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="text-decoration: none;color: white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
																			</div>
																		<?php
																		}else{
																		?>	
																			<div class="col-12 mt-1  " >
																				<span class="sadxzaA yorumk ">
																					<?php echo IcerikTemizle($YorumCevapKayit["Yorum"]);?>
																				</span>
																			</div>
																			<div class="col-12 text-right mt-1" id="ocs<?php echo IcerikTemizle($YorumCevapId); ?>" >
																			<?php
																			if (isset($_SESSION["Kullanici"])) {
																				if ($KullaniciId != $YorumCevapKayit["UyeId"] ) {
																			?>

																				<span class="bold white yorumk  ycs" data="<?php echo IcerikTemizle($YorumCevapId); ?>" data-toggle="modal" data-target="#ycse<?php echo IcerikTemizle($YorumCevapId); ?>"  style="cursor:pointer;">
																					<i style="color:#c28f2c" class="fas fa-flag white"></i> Yorumu Şikayet Et
																				</span>
																				<div  class="modal fade" id="ycse<?php echo IcerikTemizle($YorumCevapId);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
																					<div class="modal-dialog" role="document">
																						<div class="modal-content" style="background: #202020">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																									<span aria-hidden="true" class="white">&times;</span>
																								</button>
																							</div>
																							<div class="modal-body">
																								<div class="col-12 text-center  mt-2 ycss"></div>
																								<div class="col-12 text-center ycsb mt-2"></div>
																									<form class="hesabim  " id="ycg<?php echo IcerikTemizle($YorumCevapId); ?>" method="post" action="javascript:void(0);" >
																										<div class="col-12 mt-2">
																											<div class="col-12 text-left p-0 white bold" >Şikayet nedeniniz nedir?</div>      
																											<textarea type="text" style="background: black;color:white" name="OcSikayet"  ></textarea>
																											<input type="hidden" name="ocys" value="<?php echo IcerikTemizle($YorumCevapId); ?>">
																											<span class="highlight"></span>
																											<span class="bar"></span> 
																											<div class="bold  font13"style="color:#585858" >Maksimum 250 karakter</div>
																										</div>
																										<div class="col-12  mt-3 mb-3  p-0  text-center " >
																											<button class="call-to-action2  ycseb" data="<?php echo IcerikTemizle($YorumCevapId); ?>" >
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
																			}
																			?>

																			<?php
																			if (isset($_SESSION["Kullanici"])) {
																				if ($KullaniciId == $YorumCevapKayit["UyeId"] ) {
																			?>
																				<span class="bold  white yorumk oycsb" data="<?php echo  IcerikTemizle($YorumCevapId); ?>" style="cursor:pointer;"><i style="color:#c28f2c"  class="fas fa-trash-alt white"></i> Yorumu Sil</span>
																			<?php
																			}
																			}
																			?>
																			</div>
																		<?php
																		}
																		?>
																	<?php
																	}else{
																	?>
																		<div class="col-2 col-md-1   p-0   ">
																		<?php
																		if(file_exists("images/userphoto/".$CevapYorumUye["ProfilResmi"]) and (isset($CevapYorumUye["ProfilResmi"])) and ($CevapYorumUye["ProfilResmi"]!="") ){
																		?>
																			<img src="images/userphoto/<?php echo IcerikTemizle($CevapYorumUye["ProfilResmi"]) ?> " class="img-fluid userp" style="border-radius: 50%;">
																		<?php
																		}else{
																		?>
																			<img src="images/user.png" class="img-fluid userp" style="border-radius: 50%;">
																		<?php
																		}
																		?>
																		</div>
																		<div class="col-10 col-md-11   text-left ">
																			<div class="row align-items-center p-0">
																				<div class="col-12 p-0 bvrtyrxX" >
																					<span class="yorumk bold white">
																						<?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?>	
																						</span> 
																					<span class=" yorumk white opacity05">
																						<?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?>
																						</span>
																					</div>
																					<div class="col-12 p-0 VBzxc">
																						<span class="white yorumk opacity05  ">
																							(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)
																						</span>
																					</div>
																				</div>
																			</div>

																			<?php
																			if ($YorumCevapKayit["Durum"]==4) {
																			?>
																				<div class="col-12 mt-2 " >
																					<span class="ASewrQz"><i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="text-decoration: none;color: white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
																				</div>
																			<?php
																			}else{
																			?>	
																				<div class="col-12 mt-2 " >
																					<span class="sadxzaA yorumk "><?php echo IcerikTemizle($YorumCevapKayit["Yorum"]);?></span>
																				</div>
																			<?php
																			}
																			?>
																		<?php
																		}
																		?>
																	</div>
																</div>
															</div>
															<?php
															}
														}else{
														?>
														<div class="col-12  p-3" > </div>
														<?php
														}
														?>
													</div>
													<div class="col-12 mt-1" <?php if(isset($_SESSION["Kullanici"])){ ?> id="cy<?php echo IcerikTemizle($YorumId); ?>"  <?php }else{ ?> <?php } ?> ></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									}
									?>
									<div class="col-12 text-center">
										<a href="oyuntumyorumlar/<?php echo SEO(IcerikTemizle($OyunSorgusuKayit["OyunAdi"])); ?>/<?php echo  IcerikTemizle($OyunId); ?>">
											<button class="call-to-action2" >
												<div>
													<div>Tüm Yorumlar</div>
												</div>
											</button>
										</a>							
									</div>
									<?php
									}else{
									?>
										<div class="col-12 mt-2 p-3 white haberdra " style=" background: rgb(0,0,0,0.5); ">
											<p>Henüz yorum yapılmamış.</p> 
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
		<?php
		}else{
			header('Location:'. $SiteLink );
			exit();
		}
	}else{
		header('Location:'. $SiteLink);
		exit();
	}
	?>

<?php
if (isset($_SESSION["Kullanici"])) {
?>
<script type="text/javascript">
	$(document).ready(function(){

	$('body').on('click' , '.ys', function() {
		i =  $(this).attr('data'); 
		$("#yg"+i).trigger('reset');
		$(".yss").fadeOut();
		$(".ysb").fadeOut();
		$("#yg"+i).fadeIn();
	});  

	$('body').on('click' , '.yseb', function() {
		i =  $(this).attr('data'); 
		$.ajax({
			type:"post",
			url:"y_sikayet.php",
			data:$("#yg"+i).serialize(), 
			success:function(b){
				if (b==1) {
					$(".yss").html("<span class='bold font13 ' style=' color:red'>Şikayetiniz Alınamadı.</span>").hide().fadeIn();
				}else if(b==2){
					$(".yss").html("<span class='bold font13 ' style=' color:red'>Şikayet nedeniniz 250 karakterden uzun olamaz.</span>").hide().fadeIn();
				}else{
					$(".yss").fadeOut();
					$(".ysb").fadeOut();
					$(".ysb").html(b).hide().fadeIn();
					$("#yg"+i).trigger('reset');
					$("#yg"+i).fadeOut();
				}	
			}
		});    
	});


	$('body').on('click' , '.ycs', function() {
		i =  $(this).attr('data'); 
		$("#ycg"+i).trigger('reset');
		$(".ycss").fadeOut();
		$(".ycsb").fadeOut();
		$("#ycg"+i).fadeIn();
	});  

	$('body').on('click' , '.ycseb', function() {
		i =  $(this).attr('data'); 
		$.ajax({
			type:"post",
			url:"y_sikayet.php",
			data:$("#ycg"+i).serialize(), 
			success:function(b){
				if (b==1) {
					$(".ycss").html("<span class='bold font13 ' style=' color:red'>Şikayetiniz Alınamadı.</span>").hide().fadeIn();
				}else if(b==2){
					$(".ycss").html("<span class='bold font13 ' style=' color:red'>Şikayet nedeniniz 250 karakterden uzun olamaz.</span>").hide().fadeIn();
				}else{
					$(".ycss").fadeOut();
					$(".ycsb").fadeOut();
					$(".ycsb").html(b).hide().fadeIn();
					$("#ycg"+i).trigger('reset');
					$("#ycg"+i).fadeOut();
				}	
			}
		});    
	});

	$("#star-5x").click(function(){  
		puan =  $(this).attr('value'); 
		oyun= $(this).attr('data');
		var txt;
		var r = confirm("Oyunu kullanmak istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post", 
				url:"oyunp_s.php",
				data:{puan:puan,oyun:oyun}, 
				success:function(cevap){ 
					$(".star-rating").remove();
					$(".puan").html(cevap);
				}
			});
		}else{

		}
	});


	$("#star-4x").click(function(){  
		puan =  $(this).attr('value'); 
		oyun= $(this).attr('data'); 
		var txt;
		var r = confirm("Oyunu kullanmak istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post", 
				url:"oyunp_s.php",
				data:{puan:puan,oyun:oyun}, 
				success:function(cevap){ 
					$(".star-rating").remove();
					$(".puan").html(cevap);
				}
			});
		}else{

		}
	});

	$("#star-3x").click(function(){  
		puan =  $(this).attr('value'); 
		oyun= $(this).attr('data');  
		var txt;
		var r = confirm("Oyunu kullanmak istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post", 
				url:"oyunp_s.php",
				data:{puan:puan,oyun:oyun}, 
				success:function(cevap){ 
					$(".star-rating").remove();
					$(".puan").html(cevap);
				}
			});
		}else{

		}
	});

	$("#star-2x").click(function(){  
		puan =  $(this).attr('value'); 
		oyun= $(this).attr('data'); 
		var txt;
		var r = confirm("Oyunu kullanmak istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post", 
				url:"oyunp_s.php",
				data:{puan:puan,oyun:oyun}, 
				success:function(cevap){ 
					$(".star-rating").remove();
					$(".puan").html(cevap);
				}
			});
		}else{

		}
	});

	$("#star-1x").click(function(){  
		puan =  $(this).attr('value'); 
		oyun= $(this).attr('data'); 
		var txt;
		var r = confirm("Oyunu kullanmak istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post", 
				url:"oyunp_s.php",
				data:{puan:puan,oyun:oyun}, 
				success:function(cevap){ 
					$(".star-rating").remove();
					$(".puan").html(cevap);
				}
			});
		}else{

		}
	});


	$('body').on('click' , '#oyg', function() {  
		$.ajax({
			type:"post", 
			url:"oyuny_s.php",
			data:$("#oyuny").serialize(),
			success:function(cevap){ 
				if (cevap=="1") {
					$("#oyuny").trigger('reset');
					$("#oyuny").fadeIn();
					$("#oys").html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.</span> </span>');
					$("#oys").fadeOut(5000);
				}else if (cevap=="2"){
					$("#oyuny").trigger('reset');
					$("#oyuny").fadeIn();
					$("#oys").html('<span class=" text-left yorumk" > <span style="color:red;">Yorumunuz boş bırakılamaz.</span></span>');
					$("#oys").fadeOut(5000);
				}else{
					$("#oyuny").trigger('reset');
					$(".yorumlar").fadeIn(2000).prepend(cevap).hide().fadeIn(2000);
				}
			}
		});
	});


	$('body').on('click' , '.oycg', function() {
		i =  $(this).attr('data');
		$.ajax({
			type:"post", 
			url:"oyunyc_s.php",
			data:$("#oyc"+i).serialize(), 
			success:function(cevap){ 
				if (cevap=="1") {
					$("#oyc"+i).trigger('reset');
					$("#c"+i).fadeIn();
					$("#c"+i).html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.</span> </span>');
					$("#c"+i).fadeOut(5000);	
				}else if (cevap=="2"){
					$("#oyc"+i).trigger('reset');
					$("#c"+i).fadeIn();
					$("#c"+i).html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz boş bırakılamaz.</span> </span>');
					$("#c"+i).fadeOut(5000);	
				}else{
					$("#oyc"+i).trigger('reset');
					$("#cy"+i).append(cevap).hide().fadeIn(2000);
				}
			}
		});
	});


	$('body').on('click' , '.oysb', function() {
		i =  $(this).attr('data'); 
		var txt;
		var r = confirm("Bu yorumu silmek istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post",
				url:"oyunys_s.php",
				data:{yi:i}, 
				success:function(a){
					if (a==1) {
						$("#y"+i).html("<div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div>");
						$("#y"+i).remove();
						$("#cy"+i).remove();
					}else{
						$("#oy"+i).html(a);
						setTimeout(function() { $('#oy'+i).hide(); }, 2000); 
					}
				}
			});
		}else{

		}
	});

	$('body').on('click' , '.oycsb', function() {
		i =  $(this).attr('data'); 
		var txt;
		var r = confirm("Bu yorumu silmek istediğine emin misin?");
		if (r == true) {
			$.ajax({
				type:"post",
				url:"oyunycs_s.php",
				data:{yci:i}, 
				success:function(a){
					if (a==1) {
						$("#cs"+i).html("<div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div>");
						$("#cs"+i).remove();
					}else{
						$("#ss"+i).html(a);
						setTimeout(function() { $('#ss'+i).hide(); }, 2000); 
					}
				}
			});
		}else{

		}
	});

	$('body').on('click' , '.ofe', function() {
		i=$(this).attr('data'); 
		$.ajax({
			type:"post",
			url:"oyunfe_s.php",
			data:{fei:i}, 
			success:function(a){
				$(".ofes"+i).html(a);	
			}
		});    
	});
});
</script>
<?php
}
?>

<script type="text/javascript">
	$(".odr").css("display", "none");
	$(".odr").fadeIn("slow");
	$(".ody").css("display", "none");
	$(".ody").show("slow");
	$(".odyc").css("display", "none");
	$(".odyc").show("slow");
</script>

<script type="text/javascript">
let ctx = document.getElementById('myChart').getContext('2d');
let labels = ['Çok Olumsuz', 'Olumsuz', 'Kararsız', 'Olumlu',"Çok Olumlu"];
let colorHex = ['#FB3640', '#EFCA08', '#43AA8B', '#253D5B'];
let myChart = new Chart(ctx, {
type: 'pie',
data: {
datasets: [{
	data: [<?php echo $CokOlumsuzOrtalama ?>,<?php echo $OlumsuzOrtalama ?>,<?php echo $KararsizOrtalama ?>,<?php echo $OlumluOrtalama ?>,<?php echo $CokOlumluOrtalama ?>],
	backgroundColor: colorHex
}],
labels: labels,
},
options: {
responsive: true,
legend: {
	position: 'right'
},
plugins: {
	datalabels: {
	color: '#fff',
	anchor: 'end',
	align: 'end',
	offset: -30,
	borderWidth: 2,
	borderColor: '#fff',
	borderRadius: 10,
	weight:'bold',
	backgroundColor: (context) => {
		return context.dataset.backgroundColor;
	},
	font: {
		weight: 'bold',
		size: '10',
	},
	formatter: (value) => {
		return value + ' %';
	}
	}
}
}
})
</script>

<script type="text/javascript">
jQuery(document).ready(function ($) {
var jssor_1_options = {
  $AutoPlay: 1,
  $SlideWidth: 720,
  $ArrowNavigatorOptions: {
    $Class: $JssorArrowNavigator$
  },
  $BulletNavigatorOptions: {
    $Class: $JssorBulletNavigator$,
    $SpacingX: 16,
    $SpacingY: 16
  }
};
var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
var MAX_WIDTH = 1600;
function ScaleSlider() {
    var containerElement = jssor_1_slider.$Elmt.parentNode;
    var containerWidth = containerElement.clientWidth;
    if (containerWidth) {
        var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
        jssor_1_slider.$ScaleWidth(expectedWidth);
    }
    else {
        window.setTimeout(ScaleSlider, 30);
    }
}
ScaleSlider();
$(window).bind("load", ScaleSlider);
$(window).bind("resize", ScaleSlider);
$(window).bind("orientationchange", ScaleSlider);
          
});
</script>
