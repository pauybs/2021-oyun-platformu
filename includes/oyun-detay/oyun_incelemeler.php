<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunInceleme =  $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.OyunId=?  and incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 ORDER BY incelemeler.Goruntulenme DESC LIMIT 4 ");
	$OyunInceleme->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunIncelemeVeri = $OyunInceleme->rowCount();
	$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunIncelemeVeri>0) {
	?>
	<div class="row justify-content-center  p-3 p-xl-5  ">
		<div class="col-12 SAFfXxAERz bGAfxXE mb-2" >
			<h6 class="m-0 bold white oyunYazi">İncelemeler</h6>
		</div>
		<div class="col-12 mt-1">
			<div class="row justify-content-center align-items-center ">
			<?php
			$OyunIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.OyunId=?  and incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 ORDER BY incelemeler.Begeni DESC");
			$OyunIncelemeKontrol->execute([Guvenlik($OyunSorgusuKayit["id"])]);
			$OyunIncelemeKontrolVeri = $OyunIncelemeKontrol->rowCount();
			if ($OyunIncelemeKontrolVeri>4) {
			?>	
				<div class="col-12 mb-2">
					<div class="row justify-content-end">
						<div class="col-6 col-xl-3 p-1 text-center ErYTIxKL WrGYT__Xx">
							<a href="oyunincelemeler/&Ara=<?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]) ?>/1">
								<span class="gxPpxXo_">DAHA FAZLA GÖSTER</span>
							</a>
						</div>
					</div>
				</div>
			<?php
			}
			?>
            <div class="swiper-container swiper9" >
        	    <div class="swiper-wrapper">
				<?php
				foreach ($OyunIncelemeKayitlar as  $IncelemeKayitlar) {
				$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
				$OyunAdi->execute([Guvenlik($IncelemeKayitlar["OyunId"])]);
				$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

				$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
				$KuratorAdi->execute([Guvenlik($IncelemeKayitlar["KuratorId"])]);
				$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
				?>
				<div class="swiper-slide ">
				<div class="col-9 col-md-12   mb-3" >
					<div class="row p-1  ">
						<div class="col-12 imgbrd" style"border-radius:5px" >
							<div class="row align-items-end " >
								<div class="col-12 p-0 " style="background: black">
								<?php
								if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
								?>
									<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
										<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity07"  >	  
									</a>
								<?php
								}else{
								?>	
									<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
										<img src="images/resim.jpg" class="img-fluid">		 
									 </a> 
								<?php
								}
								?>
								</div>

								<div class="col-12 position-absolute p-0 asjfhete">
									<div class="row align-items-center p-2 ">
										<div class="col-12 mt-5  " >
											<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
												<p  class="bold white odib mb-1 fgdfyXx" >
													<?php echo  IcerikTemizle($IncelemeKayitlar["Baslik"]); ?> 
												</p> 
											</a>
											<div class="col-12 ip mt-1 p-0">
												<figure>
													<p class="p-0 m-0">
														<a style="color: white" href="kurator/<?php echo $KuratorAdiKayitlar["KullaniciAdi"]; ?>">
															<?php 
															if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid " >
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid " >
															<?php
															}
															?>
															<figcaption >
																<span class="bold white odib">
																	<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?> 
																</span>
															</figcaption>
														</a>
													</p>														
												</figure>
											</div>	
										</div>
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
			<div class="col-12 text-center  swiper-pagination9"></div>
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





