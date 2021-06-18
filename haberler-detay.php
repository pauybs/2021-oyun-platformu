<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_GET["ID"]) ){
	$HaberId =Guvenlik($_GET["ID"]);	
	$HaberSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum=? LIMIT 1 ");
	$HaberSorgusu->execute([$HaberId,1]);
	$HaberSorgusuSayi = $HaberSorgusu->rowCount();
	$HaberSorgusuKayit = $HaberSorgusu->fetch(PDO::FETCH_ASSOC);
	if($HaberSorgusuSayi>0){
		if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
			if ($HaberSorgusuKayit["Editor"] != $KullaniciId) {
				$HaberGoruntulenme=$DatabaseBaglanti->prepare("UPDATE haberler SET Goruntulenme=Goruntulenme+1 WHERE id=? AND Durum=? LIMIT 1 ");
				$HaberGoruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),1]);
				$HaberGoruntulenmeSayisi = $HaberGoruntulenme->rowCount();
				
				$HaberGunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE haberler SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE id=? AND Durum=? LIMIT 1 ");
				$HaberGunlukGoruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),1]);
				$HaberGunlukGoruntulenmeSayisi = $HaberGunlukGoruntulenme->rowCount();
			}
		}else{
			$HaberGoruntulenme = $DatabaseBaglanti->prepare("UPDATE haberler SET Goruntulenme=Goruntulenme+1  WHERE  id=? AND Durum=? LIMIT 1 ");
			$HaberGoruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),1]);
			$HaberGoruntulenmeSayisi = $HaberGoruntulenme->rowCount();
			
			$HaberGunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE haberler SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE id=? AND Durum=? LIMIT 1 ");
			$HaberGunlukGoruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),1]);
			$HaberGunlukGoruntulenmeSayisi = $HaberGunlukGoruntulenme->rowCount();
		}
	?>

	<?php
		$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["Editor"])),1,1]);
		$EditorSayi = $Editor->rowCount();
		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
		if ($EditorSayi>0) {
			$EditorIsim= IcerikTemizle($EditorKayit["AdSoyad"]);
			$EditorKullaniciAdi= IcerikTemizle($EditorKayit["KullaniciAdi"]);
			
		}else{
			$EditorIsim="";
			$EditorKullaniciAdi="";

		}
	?>

	<?php
	$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=? ORDER BY GosterimSayisi LIMIT 1");
	$BannerUst->execute([9,1]);
	$BannerUstVeri = $BannerUst->rowCount();
	$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
	if ($BannerUstVeri>0) {
	?>
	<div class="col-12  text-center mb-1  mt-5 d-none d-md-block">
		<div class="row justify-content-center align-items-center"  >
		    <div class="col-9  text-center mb-1  mt-5">
			<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([9 ]);	
			?>	
			</div>
		</div>	
	</div>
	<div class="col-12  text-center mb-1  mt-5  d-block d-md-none">
		<div class="row justify-content-center align-items-center"  >
		    <div class="col-12  text-center mb-1  ">
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

	<div class="col-12 p-0  mb-5 mt-3" >
		<div class="row justify-content-center m-0  mb-5 ">
			<div class="col-11 col-md-7  ">
				<div class="row justify-content-center align-items-center wWfVCA mb-5" >
					<div class="col-12 text-left white mb-2 mt-4 yaziAlan">
					    <ul class="hm yaziAlan">
					        <li><a href="<?php echo IcerikTemizle($SiteLink); ?>">Anasayfa</a></li>
					        <li> <i class="fas fa-angle-right" ></i> <a href="haber">Haber</a> </li>
					        <li class="bold "> <i class="fas fa-angle-right"></i> <?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?></li>
					    </ul>
					</div>
					<?php
					if (IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) {
					?>	
						<div class="col-12  mt-2">
							<h1 class="white bold haberDetayBaslik" >
								<?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?>
							</h1>
						</div>
					<?php
					}
					?>
					<div class="col-12 text-left white mb-2">
					    <a href="editor/<?php echo IcerikTemizle($EditorKullaniciAdi);?>"><span class=" white bold haberdra tyrzZazC opacity07"> <?php echo IcerikTemizle($EditorIsim);?></span></a>
					    <span  class="white haberdra opacity05">—</span>
						<span class="white haberdra opacity05" > 
        					<?php echo time_ago(IcerikTemizle($HaberSorgusuKayit["KayitTarihi"])); ?>
        				</span>
					</div>

					<?php
					if ( IcerikTemizle($HaberSorgusuKayit["AnaResim"]!="") and IcerikTemizle(isset($HaberSorgusuKayit["AnaResim"])) and (file_exists("images/news/".IcerikTemizle($HaberSorgusuKayit["AnaResim"])))) {
					?>	
						<div class="col-12 mb-3">
							<img src="images/news/<?php echo IcerikTemizle($HaberSorgusuKayit["AnaResim"]); ?>" alt="<?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?>" title="<?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?>" class="img-fluid hdr" style="width: 100%; height: auto">
						</div>
					<?php
					}else{
					?>
						<div class="col-12 mb-3" style="background: #202020">
							<img src="images/hata2.jpg" class="img-fluid hdr" style="width:100%">
						</div>
					<?php
					}
					?>

					<div class="col-12 mb-4">
						<div class="row justify-content-center align-items-center ">
							<div class="col-7">
								<?php
								include 'includes/haberdetay/paylasim_butonlar.php';
								?>
							</div>	
							<div class="col-5 white">
								<?php
								include 'includes/haberdetay/favori_buton.php';
								?>
							</div>
						</div>
					</div>
					
					<?php
					if (IcerikTemizle($HaberSorgusuKayit["AnaAciklama"])) {
					?>	
						<div class="col-12 mb-4">
							<p class="white haberda uyZRQwZX"  ><?php echo IcerikTemizle($HaberSorgusuKayit["AnaAciklama"]); ?></p>
						</div>
					<?php
					}
					?>

					<?php
					if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
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
					<script src="assets/main_n=3.1.4.js"></script>
					<?php
					}
					?>

					<div class="col-12">
						<div class="row">
							<?php
							include 'includes/haberdetay/haber_resimler.php';
							?>
						</div>
					</div>
					

					<?php
					if (IcerikTemizle($HaberSorgusuKayit["KaynakUrl"])) {
						?>	
						<div class="col-12   mb-4">
							<p>
								<span  class="bold white haberdra">Kaynak:</span> 
								<a href="<?php echo IcerikTemizle($HaberSorgusuKayit["KaynakUrl"]); ?>" target="_blank">
									<span  style="color: #c28f2c;" class="haberdra" ><?php echo IcerikTemizle($HaberSorgusuKayit["KaynakUrl"]); ?></span>
								</a>
							</p>
						</div>
					<?php
					}
					?>	
                    
                    <?php
                	$BannerHaber = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=? ORDER BY GosterimSayisi LIMIT 1");
                	$BannerHaber->execute([49,1]);
                	$BannerHaberVeri = $BannerHaber->rowCount();
                	$BannerHaberKayitlar = $BannerHaber->fetch(PDO::FETCH_ASSOC);
                	if ($BannerHaberVeri>0) {
                	?>
            		<div class="col-12  text-center mb-4  mt-3">
            			<div class="row justify-content-center align-items-center"  >
            				<?php echo IcerikTemizle($BannerHaberKayitlar["BannerKodu"]); ?> 
            				<?php
            				$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
            				$BannerGuncelleme->execute([49]);	
            				?>		
            			</div>	
            		</div>
                	<?php
                	}
                	?>
				</div>

				<div class="row">
					<?php
					include 'includes/haberdetay/ilgili_haber.php';
					?>
				</div>
				
				<div class="row mt-2">
					<?php
					include 'includes/haberdetay/ilgili_oyun.php';
					?>
				</div>
				
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
			
		
			
				<div class="row mt-5" style="background:#202020">	
				    <div class="col-12 mt-5">
						<div class="row">
							<div class="col-12">
								<span  style="color:#c28f2c; " class="bold  haberdra">Yorumlar (<?php echo IcerikTemizle($HaberSorgusuKayit["YorumSayisi"]); ?>)</span>
							</div>

							<?php
							if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
							?>
							<div class="col-12 mt-4 text-center haberYorum">
								<form id="habery"  action="javascript:void(0);" method="post" >
									<div class="group2">
										<div class="row  align-items-center mb-2  align-items-center">
											<div class="col-12 up ">
												<figure>
											  	<?php
												if(file_exists("images/userphoto/".IcerikTemizle($KullaniciProfilResmi)) and (IcerikTemizle(isset($KullaniciProfilResmi))) and (IcerikTemizle($KullaniciProfilResmi)!="") ){
												?>
													<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid ml-2 userp" title="<?php echo IcerikTemizle($KullaniciAdi); ?>">
												<?php
												}else{
												?>
													<img src="images/user.png" class="img-fluid userp " title="<?php echo IcerikTemizle($KullaniciAdi); ?>" title="<?php echo IcerikTemizle($KullaniciAdi); ?>">
												<?php
												}
												?>
													<figcaption>
										  				<span class=" white bold haberdra tyrzZazC ">
										  					<?php echo IcerikTemizle($KullaniciAdiSoyadi);?>
										  				</span>
													</figcaption>															
												</figure>
											</div>	
										</div>
										<div  class="text-left" id="hys"></div>
										<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."  ></textarea>  
										<input type="hidden" name="ui"  value="<?php echo IcerikTemizle($HaberId) ?>">    
										<input type="hidden" name="h"  value="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>">    
										<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
										<span class="highlight"></span>
										<span class="bar"></span>
									</div>
									<div class="col-12 p-0  mt-3 text-right hyb">
										<button class="call-to-action2" type="submit" id="hyg"  >
											<div>
												<div>Gönder</div>
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
									<div class="col-12 mb-2 p-0 white bold haberdra" >
										<span>Yorum yapmak için</span> 
										<a href="girisyap"  style="color: #c28f2c">
											<span style="">giriş yap.</span>
										</a>
									</div> 
									<textarea  placeholder="Yorumunuzu yazın..."  required></textarea>      
									<span class="highlight"></span>
									<span class="bar"></span>
								</div>
								<div class="col-12  mt-3  p-0  text-right " >
								<a href="girisyap"  >	<button class="call-to-action2" >
										<div>
											<div>GİRİŞ YAP</div>
										</div>
									</button></a>
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
						include 'includes/haberdetay/haber_yorumlar.php';
						?>
					</div>
				</div>
			</div>

			<div class="d-none d-md-block col-2 "  >
				<div class="row justify-content-center align-items-center  p-1">
					<div class="col-12 white ">
			    	<?php
					include 'includes/okunan_haberler.php';
			    	?>
					</div>
					<div class="col-10">
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

		
	<script type="text/javascript">
	$(".hdr").css("display", "none");
	$(".hdr").fadeIn("slow");

	$(".hdy").css("display", "none");
	$(".hdy").show("slow");

	$(".hdyc").css("display", "none");
	$(".hdyc").show(1100);
	</script>
	<?php
	}else{
		header('Location: ' .$SiteLink );
		exit();
	}
}else{
	header('Location: ' .$SiteLink );
	exit();
}
}else{
	header('Location: ' .$SiteLink );
	exit();
}
?>

