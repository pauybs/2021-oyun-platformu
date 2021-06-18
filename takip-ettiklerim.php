<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)  ){

	$TakipciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE TakipciId=? ");
	$TakipciKontrol->execute([$KullaniciId]);
	$TakipciKontrolData = $TakipciKontrol->rowCount();
	if ($TakipciKontrolData>0) {
		if(isset($_REQUEST["Ara"])){
		$Arama =Guvenlik($_REQUEST["Ara"]);
		$AramaSecimi = "AND ( incelemeler.Baslik LIKE '%" . $Arama . "%' OR oyunlar.OyunAdi LIKE '%" . $Arama . "%' )";
		$SayfalamaSecimi = "&Ara=" . $Arama ; 
	}else{
		$AramaSecimi="" ; 
		$SayfalamaSecimi = "&Ara=";
	} 

	$SayfalarSolVeSagButonSayisi = 1;
	$GosterilecekKayitSayisi = 12;

	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT kuratortakip.id, kuratortakip.KuratorId, kuratortakip.TakipciId, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Begeni, incelemeler.Durum, incelemeler.IpAdres, incelemeler.Resim1, incelemeler.Goruntulenme, incelemeler.IncelemeLink, incelemeler.IncelemeYazisi, incelemeler.Baslik, uyeler.id, oyunlar.id, oyunlar.Durum, uyeler.SilinmeDurumu, uyeler.Kurator FROM kuratortakip INNER JOIN incelemeler ON kuratortakip.KuratorId = incelemeler.KuratorId INNER JOIN oyunlar ON incelemeler.OyunId = oyunlar.id INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id WHERE incelemeler.Durum=1 AND oyunlar.Durum=1 AND kuratortakip.TakipciId=$KullaniciId AND uyeler.Kurator=1 and uyeler.SilinmeDurumu=0 $AramaSecimi ORDER BY incelemeler.Incelemeid Desc");
	$ToplamKayitSorgu->execute();
	$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
	$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
	$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);		
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  BannerAlani='HaberlerUst' ORDER BY GosterimSayisi LIMIT 1");
$Banner->execute();
$BannrVeri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($BannrVeri>0) {
?>	
<div class="col-12 col-xl-12 text-center mb-3 mt-5">
	<div class="row justify-content-center align-items-center">
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([Guvenlik($BannerKayitlar["id"])]);	
		?>		
	</div>	
</div>
<?php
}
?>

<div class="col-12">
	<div class="row justify-content-center m-0  mb-5 ">
		<div class="col-12 col-xl-11 p-0 mt-1 mt-xl-5 mb-5 " >
			<div class="row justify-content-center m-0 ">
				<div class="col-12">
					<div class="row justify-content-center align-items-center">
						<div class="col-6 p-0 d-none d-xl-block">
							<div class="row align-items-center">
								<div class="col-2">
									<a class="bold font15 opacity07" style="color: white " href="oyunincelemeler">
										<span>İncelemeler</span>
									</a>
								</div>
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
								?>
									<div class="col-3">
										<a class="bold font15" style="color: white" href="takipettiklerim">
											<span>Takip Ettiklerim</span>
										</a>
									</div>
								<?php
								}
								?>
							</div>
						</div>
						
						<div class="col-12 col-xl-6 text-right">
							<div class="row justify-content-end align-items-center ">
								<div class="col-12 col-xl-5 p-3 text-center" data-toggle="modal" data-target="#exampleModal" style="background: #202020;">
								<?php
									include 'includes/takip-ettiklerim/takip_edilenler.php';		
								?>
								</div>
								<div class="col-12 col-xl-4  mb-2 mt-2 p-0 ml-3">
									<form action="takipettiklerim  " method="post" > 
										<input placeholder="İnceleme Ara..." type="search" name="Ara" class=" wWfVCA xcvzxttkpe p-3"  >
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="d-block d-xl-none col-12 mb-2">
				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
				?>
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center iaQeezXzC___" >
							<label class="mt-3 mb-0" for="menu-toggle">
								<p class="bold  white" style="cursor: pointer;">
									<span class="font13">Takip Ettiklerim</span> 
									<i class="fas fa-chevron-down"></i>
								</p> 
							</label>
						</div>
						<input type="checkbox" id="menu-toggle" />
						<ul id="menu" class="wWfVCA" >
							<li>
								<div class="col-12 mt-3 mb-3 text-center" >
									<a class="t_RwAMWz_" style="color: white " href="oyunincelemeler">
										<span  class="font12">İncelemeler</span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				<?php
				}
				?>
				</div>
				
				<div class="col-12 " >
					<div class="row">
					<?php
					include 'includes/takip-ettiklerim/incelemeler.php';
					?>
					</div> 
				</div>

				<div>
				<?php
				include 'includes/takip-ettiklerim/sayfalama.php';
				?>
				</div>
					
			</div>			
		</div>
	</div>
</div>
 <script src="assets/main_te=10.2.01.js"></script>
<?php
}else{
	header('Location: ' .$SiteLink);
	exit();
}
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>


<script type="text/javascript">
	$(".h").css("display", "none");
	$(".h").fadeIn("slow");
</script>