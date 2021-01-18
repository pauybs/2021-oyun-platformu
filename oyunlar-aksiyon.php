<?php
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( oyunlar.OyunAdi LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
}

$SayfalarSolVeSagButonSayisi = 2;
$GosterilecekKayitSayisi =12;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
$ToplamKayitSorgu->execute();
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	
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

<div class="col-12 p-0  " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-11 col-xl-2 mb-3  ">
			<div class="row justify-content-center align-items-center">
				<div class="col-12 p-0 mb-3 text-right ">
					<form action="aksiyon  " method="post" > 
						<input placeholder="Ara..." type="search" name="Ara" class="gn-search2" style="background: #202020;width: 100%">
					</form>
				</div>
				<div class="col-12 text-center kiyBZJGAB" >
					<label class="mt-3 mb-0" for="menu-toggle">
						<p class="bold " style="cursor: pointer;color: white">
							<span>Kategoriler</span>
							<i class="fas fa-chevron-down"></i>
						</p> 
					</label>
				</div>
				<input type="checkbox" id="menu-toggle" >
				<ul id="menu" class="wWfVCA" >
					<li><div class="col-12 mt-3 mb-3"><a class="font13 bold" style="color: white" href="aksiyon"><span>Aksiyon</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="basiteglence"><span>Basit Eğlence</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="spor"><span>Spor</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="simulasyon"><span>Simulasyon</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="strateji"><span>Strateji</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="cokoyunculu"><span>Çok Oyunculu</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="macera"><span>Macera</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="yaris"><span>Yarış</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="rolyapma"><span>Rol Yapma</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="ucretsiz"><span>Ücretsiz</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="hayattakalma"><span>Hayatta Kalma</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="android"><span>Android Oyunları</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="ios"><span>iOS Oyunları</span></a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="windows"><span>Windows Oyunları</a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="macos"><span>MacOS Oyunları</a></div></li>
					<li><div class="col-12 mt-3 mb-3"><a class="OYTAxxXAZd" style="color: white" href="linux"><span>Linux Oyunları</a></div></li>
				</ul>
			</div>
		</div>

		<div class="col-12 col-xl-8" >
			<div class="row  " >
			<?php
			$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
			$Oyunlar->execute();
			$OyunlarVeri = $Oyunlar->rowCount();
			$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);

			if ($OyunlarVeri>0) {
				foreach ($OyunlarKayitlar as  $kayitlar) {		
			?>
				<div class="col-6 col-md-4 col-xl-3 mb-5 ">
				<?php
				if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
				?>
					<div class="col-12 p-0" style="background: black">
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
							<img src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" class="img-fluid oyunlar wWfVCA a">
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0  "  >
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
							<img src="images/resim.jpg" class="img-fluid oyunlar" >
						</a>
					</div>
				<?php
				}
				?>
						
				<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
					<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
						<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
					</a>
				</div>

				<?php
				$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
				$ToplamPuan->execute([$kayitlar["id"]]);
				$ToplamPuanVeri = $ToplamPuan->rowCount();
				$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
				if ($ToplamPuanVeri>0) {
				?>
					<?php
					$ToplamPuan=0;
					$KisiSayisi=$ToplamPuanVeri;
					foreach ($ToplamPuanKayitlar as $Puanlar) {
						$ToplamPuan+= $Puanlar["Puan"];
					}
						$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
					?>
					
					<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
				<?php
				}else{		
				?>
					<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
				<?php
				}
				?>
				
				<?php
				$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
				$OyunPlatform->execute([$kayitlar["id"]]);
				$OyunPlatformSayi = $OyunPlatform->rowCount();
				$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);

				if ($OyunPlatformSayi>0) {
				?>
					<div class="col-12  mt-1 p-0" >
						<?php
						foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
						?>
							<?php echo Platform($OyunPlatform["PlatformId"])?>
						<?php		
						}
						?>
					</div>
				<?php
				}else{
				?>	

				<?php
				}
				?>
				</div>
			<?php
			}
			}else{
			?>
		
			<div class="col-11 col-xl-11"  >
				<div class="row justify-content-center  align-items-center ml-1 wWfVCA ">
					<div class="col-12  text-center  mb-2" >
						<img src="images/logo.png" class="img-fluid" style="opacity: 0.1; width: 350px;height: 350px">
					</div>
					<div class="col-12 position-absolute text-center  mb-2" >
						<div class="row justify-content-center">
							<div class="col-12 col-xl-8">
								<h5 class="white">Hiçbir oyun bulamadık. Umarım gözden kaçırmıyoruzdur. Gözden kaçırdığımız bir şey varsa bunu bize iletişim kısmından bildirebilirsin.</h5>
							</div>
							<div class="col-12 mt-2">
								<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
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
				 

			<?php
			if($SayfaSayisi>1){
			?>
			<div class="col-12 text-center mt-3   p-4"  >
 			<?php
 			if($Sayfalar>1 ){
 				echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='aksiyon/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";	
 			}
 			for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
 				if( ($i>0)  and ($i<=$SayfaSayisi)  ){
					if($Sayfalar==$i){
 						echo "<span class='p-2  bold  '   style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white ' class='aktif p-3'>". $i . "</span>";

					}else{
						echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='aksiyon/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
					}
 				}
 			}
 					
 			if($Sayfalar!=$SayfaSayisi){
 				echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href=''aksiyon/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
 			}
 			?>
			</div>
			<?php
			}
			?>
		</div>
	</div>			
</div>
<script type="text/javascript">
	$(".a").css("display", "none");
	$(".a").fadeIn(1500);
</script>