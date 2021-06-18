<?php
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
	$SistemKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar WHERE UyeId=? LIMIT 1");
	$SistemKontrol->execute([Guvenlik($KullaniciId)]);
	$SistemKontrolVeri = $SistemKontrol->rowCount();
	$SistemKontrolKayitlar = $SistemKontrol->fetch(PDO::FETCH_ASSOC);
	if ($SistemKontrolVeri>0) {
		if ($SistemKontrolKayitlar["IsletimSistemiId"]!="" and $SistemKontrolKayitlar["IslemciId"]!="" and $SistemKontrolKayitlar["EkranKartiId"]!=""  and $SistemKontrolKayitlar["RamId"]!=""  and $SistemKontrolKayitlar["DirectxId"]!="") {

			if (isset($_REQUEST["srl"])) {
				$Sıralama=Guvenlik($_REQUEST["srl"]);
			}else{
				$Sıralama="";
			}
			?>

			<?php
			$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? AND Durum=? ORDER BY GosterimSayisi LIMIT 1");
			$Banner->execute([8,1]);
			$Veri = $Banner->rowCount();
			$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
			if ($Veri>0) {
			?>
			<div class="col-12  text-center mb-5 mt-5 ">
				<div class="row justify-content-center align-items-center" >
					<div class="col-12 ">
					<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([8 ]);	
					?>			
					</div>
				</div>
			</div>
			<?php
			}
			?>
			<div class="col-12 p-0 " style="margin-bottom: 100px">
				<div class="row  justify-content-center  m-0  mb-5 ">
					<div class="col-11 col-xl-2 mb-3 ">
						<div class="row justify-content-center align-items-center">
							<div class="col-12 text-center p-0" >
								<div class="iropdown admsrl" >
									<button class="ibutton" style="padding:12px">
										<i class="fas fa-sort-amount-down"></i>
										<?php 
										if ($Sıralama==1){
										?>
											<span>Aksiyon</span>
										<?php
										}else if($Sıralama==2){
										?>
											<span>Basit Eğlence</span>
										<?php
										}else if($Sıralama==3){
										?>
											<span>Spor</span>
										<?php
										}else if($Sıralama==4){
										?>
											<span>Simulasyon</span>
										<?php
										}else if($Sıralama==5){
										?>
											<span>Strateji</span>
										<?php
										}else if($Sıralama==6){
										?>
											<span>Çok Oyunculu</span>
										<?php
										}else if($Sıralama==7){
										?>
											<span>Macera</span>
										<?php
										}else if($Sıralama==8){
										?>
											<span>Yarış</span>
										<?php
										}else if($Sıralama==9){
										?>
											<span>Rol Yapma</span>
										<?php
										}else if($Sıralama==10){
										?>
											<span>Ücretsiz</span>
										<?php
										}else if($Sıralama==11){
										?>
											<span>Hayatta Kalma</span>
										<?php
										}else{
										?>
											<span>Tüm Oyunlar</span>
										<?php
										}
										?>
									</button>
									<div class="icontent" style="z-index: 3">
										<a class="iylink bold white text-center p-2" href="sistemineozel">
											<button class=" btn  white bold inczsdsa_ " style="color: white">Tüm Oyunlar</button>
										</a>
										<a class="iylink">
											<form action="sistemineozel " method="post" >
												<div class="col-12 ">
													<div class=" row justify-content-center ">
														<div class="col-4 text-center p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="1">
														</div>	
													</div>
													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"   value="Aksiyon" type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="2">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Basit Eğlence"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="3">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Spor"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="4">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Simulasyon"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="5">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Strateji"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="6">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Çok Oyunculu"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="7">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Macera"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="8">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Yarış"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="9">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Rol Yapma"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="10">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Ücretsiz"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
										<a class="iylink">
											<form action="sistemineozel" method="post">
												<div class="col-12 ">
													<div class=" row justify-content-center">
														<div class="col-4 p-1 text-center"> 
															<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="11">
														</div>	
													</div>

													<div class="col-12 text-center form-group">
														<input class="inczsdsa_"  value="Hayatta Kalma"  type="submit" class="btn-block btn btn btn-warning ">
													</div>
												</div>	
											</form>
										</a>
									</div>
								</div>
							</div>
							<div class="col-12 mt-2 p-0">
								<div class="iropdown admsrl" >
									<button data-toggle="modal" data-target="#oyunoner" type="button" class="ibutton  sbzXz bold roo" data="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data-id="<?php echo $Sıralama ?>" style="padding:12px">
										Rastgele Oyun Öner
									</button>
								</div>
							</div>

						</div>
					</div>
   
    				<div class="col-12 col-xl-9 " >
						<?php
							include 'includes/sistemine-ozel/uygun_oyunlar.php'
						?>	
					</div>
				</div>			
			</div>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
				<script src="assets/main_oyno=22.03.7.js"></script>


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
			
				$(function(){
				$(".ram").tooltip({
						title: "<span>Oyunun <span class='bold'>Bellek </span> Bilgisi Bulunmamaktadır.</span>",
						html:true,
						placement:"bottom",
					});
				$(".direcxt").tooltip({
						title: "<span>Oyunun <span class='bold'>Directx</span>  Bilgisi Bulunmamaktadır.</span>",
						html:true,
						placement:"bottom",
					});
				$(".drtxram").tooltip({
						title: "<span>Oyunun <span class='bold'>Directx</span>  ve <span class='bold'>Bellek</span> Bilgisi Bulunmamaktadır.</span>",
						html:true,
						placement:"bottom",
					});
				})
			</script>

		<div class="modal fade mt-5"  id="oyunoner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
			<div class="modal-dialog" role="document">
				<div class="modal-content" style="background: #202020">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" class="white">&times;</span>
						</button>
					</div>
					<div class="modal-body ooi">
						
					</div>
				</div>
			</div>
		</div>

<?php
	}else{
	?>
	<div class="container-fluid mt-5 mb-5" >
		<div class="col-12 text-center mt-5">
			<img src="images/<?php echo IcerikTemizle($SiteLogo) ?>" class="img-fluid " >
		</div>
		<div class="col-12 mb-5">
			<div class="row">
				<div class="col-12 text-center">
					<h5 class="bold white">
						Bilgisayar sistemine uygun oyun bulabilmek için bilgisayarınıza ait sistem bilgilerini <span style="color: #c28f2c">eksiksiz</span> bir şekilde girmeniz gerekmektedir.
					</h5>
				</div>
				<div class="col-12 text-center mt-3 mb-5">
				<a href="bilgisayarim"><button class="call-to-action2" id="sign-in-btn">
						<div>
							<div>Bilgisayarım</div>
						</div>
					</button></a>
				</div>
			</div>
		</div>
	</div>

	<?php
	}
	}else{
	?>
	<div class="container-fluid mt-5 mb-5" >
		<div class="col-12 text-center mt-5">
			<img src="images/<?php echo IcerikTemizle($SiteLogo) ?>" class="img-fluid "  >
		</div>
		<div class="col-12 mb-5">
			<div class="row">
				<div class="col-12 text-center">
					<h5 class="bold white">
						Bilgisayar sistemine uygun oyun bulabilmek için bilgisayarınıza ait <span style="color: #c28f2c">sistemine bilgilerini</span> girmeniz gerekmektedir.
					</h5>
				</div>
				<div class="col-12 text-center mt-3 mb-5">
				<a href="bilgisayarim"><button class="call-to-action2" id="sign-in-btn">
						<div>
							<div>Bilgisayarım</div>
						</div>
					</button></a>
				</div>
			</div>
		</div>
	</div>

	<?php
	}
}else{
?>
	<div class="container-fluid mt-5 mb-5" >
		<div class="col-12 text-center mt-5">
			<img src="images/<?php echo IcerikTemizle($SiteLogo) ?>" class="img-fluid "style="width: 200px;height: 200px"  >
		</div>
		<div class="col-12 mb-5">
			<div class="row">
				<div class="col-12 text-center">
					<h5 class="bold white">
						Bilgisayar sistemine uygun oyun bulabilmek için <span style="color: #c28f2c">üye olup</span> hesabınıza <span style="color: #c28f2c">giriş</span> yapmanız gerekmektedir.
					</h5>
				</div>
				<div class="col-12 text-center mt-3 mb-5">
				<a href="girisyap"><button class="call-to-action2" id="sign-in-btn">
						<div>
							<div>Giriş Yap</div>
						</div>
					</button></a>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>

