<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$KuratorInceleme = $DatabaseBaglanti->prepare("SELECT oyunlar.Durum, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId WHERE incelemeler.KuratorId=? and incelemeler.Durum=?  AND oyunlar.Durum=? ORDER BY incelemeler.Incelemeid DESC");
	$KuratorInceleme->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),1,1]);
	$KuratorIncelemeData = $KuratorInceleme->rowCount();
	$KuratorIncelemeKayitlar = $KuratorInceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($KuratorIncelemeData>0) {
		foreach ($KuratorIncelemeKayitlar as  $Kuratorkayitlar) {
		$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
		$KuratorAdi->execute([Guvenlik($Kuratorkayitlar["KuratorId"])]);
		$KuratorAdiVeri = $KuratorAdi->rowCount();
		$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

		$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
		$OyunAdi->execute([Guvenlik($Kuratorkayitlar["OyunId"])]);
		$OyunAdiVeri = $OyunAdi->rowCount();
		$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);	
	?>
		<div class="col-6 col-xl-3 mb-3">
			<div class="row p-2" >
				<div class="col-12 krtbrd" style="border-radius:5px">
					<div class="row align-items-end">
						<div class="col-12 p-0 " style="background: black"   >
						<?php
						if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
						?>
							<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
								<img src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" title="<?php echo IcerikTemizle($Kuratorkayitlar["Baslik"]); ?>" class="img-fluid opacity07 lazy"    >  
							</a>
						<?php
						}else{
						?>	
							<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
								<img src="images/resim.jpg" class="img-fluid "  >
							</a> 
						<?php
						}
						?>
						</div>
						<div class="col-12 position-absolute p-0 kcxvxvzbtre">
							<div class="row align-items-center p-2">
								<div class="col-12 mt-5 KznaZxXxAS">
									<a  href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($Kuratorkayitlar["Incelemeid"]); ?>" >
										<span class="bold incelemb m-0 KznaZxXxAS" >
										    <?php	echo IcerikTemizle($Kuratorkayitlar["Baslik"]); ?>
										</span><br>
										<?php
                            			if($Kuratorkayitlar["Begeni"]!="" and $Kuratorkayitlar["Begeni"]!=0){
                            			?>
                            			    	<span class="bold white font11 ml-1 "><?php echo IcerikTemizle($Kuratorkayitlar["Begeni"]); ?> beğenme</span><br>
                            
                            			<?php
                            			}
                            			?>
                            			<?php
                        				$BegeniSayisi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE (Durum=? or Durum=?) and IncelemeId=? " );
                                		$BegeniSayisi->execute([1,3,Guvenlik($Kuratorkayitlar["Incelemeid"])]);
                                		$BegeniSayisiVeri = $BegeniSayisi->rowCount();
                                        if($BegeniSayisiVeri>0){
                        				?>
                				            <span class=" white opacity07 font11 ml-1"><?php echo $BegeniSayisiVeri; ?> yorum</span><br>
                        
                        				<?php
                        				}
                        				?>
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
			<div class="col-12 mb-5">
				<div class="row justify-content-center mb-5">
					<div class="col-12 text-center mb-2 mt-4" >
						<span ><i class="far fa-edit white font45"></i></span>
					</div>
					<div class="col-12 text-center  mb-4 font15 white" >
						<span>Henüz hiç inceleme yok</span>
					</div>
					<?php
						include 'includes/populer_incelemeler.php';
					?>
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





