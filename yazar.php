<?php
require_once("settings/connect.php");
require_once("settings/functions.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if (isset($_GET["KullaniciAdi"])) {
	$KullaniciAdi= Guvenlik($_GET["KullaniciAdi"]);
	$EditorKontrol=$DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  Durum=? and Editor=? and SilinmeDurumu=? and KullaniciAdi=? and id!=? LIMIT 1" );
	$EditorKontrol->execute([1,1,0,Guvenlik($KullaniciAdi),3]);
	$EditorKontrolVeriSayisi = $EditorKontrol->rowCount();
	$EditorKontrolKayitlar = $EditorKontrol->fetch(PDO::FETCH_ASSOC);
	if ($EditorKontrolVeriSayisi>0) {
	?>	
	<div class="container">
		<?php
		$SayfalarSolVeSagButonSayisi = 1;
		$GosterilecekKayitSayisi=10;
		$ToplamKayitSorgu=$DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE  Durum=? and Editor=?   ORDER BY id Desc  ");
		$ToplamKayitSorgu->execute([1,$EditorKontrolKayitlar["id"]]);
		$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
		$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
		$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
		?>

		<?php
		$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
		$Banner->execute([1,1]);
		$BannerVeri = $Banner->rowCount();
		$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
		if ($BannerVeri>0) {
		?>
		<div class="col-12 text-center  mt-5">
			<div class="row justify-content-center align-items-center" >
				<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme->execute([1] );	
				?>
			</div>
		</div>
		<?php
		}
		?>

		<div class="col-12 p-0 mt-5 mb-5">
			<div class="row justify-content-center m-0 mb-5 ">
				<div class="col-12 col-md-7" >
					<div class="row p-2" >
						<div class="col-12">
							<div class="row">
							<div class="col-12">
								<div class="row">
								
								<?php
								$Editorler = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  id=?   lIMIT 1" );
								$Editorler->execute([$EditorKontrolKayitlar["id"]]);
								$VeriSayisi = $Editorler->rowCount();
								$EditorlerKayitlar = $Editorler->fetch(PDO::FETCH_ASSOC);
								if ($VeriSayisi>0) {
								?>
								<div class="col-12 mb-3" >
									<div class="row ">

										<div class="col-12" >
											<div class="row align-items-center">
												<div class="col-2 p-0">
													<div class="row">
													<?php
													if (file_exists("images/userphoto/".$EditorlerKayitlar["ProfilResmi"]) and ($EditorlerKayitlar["ProfilResmi"]) ) {
													?>
														<div class="col-12">
															<img src="images/userphoto/<?php echo  IcerikTemizle($EditorlerKayitlar["ProfilResmi"]);?>" title="<?php echo  IcerikTemizle($EditorlerKayitlar["KullaniciAdi"]);?>" class="img-fluid lYkqwAk wWfVCA a" >
															
														</div>
													<?php
													}else{
													?>
														<div class="col-12">
															<img src="images/userbackground.jpg" class="img-fluid lYkqwAk" >
														</div>
													<?php
													}
													?>
													</div>
												</div>
												<div class="col-10">
													<div class="row">
														<div class="col-12 ">
															<h5 class="bold m-0 white" >Editör</h5>
														</div>
														<div class="col-12 text-left mt-1 ksadsja">
															<h5 class="bold white m-0 " style="color:#c28f2c"><?php echo IcerikTemizle($EditorlerKayitlar["AdSoyad"]);?></h5>
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
							<div class="col-12 mb-3  p-2" style="background: #202020">
								<div class=" col-12 text-left  bGAfxXE " ><span >EDİTÖR İÇERİKLERİ</span></div>
							</div>

							<?php
							$EditorHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? and Editor=?  ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
							$EditorHaberler->execute([1,$EditorKontrolKayitlar["id"]]);
							$Data = $EditorHaberler->rowCount();
							$EditorHaberlerKayitlar = $EditorHaberler->fetchAll(PDO::FETCH_ASSOC);
							if ($Data>0) {
							?>
								<?php
								foreach ($EditorHaberlerKayitlar as $kayitlar) {
								?> 
								<div class="col-12 mb-3 " style="background: #202020">
									<div class="row align-items-center">
										<div class="col-4">
											<div class="row">
											<?php
											if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="") ){
											?>
												<div class="col-12 p-0" >
													<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
														<img src="images/news/<?php echo IcerikTemizle($kayitlar["AnaResim"]); ?>" alt="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" class="img-fluid wWfVCA hdr" >
													</a>
												</div>
											<?php
											}else{
											?>
											<div class="col-12 p-0">
												<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
													<img src="images/hata.jpg" class="img-fluid" >
												</a>
											</div>
											<?php
											}
											?>
											</div>
										</div>
										<div class="col-8">
											<div class="row">
												<div class="col-12 mt-2 " >
													<a   href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
														<h1 class="font15 bold white yaziAlan">
															<?php	echo IcerikTemizle($kayitlar["AnaBaslik"]); ?>	
														</h1>
													</a>
												</div>
												<div class="col-12 font11  opacity07 uQRtXT">
												    <span class="white  uQRtXT" > <i class="fas fa-clock white"></i> <?php echo time_ago(IcerikTemizle($kayitlar["KayitTarihi"])); ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>
								<?php
								if($SayfaSayisi>1){
								?>
								<div class="col-12 text-center mt-5   p-0"  >
								<?php
								if($Sayfalar>1 ){
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='editor/".$KullaniciAdi."'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='editorh/".$KullaniciAdi."/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='editorh/".$KullaniciAdi."/". $i . "'>".$i."</a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									$SayfaIleri = $Sayfalar+1;
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='editorh/".$KullaniciAdi."/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='editorh/".$KullaniciAdi."/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
								<?php
								}
								?>	
							<?php
							}else{
							?>
								<div class="col-12 mb-3 text-center  p-5" style="background: #202020">
									<h5 class="bold white m-0">İçerik bulunmamaktadır.</h5>
								</div>
							<?php
							}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5 d-none d-md-block">
					<div class="row p-2">
						<div class="col-12">
							<div class="row">
								<div class="col-12  ">
									<div class="row p-2  justify-content-end align-items-center"  style="background:#202020">
										<div class=" col-12 text-left  bGAfxXE " ><span >BUGÜN EN ÇOK OKUNANLAR</span></div>
									</div>
								</div>
								<?php
									include 'includes/home/bugun_okunan_haberler.php'
								?>
								<div class="col-12 mt-4">
            						<div class="row  justify-content-center text-center">
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
            						</div>
            					</div>
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
	}else{
		header("location:" .$SiteLink);
		exit();
	}
}else{
	header("location:" .$SiteLink);
	exit();

}
}else{
	header("location:" .$SiteLink);
	exit();

}
