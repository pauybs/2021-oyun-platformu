<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
		if(isset($_REQUEST["Ara"])){
		$Arama =Guvenlik($_REQUEST["Ara"]);
		$AramaSecimi = "AND ( incelemeler.Baslik LIKE '%" . $Arama . "%'  OR oyunlar.OyunAdi LIKE '%" . $Arama . "%'  OR uyeler.KullaniciAdi LIKE '%" . $Arama . "%' )";
		$SayfalamaSecimi = "&Ara=" . $Arama ; 
	}else{
		$AramaSecimi="" ; 
		$SayfalamaSecimi = "&Ara=";
	} 

	if (isset($_REQUEST["srl"])) {
		$Sıralama=Guvenlik($_REQUEST["srl"]);
		$SayfalamaSecimi .= "&srl=" . $Sıralama ;
	}else{
		$Sıralama="";
		$SayfalamaSecimi .= "&srl=" ;
	}

	$SayfalarSolVeSagButonSayisi = 1;
	$GosterilecekKayitSayisi = 12;
	if ($Sıralama== 1) {
		$ToplamKayitSorgu=$DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id WHERE incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Goruntulenme Desc");
	}else if($Sıralama == 2){
		$ToplamKayitSorgu=$DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid ASC");
	}else if ($Sıralama == 3) {
		$ToplamKayitSorgu=$DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Begeni Desc");
	}else{
		$ToplamKayitSorgu=$DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE  incelemeler.Durum=1 and uyeler.Kurator=1 and oyunlar.Durum=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid Desc");
	}

	$ToplamKayitSorgu->execute();
	$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
	$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
	$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);		
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? ORDER BY GosterimSayisi LIMIT 1");
$Banner->execute([37]);
$Veri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($Veri>0) {
?>	
<div class="col-12 col-xl-12 text-center   mt-5 mb-3 d-none d-md-block">
	<div class="row justify-content-center align-items-center"  >
	    <div class="col-11 text-center "  >
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([37]);	
		?>
		</div>	
	</div>	
</div>
<div class="col-12 col-xl-12 text-center   mt-5  d-block d-md-none">
	<div class="row justify-content-center align-items-center"  >
	    <div class="col-11 text-center "  >
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
<div class="col-12">
	<div class="row justify-content-center m-0 mb-5">
		<div class="col-12 col-xl-11 p-0 mb-5">
			<div class="row justify-content-center m-0  p-0">
				<div class=" col-12   mt-5" style="z-index: 2">
					<div class="row justify-content-center  align-items-center">
						<div class="col-6 p-0 d-none d-xl-block ">
							<div class="row">
								<div class="col-2" >
									<a class="bold font15" href="oyunincelemeler">
										<span class="white">İncelemeler</span>
									</a>
								</div>
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
								$TakipciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE TakipciId=? ");
								$TakipciKontrol->execute([Guvenlik($KullaniciId)]);
								$TakipciKontrolVeri = $TakipciKontrol->rowCount();
								if ($TakipciKontrolVeri>0) {
								?>
									<div class="col-3">
										<a  class="bold font15 opacity07 " style="color: white " href="takipettiklerim">
											<span>Takip Ettiklerim</span>
										</a>
									</div>
								<?php
								}
								}
								?>
							</div>
						</div>

						<div class="col-12 col-xl-6  text-right p-0  " >
							<div class="row justify-content-end ">
								<div class="col-12 col-xl-4  mb-2 ">
									<?php	
									include 'includes/incelemeler/siralama.php';
									?>
								</div>
								<div class="col-12  text-center col-xl-4 mb-2  ">
									<form action="oyunincelemeler" method="post"> 
										<input  placeholder="İnceleme Ara..." type="search" class="p-3 wWfVC vcbxinczqZ" name="Ara">	
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
					$TakipciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE TakipciId=? ");
					$TakipciKontrol->execute([Guvenlik($KullaniciId)]);
					$TakipciKontrolData = $TakipciKontrol->rowCount();
					if ($TakipciKontrolData>0) {
				?>
				<div class="d-block d-xl-none col-12  ">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center iaQeezXzC___" >
							<label class="mt-3 mb-0" for="menu-toggle">
								<p class="bold  white" style="cursor: pointer;"> 
									<span class="font13">İncelemeler</span> 
									<i class="fas fa-chevron-down"></i>
								</p> 
							</label>
						</div>
						<input type="checkbox" id="menu-toggle" />
						<ul id="menu" class="wWfVCA" >
							<li>
								<div class="col-12 mt-3 mb-3 text-center" >
									<a class="t_RwAMWz_" style="color: white " href="takipettiklerim">
										<span class="font12">Takip Ettiklerim</span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<?php
					}
				}
				?>

				<div class="col-12  " >
					<div class="row ">
						<?php
						include 'includes/incelemeler/incelemeler.php';
						?>
					</div> 
				</div>

				<div>
					<?php
					include 'includes/incelemeler/sayfalama.php';
					?>
				</div>
					
			</div>			
		</div>
	</div>
</div>

<?php
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
?>
 	<script src="assets/main_te=10.2.01.js"></script>
<?php
}
?>
<script type="text/javascript">
	$(".h").css("display", "none");
	$(".h").fadeIn("slow");
</script>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}
?>