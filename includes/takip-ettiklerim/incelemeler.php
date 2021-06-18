<?php

if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
?>
	<?php
	$Inceleme = $DatabaseBaglanti->prepare("SELECT kuratortakip.id, kuratortakip.KuratorId, kuratortakip.TakipciId, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Begeni, incelemeler.Durum, incelemeler.IpAdres, incelemeler.Resim1, incelemeler.Goruntulenme, incelemeler.IncelemeLink, incelemeler.IncelemeYazisi, incelemeler.Baslik, uyeler.id, oyunlar.id, oyunlar.Durum, uyeler.SilinmeDurumu, uyeler.Kurator FROM kuratortakip INNER JOIN incelemeler ON kuratortakip.KuratorId = incelemeler.KuratorId INNER JOIN oyunlar ON incelemeler.OyunId = oyunlar.id INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id WHERE incelemeler.Durum=1 AND oyunlar.Durum=1 AND kuratortakip.TakipciId=? AND uyeler.Kurator=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
	$Inceleme->execute([Guvenlik($KullaniciId)]);
	$IncelemeData = $Inceleme->rowCount();
	$IncelemeKayitlar = $Inceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($IncelemeData>0) {
		foreach ($IncelemeKayitlar as  $kayitlar) {
		$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
		$KuratorAdi->execute([Guvenlik($kayitlar["KuratorId"])]);
		$KuratorAdiVeri = $KuratorAdi->rowCount();
		$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

		$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
		$OyunAdi->execute([Guvenlik($kayitlar["OyunId"])]);
		$OyunAdiVeri = $OyunAdi->rowCount();
		$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
	?>
		<div class="col-12 col-xl-3 mb-3">
			<div class="row p-1">
				<div class="col-12 gamebrd"  style="    border-radius: 5px;">
					<div class="row align-items-end">
						<div class="col-12 p-0" style="background: black" >
						<?php
						if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
						?>
							<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
								<img src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" alt="<?php echo IcerikTemizle($kayitlar["Baslik"]); ?>" title="<?php echo IcerikTemizle($kayitlar["Baslik"]); ?>" class="img-fluid opacity05">	  
							</a>
						<?php
						}else{
						?>	
							<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>">
								<img src="images/resim.jpg" class="img-fluid">		  
							</a> 
						<?php
						}
						?>
						</div>

						<div class="col-12 position-absolute p-0 cxvxcvn" >
							<div class="row align-items-center p-2 ">
								<div class="col-12 mt-5 plzcvncx">
									<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
										<span class="bold white incelemb">
										<?php
										if (strlen(IcerikTemizle($kayitlar["Baslik"]))>50) {
											echo strip_tags(IcerikTemizle(substr($kayitlar["Baslik"],0,50)))."...";
										}else{
											echo IcerikTemizle($kayitlar["Baslik"]);
										}
										?>
											
												
										</span> 
									</a>
								</div>
								<?php
									include 'includes/takipci_kontrol.php';
								?>	
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
		<div class="col-12" >
			<div class="row justify-content-center align-items-center mb-5">
				<div class="col-12  text-center  mb-2" >
					<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
				</div>
				<div class="col-12 position-absolute text-center  mb-2" >
					<div class="row justify-content-center">
						<div class="col-12 col-xl-8">
							<h5 class="white">Hiçbir inceleme bulunamadı. Umarım en kısa zamanda küratörlerimiz inceleme yaparlar.</h5>
						</div>
						<div class="col-12 mt-2">
							<a href="<?php echo IcerikTemizle($SiteLink) ?>">
								<button class="call-to-action2 p-0" style="height: 50px" >
									<div>
										<div>Anasayfa</div>
									</div>
								</button>
							</a>
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
include '../../settings/connect.php';
	header("location:" .$SiteLink);
  exit();
}
}else{
include '../../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
?>






