<?php
if(isset($_GET["ID"])){
	$HaberId =SayfaNumarasiTemizle(Guvenlik($_GET["ID"]));	

	$HaberSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  id=? AND Durum=? LIMIT 1 ");
	$HaberSorgusu->execute([$HaberId,1]);
	$HaberSorgusuSayi = $HaberSorgusu->rowCount();
	$HaberSorgusuKayit = $HaberSorgusu->fetch(PDO::FETCH_ASSOC);
	if($HaberSorgusuSayi>0){
		$HaberGoruntulenme =  $DatabaseBaglanti->prepare("UPDATE haberler SET Goruntulenme=Goruntulenme+1  WHERE  id=? AND Durum=? LIMIT 1 ");
		$HaberGoruntulenme->execute([$HaberId,1]);
		$HaberGoruntulenmeSayisi = $HaberGoruntulenme->rowCount();
	?>

	<?php
		$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
		$Editor->execute([$HaberSorgusuKayit["Editor"],1,1]);
		$EditorSayi = $Editor->rowCount();
		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
		if ($EditorSayi>0) {
			$EditorIsim= IcerikTemizle($EditorKayit["AdSoyad"]);
			if(file_exists("images/userphoto/".IcerikTemizle($EditorKayit["ProfilResmi"])) and (IcerikTemizle(isset($EditorKayit["ProfilResmi"]))) and (IcerikTemizle($EditorKayit["ProfilResmi"])!="") ){
				$EditorResim="images/userphoto/".IcerikTemizle($EditorKayit["ProfilResmi"])."";
			}else{
				$EditorResim="images/user.png";
			}
		}else{
			$EditorIsim="-";
			$EditorResim="images/user.png";
		}
	?>

	<?php
		$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=? ORDER BY GosterimSayisi LIMIT 1");
		$BannerUst->execute([9,1]);
		$BannerUstVeri = $BannerUst->rowCount();
		$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
		if ($BannerUstVeri>0) {
		?>
			<div class="col-12 col-xl-12 text-center mb-1  mt-5">
				<div class="row justify-content-center align-items-center"  >
					<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([9 ]);	
					?>		
				</div>	
			</div>
		<?php
		}
	?>

		<div class="col-12 p-0  mb-5 " >
			<div class="row justify-content-center m-0  mb-5 ">
				<div class="col-11 col-xl-5 mt-3 ">
					<div class="row justify-content-center align-items-center wWfVCA" >
						<div class="col-12 text-right white mt-2">
							<i class="fas fa-clock"></i> 
							<span class="white haberdra opacity05" > 
								<?php echo time_ago(IcerikTemizle($HaberSorgusuKayit["KayitTarihi"])); ?>
							</span>
						</div>

						<?php
						if (IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) {
						?>	
							<div class="col-12 mt-4 mb-2">
								<h6 class="white bold haberDetayBaslik" >
									<?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?>
								</h6>
							</div>
						<?php
						}else{
						?>
							<div class="col-12 "></div>
						<?php
						}
						?>

						<?php
						if ( IcerikTemizle($HaberSorgusuKayit["AnaResim"]!="") and IcerikTemizle(isset($HaberSorgusuKayit["AnaResim"])) and (file_exists("images/news/".IcerikTemizle($HaberSorgusuKayit["AnaResim"])))) {
						?>	
							<div class="col-12 mb-3" style="background: #202020">
								<img src="images/news/<?php echo IcerikTemizle($HaberSorgusuKayit["AnaResim"]); ?>" class="img-fluid hdr">
							</div>
						<?php
						}else{
						?>
							<div class="col-12 mb-3" style="background: #202020">
								<img src="images/hata2.jpg" class="img-fluid hdr">
							</div>
						<?php
						}
						?>

						<?php	
						if (isset($_SESSION["Kullanici"])) {
						?>
						<div class="col-12 mb-4">
							<div class="row justify-content-center align-items-center ">
								<div class="col-6 col-xl-7">
									<div class="row align-items-center ">
										<div class="col-5 col-md-2 text-center p-0 ">
											<img src="<?php echo IcerikTemizle($EditorResim) ?>" class="img-fluid userp" style="border-radius: 50%;">	
										</div>
										<div class="col-6 col-xl-9 text-left p-0  white bold haberdra tyrzZazC" >
											<span><?php echo IcerikTemizle($EditorIsim);?></span>
										</div>
									</div>
								</div>	

								<?php
								$Favoriler= $DatabaseBaglanti->prepare("SELECT * FROM haberfavoriler WHERE HaberId=?  AND UyeId=?  LIMIT 1 ");
								$Favoriler->execute([$HaberId,$KullaniciId]);
								$FavorilerSayisi = $Favoriler->rowCount();
								if ($FavorilerSayisi>0) {
								?>
								<div class="col-6 col-xl-5   text-right white">
									<div class="row justify-content-center align-items-center">
										<div class="col-12 ">
											<span  class="hfes<?php echo IcerikTemizle($HaberId); ?>" >
												<button type="button" class="btn btn-warning hfe favoriEklendi" data="<?php echo IcerikTemizle($HaberId); ?>" title="Favorilerden Çıkar">
													<i class="fas fa-heart bold "  style="color: white"></i>
												</button>
											</span>
										</div>
									</div>
								</div>
								<?php
								}else{
								?>
								<div class="col-6 col-xl-5  text-right white">
									<div class="row justify-content-center align-items-center">
										<div class="col-12 ">
											<span  class="hfes<?php echo IcerikTemizle($HaberId); ?>" >
												<button title="Favorilere Ekle"  type="button" class="btn btn-warning favoriEkle  hfe" data="<?php echo IcerikTemizle($HaberId); ?>" >
													<i class="far fa-heart bold"></i>
												</button>
											</span>
										</div>
									</div>
								</div>		
								<?php
								}
								?>
							</div>
						</div>
						<?php
						}else{
						?>
						<div class="col-12 mb-4">
							<div class="row justify-content-center align-items-center ">
								<div class="col-6 col-xl-7">
									<div class="row align-items-center ">
										<div class="col-5 col-md-2 text-center p-0 ">
											<img src="<?php echo $EditorResim ?>" class="img-fluid userp" style="border-radius: 50%;height: 45px;width: 45px">	
										</div>
										<div class="col-6 col-xl-9 text-left p-0  white bold haberdra tyrzZazC" >
											<span><?php echo IcerikTemizle($EditorIsim);?></span>
										</div>
									</div>
								</div>
								<div class="col-6 col-xl-5  text-right white">
									<div class="row justify-content-center align-items-center">
										<div class="col-12 ">
											<a class="favoriEkle" style="text-decoration: none;" href="girisyap">
												<button  type="button" class="btn btn-warning">
													<i class="far fa-heart bold"></i>
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
						if (IcerikTemizle($HaberSorgusuKayit["AnaAciklama"])) {
						?>	
							<div class="col-12 mb-4">
								<p class="white haberda uyZRQwZX"  ><?php echo IcerikTemizle($HaberSorgusuKayit["AnaAciklama"]); ?></p>
							</div>
						<?php
						}else{
						?>
							<div class="col-12"></div>
						<?php
						}
						?>

						<?php
						$HaberResimler =  $DatabaseBaglanti->prepare("SELECT * FROM  haberresimler WHERE Durum=? and HaberId=? ");
						$HaberResimler->execute([1,$HaberId]);
						$HaberResimlerSayi = $HaberResimler->rowCount();
						$HaberResimlerKayitlar = $HaberResimler->fetchAll(PDO::FETCH_ASSOC);
						if ($HaberResimlerSayi>0) {
						foreach ($HaberResimlerKayitlar as  $Resimler) {
						?>
						<?php
							if(IcerikTemizle($Resimler["ResimBaslik"])) {
							?>	
								<div class="col-12  mt-4 mb-2">
									<h1 class="white  haberDetayAltBaslik bold white"  ><?php echo IcerikTemizle($Resimler["ResimBaslik"]); ?></h1>
								</div>
							<?php
							}else{
							?>
								<div class="col-12 "></div>
							<?php
							}
							?>

							<?php
							if ( IcerikTemizle($Resimler["Resim"]!="") and IcerikTemizle(isset($Resimler["Resim"])) and file_exists("images/news/".IcerikTemizle($Resimler["Resim"])) ) {
							?>	
								<div class="col-12  mt-1 mb-4" style="background: #202020">
									<img src="images/news/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" class="img-fluid hdr">
								</div>
							<?php
							}else{
							?>
								<div class="col-12  "></div>
							<?php
							}
							?>

							<?php
							if (IcerikTemizle($Resimler["ResimAciklama"])) {
							?>	
								<div class="col-12  mt-1 mb-4">
									<div class="white haberdra aqQazcyr"  ><?php echo IcerikTemizle($Resimler["ResimAciklama"]); ?></div>
								</div>
							<?php
							}else{
							?>
								<div class="col-12 "></div>
								<?php
							}
							?>
						<?php
						}
						}else{
						?>
						<?php
						}
						?>

						<?php
						if (IcerikTemizle($HaberSorgusuKayit["KaynakUrl"])) {
							?>	
							<div class="col-12   mb-4">
								<p>
									<span  class="bold white haberdra">Kaynak:</span> 
									<a href="<?php echo IcerikTemizle($HaberSorgusuKayit["KaynakUrl"]); ?>" target="_blank">
										<span  style="color: #c28f2c;" class="haberdra" ><?php echo IcerikTemizle($HaberSorgusuKayit["KaynakUrl"]); ?></span>
									</a>
								</p>
							</div>
						<?php
						}else{
						?>
							<div class="col-12"></div>
						<?php
						}
						?>	

						<?php
						if (IcerikTemizle($HaberSorgusuKayit["Etiketler"])) {
						?>	
							<div class="col-12 mb-4">
								<p  class="haberdra" style="color: #c28f2c;" ><?php echo IcerikTemizle($HaberSorgusuKayit["Etiketler"]); ?></p>
							</div>
						<?php
						}else{
						?>
							<div class="col-12"></div>
						<?php
						}
						?>

						<div class="col-12 mt-5">
							<div class="row">
								<div class="col-12">
									<span  style="color:#c28f2c; " class="bold  haberdra">Yorumlar (<?php echo IcerikTemizle($HaberSorgusuKayit["YorumSayisi"]); ?>)</span>
								</div>

								<?php
								if (isset($_SESSION["Kullanici"])) {
								?>
								<div class="col-12 mt-4 text-center haberYorum">
									<form id="habery"  action="javascript:void(0);" method="post" >
										<div class="group2">
											<div class="row  align-items-center mb-2  align-items-center">
												<div class=" col-2 col-md-1 text-center p-0 white" >
												<?php
												if(file_exists("images/userphoto/".IcerikTemizle($KullaniciProfilResmi)) and (IcerikTemizle(isset($KullaniciProfilResmi))) and (IcerikTemizle($KullaniciProfilResmi)!="") ){
												?>
													<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid ml-2 userp" style="border-radius: 50%;">
												<?php
												}else{
												?>
													<img src="images/user.png" class="img-fluid userp" style="border-radius: 50%;">
												<?php
												}
												?>	
												</div>
												
												<div class=" col-8 col-md-11 text-left p-0  white bold haberdra tyrzZazC ">
													<span><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
												</div>
											</div>
											<div id="hys"></div>
											<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."  ></textarea>  
											<input type="hidden" name="h"  value="<?php echo IcerikTemizle($HaberId); ?>">    
											<span class="highlight"></span>
											<span class="bar"></span>
										</div>

										<div class="col-12 p-0  mt-3 text-right hyb">
											<button class="call-to-action2" type="submit" id="hyg"  >
												<div>
													<div>Gönder</div>
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
										<div class="col-12 mb-2 p-0 white bold haberdra" >
											<span>Yorum yapmak için</span> 
											<a href="girisyap"  style="text-decoration: none;color: #c28f2c">
												<span style="">giriş yap.</span>
											</a>
										</div> 
										<textarea  placeholder="Yorumunuzu yazın..."  required></textarea>      
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
									<div class="col-12  mt-3  p-0  text-right " id="icerik">
										<button class="call-to-action2" >
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
							$Yorumlar = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumlar WHERE HaberId=? AND (Durum=? OR Durum=?)   ORDER BY YorumTarihi DESC LIMIT 5 ");
							$Yorumlar->execute([IcerikTemizle($HaberSorgusuKayit["id"]),1,4]);
							$YorumSayisi = $Yorumlar->rowCount();
							$Yorum = $Yorumlar->fetchAll(PDO::FETCH_ASSOC);
							if($YorumSayisi>0){
								foreach ($Yorum as $YorumKayit){
									$YorumId=$YorumKayit["id"];
									$YorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
									$YorumUyeAdi->execute([IcerikTemizle($YorumKayit["UyeId"])]);
									$YorumUye = $YorumUyeAdi->fetch(PDO::FETCH_ASSOC);
									?>
									<div <?php if(isset($_SESSION["Kullanici"])){ ?> class=" hyss" id="hy<?php echo IcerikTemizle($YorumId) ?>"  <?php }else{ ?> <?php } ?>  ></div>
									<div class="row p-2 hdy" <?php if(isset($_SESSION["Kullanici"])){ ?> id="y<?php echo IcerikTemizle($YorumId) ?>"   <?php }else{ ?> <?php } ?>  >
										<div class=" col-12">
											<div  class="row" >
												<div class="col-12 mb-1 BackgroundBlack" style="border-radius: 5px" >
													<div class="row p-0 justify-content-start align-items-center ">
														<div class="col-12 ">
															<div class="row p-2 justify-content-start align-items-center">
															<?php
															if (isset($_SESSION["Kullanici"])) {
															?>
																<div  class="col-2 text-center col-md-1   p-0  qweyasqz" >
																	<?php
																	if(file_exists("images/userphoto/".IcerikTemizle($YorumUye["ProfilResmi"])) and (IcerikTemizle(isset($YorumUye["ProfilResmi"]))) and (IcerikTemizle($YorumUye["ProfilResmi"])!="") ){
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
																		<div class="col-12 p-0 JHOFDFNXZz" >
																			<span class="yorumk bold white"><?php echo IcerikTemizle($YorumUye["AdSoyad"]);?></span> 
																			<span class=" yorumk white opacity05"  > <?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?></span>
																		</div>
																		<div class="col-12 p-0 tyrzZazC">
																			<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)</span>
																		</div>
																	</div>
																</div>
																<?php
																if ($YorumKayit["Durum"]==4) {
																?>
																<div class="col-12 mt-1">
																	<span class="ASewrQz yorumk">
																		<i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> 
																		<span>Bu yorum</span> 
																		<a class="bold white" style="text-decoration: none;color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>
																		<span>  ihlali nedeniyle kısıtlanmıştır.</span>
																	</span>
																</div>
																<?php
																}else{
																?>
																	<div class="col-12   mt-1  ">
																		<span class="rzrkWzXv yorumk "  ><?php echo IcerikTemizle($YorumKayit["Yorum"]);?></span>
																	</div>
																	<div class="col-12 text-right mt-1 "  >
																	<?php
																	if (isset($_SESSION["Kullanici"])) {
																	if ($KullaniciId != $YorumKayit["UyeId"] ) {
																	?>
																		<span class="bold white yorumk  ys" data="<?php echo IcerikTemizle($YorumId); ?>" data-toggle="modal" data-target="#ys<?php echo IcerikTemizle($YorumId); ?>"  style="cursor:pointer;">
																			<i style="color:#c28f2c" class="fas fa-flag white"></i>
																			<span> Yorumu Şikayet Et</span>
																		</span>

																		<div  class="modal fade" id="ys<?php echo IcerikTemizle($YorumId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
																			<div class="modal-dialog" role="document">
																				<div class="modal-content" style="background: #202020">
																					<div class="modal-header">
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																							<span aria-hidden="true" class="white">&times;</span>
																						</button>
																					</div>
																					<div class="modal-body "  >
																						<div class="col-12 text-center  mt-2 yss"></div>
																						<div class="col-12 text-center ysb mt-2"></div>
																						<form class="hesabim  " id="yg<?php echo IcerikTemizle($YorumId); ?>" method="post" action="javascript:void(0);" >
																							<div class="col-12 mt-2">
																								<div class="col-12 text-left p-0 white bold" >Şikayet nedeniniz nedir?</div>      
																								<textarea type="text"  style="background: black;color:white" name="HSikayet"  ></textarea>
																								<input type="hidden" name="hys" value="<?php echo IcerikTemizle($YorumId); ?>">
																								<span class="highlight"></span>
																								<span class="bar"></span> 
																								<div class="bold  font13"style="color:#585858" >Maksimum 250 karakter</div>
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
																		<span class="bold  white yorumk hysb" data="<?php echo IcerikTemizle($YorumId); ?>" style="cursor:pointer;">
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
																<div  class="col-2 text-center col-md-1   p-0  qweyasqz" >
																	<?php
																	if(file_exists("images/userphoto/".IcerikTemizle($YorumUye["ProfilResmi"])) and (IcerikTemizle(isset($YorumUye["ProfilResmi"]))) and (IcerikTemizle($YorumUye["ProfilResmi"])!="") ){
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
																		<div class="col-12 p-0 JHOFDFNXZz">
																			<span class="yorumk bold white"><?php echo IcerikTemizle($YorumUye["AdSoyad"]);?></span> 
																			<span class=" yorumk white opacity05"  > <?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?></span>
																		</div>
																		<div class="col-12 p-0 tyrzZazC" >
																			<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)</span>
																		</div>
																	</div>
																</div>

																<?php
																if ($YorumKayit["Durum"]==4) {
																?>
																	<div class="col-12 mt-1">
																		<span class="ASewrQz yorumk">
																			<i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> 
																			Bu yorum <a class="bold white" style="text-decoration: none;color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a> 
																			 ihlali nedeniyle kısıtlanmıştır.
																		</span>
																	</div>
																<?php
																}else{
																?>
																	<div class="col-12   mt-1  ">
																		<span class="rzrkWzXv yorumk "  ><?php echo IcerikTemizle($YorumKayit["Yorum"]);?></span>
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

												<div class="col-12 mt-1  " >
													<div class="row">
														<div class="col-4 col-xl-2 mt-1" style="cursor: pointer;" id="<?php echo IcerikTemizle($YorumKayit["id"]);?>" onClick="$.Cevap(<?php echo IcerikTemizle($YorumKayit["id"]);?> )">
															<span class="bold white yorumk" >
																<i class="fas fa-comments"></i>Yanıtla
															</span>
														</div>

														<div class="col-12 mt-2" id="cg<?php echo IcerikTemizle($YorumKayit["id"]); ?>" style="display:none;" >					
														<?php
														if (isset($_SESSION["Kullanici"])) {
														?>
															<div class="row justify-content-center">
																<div class="col-12 mt-4  haberYorum">
																	<form  id="hyc<?php echo IcerikTemizle($YorumId) ?>"  action="javascript:void(0);" method="post"   >
																		<div class="group2">
																			<div  id="c<?php echo IcerikTemizle($YorumKayit["id"]);?>"></div>
																			<textarea name="YorumCevap"  placeholder="Yorumunuzu yazın..."  ></textarea> 
																			<input type="hidden" name="hc" value="<?php echo IcerikTemizle($HaberId); ?>">
																			<input type="hidden" name="yc" value="<?php echo IcerikTemizle($YorumId); ?>">
																			<span class="highlight"></span>
																			<span class="bar"></span>
																		</div>

																		<div class="col-12 p-0  mt-3 text-right hycb">
																			<button class="call-to-action2 hycg" type="submit" data="<?php echo IcerikTemizle($YorumKayit["id"]);?>"  >
																				<div>
																					<div >Yanıtla</div>
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
																<div class="col-12 mb-2 p-0 white bold haberdra" >
																	<span>Yorum yapmak için</span> <a href="girisyap"  style="text-decoration: none;color: #c28f2c"><span style="">giriş yap</span></a>.
																</div> 
																<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
																<span class="highlight"></span>
																<span class="bar"></span>
															</div>

															<div class="col-12  mt-3  p-0  text-right " >
																<button class="call-to-action2" disabled>
																	<div>
																		<div >Yanıtla</div>
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
														$YorumlarCevap = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumcevap WHERE HaberId=? AND YorumId=? AND  (Durum=? OR Durum=?)   ORDER BY YorumTarihi ASC  ");
														$YorumlarCevap->execute([IcerikTemizle($HaberSorgusuKayit["id"]),$YorumKayit["id"],1,4]);
														$YorumCevapSayisi = $YorumlarCevap->rowCount();
														$YorumCevap = $YorumlarCevap->fetchAll(PDO::FETCH_ASSOC);
														if($YorumCevapSayisi>0){
															foreach ($YorumCevap as $YorumCevapKayit) {
															$YorumCevapId=$YorumCevapKayit["id"];
															$CevapYorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
															$CevapYorumUyeAdi->execute([IcerikTemizle($YorumCevapKayit["UyeId"])]);
															$CevapYorumUye = $CevapYorumUyeAdi->fetch(PDO::FETCH_ASSOC);
														?>

															<div class="row  hdyc justify-content-center align-items-center pb-3 mt-1 " <?php if(isset($_SESSION["Kullanici"])){ ?> id="cs<?php echo IcerikTemizle($YorumCevapId) ?>"  <?php }else{ ?> <?php } ?>    >
																<div class="col-11 col-xl-6 text center " <?php if(isset($_SESSION["Kullanici"])){ ?>  id="ss<?php echo IcerikTemizle($YorumCevapId) ?>"  <?php }else{ ?> <?php } ?> ></div>
																<div class=" offset-1 col-11   asdRzwcZ" >
																	<div class="row p-2 justify-content-start align-items-center">
																		<?php
																		if (isset($_SESSION["Kullanici"])) {
																		?>
																			<div class="col-2   col-md-1  text-center  p-0   ">
																				<?php
																				if(file_exists("images/userphoto/".IcerikTemizle($CevapYorumUye["ProfilResmi"])."") and (IcerikTemizle(isset($CevapYorumUye["ProfilResmi"]))) and (IcerikTemizle($CevapYorumUye["ProfilResmi"]!="")) ){
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
																			
																			<div class="col-10 col-md-11  text-left ">
																				<div class="row align-items-center p-0">
																					<div class="col-12 p-0 JHOFDFNXZz" ><span class="yorumk bold white"><?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?></span> <span class=" yorumk white opacity05"  > <?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?></span></div>
																					<div class="col-12 p-0 tyrzZazC" ><span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)</span></div>
																				</div>
																			</div>

																			<?php
																			if ($YorumCevapKayit["Durum"]==4) {
																			?>
																			<div class="col-12 mt-2 " >
																				<span class="ASewrQz yorumk"><i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="text-decoration: none;color: white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
																			</div>
																			<?php
																			}else{
																			?>	
																			<div class="col-12 mt-1  " >
																				<span class="sadxzaA yorumk "><?php echo IcerikTemizle($YorumCevapKayit["Yorum"]);?></span>
																			</div>
																			<div class="col-12 text-right mt-1 " <?php if(isset($_SESSION["Kullanici"])){ ?>  id="ycs<?php echo IcerikTemizle($YorumCevapId); ?>"  <?php }else{ ?> <?php } ?>  >
																			
																			<?php
																			if (isset($_SESSION["Kullanici"])) {
																			if ($KullaniciId != $YorumCevapKayit["UyeId"] ) {
																			?>
																				<span class="bold white yorumk  ycs" data="<?php echo IcerikTemizle($YorumCevapId); ?>" data-toggle="modal" data-target="#ycse<?php echo IcerikTemizle($YorumCevapId); ?>"  style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-flag white"></i> Yorumu Şikayet Et</span>

																				<div  class="modal fade" id="ycse<?php echo IcerikTemizle($YorumCevapId);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
																					<div class="modal-dialog" role="document">
																						<div class="modal-content" style="background: #202020">
																						<div class="modal-header">
																							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																								<span aria-hidden="true" class="white">&times;</span>
																							</button>
																						</div>
																						<div class="modal-body "  >
																							<div class="col-12 text-center  mt-2 ycss"></div>
																							<div class="col-12 text-center ycsb mt-2"></div>
																							<form class="hesabim  " id="ycg<?php echo IcerikTemizle($YorumCevapId); ?>" method="post" action="javascript:void(0);" >
																								<div class="col-12 mt-2">
																									<div class="col-12 text-left p-0 white bold" >Şikayet nedeniniz nedir?</div>      
																									<textarea type="text"  style="background: black;color:white" name="HcSikayet"  ></textarea>
																									<input type="hidden" name="hcys" value="<?php echo IcerikTemizle($YorumCevapId); ?>">
																									<span class="highlight"></span>
																									<span class="bar"></span> 
																									<div class="bold red font13 ">Maksimum 250 karakter</div>
																								</div>

																								<div class="col-12  mt-3 mb-3  p-0  text-center  " >
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
																				<span class="bold  white yorumk hycsb" data="<?php echo IcerikTemizle($YorumCevapId); ?>" style="cursor:pointer;"><i style="color:#c28f2c"  class="fas fa-trash-alt white"></i> Yorumu Sil</span>
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
																			<div class="col-2 text-center col-md-1  text-center  p-0  ">
																				<?php
																				if(file_exists("images/userphoto/".IcerikTemizle($CevapYorumUye["ProfilResmi"])."") and (IcerikTemizle(isset($CevapYorumUye["ProfilResmi"]))) and (IcerikTemizle($CevapYorumUye["ProfilResmi"]!="")) ){
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
																					<div class="col-12 p-0 JHOFDFNXZz" >
																						<span class="yorumk bold white"><?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?></span>
																						 <span class=" yorumk white opacity05"  > <?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?></span>
																					</div>
																					<div class="col-12 p-0 tyrzZazC" >
																						<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)</span>
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

														<div class="col-12 mt-1  " <?php if(isset($_SESSION["Kullanici"])){ ?> id="cy<?php echo IcerikTemizle($YorumId); ?>"  <?php }else{ ?> <?php } ?> >
															
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								}
								?>
								<div class="col-12 text-center">
									<a href="habertumyorumlar/<?php echo SEO(IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])); ?>/<?php echo IcerikTemizle($HaberId); ?>">
										<button class="call-to-action2" >
											<div>
												<div >Tüm Yorumlar</div>
											</div>
										</button>
									</a>							
								</div>
							<?php
							}else{
							?>
								<div class="col-12 mt-2 p-3 white haberdra hyy" style=" background: rgb(0,0,0,0.5); ">
									<p>Henüz yorum yapılmamış.</p> 
								</div>
							<?php
							}
							?>	
						</div>
					</div>
				</div>
				<div class="d-none d-xl-block col-2" >
					<div class="row p-3">
						<?php
						$BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ORDER BY GosterimSayisi LIMIT 1");
						$BannerYan->execute([10,1]);
						$BannerYanVeri = $BannerYan->rowCount();
						$BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
						if ($BannerYanVeri>0) {
						?>
							<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 	
							<?php
							$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
							$BannerGuncelleme2->execute([10]);	
							?>
						<?php
						}
						?>		

						<?php
						$KonusulanHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=?  ORDER BY YorumSayisi DESC  LIMIT 10" );
						$KonusulanHaberler->execute([1]);
						$Data = $KonusulanHaberler->rowCount();
						$HaberKayitlar = $KonusulanHaberler->fetchAll(PDO::FETCH_ASSOC);

						if ($Data>0) {
						?>
						<div class="col-12  white">
							<div class="row">
								<div class="col-12 p-0   mt-5 mb-3 text-center bold white font18" style="color: white; ">
									<span>Çok Konuşulan Haberler</span>
								</div>

								<div class="col-12 mt-2 mb-2">
									<?php
									foreach ($HaberKayitlar as $kayitlar) {
									?>
									<div class="row mb-4 justify-content-center align-items-center">
										<?php
										if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="") ){
										?>
											<div class="col-12 p-0" style="background: black">
												<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
													<img src="images/news/<?php echo IcerikTemizle($kayitlar["AnaResim"]); ?>" class="img-fluid wWfVCA hdr" >
												</a>
											</div>
										<?php
										}else{
										?>
										<div class="col-12 p-0">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
												<img src="images/hata.jpg" class="img-fluid" >
											</a>
										</div>
										<?php
										}
										?>
										<div class="col-12 mt-2 p-0" >
											<a  style="text-decoration: none;" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
												<h1  class="font15 bold white yaziAlan "  ><?php echo IcerikTemizle($kayitlar["AnaBaslik"]); ?></h1>
											</a>
										</div>
									</div>
									<?php
									}
									?>
								</div>
							</div>
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
		</div>

		<?php
		if (isset($_SESSION["Kullanici"])) {
		?>
		<script type="text/javascript">
			$(document).ready(function(){

				$('body').on('click' , '#hyg', function() {
					$.ajax({
						type:"post", 
						url:"habery_s.php",
						data:$("#habery").serialize(),
						beforeSend: function() {
							$(".hyb").html('<button class="call-to-action2 " ><div><div><div class="spinner-border text-warning" role="status"><span class="sr-only"></span></div></div></div></button>'); 
						}, 		
						success:function(cevap){
							$(".hyb").html('<button class="call-to-action2" type="submit" id="hyg"  ><div><div>Gönder</div></div></button>'); 
							if (cevap=="1") {
								$("#habery").trigger('reset');
								$("#hys").fadeIn();
								$("#hys").html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.</span> </span>');
								
							}else if (cevap=="2"){
								$("#habery").trigger('reset');
								$("#hys").fadeIn();
								$("#hys").html('<span class=" text-left yorumk" > <span style="color:red;">Yorumunuz boş bırakılamaz.</span></span>');
								
							}else if (cevap=="error"){
								$("#habery").trigger('reset');
								$("#hys").fadeIn();
								$("#hys").fadeOut(5000);
							}else{
								$("#hys").html('');
								$("#habery").trigger('reset');
								$(".yorumlar").fadeIn(2000).prepend(cevap).hide().fadeIn(2000);
								$(".hyy").fadeOut();
							}
						}
					});     
				});

				$('body').on('click' , '.hycg', function() {
					i =  $(this).attr('data'); 
					$.ajax({
						type:"post", 
						url:"haberyc_s.php",
						data:$("#hyc"+i).serialize(),
					
						success:function(cevap){ 
							if (cevap=="1") {
								$("#hyc"+i).trigger('reset');
								$("#c"+i).fadeIn();
								$("#c"+i).html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.</span> </span>');
								
							}else if (cevap=="2"){
								$("#hyc"+i).trigger('reset');
								$("#c"+i).fadeIn();
								$("#c"+i).html('<span class=" text-left yorumk "><span style="color:red;">Yorumunuz boş bırakılamaz.</span> </span>');
									
							}else{
								$("#c"+i).html('');	
								$("#hyc"+i).trigger('reset');
								$("#cy"+i).append(cevap).hide().fadeIn(2000);
							}
						}
					});       
				});
					
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
			

			$('body').on('click' , '.hysb', function() {
				i =  $(this).attr('data'); 
				var txt;
				var r = confirm("Bu yorumu silmek istediğine emin misin?");
				if (r == true) {
					$.ajax({
						type:"post",
						url:"haberys_s.php",
						data:{yi:i}, 
						success:function(a){
							if (a==1) {
								$("#y"+i).html("<div class='col-12 text-center'><div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div></div>");
								$("#y"+i).remove();
								$("#cy"+i).remove();
							} else{
								$("#hy"+i).html(a);
								setTimeout(function() { $('#hy'+i).hide(); }, 2000); 
							}
						}
					});
				}else{
					
				}
			});

			$('body').on('click' , '.hycsb', function() {
				i =  $(this).attr('data'); 
				var txt;
				var r = confirm("Bu yorumu silmek istediğine emin misin?");
				if (r == true) {
					$.ajax({
					type:"post",
					url:"haberycs_s.php",
					data:{yci:i}, 
					success:function(a){
						if (a==1) {
							$("#cs"+i).html("<div class='col-12 text-center'><div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div></div>");
							$("#cs"+i).remove();
						}else{
							$("#ss"+i).html(a);
							setTimeout(function() { $('#ss').hide(); }, 2000); 
						}
					}
					});
				}else{

				}
			});

			$('body').on('click' , '.hfe', function() {
				i=$(this).attr('data'); 
				$.ajax({
					type:"post",
					url:"haberfe_s.php",
					data:{fei:i}, 
					success:function(a){
						$(".hfes"+i).html(a);	
					}
				});
			});
		});
	</script>
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
?>

<script type="text/javascript">
	$(".hdr").css("display", "none");
	$(".hdr").fadeIn("slow");

	$(".hdy").css("display", "none");
	$(".hdy").show("slow");

	$(".hdyc").css("display", "none");
	$(".hdyc").show(1100);

</script>