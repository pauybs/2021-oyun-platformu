<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>

<div class="col-12 mt-5">			
	<div class="row justify-content-center m-0">
		<div class="col-12 col-md-9">
		<?php
		$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
		$BannerSorgu->execute([1,1]);
		$Data = $BannerSorgu->rowCount();
		$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
		if ($Data>0) {
		?>
			<div class="row justify-content-center align-items-center text-center d-none d-md-block" >
				<div class="col-12">
					<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([1] );	
					?>
				</div>
			</div>
			<div class="row justify-content-center align-items-center text-center d-block d-md-none" >
				<div class="col-12">
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

		<div class="row justify-content-center mt-3">
		<?php
		    include 'includes/home/ust_haberler.php';
		?>
	    </div>

    	<div class="row justify-content-center">
		<?php
			include 'includes/home/alt_haberler.php';
		?>
		</div>
        
        <div class="col-12 p-0 mb-5">
        <?php
			include 'includes/home/yenicikanlar_oyunlar.php';
		?>
        </div>
        
        <?php
    	$AltReklam = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
    	$AltReklam ->execute([22,1]);
    	$AltReklamVeri  = $AltReklam ->rowCount();
    	$AltReklamKayitlar  = $AltReklam ->fetch(PDO::FETCH_ASSOC);
    	if ($AltReklamVeri>0) {
    	?>
    	<div class="col-12 text-center mt-4 d-none d-md-block ">
    		<div class="row justify-content-center align-items-center" >
    		    <div class="col-12 col-md-8">
    			<?php echo IcerikTemizle($AltReklamKayitlar["BannerKodu"]); ?> 
    			<?php
    			$BannerGuncelleme2  = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
    			$BannerGuncelleme2 ->execute([22]);	
    			?>	
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
			<div class="row justify-content-center align-items-center text-center d-block d-md-none mt-5">
				<div class="col-11 col-md-12">
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

        <div class="col-12 p-0 mb-5">
         <?php
			include 'includes/home/cokyakinda_oyunlar.php';
		?>
        </div>

    	<div class="col-12 p-0 ">
    		<div class="row  justify-content-center" >
    		    <div class="col-12 col-lg-6 zcxZax" >
    		    <?php
        		include 'includes/home/son_incelemeler.php';
        		?>
    			</div>
    			<div class="col-12 col-lg-6 xcvbZW" >
    				<div class="row p-1 justify-content-center ">
    					<div class="col-12 "  >
    						<div class="row"  >
    							<div class="col-12  mb-2">
    								<div class="row p-2 justify-content-end align-items-center">
    									<div class="col-7 col-md-8  text-left  bGAfxXE " ><span >OYUN KATEGORİLERİ</span></div>
    									<div class="col-5 col-md-4 p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="tumoyunlar" ><span class=" gxPpxXo_">TÜM OYUNLAR</span></a></div>
    								</div>
    							</div>
    							<div class="swiper-container swiper5 " >
    				    			<div class="swiper-wrapper ">
    								<?php
    								$Kategoriler= array(
    									array('ResimYolu' =>$AnasayfaCokoyunculu,'Link'=>"tumoyunlar/&Ara=&c=cokoyunculu/1",'Adi'=>"Çok Oyunculu"),
    									array('ResimYolu' =>$AnasayfaAksiyon,'Link'=>"tumoyunlar/&Ara=&c=aksiyon/1",'Adi'=>"Aksiyon"),
    									array('ResimYolu' =>$AnasayfaBasitEglence,'Link'=>"tumoyunlar/&Ara=&c=basiteglence/1",'Adi'=>"Basit Eğlence"),
    									array('ResimYolu' =>$AnasayfaSpor,'Link'=>"tumoyunlar/&Ara=&c=spor/1",'Adi'=>"Spor"),
    									array('ResimYolu' =>$AnasayfaYaris,'Link'=>"tumoyunlar/&Ara=&c=yaris/1",'Adi'=>"Yarış"),
    									array('ResimYolu' =>$AnasayfaStrateji,'Link'=>"tumoyunlar/&Ara=&c=strateji/1",'Adi'=>"Strateji"),
    									array('ResimYolu' =>$AnasayfaSimulasyon,'Link'=>"tumoyunlar/&Ara=&c=simulasyon/1",'Adi'=>"Simülasyon"),
    									array('ResimYolu' =>$AnasayfaUcretsiz,'Link'=>"tumoyunlar/&Ara=&c=ucretsiz/1",'Adi'=>"Ücretsiz"),
    									array('ResimYolu' =>$AnasayfaHayattaKalma,'Link'=>"tumoyunlar/&Ara=&c=hayattakalma/1",'Adi'=>"Hayatta Kalma"),
    									array('ResimYolu' =>$AnasayfaMacera,'Link'=>"tumoyunlar/&Ara=&c=macera/1",'Adi'=>"Macera"),
    									array('ResimYolu' =>$AnasayfaRolYapma,'Link'=>"tumoyunlar/&Ara=&c=rolyapma/1",'Adi'=>"Rol Yapma"),
    								);	
    								?>
    								<?php
    								for($i=0;$i<count($Kategoriler);$i++){
    								?>
    									<div class="swiper-slide mt-5">
    										<div class="col-9 ">
    											<div class="row justify-content-center text-center">
    												<a href="<?php echo $Kategoriler[$i]["Link"] ?>" >
    												<?php
    												if ( file_exists("images/".$Kategoriler[$i]["ResimYolu"])  and ($Kategoriler[$i]["ResimYolu"])) {
    												?>
    													<img src="images/<?php echo $Kategoriler[$i]["ResimYolu"]; ?>" class="img-fluid" height="300" width="500" alt="<?php echo  IcerikTemizle($Kategoriler[$i]["Adi"]); ?>" style="width: 100%;height: auto;"/>
    												<?php
    												}else{
    												?>
    													<div style="background: #202020; height: 290px;width: 290px; border-radius: 50% "></div>
    												<?php
    												}
    												?>
    													<span class="text-center OWWQsx_"><?php echo  IcerikTemizle($Kategoriler[$i]["Adi"]); ?></span>
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
    				</div>
    			</div>
    		</div>
    	</div>

    	<?php
    	$AltReklam = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
    	$AltReklam ->execute([22,1]);
    	$AltReklamVeri  = $AltReklam ->rowCount();
    	$AltReklamKayitlar  = $AltReklam ->fetch(PDO::FETCH_ASSOC);
    	if ($AltReklamVeri>0) {
    	?>
    	<div class="col-12 text-center  mt-4 d-none d-md-block ">
    		<div class="row justify-content-center align-items-center" >
    		    <div class="col-12 col-md-8">
    			<?php echo IcerikTemizle($AltReklamKayitlar["BannerKodu"]); ?> 
    			<?php
    			$BannerGuncelleme2  = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
    			$BannerGuncelleme2 ->execute([22]);	
    			?>	
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
			<div class="row justify-content-center align-items-center text-center   d-block d-md-none mt-5" >
				<div class="col-11 col-md-12">
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
	
        <div class="col-12 p-0 mb-2">
         <?php
			include 'includes/home/populer_oyunlar.php';
		?>
	    </div>
        <div class="col-12 p-0 mb-5">
        <?php
			include 'includes/home/ucretsiz_oyunlar.php';
		?>
        </div>
    	
		<?php
    	$AltReklam = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
    	$AltReklam ->execute([22,1]);
    	$AltReklamVeri  = $AltReklam ->rowCount();
    	$AltReklamKayitlar  = $AltReklam ->fetch(PDO::FETCH_ASSOC);
    	if ($AltReklamVeri>0) {
    	?>
    	<div class="col-12 text-center  mt-4 d-none d-md-block ">
    		<div class="row justify-content-center align-items-center" >
    		    <div class="col-12 col-md-8">
    			<?php echo IcerikTemizle($AltReklamKayitlar["BannerKodu"]); ?> 
    			<?php
    			$BannerGuncelleme2  = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
    			$BannerGuncelleme2 ->execute([22]);	
    			?>	
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
			<div class="row justify-content-center align-items-center text-center   d-block d-md-none mt-5" >
				<div class="col-11 col-md-12">
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
	
    	<div class="row  justify-content-center  p-0 mb-5">
    		<div class="col-12 col-lg-8 mt-5">
    			<div class="row p-2">
    				<div class="col-12">
    					<div class="row">
    					<?php
							include 'includes/home/roak_videolar.php';
						?>
    					</div>
    				</div>
    			</div>
    		</div>

    		<div class="col-12 col-lg-4 mt-5">
    			<div class="row p-2">
    				<div class="col-12  mt-1">
						<div class="row p-2 mb-3 justify-content-end align-items-center"  style="background:#202020;border-radius:5px">
							<div class=" col-12 text-left  bGAfxXE " ><span >BUGÜN EN ÇOK OKUNANLAR</span></div>
						</div>
					</div>
    				<div class="col-12 m-0 p-0">
						<div class="tab-wrap mt-2" >
							<input class="tab" id="tab1" type="radio" name="group1" checked="checked"/>
							<label for="tab1" class="kdnav">Haber</label>
							<input class="tab" id="tab2" type="radio" name="group1"/>
							<label for="tab2" class="kdnav">İnceleme</label>
							<input class="tab" id="tab3" type="radio" name="group1"/>
							<label for="tab3" class="kdnav">Sözlük</label>
							<div class="tab-content m-0">
								<div class="row align-items-center ">
									<?php
										include 'includes/home/bugun_okunan_haberler.php';
									?>

								
								</div>
							</div>

							<div class="tab-content">
								<div class="row justify-content-center m-0">
								<?php
									include 'includes/home/bugun_okunan_incelemeler.php';
								?>
								</div>
							</div>

							<div class="tab-content">
								<div class="row align-items-center m-0">
								<?php
									include 'includes/home/bugun_okunan_sozlukyazilar.php';
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
<link rel="stylesheet" href="settings/swiper-bundle.min.css">
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

<style type="text/css">
.swiper-pagination-bullet {
    margin-right: 5px ! important
}
</style>
<?php
}else{
  header("location:" .$SiteLink);
  exit();
}

?>
   

