 <?php
 if(isset($_REQUEST["Ara"])){
 	$Arama =Guvenlik($_REQUEST["Ara"]);
 	$AramaSecimi = "AND ( AnaBaslik LIKE '%" . $Arama . "%'  )";
 	$SayfalamaSecimi = "&Ara=" . $Arama ; 
 }else{
 	$Arama="";
 	$AramaSecimi="" ; 
 	$SayfalamaSecimi = "";
 } 
 $SayfalarSolVeSagButonSayisi = 2;
 $GosterilecekKayitSayisi = 10;
 $ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id Desc  ");
 $ToplamKayitSorgu->execute([1]);
 $ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
 $BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
 $SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);		
 ?>
 <?php
 if(IcerikTemizle($Arama)!=""){
 ?>

<?php
$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
$BannerUst->execute([16,1]);
$BannerUstVeri = $BannerUst->rowCount();
$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
if ($BannerUstVeri>0) {
?>
	<div class="col-12 col-xl-12 text-center   mt-5">
		<div class="row justify-content-center align-items-center"  >
		<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
		<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([IcerikTemizle($BannerUstKayitlar["id"]) ]);	
		?>	
		</div>	
	</div>
<?php
}
?>

 <div class="col-12 mt-5 mb-5">
 	<div class="row justify-content-center">
 		<div class="col-11 col-xl-8">
 			<div class="row justify-content-center">
 				<div class="col-12 col-xl-9 mt-4 wWfVCA">
 					<div class="row">
 						<div class="col-12">
 							<div class="row justify-content-start align-items-center text-center p-4">
 								<div class="col-12 text-left mb-5 _aA_zXxCV__aF" >
 									<span class="bold white font14">"<?php echo IcerikTemizle($Arama) ?>" İçin Arama Sonuçları</span>
 								</div>
 								<div class="col-6 col-xl-2 p-1 ooOiKLMZ_AeR" >
 									<span> Haberler</span>
 								</div>
 								<div class="col-6 col-xl-2  p-1 rmtQzSwe_" >
 									<a style="color: white" href="oyunarama/<?php echo IcerikTemizle($Arama)?>">
 										<span>Oyunlar</span>
 									</a>
 								</div>
 							</div> 

 							<div class="p-0">
 								<div class="col-12">
 								<?php
 								$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
 								$Haberler->execute([1]);
 								$Data = $Haberler->rowCount();
 								$HaberKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
 								if ($Data>0) {
 									foreach ($HaberKayitlar as  $kayitlar) {
 								?>
 									<div class="row p-0 justify-content-center align-items-center">
 									<?php
 									if (file_exists("images/news/".IcerikTemizle($kayitlar["AnaResim"])) and (IcerikTemizle($kayitlar["AnaResim"])) ) {
 									?>
 										<div class="col-12 col-xl-3 p-0" style="background: black" >
 											<a href="haberdetay/<?php echo SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
 												<img src="images/news/<?php echo IcerikTemizle($kayitlar["AnaResim"]);?>" class="img-fluid haberResim ha">
 											</a>
 										</div>
									<?php
									}else{
										?>
										<div class="col-12 col-xl-3 " >
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
												<img src="images/hata2.jpg" class="img-fluid haberResim " >
											</a>
										</div>
									<?php
									}
									?>
	 									<div class="col-12 mt-2 col-xl-9">
	 										<div class="row">
	 											<div class="col-12">
	 												<a  href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>"><span class="zXxVBVa_">Haber</span></a>
	 											</div>
	 											<div class="col-12  uxmcvbCCX" >
	 												<a  href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["id"]); ?>">
	 													<h1 class="lkmKIIazX"><?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?></h1>
	 												</a>
	 											</div>
	 											<div class="col-12  __zxCxxVAa__" >
	 												<i class="fas fa-clock"></i> <?php echo  time_ago(IcerikTemizle($kayitlar["KayitTarihi"]));?> 
	 											</div>
	 										</div>
	 									</div>	
 									</div>
 									<div class="col-12 mt-3 mb-3 X_zX_awWeeR" ></div>
 								<?php
 								}
 								}else{
 								?>

 									<div class="row justify-content-center align-items-center mb-5">
										<div class="col-12 text-center  mb-2" >
											<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
										</div>
										<div class="col-12 position-absolute text-center  mb-2" >
											<div class="row justify-content-center">
												<div class="col-12 col-xl-8">
													<h5 class="white">Aradığını haberi bulamadık. Umarım bize darılmazsın. Ana sayfaya bir bak belki gönlünü alırız</h5>
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
 								<div class="col-12 text-center mt-3  p-4">
 								<?php
 								if($Sayfalar>1 ){
 									echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='haberara/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";	
 								}

								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='p-2  bold  '   style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white ' class='aktif p-3'>". $i . "</span>";
										}else{
											echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='haberara/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
										}
									}
 								}

								if($Sayfalar!=$SayfaSayisi){		
									echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href='haberara/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
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
 				$BannerYan->execute([14,1]);
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
<?php
}else{
	header('Location:' .$SiteLink );
	exit();
}
?>
<script type="text/javascript">
	$(".ha").css("display", "none");
	$(".ha").fadeIn(1500);
</script>