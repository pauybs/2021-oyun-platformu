<?php
require_once("settings/connect.php");
if(isset($_GET["Kurator"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){    
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
			if ( IcerikTemizle($KuratorBilgilerKayitlar["ArkaplanRengi"])!="") {
				$ArkaplanResmi=$DatabaseBaglanti->prepare("SELECT * FROM wallpapers WHERE id=? LIMIT 1");
				$ArkaplanResmi->execute([Guvenlik($KuratorBilgilerKayitlar["ArkaplanRengi"])]);
				$ArkaplanResmiVeri=$ArkaplanResmi->rowCount();
				$ArkaplanResmiKayitlar =$ArkaplanResmi->fetch(PDO::FETCH_ASSOC);
				if ($ArkaplanResmiVeri>0) {
					$Arkaplan=	 IcerikTemizle($ArkaplanResmiKayitlar["Resim"]);
				}else{
						
				}	
			}else{
			
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
											<?php
											include 'includes/kurator-detay/takipciler.php';
											?>
										</div>
										<div class="col-12 col-xl-4 mt-3">
											<?php
											include 'includes/kurator-detay/ayarlar.php';
											?>
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
								include 'includes/kurator-detay/incelemeler.php';
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
												<div class="col-12 mt-3 MCVXAxsA">
													<div class="row justify-content-center align-items-center text-center p-3">
														<?php
														include 'includes/kurator-detay/sosyal_medya.php';
														?>
													</div>
												</div>
												
												<div class="col-12 mt-3 MCVXAxsA">
													<div class="row justify-content-center p-3">
														<div class="col-12">
															<div class="row">
																<div class="col-12">
																	<h6 class="bold white">Donanım</h6>
																</div>
																<div>
																	<?php
																	include 'includes/kurator-detay/donanim.php';
																	?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-12 col-xl-3">
											<?php
											include 'includes/kurator-detay/istatistikler.php';
											?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-content">
							<div class="row align-items-center p-3">
							<?php
							include 'includes/kurator-detay/favori_oyunlar.php';
							?>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
	<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() { 
	var lazyloadImages = document.querySelectorAll("img.lazy"); 
	var lazyloadThrottleTimeout;
	function lazyload () {
		if(lazyloadThrottleTimeout){ 
			clearTimeout(lazyloadThrottleTimeout); 
		}    
    
		lazyloadThrottleTimeout = setTimeout(function() { 
			var scrollTop = window.pageYOffset; 
			lazyloadImages.forEach(function(img) { 
				if(img.offsetTop < (window.innerHeight + scrollTop)) {
					img.src = img.dataset.src; 
					img.classList.remove('lazy'); 
				}
			});
			if(lazyloadImages.length == 0) {  
				document.removeEventListener("scroll", lazyload); 
				window.removeEventListener("resize", lazyload); 
				window.removeEventListener("orientationChange", lazyload); 
				
			}
		}, 20);
	}
  
	document.addEventListener("scroll", lazyload); 
	window.addEventListener("resize", lazyload); 
	window.addEventListener("orientationChange", lazyload);
});
</script>

<?php
if(isset($_SESSION["Kullanici"])){
?>
	<?php
	if (isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ) {
	?>
		<?php
		if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
		?>

		<?php
		}else{
		?>
		<script src="assets/main.js"></script>
		<script src="assets/main_kdt=18.8.14.js"></script>
		<div class="modal fade mt-5" id="sikayet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
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
								<div class="col-12 text-left p-0 white bold font13"  >Şikayetiniz <span class="red font11 bold">(Zorunlu)</span></div>         
								<textarea type="text" id="textt" class="mnutv" name="Sikayet" maxlength="250"></textarea>
								<input type="hidden" name="k" value="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
								<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">

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
	}
	?>
<?php	
}
?>

<?php 
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
	if ($KullaniciKuratorDurumu==1 and ($KullaniciId==$KuratorBilgilerKayitlar["id"]) ) {
	?>
	<?php
	include 'includes/kurator-detay/ozellestir_form.php';
	?>
	<link href="settings/lightbox.css" rel="stylesheet" />
    <script src="settings/lightbox.js"></script>
	<script src="assets/main_kd=15.4.07.js"></script>
	<?php
	}
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


