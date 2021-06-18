<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$KuratorIncelemeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? and Durum=?");
	$KuratorIncelemeKontrol->execute([Guvenlik($IncelemeSorgusuKayitlar["KuratorId"]),1]);
	$KuratorIncelemeKontrolVeri = $KuratorIncelemeKontrol->rowCount();
	if ($KuratorIncelemeKontrolVeri>0) {
	?>
	<div class="col-12  mb-3 m-0 p-0">
		<div class="row  justify-content-center align-items-center m-0">
			<div class="col-12  p-3  asdxzcbzxcvZX mb-2"  >
				<span class="bold white idetaya">Kürator İncelemeleri</span>
			</div>
			<div class="col-12  p-2 asdxzcbzxcvZX" >
				<?php
				if ($KuratorIncelemeKontrolVeri>=4) {
				?>	
					<div class="row p-3 justify-content-end">
						<div class="col-5  p-1 text-center ErYTIxKL" >
							<a href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>" >
								<span class=" gxPpxXo_ font10"> DAHA FAZLA GÖSTER</span>
							</a>
						</div>
					</div>
				<?php
				}
				?>
				<div class="row  align-items-center m-0">
					<div class="swiper-container swiper2" >
						<div class="swiper-wrapper">
						<?php
						$KuratorInceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.KuratorId=? and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? LIMIT 4");
						$KuratorInceleme->execute([Guvenlik($IncelemeSorgusuKayitlar["KuratorId"]),1,1,1]);
						$KuratorIncelemeVeri = $KuratorInceleme->rowCount();
						$KuratorIncelemeKayitlar = $KuratorInceleme->fetchAll(PDO::FETCH_ASSOC);
						if ($KuratorIncelemeVeri>0) {
							foreach ($KuratorIncelemeKayitlar as  $Kuratorkayitlar) {
								$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
								$OyunAdi->execute([Guvenlik($Kuratorkayitlar["OyunId"])]);
								$OyunAdiVeri = $OyunAdi->rowCount();
								$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

								$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
								$KuratorAdi->execute([Guvenlik($Kuratorkayitlar["KuratorId"])]);
								$KuratorAdiVeri = $KuratorAdi->rowCount();
								$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
						?>
						<div class="swiper-slide ">
							<div class="col-9  mb-3">
								<div class="row p-1">
									<div class="col-12">
										<div class="row align-items-end ">
											<div class="col-12 p-0 " style="background: black" >
											<?php
											if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
											?>
												<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
													<img src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($Kuratorkayitlar["Baslik"]); ?>" title="<?php echo  IcerikTemizle($Kuratorkayitlar["Baslik"]); ?>" class="img-fluid opacity05"  >	  
												</a>
											<?php
											}else{
											?>	
												<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
													<img src="images/resim.jpg" class="img-fluid ">
												</a> 
											<?php
											}
											?>
											</div>

											<div class="col-12 position-absolute p-0 dsxzhdrt">
												<div class="row align-items-center p-2 ">
													<div class="col-12 mt-5 hgbnzXX">
														<a  href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
															<span class="bold white incelemeb" >
															
															   <?php echo IcerikTemizle($Kuratorkayitlar["Baslik"]); ?>
														
															</span> 
															
														</a>
													</div>
													<div class="col-12">
													    <?php
                                                			if($Kuratorkayitlar["Begeni"]!="" and $Kuratorkayitlar["Begeni"]!=0){
                                                			?>
                                                			  <span class="bold white font11  "><?php echo IcerikTemizle($Kuratorkayitlar["Begeni"]); ?> beğenme</span><br>
                                                			<?php
                                                			}
                                                			?>
                                                			<?php
                                            				$BegeniSayisi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE (Durum=? or Durum=?) and IncelemeId=? " );
                                                    		$BegeniSayisi->execute([1,3,Guvenlik($Kuratorkayitlar["Incelemeid"])]);
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
						<div class="col-12 text-center swiper-pagination2 mt-2"></div>
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





