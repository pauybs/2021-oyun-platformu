<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$PopulerIncelemeler = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE    incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1  Order by incelemeler.Begeni DESC LIMIT 4" );
	$PopulerIncelemeler->execute([1]);
	$PopulerIncelemelerData = $PopulerIncelemeler->rowCount();
	$PopulerIncelemelerKayitlar = $PopulerIncelemeler->fetchAll(PDO::FETCH_ASSOC);
	if ($PopulerIncelemelerData>0) {
	?>
	<div class="col-12">
	<?php
	?>
		<div class="row p-3 justify-content-end align-items-center">
			<div class="col-12 mt-3 mb-2">
				<div class="row  justify-content-end">
					<div class="col-7 col-xl-10 text-left bGAfxXE" >
						<span>POPÜLER İNCELEMELER</span>
					</div>
					<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL WrGYT__Xx">
						<a href="oyunincelemeler" >
							<span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
		<?php
		foreach ($PopulerIncelemelerKayitlar as $PopülerIncelemeler) {
		$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
		$KuratorAdi->execute([Guvenlik($PopülerIncelemeler["KuratorId"])]);
		$KuratorAdiVeri = $KuratorAdi->rowCount();
		$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

		$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
		$OyunAdi->execute([Guvenlik($PopülerIncelemeler["OyunId"])]);
		$OyunAdiVeri = $OyunAdi->rowCount();
		$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
		?>
			<div class="col-6 col-xl-3 mb-3">
				<div class="row p-2 ">
					<div class="col-12 ">
						<div class="row align-items-end " >
							<div class="col-12 p-0" style="background: black">
							<?php
							if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
							?>
								<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>" >
									<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05" title="<?php echo  IcerikTemizle($PopülerIncelemeler["Baslik"]);?>">	  
								</a>
							<?php
							}else{
							?>	
								<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>" >
									<img src="images/resim.jpg" class="img-fluid">
								</a> 
							<?php
							}
							?>
							</div>

							<div class="col-12 position-absolute p-0 kcxvxvzbtre">
								<div class="row align-items-center p-2">
									<div class="col-12 mt-5 ">
										<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($PopülerIncelemeler["Incelemeid"]); ?>">
											<p class="bold white incelemb m-0 KznaZxXxAS" >
												<?php
												if (strlen(IcerikTemizle($PopülerIncelemeler["Baslik"]))>40) {
													echo strip_tags(IcerikTemizle(substr($PopülerIncelemeler["Baslik"],0,40)))."...";
												}else{
													echo IcerikTemizle($PopülerIncelemeler["Baslik"]);
												}
												?>
											</p> 
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
		?>
		</div>
	</div>
	<?php
	}
	?>

<?php
}else{
	require_once("../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





