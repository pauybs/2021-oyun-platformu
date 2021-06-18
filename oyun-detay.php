
<?php
require_once("settings/connect.php");
if(isset($_GET["ID"])  and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){
	$OyunId =Guvenlik($_GET["ID"]);	
	$OyunSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
	$OyunSorgusu->execute([$OyunId,1]);
	$OyunSorgusuSayi = $OyunSorgusu->rowCount();
	$OyunSorgusuKayit = $OyunSorgusu->fetch(PDO::FETCH_ASSOC);
	if($OyunSorgusuSayi>0){
		$OyunGoruntulenme =  $DatabaseBaglanti->prepare("UPDATE oyunlar SET Goruntulenme=Goruntulenme+1  WHERE  id=? AND Durum=? LIMIT 1 ");
		$OyunGoruntulenme->execute([$OyunSorgusuKayit["id"],1]);
		$OyunGoruntulenmeSayisi = $OyunGoruntulenme->rowCount();
	?>
		<?php
		$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=?");
		$BannerUst->execute([13,1]);
		$BannerUstVeri = $BannerUst->rowCount();
		$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
		if ($BannerUstVeri>0) {	
		?>
		<div class="col-12  mb-3  mt-5 d-none d-md-block">
			<div class="row justify-content-center align-items-center text-center"  >	
				<div class="col-9">			
					<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 			
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([13]);	
					?>		
				</div>	
			</div>
		</div>
		<div class="col-12   mt-5 d-block d-md-none">
			<div class="row justify-content-center align-items-center text-center"  >	
				<div class="col-11">			
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
	
	<?php
	if ($OyunSorgusuKayit["Uyari"]==1) {
		if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
	    ?>
	        <?php
	        if( isset($_SESSION["warning"]) and ($_SESSION["warning"])==0){
	        ?>
	            <style type="text/css">.swal-overlay {background-color: black; } </style>
        		<script type="text/javascript">
        			swal({
        				title: "Bu Oyun Yalnızca +18 Yaş Grubu İçin Uygundur.",
        				icon: "info",
        				closeOnClickOutside: false,
        				buttons: [false, "Devam Et"],
        			})
        			.then((willDelete) => {
					  if (willDelete) {
					      <?php
					       $_SESSION["warning"]=1;
					      ?>
					
				        }
					});
        	    </script>
	        <?php
	        }
	        ?>
	    <?php
	    }else{
	    ?>
	        <style type="text/css">.swal-overlay {background-color: black; } </style>
			<script type="text/javascript">
				swal({
					title: "Bu Oyun Yalnızca +18 Yaş Grubu İçin Uygundur.",
					icon: "info",
					closeOnClickOutside: false,
					buttons: [false, "Devam Et"],
				})
	    	</script>
	    <?php
	    }
	    ?>
	<?php
	}
	?>
	<script src="settings/Chart.min.js"></script>
	<script src="settings/chartjs-plugin-datalabels.js"></script>
	<div class="col-12">
		<?php	
		include 'includes/oyun-detay/oyun_resimler.php';
		?>
	</div>
	
	<div class="col-12">
		<div class="row m-0 justify-content-center mt-5 mb-5">
			<div class="col-xl-9 text-right mb-1">
			<?php	
			include 'includes/oyun-detay/favori_buton.php';
			?>				
			</div>

			<div class="col-11 col-xl-9 aaYTbZHa">
				<div class="row justify-content-center mt-5" >
					<div class=" col-12  mb-4">
						<div class="row justify-content-center align-items-center text-center p-1 ">
							<div class="col-9 col-xl-2">
								<div class="row">
									<?php
									if (file_exists("images/games/".$OyunSorgusuKayit["AnaResim"]) and ($OyunSorgusuKayit["AnaResim"])) {
									?>
									<div class="col-12 ">
										<img src="images/games/<?php echo IcerikTemizle($OyunSorgusuKayit["AnaResim"]) ?>" class="img-fluid loYtzXw odr"  style="width: 100%; height: auto" alt="<?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]); ?>" >
									</div>
									<?php
									}else{
									?>
									<div class="col-12">
										<img src="images/resim.jpg" class="img-fluid loYtzXw" >
									</div>
									<?php
									}
									?>
									<div class="col-12 text-center mt-3">
										<h1 class="bold white oyunname" ><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?></h1>
									</div>
									<?php
									$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
									$ToplamPuan->execute([Guvenlik($OyunSorgusuKayit["id"])]);
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
								</div>
							</div>
							<div class="col-12 col-xl-10 text-center "    >
							<?php
							if (IcerikTemizle($OyunSorgusuKayit["OyunHakkinda"])) {
							?>
								<p class="bold white oyunYazi mt-2">
									<?php echo IcerikTemizle($OyunSorgusuKayit["OyunHakkinda"]);?> 
								</p>
							<?php
							}
							?>
							</div>		
						</div>
					</div>
				<div class="col-2"></div>
				<div class="col-11 col-xl-10 p-0 m-0" >
					<div class="row  justify-content-center">
						<div class="col-12">
							<div class="row justify-content-center">
								<div class="col-12 ksayXtAS">
									<?php	
									include 'includes/oyun-detay/oyun_hakkinda.php';
									?>	
								</div>
								<div class="col-12  mt-5 ksayXtAS" >
									<?php	
									include 'includes/oyun-detay/oyun_videolar.php';
									?>	
								</div>
								<div class="col-12 mt-5  ksayXtAS" >
									<?php	
									include 'includes/oyun-detay/oyun_karakterler.php';
									?>	
								</div>

								<div class="col-12  mt-5 ksayXtAS" >
									<?php	
									include 'includes/oyun-detay/oyun_oduller.php';
									?>	
								</div>


								<?php
								$BannerAlt = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
								$BannerAlt->execute([18,1]);
								$BannerAltVeri = $BannerAlt->rowCount();
								$BannerAltKayitlar = $BannerAlt->fetch(PDO::FETCH_ASSOC);
								if ($BannerAltVeri>0){
								?>
								<div class="col-11 mt-5"  >
									<div class="row justify-content-center align-items-center" >
										<div class="col-11">
											<div class="row">
												<?php echo IcerikTemizle($BannerAltKayitlar["BannerKodu"]); ?> 
												<?php
												$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
												$BannerGuncelleme2->execute([18]);	
												?>	
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>

								<div class="col-12 mt-5 ksayXtAS">
									<?php	
									include 'includes/oyun-detay/oyun_sistem.php';
									?>
								</div>

								<div class="col-12 mt-5 ksayXtAS " >
									<?php	
									include 'includes/oyun-detay/oyun_diller.php';
									?>
								</div>

								<?php
								$BannerAlt = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
								$BannerAlt->execute([18,1]);
								$BannerAltVeri = $BannerAlt->rowCount();
								$BannerAltKayitlar = $BannerAlt->fetch(PDO::FETCH_ASSOC);
								if ($BannerAltVeri>0){
								?>
								<div class="col-11 mt-5"  >
									<div class="row justify-content-center align-items-center" >
										<div class="col-11">
											<div class="row">
												<?php echo IcerikTemizle($BannerAltKayitlar["BannerKodu"]); ?> 
												<?php
												$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
												$BannerGuncelleme2->execute([18]);	
												?>	
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								?>

								<div class="col-12 mt-5 ksayXtAS">
									<?php	
									include 'includes/oyun-detay/oyun_satisbaglantilari.php';
									?>
								</div>

								<div class="col-12 mt-5 ksayXtAS" >
									<?php	
									include 'includes/oyun-detay/oyun_incelemeler.php';
									?>
								</div>

								<div class="col-12 mt-5 ksayXtAS" >
									<?php	
									include 'includes/oyun-detay/oyun_haberler.php';
									?>
								</div>

								<div class="col-12 mt-5 ksayXtAS">
									<?php	
									include 'includes/oyun-detay/oyun_degerlendirme.php';
									?>
								</div>

									
								<div class="col-12 mt-5 ksayXtAS" >
									<div class="row justify-content-center  p-xl-5">
										<div class="col-12" >
										    <div class="row  p-3 ">
										        <div class="col-12 SAFfXxAERz bGAfxXE" >
										        <h6 class="m-0 bold white oyunYazi">Yorumlar (<?php echo IcerikTemizle($OyunSorgusuKayit["YorumSayisi"]);  ?>)</h6>
										        </div>
										    </div>
											
										</div>
										<div class="col-12  " >
											<div class="row justify-content-center align-items-center text-center">
											<?php
											if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
											?>
												<div class="col-12 mt-4">
													<form class="text-center haberYorum" id="oyuny" action="javascript:void(0);" method="post">
														<div class="group2">
															<div class="row  align-items-center mb-1">
																<div class="col-12 up">
																	<figure>
																  	<?php
																	if(file_exists("images/userphoto/".IcerikTemizle($KullaniciProfilResmi)) and (IcerikTemizle(isset($KullaniciProfilResmi))) and (IcerikTemizle($KullaniciProfilResmi)!="") ){
																	?>
																		<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid  userp" >
																	<?php
																	}else{
																	?>
																		<img src="images/user.png" class="img-fluid userp " >
																	<?php
																	}
																	?>
																	
																		<figcaption>
															  				<span class=" white bold  oyunYazi "><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
																		</figcaption>															
																	</figure>
																</div>	
															</div>
															<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."></textarea>  
															<input type="hidden" name="o"  value="<?php echo  IcerikTemizle($OyunSorgusuKayit["id"]); ?>">
															<input type="hidden" name="ui" value="<?php echo IcerikTemizle($OyunId); ?>">
															<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">    
															<span class="highlight"></span>
															<span class="bar"></span>
														</div>
														<div class="col-12 p-0  mt-3 text-right oyb">
															<button class="call-to-action2" type="submit" id="oyg"  >
																<div>
																	<div class="">Gönder</div>
																</div>
															</button>
														</div>
													</form>
												</div>
											<?php	
											}else{
											?>
												<div class="col-12 mt-4 haberYorum">
													<div class="group2">
														<div class="col-12 mb-2 p-0 lıyTQMZLD text-left white oyunYazi" >
															<span>Yorum yapmak için</span> 
															<a href="girisyap"  style="color: #c28f2c">
																<span class="oyunYazi" style="">giriş yap.</span>
															</a>
														</div> 
														<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
														<span class="highlight"></span>
														<span class="bar"></span>
													</div>
													<div class="col-12  mt-3  p-0  text-right " >
														<button class="call-to-action2 " >
															<div>
																<div>Gönder</div>
															</div>
														</button>
													</div>
												</div>
											<?php
											}
											?>
											</div>
										</div>
										
										<div class="col-12  mb-5 ">
											<div class="yorumlar"></div>
											<?php	
											include 'includes/oyun-detay/oyun_yorumlar.php';
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
		</div>
	</div>
	<link rel="stylesheet" href="settings/swiper-bundle.min.css">
	<script src="settings/swiper-bundle.min.js"></script>

	<?php
	if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
		if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
			if ($Zaman>=$KullaniciYorumBanTarih) {
				$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
				$BanKaldir->execute([0,NULL,$KullaniciId]);
				$BanKaldirSayisi = $BanKaldir->rowCount();
				if ($BanKaldirSayisi>0) {
					header("Refresh:0");
					exit();
				}
			}
		}
	?>
	<script src="assets/main_g=5.1.5.js"></script> 		
	<?php
	}
	?>

	<script type="text/javascript">
		$(".odr").css("display", "none");
		$(".odr").fadeIn("slow");
		$(".ody").css("display", "none");
		$(".ody").show("slow");
		$(".odyc").css("display", "none");
		$(".odyc").show("slow");
	</script>

	<script type="text/javascript">
		let ctx = document.getElementById('myChart').getContext('2d');
		let labels = ['Çok Olumsuz', 'Olumsuz', 'Kararsız', 'Olumlu',"Çok Olumlu"];
		let colorHex = ['#FB3640', '#EFCA08', '#43AA8B', '#253D5B'];
		let myChart = new Chart(ctx, {
		type: 'pie',
		data: {
		datasets: [{
			data: [<?php echo $CokOlumsuzOrtalama ?>,<?php echo $OlumsuzOrtalama ?>,<?php echo $KararsizOrtalama ?>,<?php echo $OlumluOrtalama ?>,<?php echo $CokOlumluOrtalama ?>],
			backgroundColor: colorHex
		}],
		labels: labels,
		},
		options: {
		responsive: true,
		legend: {
			position: 'right'
		},
		plugins: {
			datalabels: {
			color: '#fff',
			anchor: 'end',
			align: 'end',
			offset: -30,
			borderWidth: 2,
			borderColor: '#fff',
			borderRadius: 10,
			weight:'bold',
			backgroundColor: (context) => {
				return context.dataset.backgroundColor;
			},
			font: {
				weight: 'bold',
				size: '10',
			},
			formatter: (value) => {
				return value + ' %';
			}
			}
		}
		}
		})
	</script>

	<script type="text/javascript">
	$('body').on('click' , '.dvm', function() {
		$('.y').removeClass("sozsXzv");
		$('.d').remove();
	});
	</script>
	<script type="text/javascript">
	$('body').on('click' , '.lng', function() {
		$('.lngt').removeClass("gamlngtbl");
		$('.lng').remove();	
	});
	</script>
	<?php
	}else{
		header('Location: '.$SiteLink );
		exit();
	}
}else{
	header('Location: '.$SiteLink);
	exit();
}
?>


