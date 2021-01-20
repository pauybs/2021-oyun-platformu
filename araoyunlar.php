 <?php
 if(isset($_GET["Ara"])){
 	$Arama =Guvenlik($_GET["Ara"]);
 	$AramaSecimi = "AND ( OyunAdi LIKE '%" . $Arama . "%'  )";
 	$SayfalamaSecimi = "&Ara=" . $Arama ; 
 }else{
 	$Arama="";
 	$AramaSecimi="" ; 
 	$SayfalamaSecimi = "&Ara=";
 } 
 $SayfalarSolVeSagButonSayisi = 2;
 $GosterilecekKayitSayisi = 10;
 $ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? $AramaSecimi ORDER BY id Desc  ");
 $ToplamKayitSorgu->execute([1]);
 $ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
 $BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
 $SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);		
 ?>
 <?php
 if ($Arama!="") {
 ?>

 <?php
 $BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
 $BannerYan->execute([17,1]);
 $BannerYanVeri = $BannerYan->rowCount();
 $BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
 if ($BannerYanVeri>0) {
 ?>
 <div class="col-12 col-xl-12 text-center mt-5">
 	<div class="row justify-content-center align-items-center"  >				
 		<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 
 			
 		<?php
 		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
 		$BannerGuncelleme->execute([IcerikTemizle($BannerYanKayitlar["id"]) ]);	
 		?>	
 	</div>	
 </div>
<?php
}
?>		
 	
<div class="col-12  mt-5 mb-5 " >
 	<div class="row justify-content-center">
 		<div class="col-11 col-xl-8" >
 			<div class="row justify-content-center">
 				<div class="col-12 col-xl-9 mt-4" style="background: #202020">
 					<div class="row">
 						<div class="col-12">
 							<div class="row justify-content-start align-items-center text-center p-4">
 								<div class="col-12 text-left mb-5 loOpTys_" >
 									<span class="aIyTJNZx">"<?php echo IcerikTemizle($Arama) ?>" İçin Arama Sonuçları</span>
 								</div>
								<div class="col-6 col-xl-2 p-1 Uytm_QZMM__"  >
									<a style="color: white" href="haberlerara/<?php echo IcerikTemizle($Arama) ?> "><span>Haberler</span></a>
								</div>
								<div class="col-6 col-xl-2 p-1 Powt_aWY">
									<span>Oyunlar</span>
								</div>
 							</div>

 							<div class="p-0">
 								<div class="col-12 mb-5">
								<?php
								$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? $AramaSecimi ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
								$Oyunlar->execute([1]);
								$OyunlarVeri = $Oyunlar->rowCount();
								$OyunKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
 								if ($OyunlarVeri>0) {
 									foreach ($OyunKayitlar as  $kayitlar) {
 								?>
 									<div class="row p-0 mb-3 justify-content-center align-items-center">
 									<?php
 									if (file_exists("images/games/".IcerikTemizle($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]) ) {
 									?>
 										<div class="col-8 col-xl-3 p-0" style="background: black" >
 											<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
 												<img src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" class="img-fluid haberResim BackgroundBlack ao" >		
 											</a>
 										</div>
 									<?php
 									}else{
 									?>
 										<div class="col-8 col-xl-3 " >
 											<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">			
 												<img src="images/hata2.jpg" class="img-fluid haberResim BackgroundBlack" >
 											</a>
 										</div>
 									<?php
 									}
 									?>

									<div class="col-9 mt-2 col-xl-9">
										<div class="row">
											<div class="col-12 ">
												<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>"><span class="_XXx_ADgT">Oyun</span></a>
											</div>
											<div class="col-12">
												<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>"><h1 class="___RrSxX__aAeWq_"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h1></a>
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
												
												<div class="col-12 " ><?php echo PuanHesapla($OrtalamaPuan);?></div>
											<?php
											}else{		
											?>
												<div class="col-12  " ><?php echo PuanHesapla(0);?></div>
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
												<div class="col-12 mt-1">
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
 									</div>
 								</div>
 								<?php
 								}
 							}else{
 							?>
 								<div class="row justify-content-center align-items-center mb-5">
									<div class="col-12  text-center  mb-2" >
										<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
									</div>
									<div class="col-12 position-absolute text-center  mb-2" >
										<div class="row justify-content-center">
											<div class="col-12 col-xl-8">
												<h5 class="white">Aradığını oyunu bulamadık. Umarım bize darılmazsın. Ana sayfaya bir bak belki gönlünü alırız</h5>
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
 								echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='oyunara/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";				
 							}

 							for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
 								if( ($i>0)  and ($i<=$SayfaSayisi)  ){
 									if($Sayfalar==$i){
 									echo "<span class='p-2 bold' style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white' class='aktif p-3'>". $i . "</span>";
 									}else{
 										echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='oyunara/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
 									}
 								}
 							}
							if($Sayfalar!=$SayfaSayisi){
								echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href='oyunara/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
							}
							?>
 							</div>
 						<?php
 						}
 						?>
 					</div>
 				</div>
 			</div>
 		</div>
 					
		<?php
		$BannerYan = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=?");
		$BannerYan->execute([15,1]);
		$BannerYanVeri = $BannerYan->rowCount();
		$BannerYanKayitlar = $BannerYan->fetch(PDO::FETCH_ASSOC);
		if ($BannerYanVeri>0) {
		?>
		<div class="d-none d-xl-block col-3 mt-3 ">
			<div class="row justify-content-center align-items-center p-2"  >				
				<?php echo IcerikTemizle($BannerYanKayitlar["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme2->execute([IcerikTemizle($BannerYanKayitlar["id"]) ]);	
				?>
			</div>	
		</div>
		<?php
		}
 		?>			
 		</div>
 	</div>	
 </div>
</div>
 <script type="text/javascript">
 	$(".ao").css("display", "none");
 	$(".ao").fadeIn(1500);
 </script>
 <?php
 }else{
 	header('Location:' .$SiteLink );
 	exit();
 }
 ?>

 