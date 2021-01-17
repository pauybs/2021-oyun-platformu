
<?php
$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
$BannerUst->execute([4,1]);
$BannerUstVeri = $BannerUst->rowCount();
$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
if ($BannerUstVeri>0) {	
	?>
	<div class="col-12 col-xl-12 text-center   mt-5">
		<div class="row justify-content-center align-items-center"  >
			<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([4 ]);	
			?>		
		</div>	
	</div>
	<?php
}
?>

<div class="col-12">
	<div class="row justify-content-center m-0">
		<div class="col-12 col-xl-7 mt-5 mb-5 " >
			<div class="row justify-content-center m-0  mb-5 ">
				<div class="d-none d-xl-block col-12 mb-3">
					<div class="row justify-content-center align-items-center" style="height:70px">
						<div class="col-6">
							<div class="row ">
								<div class="col-3" >
									<a class="t_RwAMWz_" style="color: white;" href="haber">
										<span>Tüm Haberler</span>
									</a>
								</div>
								<div class="col-4">
									<a class="___zAa__uTyRee" style="color: white ; " href="okunanhaberler">
										<span> Çok Okunan Haberler</span>
									</a>
								</div>
								<div class="col-5" >
									<a class="t_RwAMWz_" style="color: white" href="konusulanhaberler">
										<span>Çok Konuşulan Haberler</span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-6 p-2 text-right "></div>
					</div>
				</div>

				<div class="d-block d-xl-none col-12 mb-5">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center iaQeezXzC___" >
							<label class="mt-3 mb-0" for="menu-toggle">
								<p class="bold" style="cursor: pointer;color: white">
									<span class="font13">Çok Okunan Haberler</span> 
									<i class="fas fa-chevron-down"></i>
								</p> 
							</label>
						</div>
						<input type="checkbox" id="menu-toggle" />
						<ul id="menu" class="wWfVCA">
							<li>
								<div class="col-12 mt-3 mb-3 text-center" >
									<a class="t_RwAMWz_" style="color: white ;" href="haber">
										<span class="font12">Tüm Haberler</span>
									</a>
							</div></li>
							<li>
								<div class="col-12 mt-3 mb-3 text-center" >
									<a class="t_RwAMWz_" style="color: white;" href="konusulanhaberler">
										<span class="font12">Çok Konuşulan Haberler</span>
									</a>
								</div>
							</li>
						</ul>	
					</div>
				</div>


				<div class="col-12" >
					<div class="row ">
					<?php
					$OkunulanHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? ORDER BY Goruntulenme DESC  LIMIT 10" );
					$OkunulanHaberler->execute([1]);
					$VeriSayisi = $OkunulanHaberler->rowCount();
					$HaberKayitlar = $OkunulanHaberler->fetchAll(PDO::FETCH_ASSOC);
					if ($VeriSayisi>0) {
					foreach ($HaberKayitlar as  $kayitlar) {
					?>
						<div class="col-12 col-xl-6  " >
							<div class="row p-2">
								<div class="col-12">
									<div class="row align-items-end  "  >
										<div class="col-12  p-0">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
												<?php
												if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"]))  and ($kayitlar["AnaResim"]!="") ) {
												?>
													<img src="images/news/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" class="img-fluid haberResim wWfVCA h"  >
												<?php
												}else{
												?>
													<img src="images/hata.jpg" class="img-fluid haberResim gAqz__AZxXzQ" >
												<?php
												}
												?>
											</a>
										</div>
												
										<div class="col-12 position-absolute lkAQIYMvX p-0">
											<div class="row p-2 ">
												<div class="col-12 mt-5">
													<a  style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
														<h2 class="haberlerBaslik bold  SSZx__aWqaz h" >
															<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>
														</h2>
													</a>
													<a style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
														<i class="fas fa-comment-alt font14 h"></i>
														<span class=" h font14">
															<?php echo  IcerikTemizle($kayitlar["YorumSayisi"]);?>
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
					}else{
					?>
						<div class="col-12">
							<div class="row justify-content-center align-items-center mb-5">
								<div class="col-12  text-center  mb-2" >
									<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
								</div>

								<div class="col-12 position-absolute text-center  mb-2" >
									<div class="row justify-content-center">
										<div class="col-12 col-xl-8">
											<h5 class="white">Hiçbir haber bulamadık. Bu konu veya oyun hakkında bir şeyler yazmamızı istiyorsan bizimle iletişime geç ve bir daha arandığında bu hata ortaya çıkmasın.</h5>
										</div>

										<div class="col-12 mt-2">
											<a href="index.php">
												<button class="call-to-action2 p-0" style="height: 50px " >
													<div>
														<div>Anasayfa</div>
													</div>
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
					</div>			 
				</div>			
			</div>
		</div>

		<?php
		$BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
		$BannerYan->execute([5,1]);
		$BannerYanVeri = $BannerYan->rowCount();
		$BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
		if ($BannerYanVeri>0) {
		?>
			<div class="d-none d-xl-block col-2  mb-5">
				<div class="row justify-content-center align-items-center mt-5"  >		
					<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme2->execute([5 ]);	
					?>		
				</div>	
			</div>
		<?php
		}
		?>
	</div>
</div>
<script type="text/javascript">
	$(".h").css("display", "none");
	$(".h").fadeIn("slow");
</script>