<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunInceleme =  $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE   incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 ORDER BY incelemeler.Incelemeid DESC LIMIT 8");
	$OyunInceleme->execute([]);
	$OyunIncelemeVeri = $OyunInceleme->rowCount();
	$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunIncelemeVeri>0) {
	?>
	<div class="row p-1">
		<div class="col-12 " >
			<div class="row justify-content-center align-items-center" >
				<div class="col-12  mb-2">
					<div class="row p-2 justify-content-end align-items-center">
						<div class=" col-7 col-md-8 text-left  bGAfxXE " ><span >SON İNCELEMELER</span></div>
						<div class="col-5 col-md-4  p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="oyunincelemeler" ><span class=" gxPpxXo_">DAHA FAZLA GÖSTER</span></a></div>
					</div>
				</div>
				<div class="swiper-container swiper2">
	    			<div class="swiper-wrapper mb-3">
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
						<div class="col-9 col-md-6  mb-3 imgbrd" style="border-radius: 5px" >
							<div class="row align-items-end ">
								<div class="col-12 p-0 ">
								<?php
								if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
								?>
									<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
										<img  src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>"  alt="<?php echo IcerikTemizle($IncelemeKayitlar["Baslik"]);?>" title="<?php echo IcerikTemizle($IncelemeKayitlar["Baslik"]);?>" class="img-fluid lazy"  >	  
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
										<div class="col-12 fgdfyXx">
											<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
												<span class="bold white  mb-1 fgdfyXx incelemeb" ><?php	echo IcerikTemizle($IncelemeKayitlar["Baslik"]); ?></span> 
											</a>
										</div>
										<div class="col-12 ip mt-1">
											<figure class="m-0 p-0 mb-1">
												<?php 
												if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
												?>
													<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid"  alt="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
												<?php
												}else{
												?>
													<img src="images/user.png" class="img-fluid"  alt="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
												<?php
												}
												?>
												<figcaption >
													<span class="bold white odib">	<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?> </span>
												</figcaption>
											</figure>
											<figure class="m-0 p-0">
											    <?php
                                    			if($IncelemeKayitlar["Begeni"]!="" and $IncelemeKayitlar["Begeni"]!=0){
                                    			?>
                                    			  <span class="bold white font11  "><?php echo IcerikTemizle($IncelemeKayitlar["Begeni"]); ?> beğenme</span>
                                    			<?php
                                    			}
                                    			?>
											</figure>
											<figure class="m-0 p-0">
											    <?php
                                				$BegeniSayisi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE (Durum=? or Durum=?) and IncelemeId=? " );
                                        		$BegeniSayisi->execute([1,3,Guvenlik($IncelemeKayitlar["Incelemeid"])]);
                                        		$BegeniSayisiVeri = $BegeniSayisi->rowCount();
                                                if($BegeniSayisiVeri>0){
                                				?>
                        				            <span class=" white opacity07 font11 "><?php echo $BegeniSayisiVeri; ?> yorum</span>
                                				<?php
                                				}
                                				?>
											</figure>
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
			</div>
	  	</div>
  	</div>
	<?php
	}else{
	?>
	<div class="row p-1">
		<div class="col-12 " >
			<div class="row justify-content-center align-items-center" >
				<div class="col-12  mb-2">
					<div class="row p-2 justify-content-end align-items-center">
						<div class=" col-7  text-left  bGAfxXE " ><span >SON İNCELEMELER</span></div>
						<div class="col-5  p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="oyunincelemeler" ><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
					</div>
				</div>
				<div class="swiper-container swiper2">
	    			<div class="swiper-wrapper mb-3">
			    	<?php
    				for ($i=0; $i <8 ; $i++) { 
    				?>
        			<div class="swiper-slide ">
						<div class="col-7 col-xl-6  mb-3">
							<div class="row align-items-end">
	        					<div class="col-12 m-0 p-0" style="background: #202020;height: 400px"></div>
	        				</div>
	        			</div>
	        		</div>
    				<?php	
    				}
    				?>
					</div> 
				</div>
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





