<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	
	<?php
	$OyunIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE OyunId=? and Durum=? ");
	$OyunIncelemeKontrol->execute([Guvenlik($IncelemeSorgusuKayitlar["OyunId"]),1]);
	$OyunIncelemeKontrolVeri = $OyunIncelemeKontrol->rowCount();
	if ($OyunIncelemeKontrolVeri>0) {
	?>
	<div class="col-12 mt-1 mb-3 m-0 p-0">
		<div class="row justify-content-center align-items-center m-0 ">
			<div class="col-12 p-3 asdxzcbzxcvZX mb-2 ">
				<span class="bold white idetaya"> <?php echo  IcerikTemizle($OyunBilgilerKayit["OyunAdi"]); ?> İncelemeleri</span>
			</div>

			<div class="col-12  p-2 asdxzcbzxcvZX">
			<?php
			if ($OyunIncelemeKontrolVeri>=4) {
			?>	
				<div class="row p-3 justify-content-end">
					<div class="col-5 p-1 text-center ErYTIxKL">
						<a href="oyunincelemeler/&Ara=<?php echo IcerikTemizle($OyunBilgilerKayit["OyunAdi"]) ?>/1" style="text-decoration: none">
							<span class=" gxPpxXo_ font10"> DAHA FAZLA GÖSTER</span>
						</a>
					</div>
				</div>
			<?php
			}
			?>

			<div class="row  align-items-center m-0">
				<div class="swiper-container swiper5" >
					<div class="swiper-wrapper">
					<?php	
					$OyunInceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.OyunId=?  and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? LIMIT 4");
					$OyunInceleme->execute([Guvenlik($IncelemeSorgusuKayitlar["OyunId"]),1,1,1]);
					$OyunIncelemeVeri = $OyunInceleme->rowCount();
					$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);
					if ($OyunIncelemeVeri>0) {
						foreach ($OyunIncelemeKayitlar as  $IncelemeKayitlar) {
							$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
							$OyunAdi->execute([Guvenlik($IncelemeKayitlar["OyunId"])]);
							$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

							$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
							$KuratorAdi->execute([Guvenlik($IncelemeKayitlar["KuratorId"])]);
							$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="swiper-slide ">
						<div class="col-9  mb-3 ">
							<div class="row p-1">
								<div class="col-12">
									<div class="row align-items-end">
										<div class="col-12 p-0 " style="background: black"   >
										<?php
										if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
										?>
											<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
												<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05" alt="<?php echo  IcerikTemizle($IncelemeKayitlar["Baslik"]); ?>"  title="<?php echo  IcerikTemizle($IncelemeKayitlar["Baslik"]); ?>" >	  
											</a>
										<?php
										}else{
										?>	
											<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
												<img src="images/resim.jpg" class="img-fluid ">		
										  	</a> 
										<?php
										}
										?>
										</div>

										<div class="col-12 position-absolute p-0 dsxzhdrt">
											<div class="row align-items-center p-2 ">
												<div class="col-12 mt-5 hgbnzXX ">
													<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
														<span  class="hgbnzXX bold white incelemeb mb-1" >
														
															<?php	echo IcerikTemizle($IncelemeKayitlar["Baslik"]); ?>
														
														</span> 
													</a>
													<p class="p-0 m-0">
														<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
														<?php 
														if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="")) {
														?>
															<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid adzxbyZXC" title="<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]);?>">
														<?php
														}else{
														?>
															<img src="images/user.png" class="img-fluid ZXMHXCJ" >
														<?php
														}
														?>
															<span class="bold white odib">
																<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>  
															</span>
															
														</a>
													</p>
													
												</div>
												<div class="col-12">
											    <?php
                                    			if($IncelemeKayitlar["Begeni"]!="" and $IncelemeKayitlar["Begeni"]!=0){
                                    			?>
                                    			  <span class="bold white font11  "><?php echo IcerikTemizle($IncelemeKayitlar["Begeni"]); ?> beğenme</span><br>
                                    			<?php
                                    			}
                                    			?>
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
					}
					?>
					</div>
					<div class="col-12 text-center swiper-pagination5 mt-2 "></div>
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





