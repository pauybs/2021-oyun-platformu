<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="modal fade bd-example-modal-xl mt-5 mb-5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
					
						<div class="col-11 mb-1 mt-5  p-0"><h6 class="bold white">Biyografi</h6></div>
						<div class="col-11 zxbnzxX_z" >
							<div class="row align-items-center p-3">
								<div class="col-12 mt-3 mb-1">
									<textarea name="Biyo" placeholder="Açıklama Yazınız"  class="xczykur"   ><?php echo IcerikTemizle($KuratorBilgilerKayitlar["Hakkinda"]);?></textarea>
								</div>
							</div>
						</div>

						<div class="col-11  mb-1 mt-5  p-0"><h6 class="bold white">Sosyal Medya Bağlantıları</h6></div>
						<div class="col-11 ytxxzZZC">
							<div class="row justify-content-center align-items-center p-2 mb-2 mt-3">
								
								<div class="col-2 p-0 text-center col-xl-1">
									<i  class="fab fa-instagram white font25"></i>
								</div>
								<div class="col-9 col-xl-11 text-left">
									<input placeholder="Instagram Url" type="text" class="p-2 kurzzqw" name="Instagram" value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Instagram"])?>">
									<span class=" insta"></span>
								</div>

							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i  class="fab fa-youtube white font25 "></i>
								</div>
								<div class="col-9 col-xl-11 text-left">
									<input type="text"  placeholder="Youtube Url" class="p-2 kurzzqw" name="Youtube"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Youtube"])?>">
									<span class=" youtube"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i  class="fab fa-twitch white font25"></i>
								</div>
								<div class="col-9 col-xl-11 text-left">
									<input type="text"   placeholder="Twitch Url" class="p-2 kurzzqw"  name="Twitch"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitch"])?>">
									<span class=" twitch"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i  class="fab fa-twitter white font25"></i>
								</div>
								<div class=" col-9 col-xl-11 text-left">
									<input type="text" class="p-2 kurzzqw"  placeholder="Twitter Url"  name="Twitter"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitter"])?>">
									<span class=" twitter"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/facebookgaming.png" class="img-fluid cvczzWSYRW" >
								</div>
								<div class=" col-9 col-xl-11 text-left">
									<input type="text" class="p-2 kurzzqw"  placeholder="Facebook Gaming Url"  name="FacebookG"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Facebook"])?>">
									<span class=" facebook"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i   class="fab fa-discord white font25"></i>
								</div>
								<div class=" col-9 col-xl-11 text-left">
									<input type="text" class="p-2 kurzzqw"  placeholder="Discord Url"  name="Discord"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Discord"]) ?>">
									<span class=" discord"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/dlive.png" class="img-fluid disxcz"  >
								</div>
								<div class=" col-9 col-xl-11 text-left">
									<input type="text" class="p-2 kurzzqw"  placeholder="Dlive Url"  name="Dlive"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Dlive"])?>">
									<span class=" dlive"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-2">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<img src="images/nonolive.png" class="img-fluid xczxZx"  >
								</div>
								<div class=" col-9 col-xl-11 text-left">
									<input type="text" class="p-2 kurzzqw"  placeholder="Nonolive Url" name="Nonolive"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"])?>">
									<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
									<span class=" nonolive"></span>
								</div>
							</div>
							<div class="row justify-content-center align-items-center p-2 mb-3 ">
								<div class="col-2  p-0 text-center col-xl-1 ">
									<i  class="fas fa-globe white font23" ></i>
								</div>
								<div class=" col-9 col-xl-11 text-left"><input type="text" class="p-2 kurzzqw"  placeholder="Web Sitesi Url"  name="WebSite"  value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["WebSite"])?>"></div>
							</div>
						</div>

						<div class="col-11 mb-1 mt-5  p-0"><h6 class="bold white">Arkaplan Resmi</h6></div>
						<div class="col-11 mb-5" >
							<div class="row justify-content-center mt-4 p-3 cxvnxcz kazavdX" >
								<div class="col-12 col-md-4  mt-3" >
									<div class="row">
										<div class="col-12"><img src="images/hata2.jpg" class="img-fluid azceXz" ></div>
										<div class="col-12 text-center"><input type="radio"  name="Wall" value="0" ></div>
									</div>
								</div>
								<?php
								$Arkaplan = $DatabaseBaglanti->prepare("SELECT * FROM wallpapers order by id DESC ");
								$Arkaplan->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),1]);
								$ArkaplanData = $Arkaplan->rowCount();
								$ArkaplanKayitlar = $Arkaplan->fetchAll(PDO::FETCH_ASSOC);
								if ($ArkaplanData>0) {
									foreach ($ArkaplanKayitlar as  $ArkaKayitlar) {
								?>
									<div class="col-12 col-md-4 mt-3">
										<div class="row">
											<div class="col-12">
												<a href="images/wallpapers/<?php echo IcerikTemizle($ArkaKayitlar["Resim"]) ?>" style="overflow: hidden;"  data-lightbox="image-1" >
													<img src="images/wallpapers/<?php echo IcerikTemizle($ArkaKayitlar["Resim"]) ?>" class="img-fluid azceXz" >
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
						<div class="col-12 text-center mb-5 kpr">
							<button class="call-to-action2 kdd" type="submit" >
								<div>
									<div>Kaydet</div>
								</div>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





