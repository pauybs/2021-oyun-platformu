
<div class="col-12 mt-5 " >			
	<div class="row justify-content-center">
		<div class="col-12 col-md-8">
			<?php
			$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
			$BannerSorgu->execute([1,1]);
			$Data = $BannerSorgu->rowCount();
			$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
			if ($Data>0) {
			?>
				<div class="row justify-content-center align-items-center text-center" >
					<div class="col-12">
						<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
						<?php
							$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
							$BannerGuncelleme->execute([1] );	
						?>
					</div>
				</div>
			<?php
			}
			?>

			<div class="row justify-content-center mt-3 m-0">
				<div class="col-12 col-xl-3">
					<div class="row justify-content-center align-items-center">
						<?php 
						$SolUst = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 1,1");
						$SolUst->execute([1]);
						$SolUstVeri = $SolUst->rowCount();
						$SolUstKayitlar =  $SolUst-> fetchAll(PDO::FETCH_ASSOC);
						if ($SolUstVeri>0) {
						?>
						<div class="col-6 col-xl-12 ">
							<?php
							foreach ($SolUstKayitlar as $solusthaber){
							?>
								<div class="row p-1">
									<div class="col-12">
										<div class="row align-items-end">
											<?php
											if (file_exists("images/news/".$solusthaber["AnaResim"]) and ($solusthaber["AnaResim"]) ) {
											?>
												<div class="col-12 p-0">
													<a href="haberdetay/<?php echo  SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["id"]); ?>">
														<img src="images/news/<?php echo IcerikTemizle($solusthaber["AnaResim"]) ?>" class="img-fluid resim wWfVCA a">		 
													</a>						
												</div>
												
												<div class="col-12 position-absolute p-0 __aSFczza" >
													<div class="row p-2">
														<div class="col-12">	
															<a href="haberdetay/<?php echo  SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["id"]); ?>">
																<h2  class="a uQRtXT haberYan mt-2">
																	<?php echo IcerikTemizle($solusthaber["AnaBaslik"]) ?>	
																</h2>
															</a>
														</div>
													</div>										
												</div>
											<?php
											}else{
											?>
												<div class="col-12 p-0" >
													<a href="haberdetay/<?php echo SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["id"]); ?>">
														<img src="images/hata.jpg" class="img-fluid resim">
													</a>	
												</div>
												
												<div class="col-12 position-absolute p-0 __aSFczza" >
													<div class="row p-2">
														<div class="col-12">	
															<a href="haberdetay/<?php echo SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["id"]);?>">
																<h2  class="uQRtXT haberYan mt-2">
																	<?php echo IcerikTemizle($solusthaber["AnaBaslik"]) ?>
																</h2>
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
							<?php	
							}
							?>
						</div>
						<?php
						}else{
						?>
							<div class="col-6 col-xl-12 m-0">
								<div class="row p-0">
									<div class="col-12 m-0 p-0">
										<img src="images/hata.jpg" class="img-fluid resim">
									</div>
								</div>
							</div>
						<?php
						}
						?>

						<?php 
						$SolAlt = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=? ORDER BY id DESC  LIMIT 2,1");
						$SolAlt->execute([1]);
						$SolAltVeri = $SolAlt->rowCount();
						$SolAltKayitlar =  $SolAlt-> fetchAll(PDO::FETCH_ASSOC);
						if ($SolAltVeri>0) {
						?>
						<div class="col-6 col-xl-12 ">
						<?php
						foreach ($SolAltKayitlar as $SolAltHaber){
						?>
							<div class="row p-1">
								<div class="col-12">
									<div class="row align-items-end">
										<?php
										if (file_exists("images/news/".$SolAltHaber["AnaResim"])  and ($SolAltHaber["AnaResim"]) ) {
										?>
											<div class="col-12 p-0">
												<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SolAltHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($SolAltHaber["id"]); ?>">
													<img src="images/news/<?php echo IcerikTemizle($SolAltHaber["AnaResim"]) ?>" class="img-fluid resim wWfVCA a">		 
												</a>						
											</div>
											<div class="col-12 position-absolute p-0 __aSFczza">
												<div class="row p-2 ">
													<div class="col-12 ">	
														<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SolAltHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($SolAltHaber["id"]); ?>" >
															<h2 class="a uQRtXT haberYan mt-2">
																<?php echo IcerikTemizle($SolAltHaber["AnaBaslik"]) ?>
															</h2>
														</a>
													</div>
												</div>										
											</div>
										<?php
										}else{
										?>
											<div class="col-12 p-0">
												<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SolAltHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($SolAltHaber["id"]); ?>" >
													<img src="images/hata.jpg" class="img-fluid resim">
												</a>	
											</div>
											<div class="col-12 position-absolute p-0 cvzxcdrZ">
												<div class="row p-4">
													<div class="col-12">	
														<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SolAltHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($SolAltHaber["id"]); ?> " >
															<h2  class="uQRtXT haberYan mt-2">
																<?php echo IcerikTemizle($SolAltHaber["AnaBaslik"]) ?>	
															</h2>
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
						<?php	
						}
						?>
					</div>
					<?php
					}else{
					?>
						<div class="col-6 col-xl-12 m-0 ">
							<div class="row p-0">
								<div class="col-12 m-0 p-0">
									<img src="images/hata.jpg" class="img-fluid resim">
								</div>
							</div>
						</div>
					<?php
					}
					?>	
				</div>
			</div>


			<?php 
			$OrtaHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 1");
			$OrtaHaber->execute([1]);
			$OrtaHaberVeri = $OrtaHaber->rowCount();
			$OrtaHaberKayitlar =  $OrtaHaber-> fetchAll(PDO::FETCH_ASSOC);
			if ($OrtaHaberVeri>0) {
			?>
			<div class="col-12 col-xl-6 ">
				<?php
				foreach ($OrtaHaberKayitlar as $OrtaSonHaber){
				?>
					<div class="row p-1">
						<div class="col-12">
							<div class="row align-items-end   ">
								<?php
								if (file_exists("images/news/".$OrtaSonHaber["AnaResim"])  and ($OrtaSonHaber["AnaResim"]) ) {
								?>
									<div class="col-12 p-0 " >
										<a href="haberdetay/<?php echo  SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"])); ?>/<?php echo IcerikTemizle($OrtaSonHaber["id"]); ?>" >
											<img src="images/news/<?php echo IcerikTemizle($OrtaSonHaber["AnaResim"]); ?>" class="img-fluid resim wWfVCA a">		 
										</a>						
									</div>
									<div class="col-12   position-absolute	 p-0 __aSFczza" >
										<div class="row p-2 ">
											<div class="col-12 ">	
												<a href="haberdetay/<?php echo  SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["id"]); ?> " >
													<h2  class="a uQRtXT haberAna mt-2">
														<?php echo IcerikTemizle($OrtaSonHaber["AnaBaslik"]) ?>
													</h2>
												</a>
											</div>
										</div>										
									</div>
								<?php
								}else{
								?>
									<div class="col-12 p-0">
										<a href="haberdetay/<?php echo SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["id"]); ?>">
											<img src="images/hata.jpg" class="img-fluid resim">
										</a>	
									</div>
									<div class="col-12 position-absolute  p-0" >
										<div class="row p-2">
											<div class="col-12 ">	
												<a href="haberdetay/<?php echo SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["id"]); ?>">
													<h2 class="uQRtXT haberAna mt-2"><?php echo IcerikTemizle($OrtaSonHaber["AnaBaslik"]) ?></h2>
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
				<?php	
				}
				?>
			</div>
			<?php
			}else{
			?>	
				<div class="col-12 col-xl-6 ">
					<div class="row p-0">
						<div class="col-12 m-0 p-0" >
							<img src="images/hata.jpg" class="img-fluid resim">
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<div class="col-12 col-xl-3">
				<div class="row">
					<?php 
					$SagUstHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 3,1");
					$SagUstHaber->execute([1]);
					$SagUstHaberVeri = $SagUstHaber->rowCount();
					$SagUstHaberKayitlar =  $SagUstHaber-> fetchAll(PDO::FETCH_ASSOC);
					if ($SagUstHaberVeri>0) {
					?>
					<div class="col-6 col-xl-12 ">
					<?php
					foreach ($SagUstHaberKayitlar as $SagUst){
					?>
						<div class="row p-1">
							<div class="col-12">
								<div class="row align-items-end">
									<?php
									if (file_exists("images/news/".$SagUst["AnaResim"])  and ($SagUst["AnaResim"]) ) {
									?>
										<div class="col-12 p-0">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"])); ?>/<?php echo IcerikTemizle($SagUst["id"]); ?>">
												<img src="images/news/<?php echo IcerikTemizle($SagUst["AnaResim"]);?>" class="img-fluid resim wWfVCA a">		 
											</a>					
										</div>
										
										<div class="col-12 position-absolute p-0 __aSFczza">
											<div class="row p-2 ">
												<div class="col-12 ">	
													<a href="haberdetay/<?php echo SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["id"]); ?> ">
														<h2 class="a uQRtXT haberYan mt-2"><?php echo IcerikTemizle($SagUst["AnaBaslik"]) ?></h2>
													</a>
												</div>
											</div>										
										</div>
									<?php
									}else{
									?>
										<div class="col-12 p-0 " >
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["id"]); ?>" >
												<img src="images/hata.jpg" class="img-fluid resim  "  >
											</a>	
										</div>
										<div class="col-12 position-absolute  p-0" >
											<div class="row p-2 ">
												<div class="col-12 ">	
													<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["id"]); ?> " >
														<h2  class="uQRtXT haberYanmt-2"><?php echo IcerikTemizle($SagUst["AnaBaslik"]) ?></h2>
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
					<?php	
					}
					?>
					</div>
					<?php
					}else{
					?>
						<div class="col-6 col-xl-12 m-0 ">
							<div class="row p-0">
								<div class="col-12 m-0 p-0" >
									<img src="images/hata.jpg" class="img-fluid resim  "   >
								</div>
							</div>
						</div>
					<?php
					}
					?>		

					<?php 
					$SagAltHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 4,1");
					$SagAltHaber->execute([1]);
					$SagAltHaberVeri = $SagAltHaber->rowCount();
					$SagAltHaberKayitlar =  $SagAltHaber-> fetchAll(PDO::FETCH_ASSOC);
					if ($SagAltHaberVeri>0) {
					?>
					<div class="col-6 col-xl-12 ">
					<?php
					foreach ($SagAltHaberKayitlar as $SagAlt){
					?>
						<div class="row p-1">
							<div class="col-12">
								<div class="row align-items-end  ">
									<?php
									if (file_exists("images/news/".$SagAlt["AnaResim"])  and ($SagAlt["AnaResim"]) ){
									?>
										<div class="col-12 p-0"  >
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagAlt["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagAlt["id"]); ?>">
												<img src="images/news/<?php echo IcerikTemizle($SagAlt["AnaResim"]) ?>" class="img-fluid resim wWfVCA a"   >		 
											</a>						
										</div>
										
										<div class="col-12 position-absolute p-0 __aSFczza">
											<div class="row p-2 ">
												<div class="col-12 ">	
													<a href="haberdetay/<?php echo SEO(IcerikTemizle($SagAlt["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagAlt["id"]); ?>">
														<h2 class="a uQRtXT haberYan mt-2"><?php echo IcerikTemizle($SagAlt["AnaBaslik"]) ?></h2>
													</a>
												</div>
											</div>										
										</div>
									<?php
									}else{
									?>
										<div class="col-12 p-0 " >
											<a href="haberdetay/<?php echo SEO(IcerikTemizle($SagAlt["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagAlt["id"]); ?>">
												<img src="images/hata.jpg" class="img-fluid resim">
											</a>	
										</div>
										
										<div class="col-12 position-absolute p-0">
											<div class="row p-2">
												<div class="col-12">	
													<a href="haberdetay/<?php echo SEO(IcerikTemizle($SagAlt["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagAlt["id"]); ?>">
														<h2 class="uQRtXT haberYan mt-2"><?php echo IcerikTemizle($SagAlt["AnaBaslik"]) ?></h2>
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
					<?php	
					}
					?>
					</div>
					<?php
					}else{
					?>
						<div class="col-6 col-xl-12 m-0">
							<div class="row p-0">
								<div class="col-12 m-0 p-0">
									<img src="images/hata.jpg" class="img-fluid resim">
								</div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>




		<?php 
		$AltHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 5,4");
		$AltHaberler->execute([1]);
		$AltHaberlerVeri = $AltHaberler->rowCount();
		$AltHaberlerKayitlar =  $AltHaberler-> fetchAll(PDO::FETCH_ASSOC);
		if ($AltHaberlerVeri>0) {
		?>
		<div class="row justify-content-center  m-0">
		<?php
		foreach ($AltHaberlerKayitlar as $AltHaberlerkayitlar){
		?>	
			<div class="col-6 col-xl-3 ">
				<div class="row p-1 ">
					<div class="col-12">
						<div class="row align-items-end">
						<?php
						if (file_exists("images/news/".$AltHaberlerkayitlar["AnaResim"])  and ($AltHaberlerkayitlar["AnaResim"]) ) {
						?>
							<div class="col-12 p-0">
								<a href="haberdetay/<?php echo  SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["id"]); ?>" >
									<img src="images/news/<?php echo IcerikTemizle($AltHaberlerkayitlar["AnaResim"]) ?>" class="img-fluid  resim wWfVCA a">
								</a>						
							</div>
							
							<div class="col-12 position-absolute p-0 __aSFczza" >
								<div class="row p-2 ">
									<div class="col-12 ">	
										<a href="haberdetay/<?php echo  SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["id"]); ?> " style="text-decoration: none">
											<h2 class="a uQRtXT haberYan mt-2"><?php echo IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]) ?></h2>
										</a>
									</div>
								</div>										
							</div>
						<?php
						}else{
						?>
							<div class="col-12 xkLYTM p-0">
								<a href="haberdetay/<?php echo  SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["id"]); ?>" >
									<img src="images/hata.jpg" class="img-fluid resim">
								</a>	
							</div>
							<div class="col-12 position-absolute  p-0" >
								<div class="row p-4 ">
									<div class="col-12 ">	
										<a href="haberdetay/<?php echo SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["id"]); ?> ">
											<h2 class="uQRtXT haberYan mt-2"><?php echo IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]) ?></h2>
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

		<div class="row p-0  justify-content-center align-items-center  mt-5 " >
			<div class="  col-12    " >
				<div class="sliders ">
					<div class="col-12  text-left bGAfxXE"  ><span>OYUN KATEGORİLERİ</span></div>
					<div class="slide-track mt-5 mb-5 ">
						<?php
						$Kategoriler= array(
							array('ResimYolu' =>$AnasayfaCokoyunculu,'Link'=>"cokoyunculu",'Adi'=>"Çok Oyunculu"),
							array('ResimYolu' =>$AnasayfaAksiyon,'Link'=>"aksiyon",'Adi'=>"Aksiyon"),
							array('ResimYolu' =>$AnasayfaBasitEglence,'Link'=>"basiteglence",'Adi'=>"Basit Eğlence"),
							array('ResimYolu' =>$AnasayfaSpor,'Link'=>"spor",'Adi'=>"Spor"),
							array('ResimYolu' =>$AnasayfaYaris,'Link'=>"yaris",'Adi'=>"Yarış"),
							array('ResimYolu' =>$AnasayfaStrateji,'Link'=>"strateji",'Adi'=>"Strateji"),
							array('ResimYolu' =>$AnasayfaSimulasyon,'Link'=>"simulasyon",'Adi'=>"Simülasyon"),
							array('ResimYolu' =>$AnasayfaUcretsiz,'Link'=>"ucretsiz",'Adi'=>"Ücretsiz"),
							array('ResimYolu' =>$AnasayfaHayattaKalma,'Link'=>"hayattakalma",'Adi'=>"Hayatta Kalma"),
							array('ResimYolu' =>$AnasayfaMacera,'Link'=>"macera",'Adi'=>"Macera"),
							array('ResimYolu' =>$AnasayfaRolYapma,'Link'=>"rolyapma",'Adi'=>"Rol Yapma"),
						);	
						?>
						<?php
						for($i=0;$i<count($Kategoriler);$i++){
						?>
	   						<a href="<?php echo $Kategoriler[$i]["Link"] ?>" >
								<div class="slide text-center">
									<?php
									if ( file_exists("images/".$Kategoriler[$i]["ResimYolu"])  and ($Kategoriler[$i]["ResimYolu"])) {
									?>
										<img src="images/<?php echo $Kategoriler[$i]["ResimYolu"]; ?>" class="img-fluid" height="300" width="500" alt="" />
										<?php
									}else{
										?>
										<img src="images/hata.jpg" class="img-fluid ıuYTWMZ" height="300" width="500" alt="" >
										<?php
									}
									?>
									<p class="text-center OWWQsx_"><?php echo  $Kategoriler[$i]["Adi"];  ?></p>
								</div>
							</a>

	 					<?php	
						}
						?>
					</div>
				</div>
			</div>
		</div>


		<?php 
		$YeniOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join oyunlar on oyunlar.id=oyunkategorileri.OyunId WHERE KategoriId=13 and oyunlar.Durum=1 ORDER BY oyunlar.id DESC LIMIT 4");
		$YeniOyunlar->execute();
		$YeniOyunlarVeri = $YeniOyunlar->rowCount();
		$YeniOyunlarKayitlar =  $YeniOyunlar-> fetchAll(PDO::FETCH_ASSOC);
		if ($YeniOyunlarVeri>3) {
		?>
		<div class="col-12 p-0 ">
			<div class="row justify-content-center align-items-center ">
				<div class="col-12 mt-3 mb-2">
					<div class="row p-3 justify-content-end">
						<div class="col-12 text-left bGAfxXE" ><span >YENİ ÇIKAN OYUNLAR</span></div>
					</div>
				</div>
				
				<?php
				foreach ($YeniOyunlarKayitlar as $YeniOyunKayitlar){	
				?>
				<div class="col-6 col-xl-3 mb-4 " >
					<div class="row p-2" >
					<?php
					if ( file_exists("images/games/".$YeniOyunKayitlar["AnaResim"])  and ($YeniOyunKayitlar["AnaResim"])) {
					?>
						<div class="col-12 p-0 " >
							<a href="oyundetay/<?php echo SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["id"]); ?>">
								<img src="images/games/<?php echo IcerikTemizle($YeniOyunKayitlar["AnaResim"]) ?>" class="img-fluid _pXxZnTY o" >
							</a>
						</div>
					<?php
					}else{
					?>
						<div class="col-12 p-0" >
							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["id"]); ?>">
								<img src="images/resim.jpg" class="img-fluid">
							</a>
						</div>
					<?php
					}
					?>
						<div class="col-12 mt-3 p-0" >
							<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["id"]); ?>">
								<h6 class="uQRtXT o  oyunAdi"><?php echo IcerikTemizle($YeniOyunKayitlar["OyunAdi"]) ?></h6>
							</a>
						</div>
						
						<?php
						$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
						$ToplamPuan->execute([$YeniOyunKayitlar["id"]]);
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
						$OyunPlatform->execute([$YeniOyunKayitlar["id"]]);
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
						}else{
						?>	

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
		<?php
		}
		?>	


	<?php
	$AltReklam = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
	$AltReklam ->execute([22,1]);
	$AltReklamVeri  = $AltReklam ->rowCount();
	$AltReklamKayitlar  = $AltReklam ->fetch(PDO::FETCH_ASSOC);
	if ($AltReklamVeri>0) {
	?>
		<div class="col-12 text-center mb-5 ">
			<div class="row justify-content-center align-items-center" >
				<?php echo IcerikTemizle($AltReklamKayitlar ["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme2  = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme2 ->execute([22]);	
				?>	
			</div>
		</div>
	<?php
	}
	?>

	<?php
	if ( (file_exists("images/".$AnasayfaCokYakinda)) and isset($AnasayfaCokYakinda) ) {
	?>
		<div class="row justify-content-center align-items-center p-0 mt-5 mb-5" s>
			<div class="col-12 ">
				<div class="row "></div>
				<div class="card2 " style="background-image: url(images/<?php echo IcerikTemizle($AnasayfaCokYakinda);?>);background-position: center;">
					<div class="content2">
						<h2 class="bold">Çok Yakında</h2>
						<p class="font18">Yeni çıkacak oyunlara göz at,keşfet </p>
						<a href="cokyakinda">
							<button class="call-to-action p-0" style="height: 50px">
								<div>
									<div>Göz At</div>
								</div>
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
	?>


	<?php 
	$PopulerOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum='1'  ORDER BY Goruntulenme DESC  LIMIT 4");
	$PopulerOyunlar->execute();
	$PopulerOyunlarVeri = $PopulerOyunlar->rowCount();
	$PopulerOyunlarKayitlar =  $PopulerOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($PopulerOyunlarVeri>3) {
	?>
	<div class="col-12 p-0  mb-2 " >
		<div class="row justify-content-center align-items-center   ">
			<div class="col-12  mt-3 mb-2">
				<div class="row p-3 justify-content-end align-items-center">
					<div class=" col-7 col-xl-10  text-left   bGAfxXE" ><span >POPÜLER OYUNLAR</span></div>
					<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="populeroyunlar" style="text-decoration: none"><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
				</div>
			</div>

			<?php
			foreach ($PopulerOyunlarKayitlar as $PopulerKayitlar){
			?>
			<div class="col-6 col-xl-3 mb-4 ">
				<div class="row p-2">
				<?php
				if ( file_exists("images/games/".$PopulerKayitlar["AnaResim"])  and ($PopulerKayitlar["AnaResim"])) {
				?>
					<div class="col-12 p-0">
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["id"]); ?>">
							<img src="images/games/<?php echo IcerikTemizle($PopulerKayitlar["AnaResim"]) ?>" class="img-fluid _pXxZnTY  po" >
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0" >
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["id"]); ?>">
							<img src="images/resim.jpg" class="img-fluid">
						</a>
					</div>
				<?php
				}
				?>

				<div class="col-12 mt-3 p-0" >
					<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["id"]); ?>">
						<h6 class="po uQRtXT oyunAdi"><?php echo IcerikTemizle($PopulerKayitlar["OyunAdi"]) ?></h6>
					</a>
				</div>
				
				<?php
				$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
				$ToplamPuan->execute([$PopulerKayitlar["id"]]);
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
							
						<div class="col-12 p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
					<?php
					}else{		
					?>
						<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
					<?php
					}
					?>
					
					<?php
					$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
					$OyunPlatform->execute([$PopulerKayitlar["id"]]);
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
					}else{
						?>	

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
	<?php
	}
	?>	



	<?php 
	$UretsizOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId  WHERE KategoriId=11 and oyunlar.Durum=1  ORDER BY oyunlar.Goruntulenme DESC  LIMIT 4");
	$UretsizOyunlar->execute();
	$UretsizOyunlarVeri = $UretsizOyunlar->rowCount();
	$UretsizOyunlarVeriler =  $UretsizOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($UretsizOyunlarVeri>3) {
	?>
	<div class="col-12 p-0 mb-5">
		<div class="row justify-content-center align-items-center">
			<div class="col-12 mt-3 mb-2">
				<div class="row p-3 justify-content-end align-items-center">
					<div class=" col-7 col-xl-10  text-left  bGAfxXE " ><span >ÜCRETSİZ OYUNLAR</span></div>
					<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="ucretsiz" style="text-decoration: none"><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
				</div>
			</div>

			<?php
			foreach ($UretsizOyunlarVeriler as $UretsizKayitlar){			
			?>
			<div class="col-6 col-xl-3 mb-4">
				<div class="row p-2">
				<?php
				if ( file_exists("images/games/".$UretsizKayitlar["AnaResim"])  and ($UretsizKayitlar["AnaResim"])) {
				?>
					<div class="col-12 p-0">
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["id"]); ?>">
							<img src="images/games/<?php echo IcerikTemizle($UretsizKayitlar["AnaResim"]) ?>" class="img-fluid _pXxZnTY  uo">
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0">
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["id"]); ?>">
							<img src="images/resim.jpg" class="img-fluid ">
						</a>
					</div>
				<?php
				}
				?>
				
				<div class="col-12 mt-3 p-0">
					<a  s href="oyundetay/<?php echo SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["id"]); ?>">
						<h6 class="uQRtXT uo oyunAdi"><?php echo IcerikTemizle($UretsizKayitlar["OyunAdi"]) ?></h6>
					</a>
				</div>
					
				<?php
				$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
				$ToplamPuan->execute([$UretsizKayitlar["id"]]);
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
							
						<div class="col-12 p-0"><?php echo PuanHesapla($OrtalamaPuan);?></div>
					<?php
					}else{		
					?>
						<div class="col-12 p-0"><?php echo PuanHesapla(0);?></div>
					<?php
					}
					?>
					
					<?php
					$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
					$OyunPlatform->execute([$UretsizKayitlar["id"]]);
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
			<?php	
			}
			?>
		</div>
	</div>
	<?php
	}
	?>	

	
	<?php
	if ( (file_exists("images/".$AnasayfaTumOyunlar)) and isset($AnasayfaTumOyunlar)  ) {
	?>
		<div class="row justify-content-center align-items-center p-0 mt-5 mb-5" s>
			<div class="col-12 ">
				<div class="row "></div>
				<div class="card2 " style="background-image: url(images/<?php echo IcerikTemizle($AnasayfaTumOyunlar);?>);background-position: center;">
					<div class="content2">
						<h2 class="bold">Oyun Kataloğu</h2>
						<p class="font18">Tüm oyunlara göz at, keşfet</p>
						<a href="tumoyunlar">
							<button class="call-to-action p-0" style="height: 50px "  >
								<div>
									<div>Göz At</div>
								</div>
							</button>
						</a>
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


