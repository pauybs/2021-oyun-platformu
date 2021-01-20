<?php
if(isset($_GET["Kurator"]) ){    
$Kurator =Guvenlik($_GET["Kurator"]);	
$KuratorKontrol=$DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE KullaniciAdi=? AND Kurator=? and Durum=? and SilinmeDurumu=? LIMIT 1");
$KuratorKontrol->execute([$Kurator,1,1,0]);
$KuratorKontrolSayi = $KuratorKontrol->rowCount();
$KuratorKontrolKayit = $KuratorKontrol->fetch(PDO::FETCH_ASSOC);
	if($KuratorKontrolSayi>0){
	$KuratorBilgiler=$DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE KullaniciAdi=? and Kurator=? and Durum=? and SilinmeDurumu=? LIMIT 1 ");
	$KuratorBilgiler->execute([$Kurator,1,1,0]);
	$KuratorBilgilerVeri = $KuratorBilgiler->rowCount();
	$KuratorBilgilerKayitlar = $KuratorBilgiler->fetch(PDO::FETCH_ASSOC);
	if ($KuratorBilgilerVeri>0) {
		if ( IcerikTemizle($KuratorBilgilerKayitlar["ArkaplanRengi"])=="") {
				
		}else{
			$ArkaplanResmi=$DatabaseBaglanti->prepare("SELECT * FROM wallpapers WHERE id=? LIMIT 1");
			$ArkaplanResmi->execute([IcerikTemizle($KuratorBilgilerKayitlar["ArkaplanRengi"])]);
			$ArkaplanResmiVeri=$ArkaplanResmi->rowCount();
			$ArkaplanResmiKayitlar =$ArkaplanResmi->fetch(PDO::FETCH_ASSOC);
			if ($ArkaplanResmiVeri>0) {
				$Arkaplan=	 IcerikTemizle($ArkaplanResmiKayitlar["Resim"]);
			}else{
					
			}
		}
		?>
		<div class="col-12" style="<?php if(IcerikTemizle($KuratorBilgilerKayitlar["ArkaplanRengi"])=="" or IcerikTemizle($ArkaplanResmiVeri)<=0){ ?> <?php }else{ ?> background: url('images/wallpapers/<?php echo IcerikTemizle($Arkaplan);?>') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover; background-size: cover; <?php } ?>">
			<div class="row justify-content-center m-0">
				<div class="col-12 col-xl-8">			
					<div class="row">
						<div class="col-12">
							<div class="row justify-content-center align-items-center">
								<div class="col-12 p-0 mt-5 mb-4">
									<div class="row justify-content-center align-items-center text-center">
										<div class="col-12 col-xl-2 mt-3">
											<div class="row justify-content-center align-items-center text-center">
												<div class="col-12">
												<?php
												if (file_exists("images/userphoto/".$KuratorBilgilerKayitlar["ProfilResmi"]) and (isset($KuratorBilgilerKayitlar["ProfilResmi"])) and ($KuratorBilgilerKayitlar["ProfilResmi"]!="") ){
												?>
													<img src="images/userphoto/<?php echo IcerikTemizle($KuratorBilgilerKayitlar["ProfilResmi"]) ?>" class="img-fluid KYVBXZCza" >
												<?php
												}else{
												?>
													<img src="images/user.png" class="img-fluid KYVBXZCza">
												<?php
												}
												?>
												</div>
												<div class="col-12 mt-1">
													<span class="bold white kurator">
														<?php echo IcerikTemizle($KuratorBilgilerKayitlar["KullaniciAdi"]); ?>
													</span>
												</div>
											</div>
										</div>

										<div class="col-10 col-xl-6 mt-3">
											<div class="row justify-content-center align-items-center">
												<div class="col-12">
													<div class="row align-items-center">
														<div class="col-4  text-left col-xl-2">
															<div class="row justify-content-center align-items-center text-center">
																<div class="col-12">
																<?php	
																$KuratorTakipSayi = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=?");
																$KuratorTakipSayi->execute([$KuratorBilgilerKayitlar["id"]]);
																$KuratorTakipSayiVeri = $KuratorTakipSayi->rowCount();
																?>
																	<span class="bold white kurator">
																		<?php echo IcerikTemizle(number_format_short($KuratorTakipSayiVeri)); ?>
																	</span>
																</div>
																<div class="col-12">
																	<span class="bold white kurator opacity07">Takipçi</span>
																</div>
															</div>
														</div>

														<div class="col-4 text-left col-xl-2">
															<div class="row justify-content-center align-items-center text-center">
																<div class="col-12">
																<?php	
																$KuratorIncelemeSayi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? and Durum=?");
																$KuratorIncelemeSayi->execute([$KuratorBilgilerKayitlar["id"],1]);
																$KuratorIncelemeSayiVeri = $KuratorIncelemeSayi->rowCount();
																?>
																<span class="bold white kurator">
																	<?php echo IcerikTemizle(number_format_short($KuratorIncelemeSayiVeri)); ?> 
																</span>
																</div>
																<div class="col-12">
																	<span class="bold white kurator opacity07">İnceleme</span>
																</div>
															</div>
														</div>
														
														<div class="col-4 text-left col-xl-2">
															<div class="row justify-content-center align-items-center text-center">
																<div class="col-12">
																<?php	
																$KuratorBegeniSayi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? And Durum=?");
																$KuratorBegeniSayi->execute([$KuratorBilgilerKayitlar["id"],1]);
																$KuratorBegeniSayiVeri = $KuratorBegeniSayi->rowCount();
																$KuratorBegeniSayiKayit = $KuratorBegeniSayi->fetchAll(PDO::FETCH_ASSOC);
																$ToplamBegeni=0;
																foreach ($KuratorBegeniSayiKayit as $Begeni) {
																	$ToplamBegeni+= $Begeni["Begeni"];
																}
																?>
																	<span class="bold white kurator">
																		<?php echo IcerikTemizle(number_format_short($ToplamBegeni));?> 
																	</span>
																</div>
																<div class="col-12">
																	<span class="bold white kurator opacity07">Beğeni</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-xl-4 mt-3">
											<div class="row justify-content-center align-items-center ">
												<div class="col-12">
													<span <?php if(isset($_SESSION["Kullanici"])){ ?> class="kt<?php echo  IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>" <?php }else{ ?> <?php } ?>>
														<?php
														if(isset($_SESSION["Kullanici"] )){
														?>
															<?php	
															$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=? LIMIT 1" );
															$TakipKontrol->execute([$KuratorBilgilerKayitlar["id"],$KullaniciId]);
															$TakipKontrolVeri = $TakipKontrol->rowCount();
															$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
															if ($TakipKontrolVeri>0) {
															?>
																<?php
																if ($KuratorBilgilerKayitlar["id"] == $KullaniciId) {
																?>
																	<?php
																	if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
																	?>
																		<button style="background: #202020" data-toggle="modal" data-target=".bd-example-modal-xl" type="button" class="btn bold kurator pt-0 pb-0">
																			<span class="bold kurator white" ><i class="fas fa-cog" style="font-size: 15px"></i> Özelleştir</span>
																		</button>
																	<?php	
																	}
																	?>
																<?php
																}else{
																?>
																	<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 kte" data="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
																		<i class="fas fa-user-check white" style="font-size: 15px"></i><span class="white">Takip Ediliyor</span>
																	</button>
																<?php
																}
																?>
															<?php
															}else{
															?>	
																<?php
																if ($KuratorBilgilerKayitlar["id"] == $KullaniciId){
																?>

																	<?php
																	if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
																		?>
																		<button style="background: #202020" data-toggle="modal" data-target=".bd-example-modal-xl" type="button" class="btn bold kurator pt-0 pb-0">
																			<span class="bold kurator white" ><i class="fas fa-cog " style="font-size: 15px"></i> Özelleştir</span>
																		</button>
																	<?php	
																	}
																	?>
																<?php
																}else{
																?>
																	<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 kte" data="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
																		<span class="bold kurator white" ><i class="fas fa-user-plus"></i> Takip Et</span>
																	</button>
																<?php
																}
																?>
															<?php
															}
															?>
														<?php
														}else{
														?> 
															<a href="girisyap" s>
																<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0">
																	<span class="bold kurator white"><i class="fas fa-user-plus"></i>Takip Et</span>
																</button>
															</a>
														<?php
														}
														?>
													</span> 
													<?php 
													if (isset($_SESSION["Kullanici"])) {
													?>
														<?php
														if ($KuratorBilgilerKayitlar["id"] != $KullaniciId) {
														?>
															<span>
																<button style="background: #202020"  type="button" class="btn bold kurator pt-0 pb-0 ml-3 keb" data-toggle="modal" data-target="#sikayet"><span class="white">Şikayet Et</span></button>
															</span>
														<?php
														}
														?>
													<?php
													}else{
													?> 
														<a href="girisyap">
															<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 ml-3 "><span class="white">Şikayet Et</span></button>
														</a>
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

				<div class="col-12 col-xl-8 p-0">
					<div class="tab-wrap">
						<input class="tab" id="tab1" type="radio" name="group1" checked="checked"/>
						<label for="tab1" class="kdnav">İncelemeler</label>
						<input class="tab" id="tab2" type="radio" name="group1"/>
						<label for="tab2" class="kdnav">Hakkında</label>
						<input class="tab" id="tab3" type="radio" name="group1"/>
						<label for="tab3" class="kdnav">Favori Oyunlar</label>
						<div class="tab-content">
							<div class="row align-items-center m-0">
							<?php
							$KuratorInceleme = $DatabaseBaglanti->prepare("SELECT oyunlar.Durum, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId WHERE incelemeler.KuratorId=? and incelemeler.Durum!=? and incelemeler.Durum!=? AND oyunlar.Durum=? ORDER BY incelemeler.Begeni DESC");
							$KuratorInceleme->execute([$KuratorBilgilerKayitlar["id"],0,3,1]);
							$KuratorIncelemeData = $KuratorInceleme->rowCount();
							$KuratorIncelemeKayitlar = $KuratorInceleme->fetchAll(PDO::FETCH_ASSOC);
							if ($KuratorIncelemeData>0) {
								foreach ($KuratorIncelemeKayitlar as  $Kuratorkayitlar) {
								$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
								$KuratorAdi->execute([$Kuratorkayitlar["KuratorId"]]);
								$KuratorAdiVeri = $KuratorAdi->rowCount();
								$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

								$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
								$OyunAdi->execute([$Kuratorkayitlar["OyunId"]]);
								$OyunAdiVeri = $OyunAdi->rowCount();
								$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);	
							?>
								<div class="col-6 col-xl-3 mb-3">
									<div class="row p-2">
										<div class="col-12 krtbrd">
											<div class="row align-items-end">
												<div class="col-12 p-0 " style="background: black"   >
												<?php
												if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
												?>
													<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
														<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05"  >  
													</a>
												<?php
												}else{
												?>	
													<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
														<img src="images/resim.jpg" class="img-fluid "  >
													</a> 
												<?php
												}
												?>
												</div>
												<div class="col-12 position-absolute p-0 kcxvxvzbtre">
													<div class="row align-items-center p-2">
														<div class="col-12 mt-5">
															<a  href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
																<p class="bold incelemb m-0 KznaZxXxAS" >
																	<?php echo IcerikTemizle($Kuratorkayitlar["Baslik"]); ?> 
																</p> 
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
								}else{
								?>
									<div class="col-12 mb-3">
										<div class="row justify-content-center mb-5">
											<div class="col-12 text-center mb-2 mt-4" >
												<span style="font-size: 45px"><i class="far fa-edit white"></i></span>
											</div>
											<div class="col-12 text-center  mb-4 font15 white" >
												<span>Henüz hiç inceleme yok</span>
											</div>
											<?php
											$PopulerIncelemeler = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE    incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1  Order by incelemeler.Begeni DESC LIMIT 4" );
											$PopulerIncelemeler->execute([1]);
											$PopulerIncelemelerData = $PopulerIncelemeler->rowCount();
											$PopulerIncelemelerKayitlar = $PopulerIncelemeler->fetchAll(PDO::FETCH_ASSOC);
											if ($PopulerIncelemelerData>0) {
											?>
											<div class="col-12">
											<?php
											?>
												<div class="row p-3 justify-content-end align-items-center">
													<div class="col-12 mt-3 mb-2">
														<div class="row  justify-content-end">
															<div class="col-7 col-xl-10 text-left bGAfxXE" >
																<span>POPÜLER İNCELEMELER</span>
															</div>
															<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL WrGYT__Xx">
																<a href="oyunincelemeler" >
																	<span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span>
																</a>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
												<?php
												foreach ($PopulerIncelemelerKayitlar as $PopülerIncelemeler) {
												$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
												$KuratorAdi->execute([$PopülerIncelemeler["KuratorId"]]);
												$KuratorAdiVeri = $KuratorAdi->rowCount();
												$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

												$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
												$OyunAdi->execute([$PopülerIncelemeler["OyunId"]]);
												$OyunAdiVeri = $OyunAdi->rowCount();
												$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
												?>
													<div class="col-6 col-xl-3 mb-3">
														<div class="row p-2 ">
															<div class="col-12 ">
																<div class="row align-items-end " >
																	<div class="col-12 p-0" style="background: black">
																	<?php
																	if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
																	?>
																		<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>" >
																			<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05">	  
																		</a>
																	<?php
																	}else{
																	?>	
																		<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>" >
																			<img src="images/resim.jpg" class="img-fluid">
																		</a> 
																	<?php
																	}
																	?>
																	</div>

																	<div class="col-12 position-absolute p-0 kcxvxvzbtre">
																		<div class="row align-items-center p-2">
																			<div class="col-12 mt-5 ">
																				<a  href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>" >
																					<p class="bold white incelemb m-0 KznaZxXxAS" >
																						<?php echo IcerikTemizle($PopülerIncelemeler["Baslik"]); ?> 
																					</p> 
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
							</div>
						</div>

						<div class="tab-content">
							<div class="row justify-content-center m-0">
								<div class="col-12 mb-4" >
									<div class="row justify-content-center">
										<div class="col-12 col-xl-9">
											<div class="row p-2">
												<div class="col-12 MCVXAxsA">
													<div class="row justify-content-center p-3">
														<div class="col-12">
															<div class="row">
																<div class="col-12" >
																	<h6 class="bold white">Hakkında</h6>
																</div>
																<div class="col-12 mt-2">
																	<span class=" white opacity07 incelemeb">
																		<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Hakkinda"]); ?>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>

												<?php
												if ((IcerikTemizle($KuratorBilgilerKayitlar["Youtube"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Twitch"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Instagram"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Twitter"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Facebook"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Discord"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Dlive"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["WebSite"])!="") ) {
												?>
												<div class="col-12 mt-3 MCVXAxsA">
													<div class="row justify-content-center align-items-center text-center p-3">
													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Youtube"])!=""){
													?>
														<span class="ml-3 mb-2">
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Youtube"]) ?>">
																<i  class="fab fa-youtube white font25"></i>
															</a>
														</span>
													<?php
													}
													?>
													
													<?php
													if( IcerikTemizle($KuratorBilgilerKayitlar["Twitch"])!=""){
													?>
														<span class="ml-3 mb-2">
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitch"]) ?>">
																<i class="fab fa-twitch white font25"></i>
															</a>
														</span>
													<?php
													}
													?>

													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Instagram"])!=""){
													?>
														<span class="ml-3 mb-2">
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Instagram"]) ?>">
																<i class="fab fa-instagram white font25"></i>
															</a>
														</span>
														<?php
													}
													?>
													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Twitter"])!=""){
													?>
														<span class="ml-3  mb-2">
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitter"]) ?>">
																<i class="fab fa-twitter white font25 "></i>
															</a>
														</span>	
													<?php
													}
													?>

													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Facebook"])!=""){
														?>
														<span class="ml-3   mb-2 vcjcbsd" >
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Facebook"]) ?>"><img src="images/facebookgaming.png" class="img-fluid czxzcvHAS"  ></a>
														</span>
														<?php
													}
													?>

													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Discord"])!=""){
														?>
														<span class="ml-3  mb-2" >
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Discord"]) ?>"><i style="font-size: 23px" class="fab fa-discord white "></i></a>
														</span>
														<?php
													}
													?>


													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Dlive"])!=""){
														?>
														<span class="ml-3  mb-2 xczpteer"  >
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Dlive"]) ?>"><img src="images/dlive.png" class="img-fluid ZXCajsasd"  ></a>
														</span>
														<?php
													}
													?>

													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"])!=""){
														?>
														<span class="ml-3  mb-2 xczpteer"  >
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"]) ?>"><img src="images/nonolive.png" class="img-fluid xvcbxcvmb"  ></a>
														</span>
														<?php
													}
													?>

													<?php
													if(IcerikTemizle($KuratorBilgilerKayitlar["WebSite"])!=""){
														?>
														<span class="ml-3  mb-2" >
															<a target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["WebSite"]) ?>"><i style="font-size: 23px"  class="fas fa-globe white" ></i></a>
														</span>	
														<?php
													}
													?>
													</div>
												</div>
												<?php
												}else{
												?>

												<?php
												}
												?>
												<div class="col-12 mt-3 MCVXAxsA">
													<div class="row justify-content-center p-3">
														<div class="col-12">
															<div class="row">
																<div class="col-12">
																	<h6 class="bold white">Donanım</h6>
																</div>
																<?php
																$Donanim = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar WHERE UyeId=? LIMIT 1");
																$Donanim->execute([$KuratorBilgilerKayitlar["id"]]);
																$DonanimVeri = $Donanim->rowCount();
																$DonanimKayitlar = $Donanim->fetch(PDO::FETCH_ASSOC);
																if ($DonanimVeri>0) {
																?>
																	<?php
																	if ($DonanimKayitlar["IsletimSistemiId"]!="") {
																	?>
																		<?php
																		$IsletimSistemi = $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE id=? LIMIT 1");
																		$IsletimSistemi->execute([$DonanimKayitlar["IsletimSistemiId"]]);
																		$IsletimSistemiVeri = $IsletimSistemi->rowCount();
																		$IsletimSistemiKayitlar = $IsletimSistemi->fetch(PDO::FETCH_ASSOC);
																		if ($IsletimSistemiVeri>0) {
																		?>
																			<div class="col-12 mt-2 incelemeb">
																				<span class=" white bold">İşletim Sistemi:</span>
																				<span class=" white opacity07">
																					<?php echo IcerikTemizle($IsletimSistemiKayitlar["IsletimSistemiAdi"]); ?>
																				</span>
																			</div>
																		<?php
																		}
																		?>
																	<?php
																	}
																	?>

																	<?php
																	if ($DonanimKayitlar["IslemciId"]!="") {
																	?>
																		<?php
																		$Islemci = $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE id=? LIMIT 1");
																		$Islemci->execute([$DonanimKayitlar["IslemciId"]]);
																		$IslemciVeri = $Islemci->rowCount();
																		$IslemciKayitlar = $Islemci->fetch(PDO::FETCH_ASSOC);
																		if ($IslemciVeri>0) {
																		?>
																			<div class="col-12 mt-2 incelemeb">
																				<span class="white bold">İşlemci:</span>
																				<span class="white opacity07">
																					<?php echo IcerikTemizle($IslemciKayitlar["IslemciAdi"]); ?>
																				</span>
																			</div>
																		<?php
																		}
																		?>
																	<?php
																	}
																	?>

																	<?php
																	if ($DonanimKayitlar["EkranKartiId"]!="") {
																	?>
																		<?php
																		$EkranKarti = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE id=? LIMIT 1");
																		$EkranKarti->execute([$DonanimKayitlar["EkranKartiId"]]);
																		$EkranKartiVeri = $EkranKarti->rowCount();
																		$EkranKartiKayitlar = $EkranKarti->fetch(PDO::FETCH_ASSOC);
																		if ($EkranKartiVeri>0) {
																			?>
																			<div class="col-12 mt-2 incelemeb">
																				<span class=" white bold">Ekran Kartı:</span>
																				<span class=" white opacity07">
																					<?php echo IcerikTemizle($EkranKartiKayitlar["EkranKartiAdi"]); ?>	
																				</span>
																			</div>
																		<?php
																		}
																		?>
																	<?php
																	}
																	?>


																	<?php
																	if ($DonanimKayitlar["RamId"]!="") {
																	?>
																		<?php
																		$Ram=$DatabaseBaglanti->prepare("SELECT * FROM ram WHERE id=? LIMIT 1");
																		$Ram->execute([$DonanimKayitlar["RamId"]]);
																		$RamVeri = $Ram->rowCount();
																		$RamKayitlar = $Ram->fetch(PDO::FETCH_ASSOC);
																		if ($RamVeri>0) {
																		?>
																			<div class="col-12 mt-2 incelemeb">
																				<span class=" white bold">Bellek:</span>
																				<span class=" white opacity07">
																					<?php echo IcerikTemizle($RamKayitlar["RamTuru"]); ?>
																				</span>
																			</div>
																		<?php
																		}
																		?>
																	<?php
																	}
																	?>

																	<?php
																	if ($DonanimKayitlar["DirectxId"]!="") {
																	?>
																		<?php
																		$directx = $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
																		$directx->execute([$DonanimKayitlar["DirectxId"]]);
																		$directxVeri = $directx->rowCount();
																		$directxKayitlar = $directx->fetch(PDO::FETCH_ASSOC);
																		if ($directxVeri>0) {
																		?>
																			<div class="col-12 mt-2 incelemeb">
																				<span class=" white bold">DirectX:</span>
																				<span class=" white opacity07">
																					<?php echo IcerikTemizle($directxKayitlar["DirectxAdi"]); ?>
																				</span>
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

																<?php
																}
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-12 col-xl-3">
											<div class="row p-2" >
												<div class="col-12 MCVXAxsA" >
													<div class="row justify-content-center align-items-center">
														<div class="col-12 text-center">
															<div class="row">
																<div class="col-12 bold mt-4" style="color: #c28f2c">
																<?php	
																$Erisim = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? And Durum=? " );
																$Erisim->execute([$KuratorBilgilerKayitlar["id"],1]);
																$ErisimVeri = $Erisim->rowCount();
																$ErisimKayit = $Erisim->fetchAll(PDO::FETCH_ASSOC);
																$ToplamErisim=0;
																foreach ($ErisimKayit as $Erisimler) {
																	$ToplamErisim+= $Erisimler["Goruntulenme"];
																}
																if ($ToplamErisim==0) {
																	$ErisimSayisi= "-";
																}else{
																	$ErisimSayisi=$ToplamErisim;
																}
																?>

																	<h4><?php echo IcerikTemizle($ErisimSayisi); ?></h4>
																</div>
																<div class="col-12 bold white"><h6>Erişim</h6></div>
																<div class="col-12 bold mt-4 " style="color: #c28f2c">
																<?php	
																if ($KuratorIncelemeSayiVeri==0) {
																	$IncelemeSayisi= "-";
																}else{
																	$IncelemeSayisi=$KuratorIncelemeSayiVeri;
																}
																?>
																	<h4><?php echo IcerikTemizle($IncelemeSayisi); ?></h4>
																</div>
																<div class="col-12 bold white"><h6>İnceleme</h6></div>
																<div class="col-12 bold mt-4 " style="color: #c28f2c">
																<?php	
																	if ($ToplamBegeni==0) {
																		$ToplamBegeni= "-";
																	}
																	?>
																	<h4><?php echo IcerikTemizle($ToplamBegeni); ?></h4>
																</div>
																<div class="col-12 bold white mb-2"><h6>Beğeni</h6></div>
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

						<div class="tab-content">
							<div class="row align-items-center p-3">
							<?php
							$FavorilerSorgu = $DatabaseBaglanti->prepare("SELECT oyunfavoriler.OyunId, oyunlar.id, oyunlar.Durum, oyunfavoriler.id, oyunfavoriler.UyeId FROM oyunfavoriler INNER JOIN oyunlar ON oyunfavoriler.OyunId = oyunlar.id WHERE oyunfavoriler.UyeId=? AND oyunlar.Durum=1 ORDER BY oyunfavoriler.id DESC   ");
							$FavorilerSorgu->execute([$KuratorBilgilerKayitlar["id"]]);
							$FavoriData = $FavorilerSorgu->rowCount();
							$FavoriKayit = $FavorilerSorgu->fetchAll(PDO::FETCH_ASSOC);
							if($FavoriData>0){
								foreach($FavoriKayit as $Kayitlar) {		
								$Oyunlar = $DatabaseBaglanti->prepare("SELECT *  FROM oyunlar WHERE Durum=1 AND id=?   LIMIT 1 ");
								$Oyunlar->execute([$Kayitlar["OyunId"]]);
								$OyunKayitlar = $Oyunlar->fetch(PDO::FETCH_ASSOC);
							?>
								<div class="col-6 col-xl-3">
									<div class="row  align-items-center mb-2" >
										<div class="col-12" >
											<div class="row align-items-center p-1">
											<?php
											if (file_exists("images/games/".$OyunKayitlar["AnaResim"]) and ($OyunKayitlar["AnaResim"])) {
											?>
												<div class="col-12 p-0 krtbrd">
													<div class="row">
														<div class="col-12">
															<a  style="color: black; font-weight: bold;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["id"]); ?>" >
																<img src="images/games/<?php echo  IcerikTemizle($OyunKayitlar["AnaResim"]);?>" class="img-fluid wWfVCA"  >
															</a>        
														</div>
													</div>
												</div>
											<?php
											}else{
											?>
												<div class="col-12 p-0 krtbrd">
													<div class="row">
														<div class="col-12 ">
															<a style="color: white; font-weight: bold;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["id"]); ?>" >
																<img src="images/resim.jpg" class="img-fluid wWfVCA"  >
															</a>        
														</div>
													</div>
												</div>
											<?php
											}
											?>
												<div class="col-12 mt-2 p-0" >
													<div class="row text-left">
														<div class="col-12 " >
															<a  style= "color: white; font-weight: bold;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["id"]); ?>" >
																<h1 class="favorio __PaQqpL_AZxZxX">
																 <?php echo IcerikTemizle($OyunKayitlar["OyunAdi"]); ?>
																 </h1>
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
							}else{
							?>						
								<div class="col-12 mb-3">
									<div class="row justify-content-center mb-5 m-0">
										<div class="col-12 text-center mb-2 mt-4" >
											<span style="font-size: 45px"><i class="fas fa-gamepad white"></i></span>
										</div>
										<div class="col-12 text-center mb-4 white font15">
											<span>Favori oyun bulunmamaktadır.</span>
										</div>
										<?php 
										$EnPopulerOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=?  ORDER BY Goruntulenme DESC  LIMIT 4");
										$EnPopulerOyunlar->execute([1]);
										$EnPopulerOyunlarVeriSayisi = $EnPopulerOyunlar->rowCount();
										$EnPopulerOyunlarVeriler =  $EnPopulerOyunlar-> fetchAll(PDO::FETCH_ASSOC);
										if ($EnPopulerOyunlarVeriSayisi>0) {
										?>
										<div class="col-12 p-0 mb-2">
											<div class="row justify-content-center align-items-center">
												<div class="col-12  mt-3 mb-2">
													<div class="row p-3 justify-content-end align-items-center">
														<div class="col-12 text-left cncxbvfv" ><span>POPÜLER OYUNLAR</span></div>
													</div>
													<div class="row justify-content-end">
														<div class="col-6 col-xl-2 p-1 text-center ErYTIxKL WrGYT__Xx">
															<a href="populeroyunlar" >
																<span class=" gxPpxXo_">DAHA FAZLA GÖSTER</span>
															</a>
														</div>
													</div>
												</div>
												<?php
												foreach ($EnPopulerOyunlarVeriler as $EnPopulerOyunlarKayitlar){
												?>
												<div class="col-6 col-xl-3 mb-4">
													<div class="row p-2">
													<?php
													if ( file_exists("images/games/".$EnPopulerOyunlarKayitlar["AnaResim"])and ($EnPopulerOyunlarKayitlar["AnaResim"])) {
													?>
														<div class="col-12 p-0" style="background: black" >
															<a href="oyundetay/<?php echo  SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["id"]); ?>">
																<img src="images/games/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["AnaResim"]) ?>" class="img-fluid   po" >
															</a>
														</div>
													<?php
													}else{
													?>
														<div class="col-12 p-0">
															<a href="oyundetay/<?php echo SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["id"]); ?>">
																<img src="images/resim.jpg" class="img-fluid  " >
															</a>
														</div>
													<?php
													}
													?>
														<div class="col-12 mt-3 p-0" >
															<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["id"]); ?>">
																<h6 class="po uQRtXT oyunAdi ">
																	<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]) ?>
																</h6>
															</a>
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
	</div>
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
if(isset($_SESSION["Kullanici"])){
?>
	<?php
	if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
	?>

	<?php
	}else{
	?>
	<script>
	$(document).ready(function(){
		$('body').on('click' , '.keb', function() {
			$(".kss").fadeOut();
			$(".ksb").fadeOut();
			$(".ksg").fadeIn();
		}); 
		$('body').on('click' , '.kte', function() {
			i=$(this).attr('data'); 
			$.ajax({
				type:"post",
				url:"k_tkp.php",
				data:{kdte:i}, 
				success:function(a){
				$(".kt"+i).html(a);
				}
			});    
		}); 
				
		$('body').on('click' , '.kse', function() {
			$.ajax({
				type:"post",
				url:"k_sikayet.php",
				data:$(".ksg").serialize(), 
				success:function(b){
					if (b==1) {
						$(".kss").html("<span class='bold font13 ' style=' color:red'>Şikayetiniz Alınamadı.</span>").hide().fadeIn();
					}else if(b==2){
						$(".kss").html("<span class='bold font13 ' style=' color:red'>Şikayet nedeniniz 250 karakterden uzun olamaz.</span>").hide().fadeIn();
					}else{
						$(".kss").fadeOut();
						$(".ksb").fadeOut();
						$(".ksb").html(b).hide().fadeIn();
						$(".ksg").trigger('reset');
						$(".ksg").fadeOut();
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
					<div class="col-12 text-center  mt-2 kss"></div>
					<div class="col-12 text-center ksb mt-2"></div>
					<form class="hesabim ksg " method="post" action="javascript:void(0);">
						<div class="col-12 mt-2">
							<div class="col-12 text-left p-0 white bold" >Şikayet nedeniniz nedir?</div>      
							<textarea type="text" id="textt" style="background: black;color:white" name="Sikayet"></textarea>
							<input type="hidden" name="k" value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
							<span class="highlight"></span>
							<span class="bar"></span> 
							<div class="bold  font13" style="color: #585858">Maksimum 250 karakter</div>
						</div>
						<div class="col-12  mt-3 mb-3  p-0  text-center  " >
							<button class="call-to-action2  kse" >
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
<?php
}
?>



<?php 
if (isset($_SESSION["Kullanici"])) {
	if ($KullaniciKuratorDurumu==1 and ($KullaniciId==$KuratorBilgilerKayitlar["id"]) ) {
	?>
	<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content " style="background: #202020">
				<button type="button" class="close text-right p-2" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="white" >&times;</span>
				</button>
				<form class="kb" method="post" action="javascript:void(0);">
					<div class="row justify-content-center m-0  kds" >
						<div class="col-11 p-0  text-right mt-5 kpr">
							<button class="call-to-action2 kdd" type="submit" >
								<div>
									<div>Kaydet</div>
								</div>
							</button>
						</div>
						<div class="col-11 mb-1  p-0"><h6 class="bold white">Profil Resmi</h6></div>
						<div class="col-11 " style="background: rgb(0,0,0,0.5);border-radius: 5px">
							<div class="row align-items-center p-3">
								<?php
								if(($KullaniciProfilResmi!="") and (isset($KullaniciProfilResmi)) and file_exists("images/userphoto/".$KullaniciProfilResmi) ){
								?>
									<div class="col-12 col-xl-2 text-center mb-2 ">
										<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?> " class="img-fluid" style="border-radius: 50%;height: 70px; width: 70px">
									</div>
									<div class="col-12 col-xl-10 text-left white mb-2">
										<div class="row">
											<div class="col-12 kdrs"></div>
											<div class="col-12">
												<input type="file" style="overflow:hidden;font-size:13px" name="ProfilResim" >
											</div>
											<div class="col-12 white font13 mt-1" style="color:#585858">
												<span>Resim JPG veya JPEG formatında olmalı, 400 X 400 piksel ve 2MB'yi aşmamalıdır.</span>
											</div>
										</div>
									</div>
								<?php
								}else{
								?>
									<div class="col-4 col-xl-2 ">
										<img src="images/user.png " class="img-fluid" style="border-radius: 50%;height: 100px; width: 100px">
									</div>
									<div class="col-8 col-xl-10 text-left white">
										<div class="row">
											<div class="col-12 kdrs"></div>
											<div class="col-12"><input type="file"  style="overflow:hidden;font-size:13px" name="ProfilResim"  ></div>
											<div class="col-12 white font13 mt-1"style="color:#585858"><span>Resim JPG veya JPEG formatında olmalı, 400 X 400 piksel ve 2MB'yi aşmamalıdır.</span></div>
										</div>
									</div>
								<?php
								}
								?>	
							</div>
						</div>

						<div class="col-11 mb-1 mt-5  p-0"><h6 class="bold white">Biyografi</h6></div>
						<div class="col-11 " style="background: rgb(0,0,0,0.5);border-radius: 5px">
							<div class="row align-items-center p-3">
								<div class="col-12 mt-3 mb-1">
									<textarea name="Biyo" placeholder="Açıklama Yazınız"   style="width: 100%;background: #202020;color: white;border:none;height: 100px;border-radius: 5px;font-size:13px" ><?php echo IcerikTemizle($KuratorBilgilerKayitlar["Hakkinda"]);?></textarea>
								</div>
							</div>
						</div>

						<div class="col-11  mb-1 mt-5  p-0"><h6 class="bold white">Sosyal Medya Bağlantıları</h6></div>
						<div class="col-11 " style="background: rgb(0,0,0,0.5);border-radius: 5px">
							<div class="row justify-content-center align-items-center p-2 mb-2 mt-3">
								<div class="col-2 p-0 text-center col-xl-1">
									<i style="font-size: 25px" class="fab fa-instagram white "></i>
								</div>
								<div class="col-9 col-xl-11 text-left">
									<input placeholder="Instagram Url" type="text" class="p-2" style="background: #202020;border: none;color: white;width: 100%" name="Instagram" value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Instagram"]) ?>">
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i  style="font-size: 25px" class="fab fa-youtube white "></i>
								</div>
								<div class="col-9 col-xl-11 text-left"><input type="text"  placeholder="Youtube Url" class="p-2" style="background: #202020;border: none;color: white;width: 100%" name="Youtube"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Youtube"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i style="font-size: 25px" class="fab fa-twitch white "></i>
								</div>
								<div class="col-9 col-xl-11 text-left"><input type="text"   placeholder="Twitch Url" class="p-2" style="background: #202020;border: none;color: white;width: 100%" name="Twitch"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitch"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i style="font-size: 25px"  class="fab fa-twitter white "></i>
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Twitter Url" style="background: #202020;border: none;color: white;width: 100%" name="Twitter"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitter"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/facebookgaming.png" class="img-fluid" style="width: 20px;height: 20px" >
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Facebook Gaming Url" style="background: #202020;border: none;color: white;width: 100%" name="FacebookG"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Facebook"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i style="font-size: 25px"  class="fab fa-discord white "></i>
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Discord Url" style="background: #202020;border: none;color: white;width: 100%" name="Discord"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Discord"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/dlive.png" class="img-fluid" style="width: 25px;height: 25px" >
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Dlive Url" style="background: #202020;border: none;color: white;width: 100%" name="Dlive"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Dlive"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/nonolive.png" class="img-fluid" style="width: 23px;height: 23px" >
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Nonolive Url" style="background: #202020;border: none;color: white;width: 100%" name="Nonolive"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"]) ?>"></div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-3 ">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i style="font-size: 23px"  class="fas fa-globe white" ></i>
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2"  placeholder="Web Sitesi Url" style="background: #202020;border: none;color: white;width: 100%" name="WebSite"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["WebSite"]) ?>"></div>
							</div>
						</div>

						<div class="col-11 mb-1 mt-5  p-0"><h6 class="bold white">Arkaplan Resmi</h6></div>
						<div class="col-11 mb-5" >
							<div class="row justify-content-center mt-4 p-3 cxvnxcz" style="overflow-y: scroll;height: 670px ">
								<div class="col-12 col-md-4  mt-3" >
									<div class="row">
										<div class="col-12"><img src="images/hata2.jpg" class="img-fluid " style="background: black;border: 1px solid rgb(255,255,255,0.3)"></div>
										<div class="col-12 text-center"><input type="radio"  name="Wall" value="0" ></div>
									</div>
								</div>
								<?php
								$Arkaplan = $DatabaseBaglanti->prepare("SELECT * FROM wallpapers order by id DESC ");
								$Arkaplan->execute([$KuratorBilgilerKayitlar["id"],1]);
								$ArkaplanData = $Arkaplan->rowCount();
								$ArkaplanKayitlar = $Arkaplan->fetchAll(PDO::FETCH_ASSOC);
								if ($ArkaplanData>0) {
									foreach ($ArkaplanKayitlar as  $ArkaKayitlar) {
								?>
									<div class="col-12 col-md-4 mt-3">
										<div class="row">
											<div class="col-12">
												<a href="images/wallpapers/<?php echo IcerikTemizle($ArkaKayitlar["Resim"]) ?>" style="overflow: hidden;"  data-lightbox="image-1" >
													<img src="images/wallpapers/<?php echo IcerikTemizle($ArkaKayitlar["Resim"]) ?>" class="img-fluid" style="background:black;border: 1px solid rgb(255,255,255,0.3) ">
												</a>
											</div>
											<div class="col-12 text-center">
												<input type="radio"  name="Wall" value="<?php echo IcerikTemizle($ArkaKayitlar["id"]) ?> " <?php if( IcerikTemizle($KuratorBilgilerKayitlar["ArkaplanRengi"] ) == (IcerikTemizle($ArkaKayitlar['id'])) ){ ?> checked="checked" <?php  } ?> >
											</div>
										</div>	
									</div>
									<?php
									}
								}
								?>
							</div>
						</div>
						<div class="col-12 text-center mb-2 kpr">
							<button class="call-to-action2 kdd" type="submit" >
								<div>
									<div>Kaydet</div>
								</div>
							</button>
						</div>
					</div>
				</form>
				
				<script type="text/javascript">
				$(document).ready(function(){
					$(".kdd").click(function(){
						var html =  $('input[name=ProfilResim]').val();
						var ResimUzantisi = html.substr(-4);
						if (ResimUzantisi==".zip") {
							$('input[name=ProfilResim]').val('');
							$(".kdrs").html("<span class='bold yorumk ' style=' color:red'>JPG veya JPEG dosyası yükleyiniz</span>"); 
						}else{
							var resim = $('.kb')[0];
							var resimyukle= new FormData(resim);    
							$.ajax({
								type:"post", 
								url:"k_dznl.php",
								enctype: 'multipart/form-data',
								processData: false,
								contentType: false,
								cache:false,
								data: resimyukle,
								success:function(cevap){ 
									if (cevap=="image") {
										$('input[name=ProfilResim]').val('');
										$(".kdrs").html("<span class='bold yorumk ' style=' color:red'> Resim Yüklenemedi. Tekrar Deneyiniz </span>"); 
									}else if(cevap=="image1"){
										$('input[name=ProfilResim]').val('');
										$(".kdrs").html("<span class='bold yorumk ' style=' color:red'>Resim 2MB'dan yüksek olamaz.</span>"); 
									}else if(cevap=="image2"){
										$('input[name=ProfilResim]').val('');
										$(".kdrs").html("<span class='bold yorumk ' style=' color:red'>400 X 400 piksel resim yükleyiniz</span>"); 
									}else if(cevap=="image3"){
										$('input[name=ProfilResim]').val('');
										$(".kdrs").html("<span class='bold yorumk ' style=' color:red'>JPG veya JPEG dosyası yükleyiniz</span>"); 
									}else{
										$(".kds").html(cevap); 
									}
								}
							});  
						}
					});
				});   
				</script>
			</div>
		</div>
	</div>
	<?php
	}
}
?>