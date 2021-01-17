<?php
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( AnaBaslik LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
} 
$SayfalarSolVeSagButonSayisi = 2;
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
if ($BannerUst>0) {
?>	
<div class="col-12 col-xl-12 text-center   mt-5">
	<div class="row justify-content-center align-items-center">
		<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([2]);	
		?>		
	</div>	
</div>
<?php
}
?>
<div class="col-12">
	<div class="row justify-content-center   m-0  mb-5 ">
		<div class="col-12 col-xl-7 mt-5 mb-5 " >
			<div class="row  justify-content-center m-0 ">
				<div class="d-none d-xl-block col-12 mb-3">
					<div class="row justify-content-center align-items-center">
						<div class="col-6">
							<div class="row ">
								<div class="col-3" >
									<a class="___zAa__uTyRee" style="color: white" href="haber">
										<span>Tüm Haberler</span>
									</a>
								</div>
								<div class="col-4">
									<a  class="t_RwAMWz_" style="color: white" href="okunanhaberler">
										<span> Çok Okunan Haberler</span>
									</a>
								</div>
								<div class="col-5">
									<a class="t_RwAMWz_" style="color: white" href="konusulanhaberler">
										<span>Çok Konuşulan Haberler</span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-6 p-2 text-right ">
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
									<a class="t_RwAMWz_" style="text-decoration: none;color: white " href="okunanhaberler">
										<span class="font12">Çok Okunan Haberler</span>
									</a>
								</div>
							</li>
							<li>
								<div class="col-12 mt-3 mb-3 text-center " >
									<a class="t_RwAMWz_" style="text-decoration: none;color: white " href="konusulanhaberler">
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

				<div class="col-12 " >
					<div class="row    ">
					<?php
					$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
					$Haberler->execute([1]);
					$VeriSayisi = $Haberler->rowCount();
					$HaberKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
					if ($VeriSayisi>0) {
					foreach ($HaberKayitlar as  $kayitlar) {
					?>
						<div class="col-12 col-xl-6">
							<div class="row p-2">
								<div class="col-12">
									<div class="row align-items-end">
										<div class="col-12 p-0">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
												<?php
												if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="" )) {
												?>
													<img src="images/news/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" class="img-fluid haberResim wWfVCA h">
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
													<a  style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
														<h2 class="h haberlerBaslik bold SSZx__aWqaz" >
															<?php echo IcerikTemizle($kayitlar["AnaBaslik"]);?>
														</h2>
													</a>
													<a style="color: white" href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
														<i class="h fas fa-comment-alt font14"></i> 
														<span class="h font14"><?php echo IcerikTemizle($kayitlar["YorumSayisi"]);?></span>
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
								<div class="col-12 text-center mb-2" >
									<img src="images/logo.png" class="img-fluid tznzuy7YQ">
								</div>

								<div class="col-12 position-absolute text-center mb-2">
									<div class="row justify-content-center">
										<div class="col-12 col-xl-8">
											<h5 class="white">Hiçbir haber bulamadık. Bu konu veya oyun hakkında bir şeyler yazmamızı istiyorsan bizimle iletişime geç ve bir daha arandığında bu hata ortaya çıkmasın.</h5>
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
			</div>

			<?php
			if($SayfaSayisi>1){
			?>
			<div class="col-12 text-center mt-3   p-4"  >
				<?php
				if($Sayfalar>1 ){
					echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='haber/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";
				}

				for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
					if( ($i>0)  and ($i<=$SayfaSayisi)  ){
						if($Sayfalar==$i){
							echo "<span class='p-2 bold' style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white' class='aktif p-3'>". $i . "</span>";
						}else{
							echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='haber/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
						}
					}
				}

				if($Sayfalar!=$SayfaSayisi){
					echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href='haber/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right'></i></a></span>";	
				}
				?>
			</div>
			<?php
			}
			?>	
		</div>			
	</div>
	
	<?php
	$BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
	$BannerYan->execute([3,1]);
	$BannerYanVeri = $BannerYan->rowCount();
	$BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
	if ($BannerYanVeri>0) {
	?>
		<div class="d-none d-xl-block col-2 mt-5">
			<div class="row justify-content-center align-items-center"  >
				<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 	
				<?php
				$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme2->execute([3]);	
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