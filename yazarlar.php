<?php
require_once("settings/connect.php");
require_once("settings/functions.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<div class="container">
	<?php
	$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
	$Banner->execute([39,1]);
	$BannerVeri = $Banner->rowCount();
	$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
	if ($BannerVeri>0) {
	?>
	<div class="col-12 text-center  mt-5">
		<div class="row justify-content-center align-items-center" >
			<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([39] );	
			?>
		</div>
	</div>
	<?php
	}
	?>

	<div class="col-12 p-0 mt-5 mb-5">
		<div class="row justify-content-center m-0 mb-5 ">
			<div class="col-12 col-md-7" >
				<div class="row " >
					<div class="col-12 " >
						<div class="row p-2">
							<div class="col-12" style="background: #202020;">
								<div class="row p-2 align-items-center">
									<div class=" col-12 text-left  bGAfxXE " ><span >EDİTÖRLER</span></div>
								</div>
							</div>
						</div>
					</div>	
					<?php
					$Editorler = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  Durum=? and Editor=? and SilinmeDurumu=? and id!=?  ORDER BY id DESC" );
					$Editorler->execute([1,1,0,3]);
					$VeriSayisi = $Editorler->rowCount();
					$EditorlerKayitlar = $Editorler->fetchAll(PDO::FETCH_ASSOC);
					if ($VeriSayisi>0) {
					foreach ($EditorlerKayitlar as  $kayitlar) {	
					?>
					<div class="col-12 " >
						<div class="row p-2">
							<div class="col-12" style="background: rgb(32,32,32,0.5);">
								<div class="row align-items-center">
									<div class="col-3 p-0">
										<div class="row">
										<?php
										if (file_exists("images/userphoto/".$kayitlar["ProfilResmi"]) and ($kayitlar["ProfilResmi"]) ) {
										?>
											<div class="col-12">
												<a href="editor/<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>">
													<img src="images/userphoto/<?php echo  IcerikTemizle($kayitlar["ProfilResmi"]);?>" title="<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>" class="img-fluid lYkqwAk wWfVCA a" >
												</a>
											</div>
										<?php
										}else{
										?>
											<div class="col-12">
												<a href="editor/<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>">
													<img src="images/userbackground.jpg" class="img-fluid lYkqwAk" >
												</a>
											</div>
										<?php
										}
										?>
										</div>
									</div>
									<div class="col-9">
										<div class="row">
											<div class="col-12 text-left mt-2 ksadsja">
												<a href="editor/<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>"><h5 class="bold white  m-0" style="color:#c28f2c"><?php echo IcerikTemizle($kayitlar["AdSoyad"]);?></h5></a>
											</div>
											<?php
											$EditorHaber=$DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE  Durum=? and Editor=? ORDER BY id DESC LIMIT 1" );
											$EditorHaber->execute([1,$kayitlar["id"]]);
											$EditorHaberVeriSayisi = $EditorHaber->rowCount();
											$EditorHaberKayitlar = $EditorHaber->fetch(PDO::FETCH_ASSOC);
											if ($EditorHaberVeriSayisi>0) {
											?>
											<div class="col-12 text-left mt-2 ksadsja">
												<a href="haberdetay/<?php echo SEO(IcerikTemizle($EditorHaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($EditorHaberKayitlar["HaberUniqid"]);?>"><span class="bold white font16"><?php echo IcerikTemizle($EditorHaberKayitlar["AnaBaslik"]);?></span></a>
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
					<?php
					}
					}
					?>
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
?>