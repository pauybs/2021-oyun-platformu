<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$Yorumlar = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumlar WHERE HaberId=? AND (Durum=? OR Durum=?)   ORDER BY YorumTarihi DESC LIMIT 5 ");
	$Yorumlar->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),1,4]);
	$YorumSayisi = $Yorumlar->rowCount();
	$Yorum = $Yorumlar->fetchAll(PDO::FETCH_ASSOC);
	if($YorumSayisi>0){
		foreach ($Yorum as $YorumKayit){
		$YorumId=$YorumKayit["id"];
		$YorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
		$YorumUyeAdi->execute([Guvenlik($YorumKayit["UyeId"])]);
		$YorumUye = $YorumUyeAdi->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="row p-2 hdy" id="y<?php echo IcerikTemizle($YorumId) ?>"   >
			<div class=" col-12">
				<div  class="row" >
					<div class="col-12 mb-1 sncvdsa"  >
						<div class="row p-0 justify-content-start align-items-center ">
							<div class="col-12 ">
								<div class="row p-2 justify-content-start align-items-center">
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
								?>
									<div class="col-12 up  p-1">
										<figure>
									  	<?php
										if(file_exists("images/userphoto/".IcerikTemizle($YorumUye["ProfilResmi"])) and (IcerikTemizle(isset($YorumUye["ProfilResmi"]))) and (IcerikTemizle($YorumUye["ProfilResmi"])!="") ){
										?>
											<img src="images/userphoto/<?php echo IcerikTemizle($YorumUye["ProfilResmi"]) ?> " class="img-fluid userp" title="<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>"title="<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>">
										<?php
										}else{
										?>
											<img src="images/user.png" class="img-fluid userp " title="<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>">
										<?php
										}
										?>
											<div class="row">
												<div class="col-12 ">
													<figcaption>
										  				<span class="yorumk bold white"><?php echo IcerikTemizle($YorumUye["AdSoyad"]);?></span> 
														<span class=" yorumk white opacity05"> <?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?></span>
													</figcaption>
												</div>
												<div class="col-12 ">	 	
													<figcaption >
														<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)</span>
													</figcaption>
												</div>
											</div>															
										</figure>
									</div>	
									<?php
									if ($YorumKayit["Durum"]==4) {
									?>
									<div class="col-12 mt-1">
										<span class="ASewrQz yorumk">
											<i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> 
											<span>Bu yorum</span> 
											<a class="bold white" style="color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>
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
										if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
											if ($KullaniciId != $YorumKayit["UyeId"] ) {
										?>
											<span class="bold white yorumk  ys" data="<?php echo IcerikTemizle($YorumId); ?>" data-toggle="modal" data-target="#ys<?php echo IcerikTemizle($YorumId); ?>"  style="cursor:pointer;">
												<i style="color:#c28f2c" class="fas fa-flag white"></i>
												<span> Yorumu Şikayet Et</span>
											</span>

											<div  class="modal fade mt-5" id="ys<?php echo IcerikTemizle($YorumId); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
															<form class="hesabim" id="yg<?php echo IcerikTemizle($YorumId); ?>" method="post" action="javascript:void(0);" >
																<div class="col-12 mt-2">
																	<div class="col-12 text-left p-0 white bold font13"  >Şikayetiniz <span class="red font11 bold">(Zorunlu)</span></div>         
																	<textarea type="text"class="hbdxzzb_" name="HSikayet"  maxlength="250"></textarea>
																	<input type="hidden" name="hys" value="<?php echo IcerikTemizle($YorumId); ?>">
																	<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>">
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
										if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
											if($KullaniciId==$YorumKayit["UyeId"]){
										?>
											<span class="bold  white yorumk hysb" data-type="<?php echo  IcerikTemizle($HaberId); ?>" id="<?php echo  IcerikTemizle($HaberSorgusuKayit["id"]); ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($YorumId); ?>" style="cursor:pointer;">
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
									<div class="col-12 up p-1">
										<figure>
									  	<?php
										if(file_exists("images/userphoto/".IcerikTemizle($YorumUye["ProfilResmi"])) and (IcerikTemizle(isset($YorumUye["ProfilResmi"]))) and (IcerikTemizle($YorumUye["ProfilResmi"])!="") ){
										?>
											<img src="images/userphoto/<?php echo IcerikTemizle($YorumUye["ProfilResmi"]) ?> " class="img-fluid userp" title="<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>">
										<?php
										}else{
										?>
											<img src="images/user.png" class="img-fluid userp " title="<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>">
										<?php
										}
										?>
											<div class="row">
												<div class="col-12 ">
													<figcaption>
										  				<span class="yorumk bold white"><?php echo IcerikTemizle($YorumUye["AdSoyad"]);?></span> 
														<span class=" yorumk white opacity05"> <?php echo time_ago(IcerikTemizle($YorumKayit["YorumTarihi"]));?></span>
													</figcaption>
												</div>
												<div class="col-12 ">	 	
													<figcaption >
														<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($YorumUye["KullaniciAdi"]);?>)</span>
													</figcaption>
												</div>
											</div>															
										</figure>
									</div>	

									<?php
									if ($YorumKayit["Durum"]==4) {
									?>
										<div class="col-12 mt-1">
											<span class="ASewrQz yorumk">
												<i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> 
												Bu yorum <a class="bold white" style="color:white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a> 
												 ihlali nedeniyle kısıtlanmıştır.
											</span>
										</div>
									<?php
									}else{
									?>
										<div class="col-12 mt-1">
											<span class="rzrkWzXv yorumk"><?php echo IcerikTemizle($YorumKayit["Yorum"]);?></span>
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
							<div class="col-4 col-md-2 " style="cursor: pointer;" id="<?php echo IcerikTemizle($YorumKayit["id"]);?>" onClick="$.Cevap(<?php echo IcerikTemizle($YorumKayit["id"]);?> )">
								<span class="bold white yorumk" >
									Yanıtla
								</span>
							</div>

							<div class="col-12 mt-2" id="cg<?php echo IcerikTemizle($YorumKayit["id"]); ?>" style="display:none;" >					
							<?php
							if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
							?>
								<div class="row justify-content-center">
									<div class="col-12 mt-4  haberYorum">
										<form  id="hyc<?php echo IcerikTemizle($YorumId) ?>"  action="javascript:void(0);" method="post"   >
											<div class="">
												<textarea name="YorumCevap"  placeholder="Yorumunuzu yazın..."  ></textarea> 
												<input type="hidden" name="hc" value="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>">
												<input type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId); ?>">
												<input type="hidden" name="yc" value="<?php echo IcerikTemizle($YorumId); ?>">
												<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">

												<span class="highlight"></span>
												<span class="bar"></span>
											</div>

											<div class="col-12 p-0  mt-3 text-right " id="cb<?php echo IcerikTemizle($YorumKayit["id"]);?>">
												<button class="call-to-action2 hycg" type="submit" id="<?php echo IcerikTemizle($HaberId) ?>"  data-id="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>" data="<?php echo IcerikTemizle($YorumKayit["id"]);?>"  >
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
										<span>Yorum yapmak için</span> <a href="girisyap"  style="color: #c28f2c"><span >giriş yap</span></a>.
									</div> 
									<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
									<span class="highlight"></span>
									<span class="bar"></span>
								</div>

								<div class="col-12  mt-3  p-0  text-right " >
									<a href="girisyap"><button class="call-to-action2" disabled>
										<div>
											<div >Giriş YAP</div>
										</div>
									</button></a>
								</div>		
							</div>
							<?php
							}
							?>		
							</div>
							
							<div class="col-12 mt-1 yscrool"  id="yscrool-1">
								<?php
								include 'includes/haberdetay/haber_yorumlar_cevap.php';
								?>
								<div class="row">
									<div class="col-12 mt-1  "  id="cy<?php echo IcerikTemizle($YorumId); ?>"></div>
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
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





