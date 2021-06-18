<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunInceleme =  $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE   incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 ORDER BY incelemeler.GunlukGoruntulenme DESC, incelemeler.Incelemeid DESC LIMIT 4");
	$OyunInceleme->execute([]);
	$OyunIncelemeVeri = $OyunInceleme->rowCount();
	$OyunIncelemeKayitlar = $OyunInceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunIncelemeVeri>0) {
	?>
		<?php
		foreach ($OyunIncelemeKayitlar as  $IncelemeKayitlar) {
		$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
		$OyunAdi->execute([Guvenlik($IncelemeKayitlar["OyunId"])]);
		$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
		$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
		$KuratorAdi->execute([Guvenlik($IncelemeKayitlar["KuratorId"])]);
		$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="col-12 p-0 mt-3" style="background: #202020">
			<div class="row align-items-center">
				<div class="col-3 col-md-2 p-0">
					<div class="row">
						<div class="col-12">
						<?php
						if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
						?>
							<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
								<img   src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>"  alt="<?php echo IcerikTemizle($IncelemeKayitlar["Baslik"]);?>" title="<?php echo IcerikTemizle($IncelemeKayitlar["Baslik"]);?>" class="img-fluid lazy" style="width: 100%;height: auto;" >	  
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
					</div>
				</div>
				<div class="col-9 col-md-10">
					<div class="row">
						<div class="col-12 xbzsWyT mb-1">
							<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($IncelemeKayitlar["Incelemeid"]); ?>" >
								<span class="bold white font14 mb-1 xbzsWyT" ><?php echo IcerikTemizle($IncelemeKayitlar["Baslik"]); ?></span> 
							</a>
						</div>
						<div class="col-12 ip mt-1">
							<figure>
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
									<span class="bold white odib"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?> </span>
								</figcaption>
							</figure>
						</div>
					</div>
				</div>
			</div>
		</div>		
		<?php
		}
		?>
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





