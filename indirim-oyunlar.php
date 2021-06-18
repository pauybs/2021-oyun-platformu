<?php
require_once("settings/connect.php");
?>

<div class="col-12" style="background: #202020; background: url('images/indirim2.png') no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover; background-size: cover;">
	<div class="container"  >
	    <?php
	    $IndirimKategori       = $DatabaseBaglanti->prepare(" SELECT * FROM indirimler  ");
		$IndirimKategori->execute();
		$IndirimKategoriSayisi = $IndirimKategori->rowCount();
		$IndirimKategoriKayit  = $IndirimKategori->fetchAll(PDO::FETCH_ASSOC);
		if ($IndirimKategoriSayisi>0){
			foreach ($IndirimKategoriKayit as $indirimler) {
				$IndirimOyun       = $DatabaseBaglanti->prepare(" SELECT * FROM indirimoyunlari Where IndirimId=? ");
				$IndirimOyun->execute([$indirimler["IndirimId"]]);
				$IndirimOyunSayisi = $IndirimOyun->rowCount();
				$IndirimOyunKayit  = $IndirimOyun->fetchAll(PDO::FETCH_ASSOC);
				if ($IndirimOyunSayisi >0 ) {
				    foreach ($IndirimOyunKayit as $indirimoyun) {
						if ($indirimoyun["Tarih"]<$Zaman) {
							$OyunlarSil       = $DatabaseBaglanti->prepare(" DELETE FROM indirimoyunlari WHERE id=?");
							$OyunlarSil->execute([$indirimoyun["id"]]);

						}
				    }
					
				}else{
					
				}
			}
		}

	    ?>
	
		<?php
		$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
		$BannerSorgu->execute([1,1]);
		$Data = $BannerSorgu->rowCount();
		$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
		if ($Data>0) {
		?>
			<div class="row justify-content-center align-items-center text-center d-none d-md-block mt-5" >
				<div class="col-12 ">
					<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([1] );	
					?>
				</div>
			</div>
			<div class="row justify-content-center align-items-center text-center d-block d-md-none" >
				<div class="col-12 mt-5">
						<ins class="adsbygoogle"
                         style="display:inline-block;width:100%;height:90px"
                         data-ad-client="ca-pub-6491655414364653"
                         data-ad-slot="1630401356"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
				</div>
			</div>
		<?php
		}
		?>
		
		<div class="row mb-5 mt-5" >
			<?php
		 	 $OzelFirsatlar = $DatabaseBaglanti->prepare("SELECT * FROM steamindirimler Where Tur=?  ORDER BY IndirimId ASC ");
			$OzelFirsatlar->execute([1]);
			$OzelFirsatlarVeri = $OzelFirsatlar->rowCount();
			$OzelFirsatlarKayitlar =  $OzelFirsatlar-> fetchAll(PDO::FETCH_ASSOC);
		  	if ($OzelFirsatlarVeri>0) {
		  	?>
			<div class="col-12 mb-5">
				<div class="row">
					<div class="col-12     " >
					    <div class="row p-2 stindSz" >
					        <h6 class="white m-0  bold white"><span> Steam Özel Fırsatlar</span></h6>
					    </div>
						
					</div>
					<div class="col-12 indstSZ" >
						<div class="row">
							<?php
						  	foreach ($OzelFirsatlarKayitlar as  $OzelFirsatlarVeriler) {
							?>
							<div class="col-12 col-md-6 mt-2" >
								<div class="row p-2 ">
									<div class="col-12 ">
										<div class="row ">
											<div class="  col-12 ind p-0 "  style="background: rgb(16,16,16,1);"  >
												<figure  class="skTlPeX m-0" > 
													<img <?php echo $OzelFirsatlarVeriler["OyunResim"]; ?> class="img-fluid" alt="roakgame">
													<div class="row ">
														<div class="col-12 mt-1 ">
														 	<figcaption class="font13" >
															 	<div class="col-10 skTlPeX p-0 ml-2" > 
															  	<?php 
																preg_match_all('@<span class="title">(.*?)</span>@si',$OzelFirsatlarVeriler["OyunAdi"],$OyunAdi);
																	echo($OyunAdi[0][0]); 
																?>	
																</div>	
														  	</figcaption>
														</div>
														<div class="col-12  ml-1" >
														 	<figcaption >
															  	
													  		<div class="p-0 ml-1">
																<span class="bold white opacity05 font13"><?php echo $OzelFirsatlarVeriler["Fiyat"]; ?></span>
																<span class="bold white  font13"><?php echo $OzelFirsatlarVeriler["IndirimliFiyat"]; ?></span> 
																
														  </figcaption>
														</div> 
													</div> 
												</figure>
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
			}
			?>	 
            

			<?php 
			$CokSatanlar = $DatabaseBaglanti->prepare("SELECT * FROM steamindirimler Where Tur=?  ORDER BY IndirimId ASC LIMIT 10");
			$CokSatanlar->execute([2]);
			$CokSatanlarVeri = $CokSatanlar->rowCount();
			$CokSatanlarKayitlar =  $CokSatanlar-> fetchAll(PDO::FETCH_ASSOC);
		  	if ($CokSatanlarVeri>0) {
			?>
			<div class="col-12  mb-2 mt-5">
				<div class="row justify-content-center align-items-center ckindXS">
					<div class="col-12     " >
					    <div class="row p-2 CsaWxAvd">
					        <h6 class="white m-0  bold white"><span> Steam Çok Satanlar<span></h6>
					    </div>
						
					</div>

					<div class="swiper-container swiper1">
		   				 <div class="swiper-wrapper">
		   				 <?php
		   				 foreach ($CokSatanlarKayitlar as  $CokSatanlarVeriler) {	
		   				 ?>
					 		<div class="swiper-slide ">
					 			<div class="col-6 col-md-12  mt-2" >
									<div class="row p-0" style="background: rgb(16,16,16,1);">
										<div class="col-12 p-0 text-center" 
										>
										<img <?php echo $CokSatanlarVeriler["OyunResim"]; ?> class="img-fluid" alt="roakgame" style="height: 70px;width: 100%">
										</div>
										<div class="col-12 p-0 text-center">
											<div class="row">
												<div class="col-12 skTlPeX bold white mt-1"> 
											  	<?php 
												preg_match_all('@<span class="title">(.*?)</span>@si',$CokSatanlarVeriler["OyunAdi"],$OyunAdi);
													echo($OyunAdi[0][0]); 
												?>	
												</div>	
												<div class="col-12 " >
											  	<span class="bold white opacity05 font13"><?php echo $OzelFirsatlarVeriler["Fiyat"]; ?></span>
											 
												</div>
												<div class="col-12 bold white mb-1">
													<div>
													<span class="bold white  font13"><?php echo $OzelFirsatlarVeriler["IndirimliFiyat"]; ?></span> 
													
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
						<div class="col-12 text-center  swiper-pagination1 mt-5 "></div>
						</div>
						
					</div>
				</div>
				 
			</div>
			<?php
			}
			?>
            
             	<?php
		$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
		$BannerSorgu->execute([1,1]);
		$Data = $BannerSorgu->rowCount();
		$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
		if ($Data>0) {
		?>
			<div class="row justify-content-center align-items-center text-center d-none d-md-block mt-5 mb-5" >
				<div class="col-8 text-center mb-5" style="justify-content:center;align-items:center">
				    
					<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([1] );	
					?>
				</div>
			</div>
			<div class="row justify-content-center align-items-center text-center d-block d-md-none" >
				<div class="col-12 mt-5 mb-5">
						<ins class="adsbygoogle"
                         style="display:inline-block;width:100%;height:90px"
                         data-ad-client="ca-pub-6491655414364653"
                         data-ad-slot="1630401356"></ins>
                    <script>
                         (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
				</div>
			</div>
		<?php
		}
		?>

			<?php
		 	$Indirimler = $DatabaseBaglanti->prepare("SELECT * FROM indirimler ORDER BY IndirimId DESC ");
			$Indirimler->execute();
			$IndirimlerVeri = $Indirimler->rowCount();
			$IndirimlerKayitlar =  $Indirimler-> fetchAll(PDO::FETCH_ASSOC);
		  	if ($IndirimlerVeri>0) {
		  		
		  	?>
				<?php
			  	foreach ($IndirimlerKayitlar as  $indirimkayit) {
			  		$IndirimliOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM indirimoyunlari Where  Tarih>$Zaman and IndirimId=?  ORDER BY id DESC ");
					$IndirimliOyunlar->execute([$indirimkayit["IndirimId"]]);
					$IndirimliOyunlarVeri = $IndirimliOyunlar->rowCount();
					$IndirimliOyunlarKayitlar =  $IndirimliOyunlar-> fetchAll(PDO::FETCH_ASSOC);
					if ($IndirimliOyunlarVeri>0) {	
				?>
				<div class="col-12 mb-5">
					<div class="row">
						<div class="col-12" >
						    <div class="row p-2 indrokaxZ">
						        <h6 class="white m-0  bold white"><span><?php echo IcerikTemizle($indirimkayit["IndirimAdi"]); ?><span></h6>
						    </div>
						</div>
						<div class="col-12  mt-2 DSKAwXs">
							<div class="row">
							<?php
							foreach ($IndirimliOyunlarKayitlar as $indirimoyun) {
								$OyunBilgiler=$DatabaseBaglanti->prepare("SELECT * FROM oyunlar Where Durum=? and id=? ");
								$OyunBilgiler->execute([1,$indirimoyun["OyunId"]]);
								$OyunBilgilerKayitlar =  $OyunBilgiler-> fetch(PDO::FETCH_ASSOC);
							?>
								<div class="col-12 col-md-6 col-lg-4 mt-2" >
									<div class="row p-2 "  >
										<div class="col-12"style="background: rgb(16,16,16,1);">
											<div class="row  align-items-center">
												<div class="col-3 p-0">
													<?php
						    						if ( file_exists("images/games/".$OyunBilgilerKayitlar["AnaResim"])  and ($OyunBilgilerKayitlar["AnaResim"])) {
						    						?>
						    							<img src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($OyunBilgilerKayitlar["AnaResim"]) ?>" alt="<?php echo IcerikTemizle($OyunBilgilerKayitlar["OyunAdi"]);?>" title="<?php echo IcerikTemizle($OyunBilgilerKayitlar["OyunAdi"]);?>" class="img-fluid  o lazy"  >
						    						<?php
						    						}else{
						    						?>
														<img src="images/resim.jpg" class="img-fluid">
															
													<?php
													}
													?>
												</div>
												<div class="col-9 ">
													<div class="row">
														<div class="col-12 skTlPeX bold white mt-1">
															<span class="bold white  font13"><?php echo $OyunBilgilerKayitlar["OyunAdi"]; ?></span>
														</div>
														<div class="col-12">
															<span class="bold white opacity05 font13"><strike><?php echo $indirimoyun["Fiyat"]; ?> TL</strike></span>
															<span class="bold white  font13"><?php echo $indirimoyun["IndirimliFiyat"]; ?> TL</span>
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
				 	</div>		    	
				</div>
				<?php  
					}	
			  	}
			  	?>
				
			<?php
			}
			?>		   
		</div>	
	</div>
</div>

<link rel="stylesheet" href="settings/swiper-bundle.css">
<link rel="stylesheet" href="settings/swiper-bundle.min.css">
<script src="settings/swiper-bundle.js"></script>
<script src="settings/swiper-bundle.min.js"></script>
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