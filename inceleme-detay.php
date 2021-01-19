<?php
if(isset($_GET["Inceleme"])){

	$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
	$Banner->execute([36,1]);
	$BannerVeri = $Banner->rowCount();
	$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
	if ($BannerVeri>0) {
	?>
	<div class="col-12 text-center  ">
		<div class="row justify-content-center align-items-center" >
			<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([36] );	
			?>
		</div>
	</div>
	<?php
	}
			
	$IncelemeId =SayfaNumarasiTemizle(Guvenlik($_GET["Inceleme"]));	
	$IncelemeSorgusu = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE Incelemeid=? and Durum=? LIMIT 1");
	$IncelemeSorgusu->execute([$IncelemeId,1]);
	$IncelemeSorgusuVeri = $IncelemeSorgusu->rowCount();
	$IncelemeSorgusuKayitlar = $IncelemeSorgusu->fetch(PDO::FETCH_ASSOC);
	if($IncelemeSorgusuVeri>0){

		$Goruntulenme = $DatabaseBaglanti->prepare("UPDATE incelemeler SET Goruntulenme=Goruntulenme+1 WHERE Incelemeid=? AND Durum=? LIMIT 1");
		$Goruntulenme->execute([$IncelemeId,1]);

		$OyunBilgiler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  id=? and Durum=? LIMIT 1 ");
		$OyunBilgiler->execute([$IncelemeSorgusuKayitlar["OyunId"],1]);
		$OyunBilgilerVeri = $OyunBilgiler->rowCount();
		$OyunBilgilerKayit = $OyunBilgiler->fetch(PDO::FETCH_ASSOC);
		if ($OyunBilgilerVeri>0) {

			$OyunAdi= $OyunBilgilerKayit["OyunAdi"];

			$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
			$KuratorAdi->execute([$IncelemeSorgusuKayitlar["KuratorId"]]);
			$KuratorAdiVeri = $KuratorAdi->rowCount();
			$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
			?>

			<?php
			$OyunResimler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunresimler WHERE  OyunId=? ");
			$OyunResimler->execute([$OyunBilgilerKayit["id"]]);
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
					if ( IcerikTemizle($Resimler["Resim"]!="") and IcerikTemizle(isset($Resimler["Resim"])) and file_exists("images/games/".IcerikTemizle($Resimler["Resim"])) ) {
					?>	
						<div>
							<a href="images/games/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" style="overflow: hidden;" data-lightbox="image-1">
								<img  data-u="image" src="images/games/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" class="img-fluid "/>
							</a>
						</div>
					<?php
					}else{
					?>	
						<div>
							<img data-u="image" src="images/hata2.jpg" class="img-fluid "/>
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
				<div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:35px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
					<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;right:-35px;width:100%;height:100%;">
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

			<div class="col-12 mt-3 mb-2 ">
				<div class="row justify-content-center align-items-center">
				<?php
				if(isset($_SESSION["Kullanici"])){
				?>

					<?php
					if ($KullaniciId==$IncelemeSorgusuKayitlar["KuratorId"]) {
						?>

						<?php
					}else{
						?>
						<div class="col-12 col-xl-10 mb-2  text-right" >
							<span class="bold white idetaya  seb" data-toggle="modal" data-target="#sikayet" style="cursor:pointer;">
								<i style="color:#c28f2c" class="fas fa-flag white"></i> Şikayet Et
							</span>
						</div>
					<?php
					}
					?>
				<?php	
				}else{
				?>

				<?php
				}
				?>
				<div class="col-12 col-xl-10 p-4 asdxzcbzxcvZX">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center text-xl-left mb-xs-2 col-xl-8 kt<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?>">
							<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
							<?php
							if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
							?>
								<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid VBRTERXC" >
							<?php
							}else{
							?>
								<img src="images/user.png" class="img-fluid HJidxzx" >
							<?php
							}
							?>
								<span class="bold white font15"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?></span> 
							</a>
							
							<?php
							if(isset($_SESSION["Kullanici"] )){
							?>
								<?php	
								$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=?  LIMIT 1" );
								$TakipKontrol->execute([$IncelemeSorgusuKayitlar["KuratorId"],$KullaniciId]);
								$TakipKontrolVeri = $TakipKontrol->rowCount();
								$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
								if ($TakipKontrolVeri>0) {
								?>
									<?php
									if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
									?>

									<?php
									}else{
									?>
										<span class="bold white font15">•</span> 
										<span  class="bold font13  kte  "  data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?>" style="color: green;cursor:pointer;">
											<i class="fas fa-user-check font20" ></i>
										</span>
									<?php
									}
									?>
								<?php
								}else{
								?>	
									<?php
									if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
									?>

									<?php
									}else{
									?>
										<span class="bold white font15">•</span> 
										<span  class="bold font13 kte" data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?>" style="color: #0aa5ff;cursor:pointer;">
											<i class="fas fa-user-plus font20" ></i></span>
									<?php
									}
									?>
								<?php
								}
								?>
							<?php
							}else{
							?>
								<span class="bold white font15">•</span> 
								<a href="girisyap" >
									<span class="bold font13" style="color: #0aa5ff">
										<i class="fas fa-user-plus font20" ></i> 
									</span>
								</a>
							<?php
							}
							?>
						</div>
						<div class="col-12 col-xl-4 text-center mb-xs-2 text-xl-right">
							<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunBilgilerKayit["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunBilgilerKayit["id"]); ?>">
								<i class="fas fa-gamepad white "></i>
								 <span class="bold white font14"><?php echo IcerikTemizle($OyunAdi);?></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 mt-2 mb-3">
			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-xl-10 p-3 bold asdxzcbzxcvZX" >
					<h4 class="white bold idetayb"><?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Baslik"]); ?></h4>
				</div>
				<div class="col-12 col-xl-10 mt-3 p-4 bold white  asdxzcbzxcvZX" >
					<div class="opacity07 idetaya" ><?php echo IcerikTemizle($IncelemeSorgusuKayitlar["IncelemeYazisi"]); ?></div>
						<div class="col-12 mt-4 ">
							<div class="row justify-content-end align-items-center">
								<div class="col-12 text-center text-xl-right ibbs<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>">
								
								<?php
								if(isset($_SESSION["Kullanici"] )){
								?>
									<?php	
									$BegeniKontrol = $DatabaseBaglanti->prepare("SELECT * FROM  incelemebegeni WHERE IncelemeId=? and UyeId=? LIMIT 1 " );
									$BegeniKontrol->execute([$IncelemeId,$KullaniciId]);
									$BegeniKontrolVeri = $BegeniKontrol->rowCount();
									$BegeniKontrolKayitlar = $BegeniKontrol->fetch(PDO::FETCH_ASSOC);
									if ($BegeniKontrolVeri>0) {
									?>
										<?php
										if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
										?>
											<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span>
										<?php
										}else{
										?>
											<span class="white bold font12 opacity07">
												(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)
											</span>
											 <i style="cursor: pointer; color:#c28f2c;font-size:20px" class="fas fa-thumbs-up white mr-2 ibb "  data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>"></i> 
										<?php
										}
										?>
									<?php
									}else{
									?>	
										<?php
										if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
										?>
											<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span>
										<?php
										}else{
										?>
											<span class="white bold font12 opacity07">(<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Begeni"]) ?>)</span> <i style="cursor: pointer;font-size:20px"  class="far fa-thumbs-up  white mr-2 ibb" data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>" ></i> 
										<?php
										}
										?>
										<?php
									}
									?>
								<?php
								}else{
								?>
									<a href="girisyap">
										<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span> 
										<i class="far fa-thumbs-up fa-2x white mr-2" style="font-size:20px"></i> 
									</a>
								<?php
								}
								?>
									| <a  class="ml-2 idetaya" style="color: #0aa5ff" href="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["IncelemeLink"])  ?>" target="_blank">Daha fazlasını görmek için...</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php
			if (IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) and file_exists("images/inceleme/".$IncelemeSorgusuKayitlar["Resim1"]) and ($IncelemeSorgusuKayitlar["Resim1"]!="")) {
			?>
			<div class="col-12 mt-2 mb-3">
				<div class="row justify-content-center align-items-center">
					<div class="col-12 col-xl-10">
						<div class="row justify-content-center asdxzcbzxcvZX">
							<div class="col-12 p-4">
								<span class="bold white idetaya">İnceleme Görseller</span>
							</div>
							<div class="col-6">
								<div class="row justify-content-center align-items-center  text-center">
									<div class="col-12  p-0 m-3 col-xl-10">
										<a href="images/inceleme/<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) ?>" style="overflow: hidden;"  data-lightbox="image-1" >
											<img src="images/inceleme/<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) ?>" class="img-fluid" >
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
			$KuratorIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? and Durum=?");
			$KuratorIncelemeKontrol->execute([$IncelemeSorgusuKayitlar["KuratorId"],1]);
			$KuratorIncelemeKontrolVeri = $KuratorIncelemeKontrol->rowCount();
			if ($KuratorIncelemeKontrolVeri>0) {
			?>
			<div class="col-12 mt-1 mb-3">
				<div class="row  justify-content-center align-items-center m-0">
					<div class="col-12 col-xl-10 p-3 asdxzcbzxcvZX"  >
						<span class="bold white idetaya">Kürator İncelemeleri</span>
					</div>
					<div class="col-12 col-xl-10 p-2" >
					<?php
					if ($KuratorIncelemeKontrolVeri>6) {
					?>	
						<div class="row p-3 justify-content-end">
							<div class="col-6 col-xl-1  p-1 text-center ErYTIxKL" >
								<a href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>" >
									<span class=" gxPpxXo_ font10"> DAHA FAZLA GÖSTER</span>
								</a>
							</div>
						</div>
					<?php
					}
					?>
						<div class="row  align-items-center m-0">
						<?php
						$KuratorInceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.KuratorId=? and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? LIMIT 6");
						$KuratorInceleme->execute([$IncelemeSorgusuKayitlar["KuratorId"],1,1,1]);
						$KuratorIncelemeVeri = $KuratorInceleme->rowCount();
						$KuratorIncelemeKayitlar = $KuratorInceleme->fetchAll(PDO::FETCH_ASSOC);
						if ($KuratorIncelemeVeri>0) {
							foreach ($KuratorIncelemeKayitlar as  $Kuratorkayitlar) {
								if ($Kuratorkayitlar["Incelemeid"]!= $IncelemeId) {
								$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
								$OyunAdi->execute([$Kuratorkayitlar["OyunId"]]);
								$OyunAdiVeri = $OyunAdi->rowCount();
								$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

								$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
								$KuratorAdi->execute([$Kuratorkayitlar["KuratorId"]]);
								$KuratorAdiVeri = $KuratorAdi->rowCount();
								$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-6 col-md-6 col-xl-2 mb-3">
								<div class="row p-1">
									<div class="col-12">
										<div class="row align-items-end ">
											<div class="col-12 p-0 " style="background: black" >
											<?php
											if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
											?>
												<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
													<img src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05"  >	  
												</a>
											<?php
											}else{
											?>	
												<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
													<img src="images/resim.jpg" class="img-fluid ">
												</a> 
											<?php
											}
											?>
											</div>

											<div class="col-12 position-absolute p-0 dsxzhdrt">
												<div class="row align-items-center p-2 ">
													<div class="col-12 mt-5 hgbnzXX">
														<a  href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
															<span class="bold white incelemeb" >
																<?php echo  IcerikTemizle($Kuratorkayitlar["Baslik"]); ?> 
															</span> 
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
						}
						}
						?>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>

			<?php
			$OyunIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE OyunId=? and Durum=? ");
			$OyunIncelemeKontrol->execute([$IncelemeSorgusuKayitlar["OyunId"],1]);
			$OyunIncelemeKontrolVeri = $OyunIncelemeKontrol->rowCount();
			if ($OyunIncelemeKontrolVeri>0) {
			?>
			<div class="col-12 mt-1 mb-3">
				<div class="row justify-content-center align-items-center m-0 ">
					<div class="col-12 col-xl-10 p-3 asdxzcbzxcvZX">
						<span class="bold white idetaya"> <?php echo  IcerikTemizle($OyunBilgilerKayit["OyunAdi"]); ?> İncelemeleri</span>
					</div>

					<div class="col-12 col-xl-10 p-2">
					<?php
					if ($OyunIncelemeKontrolVeri>6) {
					?>	
						<div class="row p-3 justify-content-end">
							<div class="col-6 col-xl-1 p-1 text-center ErYTIxKL  "  >
								<a href="oyunincelemeler/&Ara=<?php echo IcerikTemizle($OyunBilgilerKayit["OyunAdi"]) ?>/1" style="text-decoration: none">
									<span class=" gxPpxXo_ font10"> DAHA FAZLA GÖSTER</span>
								</a>
							</div>
						</div>
					<?php
					}
					?>

						<div class="row  align-items-center m-0 ">
						<?php	
						$OyunInceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.OyunId=?  and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? LIMIT 6");
						$OyunInceleme->execute([$IncelemeSorgusuKayitlar["OyunId"],1,1,1]);
						$OyunIncelemeVeri = $OyunInceleme->rowCount();
						$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);

						if ($OyunIncelemeVeri>0) {
							foreach ($OyunIncelemeKayitlar as  $IncelemeKayitlar) {
								if ($IncelemeKayitlar["Incelemeid"]!= $IncelemeId) {
								$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
								$OyunAdi->execute([$IncelemeKayitlar["OyunId"]]);
								$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

								$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
								$KuratorAdi->execute([$IncelemeKayitlar["KuratorId"]]);
								$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="col-6 col-md-6 col-xl-2  mb-3 ">
								<div class="row p-1">
									<div class="col-12">
										<div class="row align-items-end">
											<div class="col-12 p-0 " style="background: black"   >
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
													<img src="images/resim.jpg" class="img-fluid ">		
											  	</a> 
											<?php
											}
											?>
											</div>

											<div class="col-12 position-absolute p-0 dsxzhdrt">
												<div class="row align-items-center p-2 ">
													<div class="col-12 mt-5 ">
														<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
															<p  class="hgbnzXX bold white incelemeb mb-1" >
																<?php echo  IcerikTemizle($IncelemeKayitlar["Baslik"]); ?> 
															</p> 
														</a>
														<p class="p-0 m-0">
															<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
															<?php 
															if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="")) {
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid adzxbyZXC">
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid ZXMHXCJ" >
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
						}
						}
						?>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		<?php
		}else{
			header('Location:'. $SiteLink );
			exit();
		}
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
if (isset($_SESSION["Kullanici"]) and ($IncelemeSorgusuKayitlar["KuratorId"] != $KullaniciId)) {
?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('body').on('click' , '.kte', function() {
				i=$(this).attr('data'); 
				$.ajax({
					type:"post",
					url:"k_tkp.php",
					data:{te:i}, 
					success:function(a){
						$(".kt"+i).html(a);
					}
				});    
			});

			$('body').on('click' , '.ibb', function() {
				i=$(this).attr('data'); 
				$.ajax({
					type:"post",
					url:"inc_bgn.php",
					data:{ib:i}, 
					success:function(b){
						$(".ibbs"+i).html(b);
					}
				});    
			});
		});
	</script>

	<?php
	if ($KullaniciId!=$IncelemeSorgusuKayitlar["KuratorId"]) {
	?>
		<script>
		$(document).ready(function(){
			$('body').on('click' , '.seb', function() {
				$(".iss").html('');
				$(".isb").fadeOut();
				$(".isg").fadeIn();
			});  

			$('body').on('click' , '.ise', function() {
				$.ajax({
					type:"post",
					url:"inc_sikayet.php",
					data:$(".isg").serialize(), 
					success:function(b){
						if (b==1) {
							$(".iss").html("<span class='bold font13 ' style=' color:red'>Şikayetiniz Alınamadı.</span>");
						}else if(b==2){
							$(".iss").html("<span class='bold font13 ' style=' color:red'>Şikayet nedeniniz 250 karakterden uzun olamaz.</span>");
						}else{
							$(".iss").html('');
							$(".isb").fadeOut();
							$(".isb").html(b).hide().fadeIn();
							$(".isg").trigger('reset');
							$(".isg").fadeOut();
						}	
					}
				});    
			});

		});
		</script>

		<div class="modal fade" id="sikayet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="background: #202020">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" class="white">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="col-12 text-center  mt-2 iss"></div>
						<div class="col-12 text-center isb mt-2"></div>
						<form class=" isg " method="post" action="javascript:void(0);">
							<div class="col-12 mt-2">
								<div class="col-12 text-left p-0 white bold font13" >Şikayet nedeniniz nedir?</div>      
								<textarea type="text" id="textt" style="background: black;color:white;width: 100%;border:none" name="Sikayet"></textarea>
								<input type="hidden" name="in" value="<?php echo IcerikTemizle($IncelemeId) ?>">
								<div id="character" class="bold  font13" style="color:#585858">Maksimum karakter:250</div>
							</div>
							<div class="col-12  mt-3 mb-3  p-0  text-center  " >
								<button class="call-to-action2  ise" >
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
	}else{
	?>
		
	<?php
	}
	?>

<?php
}
?>
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
            }else{
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
    });
</script>