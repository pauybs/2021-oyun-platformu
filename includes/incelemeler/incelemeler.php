<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	if ($Sıralama== 1) {
		$Inceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Goruntulenme Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
	}else if($Sıralama == 2){
		$Inceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid ASC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
	}else if ($Sıralama == 3) {
		$Inceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Begeni Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
	}else{
		$Inceleme = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
	}

	$Inceleme->execute();
	$IncelemeData = $Inceleme->rowCount();
	$IncelemeKayitlar = $Inceleme->fetchAll(PDO::FETCH_ASSOC);
	if ($IncelemeData>0) {
	    $sayac=0;
		foreach ($IncelemeKayitlar as  $kayitlar) {
		$sayac++;
		$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? and id=? " );
		$OyunAdi->execute([1,Guvenlik($kayitlar["OyunId"])]);
		$OyunAdiVeri = $OyunAdi->rowCount();
		$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);

		$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=? and id=? " );
		$KuratorAdi->execute([1,Guvenlik($kayitlar["KuratorId"])]);
		$KuratorAdiVeri = $KuratorAdi->rowCount();
		$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
	?>
		
	<?php
	 if($sayac==5){
	?>
    <div class=" col-11 col-md-12  mb-3   "  >
    	<ins class="adsbygoogle"
        style="display:block; text-align:center;"
        data-ad-layout="in-article"
        data-ad-format="fluid"
        data-ad-client="ca-pub-6491655414364653"
        data-ad-slot="1903795723"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>	   
	</div>
    <?php
    }
    ?>   
	<div class=" col-12 col-xl-3  mb-3   "  >
		<div class="row p-1">
			<div class="col-12 gamebrd"  style="    border-radius: 5px;"> 
				<div class="row align-items-end  "  >
					<div class="col-12 p-0 " style="background: black"   >
					<?php
					if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
					?>
						<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"])); ?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
							<img src="images/games/<?php echo  IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" alt="<?php echo IcerikTemizle($kayitlar["Baslik"]);?>" title="<?php echo IcerikTemizle($kayitlar["Baslik"]);?>" class="img-fluid opacity07" >  
						</a>
					<?php
					}else{
					?>	
						<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
							<img src="images/resim.jpg" class="img-fluid">
						</a> 
					<?php
					}
					?>
					</div>

					<div class="col-12 position-absolute p-0 cxvxcvn" >
						<div class="row align-items-center p-2 ">
							<div class="col-12 mt-5 plzcvncx" >
								<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
								    <span class="bold white incelemb">
								
									<?php echo IcerikTemizle($kayitlar["Baslik"]); ?>
								
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
	<div class="col-12 mb-3" style="background: #202020">
		<div class="row justify-content-center align-items-center mb-5">
			<div class="col-12 text-center mb-2">
				<img src="images/logo.png" class="img-fluid tznzuy7YQ">
			</div>
			<div class="col-12 position-absolute text-center mb-2">
				<div class="row justify-content-center">
					<div class="col-12 col-xl-8">
						<h5 class="white">Hiçbir inceleme bulunamadı. Umarım en kısa zamanda küratörlerimiz inceleme yaparlar.</h5>
					</div>
					<div class="col-12 mt-2">
						<a href="<?php echo IcerikTemizle($SiteLink);  ?>">
							<button class="call-to-action2 p-0" style="height: 50px " >
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
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





