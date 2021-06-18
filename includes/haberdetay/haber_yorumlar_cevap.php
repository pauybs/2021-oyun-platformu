<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$YorumlarCevap = $DatabaseBaglanti->prepare("SELECT * FROM haberyorumcevap WHERE HaberId=? AND YorumId=? AND  (Durum=? OR Durum=?)   ORDER BY YorumTarihi ASC  ");
	$YorumlarCevap->execute([Guvenlik($HaberSorgusuKayit["id"]),Guvenlik($YorumKayit["id"]),1,4]);
	$YorumCevapSayisi = $YorumlarCevap->rowCount();
	$YorumCevap = $YorumlarCevap->fetchAll(PDO::FETCH_ASSOC);
	if($YorumCevapSayisi>0){
		foreach ($YorumCevap as $YorumCevapKayit) {
		$YorumCevapId=$YorumCevapKayit["id"];
		$CevapYorumUyeAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?  LIMIT 1 ");
		$CevapYorumUyeAdi->execute([Guvenlik($YorumCevapKayit["UyeId"])]);
		$CevapYorumUye = $CevapYorumUyeAdi->fetch(PDO::FETCH_ASSOC);
	?>
	<div class="row  hdyc justify-content-center align-items-center pb-3 mt-1 " id="cs<?php echo IcerikTemizle($YorumCevapId) ?>"   >
		<div class=" offset-1 col-11   asdRzwcZ" >
			<div class="row p-2 justify-content-start align-items-center">
				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
				?>
				<div class="col-12 up p-1">
					<figure>
				  	<?php
					if(file_exists("images/userphoto/".IcerikTemizle($CevapYorumUye["ProfilResmi"])) and (IcerikTemizle(isset($CevapYorumUye["ProfilResmi"]))) and (IcerikTemizle($CevapYorumUye["ProfilResmi"])!="") ){
					?>
						<img src="images/userphoto/<?php echo IcerikTemizle($CevapYorumUye["ProfilResmi"]) ?> " class="img-fluid userp" title="<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>">
					<?php
					}else{
					?>
						<img src="images/user.png" class="img-fluid userp " title="<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>">
					<?php
					}
					?>
						<div class="row">
							<div class="col-12 ">
								<figcaption>
					  				<span class="yorumk bold white"><?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?></span> 
									<span class=" yorumk white opacity05"> <?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?></span>
								</figcaption>
							</div>
							<div class="col-12 ">	 	
								<figcaption >
									<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)</span>
								</figcaption>
							</div>
						</div>															
					</figure>
				</div>	
					<?php
					if ($YorumCevapKayit["Durum"]==4) {
					?>
					<div class="col-12 mt-2 " >
						<span class="ASewrQz yorumk"><i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="color: white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
					</div>
					<?php
					}else{
					?>	
						<div class="col-12 mt-1  " >
							<span class="sadxzaA yorumk "><?php echo IcerikTemizle($YorumCevapKayit["Yorum"]);?></span>
						</div>
						<div class="col-12 text-right mt-1 "   id="ycs<?php echo IcerikTemizle($YorumCevapId); ?>">
						<?php
						if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
							if ($KullaniciId != $YorumCevapKayit["UyeId"] ) {
						?>
							<span class="bold white yorumk  ycs" data="<?php echo IcerikTemizle($YorumCevapId); ?>" data-toggle="modal" data-target="#ycse<?php echo IcerikTemizle($YorumCevapId); ?>"  style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-flag white"></i> Yorumu Şikayet Et</span>

							<div  class="modal fade mt-5" id="ycse<?php echo IcerikTemizle($YorumCevapId);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
												<div class="col-12 text-left p-0 white bold font13"  >Şikayetiniz <span class="red font11 bold">(Zorunlu)</span></div>      
												<textarea type="text" class="hbdxzzb_"  name="HcSikayet" maxlength="250" ></textarea>
												<input type="hidden" name="hcys" value="<?php echo IcerikTemizle($YorumCevapId); ?>">
												<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>">
												<span class="highlight"></span>
												<span class="bar"></span> 
												<div class="bold red font13 ">Maksimum 250 karakter</div>
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
						if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
							if ($KullaniciId == $YorumCevapKayit["UyeId"] ) {
							?>
								<span class="bold  white yorumk hycsb" data-type="<?php echo  IcerikTemizle($HaberId); ?>" id="<?php echo  IcerikTemizle($HaberSorgusuKayit["id"]); ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>"  data="<?php echo IcerikTemizle($YorumCevapId); ?>" style="cursor:pointer;"><i style="color:#c28f2c"  class="fas fa-trash-alt white"></i> Yorumu Sil</span>
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
						if(file_exists("images/userphoto/".IcerikTemizle($CevapYorumUye["ProfilResmi"])) and (IcerikTemizle(isset($CevapYorumUye["ProfilResmi"]))) and (IcerikTemizle($CevapYorumUye["ProfilResmi"])!="") ){
						?>
							<img src="images/userphoto/<?php echo IcerikTemizle($CevapYorumUye["ProfilResmi"]) ?> " class="img-fluid userp" title="<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>">
						<?php
						}else{
						?>
							<img src="images/user.png" class="img-fluid userp " title="<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>">
						<?php
						}
						?>
							<div class="row">
								<div class="col-12 ">
									<figcaption>
						  				<span class="yorumk bold white"><?php echo IcerikTemizle($CevapYorumUye["AdSoyad"]);?></span> 
										<span class=" yorumk white opacity05"> <?php echo time_ago(IcerikTemizle($YorumCevapKayit["YorumTarihi"]));?></span>
									</figcaption>
								</div>
								<div class="col-12 ">	 	
									<figcaption >
										<span class="white yorumk opacity05  ">(@<?php echo IcerikTemizle($CevapYorumUye["KullaniciAdi"]);?>)</span>
									</figcaption>
								</div>
							</div>															
						</figure>
					</div>
					<?php
					if ($YorumCevapKayit["Durum"]==4) {
					?>
					<div class="col-12 mt-2 " >
						<span class="ASewrQz"><i  class="fas fa-exclamation-triangle fa-2x pUyzAR"></i> Bu yorum <a class="bold white" style="color: white" href="topluluk-kurallari" target="_blank">Topluluk Kuralları</a>  ihlali nedeniyle kısıtlanmıştır.</span>
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
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





