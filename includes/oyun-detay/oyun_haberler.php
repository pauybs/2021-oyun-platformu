<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunHaberler =  $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? AND IlgiliOyun=? ORDER BY id DESC LIMIT 4");
	$OyunHaberler->execute([1,$OyunId]);
	$OyunHaberlerVeri = $OyunHaberler->rowCount();
	$OyunHaberlerKayitlar = $OyunHaberler->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunHaberlerVeri>0) {
	?>
	<div class="row justify-content-center  p-3 p-xl-5  ">
		<div class="col-12 SAFfXxAERz bGAfxXE mb-2" >
			<h6 class="m-0 bold white oyunYazi">İlgili Haberler</h6>
		</div>
		<div class="col-12 mt-3">
			<div class="row justify-content-center align-items-center ">
			
            <div class="swiper-container swiper10" >
        	    <div class="swiper-wrapper">
				<?php
				foreach ($OyunHaberlerKayitlar as  $HaberKayitlar) {
			    ?>
			    <div class="col-12 col-xl-4 mb-1">
					<div class="row p-1">
						<div class="col-12">
							<div class="row align-items-end">
								<div class="col-12 p-0">
									<a href="haberdetay/<?php echo  SEO(IcerikTemizle($HaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($HaberKayitlar["HaberUniqid"]); ?>">
										<?php
										if (file_exists("images/news/".$HaberKayitlar["AnaResim"]) and (isset($HaberKayitlar["AnaResim"])) and ($HaberKayitlar["AnaResim"]!="" )) {
										?>
											<img src="images/news/<?php echo  IcerikTemizle($HaberKayitlar["AnaResim"]);?>" alts="<?php echo  IcerikTemizle($HaberKayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($HaberKayitlar["AnaBaslik"]);?>" class="img-fluid haberResim wWfVCA h">
										<?php
										}else{
										?>
											<img src="images/hata.jpg" class="img-fluid ">
										<?php
										}
										?>	
									</a>
								</div>

								<div class="col-12 position-absolute p-0 lkAQIYMvX">
									<div class="row p-2 ">
										<div class="col-12 mt-5">
											<a  style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($HaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($HaberKayitlar["HaberUniqid"]); ?>">
												<h2 class="h haberlerBaslik bold SSZx__aWqaz" >
													<?php
													if (strlen(IcerikTemizle($HaberKayitlar["AnaBaslik"]))>70) {
														echo strip_tags(IcerikTemizle(substr($HaberKayitlar["AnaBaslik"],0,70)))."...";
													}else{
														echo IcerikTemizle($HaberKayitlar["AnaBaslik"]);
													}
													?>
												</h2>
											</a>
											<a style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($HaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($HaberKayitlar["HaberUniqid"]); ?>">
												<i class=" fas fa-comment-alt font12"></i> 
												<span class="h font12"><?php echo IcerikTemizle($HaberKayitlar["YorumSayisi"]);?></span>
											</a>
										</div>
										<?php
										$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                                		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($HaberKayitlar["Editor"])),1,1]);
                                		$EditorSayi = $Editor->rowCount();
                                		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                                		if ($EditorSayi>0) {
                                			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                                			
                                		}else{
                                			$EditorIsim="";
                                			
                                		}
										?>
										<div class="col-12 font12  opacity07 uQRtXT">
										    <span class="white  uQRtXT" > <?php echo $EditorIsim ?> / <i class="fas fa-clock white"></i> <?php echo time_ago(IcerikTemizle($HaberKayitlar["KayitTarihi"])); ?></span>
											
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
		    <div class="col-12 text-center  swiper-pagination10 mt-2"></div>
            </div>
		</div>
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





