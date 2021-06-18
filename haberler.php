<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( AnaBaslik LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
} 
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 10;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id Desc");
$ToplamKayitSorgu->execute([1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	
?>
<?php
$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
$BannerUst->execute([2,1]);
$BannerUstVeri = $BannerUst->rowCount();
$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
if ($BannerUstVeri>0) {
?>	
<div class="col-12  text-center mt-5 d-none d-md-block">
	<div class="row justify-content-center align-items-center">
	    <div class="col-10">
		<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([2]);	
		?>	
		</div>
	</div>	
</div>
<div class="col-12  text-center mt-5 d-block d-md-none">
	<div class="row justify-content-center align-items-center">
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
</div>
<?php
}
?>

<div class="col-12">
	<div class="row justify-content-center   m-0  mb-5 ">
		<div class="col-12  mt-5 mb-5 p-0 " >
			<div class="row  justify-content-center m-0 ">
				<div class="d-none d-xl-block col-12 col-md-10 mb-3">
					<div class="row justify-content-center align-items-center">
						<div class="col-8">
							<div class="row newdjA" >
								<li >
									<a class="___zAa__uTyRee" style="color: white" href="haber">
										<span>Tüm Haberler</span>
									</a>
								</li>
								<li >
									<a  class="t_RwAMWz_" style="color: white" href="okunanhaberler">
										<span> Çok Okunan Haberler</span>
									</a>
								</li>
								<li >
									<a class="t_RwAMWz_" style="color: white" href="konusulanhaberler">
										<span>Çok Konuşulan Haberler</span>
									</a>
								</li>
							</div>
						</div>
						<div class="col-4 p-2 text-right ">
							<form action="haber" method="post" > 
								<input placeholder="Ara..." type="search" name="Ara" class="gn-search2 wWfVCA " style="background: #202020">
							</form>
						</div>	
					</div>
				</div>

				<div class="d-block d-xl-none col-12 mb-3">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center iaQeezXzC___" >
							<label class="mt-3 mb-0" for="menu-toggle">
								<p class="bold  white font13" style="cursor: pointer;">
									<span>Tüm Haberler</span> 
									<i class="fas fa-chevron-down"></i>
								</p> 
							</label>
						</div>

						<input type="checkbox" id="menu-toggle" />
						<ul id="menu" class="wWfVCA" >
							<li>
								<div class="col-12 mt-3 mb-3 text-center " >
									<a class="t_RwAMWz_" style="color: white " href="okunanhaberler">
										<span class="font12">Çok Okunan Haberler</span>
									</a>
								</div>
							</li>
							<li>
								<div class="col-12 mt-3 mb-3 text-center " >
									<a class="t_RwAMWz_" style="color: white " href="konusulanhaberler">
										<span class="font12">Çok Konuşulan Haberler</span>
									</a>
								</div>
							</li>
						</ul>
						<div class="col-12 mt-4  text-right  wWfVCA" >
							<form action="haber  " method="post" >
								<input style="width: 100%"   placeholder="Ara..." type="search" class="gn-search2 wWfVCA" name="Ara" >
							</form>
						</div>	
					</div>
				</div>

				<div class="col-12 col-md-8 " >
					<div class="row    ">
					<?php
					$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
					$Haberler->execute([1]);
					$VeriSayisi = $Haberler->rowCount();
					$HaberKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
					if ($VeriSayisi>0) {
					    $sayac=0;
					foreach ($HaberKayitlar as  $kayitlar) {
					    $sayac++;
					?>
					    <?php
					    if($sayac==5){
					    ?>
					    <div class="col-11 col-md-12 text-center mt-3 mb-3">
					    	<ins class="adsbygoogle"
                             style="display:block; text-align:center;"
                             data-ad-layout="in-article"
                             data-ad-format="fluid"
                             data-ad-client="ca-pub-6491655414364653"
                             data-ad-slot="1903795723"></ins>
                        <script>
                             (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
					   </div>
					    
					    <?php
					    }
					    ?>
						<div class="col-12 col-xl-6 mb-1">
							<div class="row p-1">
								<div class="col-12">
									<div class="row align-items-end">
										<div class="col-12 p-0">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
												<?php
												if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="" )) {
												?>
													<img src="images/news/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alts="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" class="img-fluid haberResim wWfVCA h">
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
													<a  style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
														<h2 class="h haberlerBaslik bold SSZx__aWqaz" >
															<?php
															if (strlen(IcerikTemizle($kayitlar["AnaBaslik"]))>70) {
																echo strip_tags(IcerikTemizle(substr($kayitlar["AnaBaslik"],0,70)))."...";
															}else{
																echo IcerikTemizle($kayitlar["AnaBaslik"]);
															}
															?>
														</h2>
													</a>
													<a style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
														<i class=" fas fa-comment-alt font12"></i> 
														<span class="h font12"><?php echo IcerikTemizle($kayitlar["YorumSayisi"]);?></span>
													</a>
												</div>
												<?php
        										$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                                        		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($kayitlar["Editor"])),1,1]);
                                        		$EditorSayi = $Editor->rowCount();
                                        		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                                        		if ($EditorSayi>0) {
                                        			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                                        			
                                        		}else{
                                        			$EditorIsim="";
                                        			
                                        		}
        										?>
        										<div class="col-12 font12  opacity07 uQRtXT">
        										    <span class="white  uQRtXT" > <?php echo $EditorIsim ?> / <i class="fas fa-clock white"></i> <?php echo time_ago(IcerikTemizle($kayitlar["KayitTarihi"])); ?></span>
        											
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
						<div class="col-12 mt-2">
							<div class="row justify-content-center align-items-center mb-5" style="background:#202020">
								<div class="col-12 text-center mb-2" >
									<img src="images/logo.png" class="img-fluid tznzuy7YQ">
								</div>

								<div class="col-12 position-absolute text-center mb-2">
									<div class="row justify-content-center">
										<div class="col-12 col-xl-8">
											<h6 class="white">Hiçbir haber bulamadık. Bu konu veya oyun hakkında bir şeyler yazmamızı istiyorsan bizimle iletişime geç ve bir daha arandığında bu hata ortaya çıkmasın.</h6>
										</div>

										<div class="col-12 mt-2">
											<a href="<?php echo IcerikTemizle($SiteLink) ?>">
												<button class="call-to-action2 p-0" style="height: 50px">
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
					<?php
					if($SayfaSayisi>1){
					?>
					<div class="col-12 text-center mt-3   p-0"  >
						<?php
						if($Sayfalar>1 ){
							echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='haber/". $SayfalamaSecimi ."/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
			 				$SayfaGeri = $Sayfalar-1;
								echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='haber/". $SayfalamaSecimi ."/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
						}
						for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
							if( ($i>0)  and ($i<=$SayfaSayisi)  ){
								if($Sayfalar==$i){
		 						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

								}else{
									echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='haber/". $SayfalamaSecimi ."/". $i . "'>".$i."</a></span>";
								}
							}
						}
						if($Sayfalar!=$SayfaSayisi){
							
		 				$SayfaIleri = $Sayfalar+1;
		 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='haber/". $SayfalamaSecimi ."/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
		 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='haber/". $SayfalamaSecimi ."/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
						}
						?>
					</div>
					<?php
					}
					?>	
				</div>
				
				<div class="d-none d-xl-block col-2  ">
				    <div class="row">
				        <div class="col-12 white ">
				    	<?php
						include 'includes/okunan_haberler.php';
				    	?>
						</div>
        				<?php
        				$BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
        				$BannerYan->execute([3,1]);
        				$BannerYanVeri = $BannerYan->rowCount();
        				$BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
        				if ($BannerYanVeri>0) {
        				?>
        					<div class="col-12 justify-content-center align-items-center"  >
        						<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 	
        						<?php
        						$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
        						$BannerGuncelleme2->execute([3]);	
        						?>		
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
<script type="text/javascript">
	$(".h").css("display", "none");
	$(".h").fadeIn("slow");
</script>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}

?>