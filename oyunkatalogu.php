<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( oyunlar.OyunAdi LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
}

if (isset($_REQUEST["c"])) {
	$Kategori=Guvenlik($_REQUEST["c"]);
	$SayfalamaSecimi .= "&c=" . $Kategori ;
}else{
	$Kategori="";
	$SayfalamaSecimi .= "&c=" ;
}

$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi =12;
if ($Kategori=="aksiyon") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="android") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunplatform inner join  oyunlar  on oyunlar.id = oyunplatform.OyunId   WHERE PlatformId=4  and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="basiteglence") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=2 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="cokoyunculu") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=3 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="hayattakalma") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=4 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="ios") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunplatform inner join  oyunlar  on oyunlar.id = oyunplatform.OyunId   WHERE PlatformId=5  and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="linux") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar  on oyunlar.id = oyungereksinim.OyunId   WHERE IsletimSistemiAdi=3 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="macera") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join oyunlar on oyunlar.id=oyunkategorileri.OyunId WHERE KategoriId=5 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="macos") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar on oyunlar.id = oyungereksinim.OyunId WHERE IsletimSistemiAdi=2 and oyunlar.Durum=1 $AramaSecimi ORDER BY oyunlar.id Desc");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="rolyapma") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=7 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="simulasyon") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=8 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="spor") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=9 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="strateji") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=10 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="ucretsiz") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=11 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="windows") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar  on oyunlar.id = oyungereksinim.OyunId   WHERE IsletimSistemiAdi=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc");
	$ToplamKayitSorgu->execute();
}else if ($Kategori=="yaris") {
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=12 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc ");
	$ToplamKayitSorgu->execute();
}else{
	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=? $AramaSecimi ORDER BY id Desc ");
	$ToplamKayitSorgu->execute([1]);	
}


$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? AND Durum=? ORDER BY GosterimSayisi LIMIT 1");
$Banner->execute([8,1]);
$Veri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($Veri>0) {
?>
<div class="col-12  text-center  mt-5 d-none d-md-block">
	<div class="row justify-content-center align-items-center" >
		<div class="col-11 ">
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([8 ]);	
		?>			
		</div>
	</div>
</div>
<div class="col-12  text-center  mt-5 d-block d-md-none">
	<div class="row justify-content-center align-items-center" >
		<div class="col-11 ">
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

<div class="col-12 p-0  " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-11 col-xl-2 mb-3  ">
			<div class="row justify-content-center align-items-center">
				<div class="col-12 p-0 mb-3 text-right ">
					<form action="tumoyunlar/<?php echo $SayfalamaSecimi ?>/1" method="post" > 
						<input placeholder="Oyun Ara..." type="search" name="Ara" class="gn-search2" style="background: #202020;width: 100%">
					</form>
				</div>
				
				<div class="col-12 text-center kiyBZJGAB p-0" >
					<div class="iropdown admsrl" >
						<button class="ibutton" style="padding:12px">
							<i class="fas fa-sort-amount-down"></i>
							<?php 
							if ($Kategori=="aksiyon"){
							?>
								<span>Aksiyon</span>
							<?php
							}else if($Kategori=="basiteglence"){
							?>
								<span>Basit Eğlence</span>
							<?php
							}else if($Kategori=="spor"){
							?>
								<span>Spor</span>
							<?php
							}else if($Kategori=="simulasyon"){
							?>
								<span>Simulasyon</span>
							<?php
							}else if($Kategori=="strateji"){
							?>
								<span>Strateji</span>
							<?php
							}else if($Kategori=="cokoyunculu"){
							?>
								<span>Çok Oyunculu</span>
							<?php
							}else if($Kategori=="macera"){
							?>
								<span>Macera</span>
							<?php
							}else if($Kategori=="yaris"){
							?>
								<span>Yarış</span>
							<?php
							}else if($Kategori=="rolyapma"){
							?>
								<span>Rol Yapma</span>
							<?php
							}else if($Kategori=="ucretsiz"){
							?>
								<span>Ücretsiz</span>
							<?php
							}else if($Kategori=="hayattakalma"){
							?>
								<span>Hayatta Kalma</span>
							<?php
							}else if($Kategori=="android"){
							?>
								<span>Android Oyunları</span>
							<?php
							}else if($Kategori=="ios"){
							?>
								<span>iOS Oyunları</span>
							<?php
							}else if($Kategori=="linux"){
							?>
								<span>Linux Oyunları</span>
							<?php
							}else if($Kategori=="macos"){
							?>
								<span>MacOS Oyunları</span>
							<?php
							}else if($Kategori=="windows"){
							?>
								<span>Windows Oyunları</span>
							<?php
							}else{
							?>
								<span>Tüm Oyunlar</span>
							<?php
							}
							?>
						</button>
						<div class="icontent" style="z-index: 3">
							<a class="iylink bold white text-center p-2" href="tumoyunlar">
								<button class=" btn  white bold inczsdsa_ " style="color: white">Tüm Oyunlar</button>
							</a>
							<a class="iylink">
								<form action="tumoyunlar " method="post" >
									<div class="col-12 ">
										<div class=" row justify-content-center ">
											<div class="col-4 text-center p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="aksiyon">
											</div>	
										</div>
										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"   value="Aksiyon" type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="basiteglence">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Basit Eğlence"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="spor">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Spor"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="simulasyon">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Simulasyon"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="strateji">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Strateji"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="cokoyunculu">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Çok Oyunculu"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="macera">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Macera"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="yaris">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Yarış"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="rolyapma">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Rol Yapma"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="ucretsiz">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Ücretsiz"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="hayattakalma">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Hayatta Kalma"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="android">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Android Oyunları"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="ios">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="iOS Oyunları"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="windows">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Windows Oyunları"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="macos">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="macOS Oyunları"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
							<a class="iylink">
								<form action="tumoyunlar" method="post">
									<div class="col-12 ">
										<div class=" row justify-content-center">
											<div class="col-4 p-1 text-center"> 
												<input type="hidden" class="vncbcvbinc"  type="radio" name="c" value="linux">
											</div>	
										</div>

										<div class="col-12 text-center form-group">
											<input class="inczsdsa_"  value="Linux Oyunları"  type="submit" class="btn-block btn btn btn-warning ">
										</div>
									</div>	
								</form>
							</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>

		<div class="col-12 col-xl-9 " style="margin-bottom: 200px" >
			<div class="row  " >
			<?php
			if ($Kategori=="aksiyon") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="android") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunplatform inner join  oyunlar  on oyunlar.id = oyunplatform.OyunId   WHERE PlatformId=4  and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="basiteglence") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=2 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="cokoyunculu") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=3 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="hayattakalma") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=4 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="ios") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunplatform inner join  oyunlar  on oyunlar.id = oyunplatform.OyunId   WHERE PlatformId=5  and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="linux") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar  on oyunlar.id = oyungereksinim.OyunId   WHERE IsletimSistemiAdi=3 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="macera") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join oyunlar on oyunlar.id=oyunkategorileri.OyunId WHERE KategoriId=5 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="macos") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar on oyunlar.id = oyungereksinim.OyunId WHERE IsletimSistemiAdi=2 and oyunlar.Durum=1 $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="rolyapma") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=7 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="simulasyon") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=8 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="spor") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=9 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="strateji") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=10 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="ucretsiz") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=11 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="windows") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyungereksinim inner join  oyunlar  on oyunlar.id = oyungereksinim.OyunId   WHERE IsletimSistemiAdi=1 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else if ($Kategori=="yaris") {
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId   WHERE KategoriId=12 and oyunlar.Durum=1  $AramaSecimi ORDER BY oyunlar.id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute();
			}else{
				$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=? $AramaSecimi ORDER BY id Desc  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
				$Oyunlar->execute([1]);	
			}

			
			$OyunlarVeri = $Oyunlar->rowCount();
			$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
                
			if ($OyunlarVeri>0) {
			$sayac=0;
				foreach ($OyunlarKayitlar as  $kayitlar) {	
				    $sayac++;
			?>
			    <?php
			    if( $sayac==5   ){
			    ?>
			    <div class="col-12 mb-5">
			    				   <ins class="adsbygoogle"
                     style="display:inline-block;width:100%;height:90px"
                     data-ad-client="ca-pub-6491655414364653"
                     data-ad-slot="1630401356"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
			    </div>

			    <?php    
			    }
			    ?>
			    <div class="col-6 col-md-4 col-xl-3 mb-5 ">
				<?php
				if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
				?>
					<div class="col-12 p-0 gamebrd" style="background: black">
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
							<img src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" style="border-radius: 5px"  class="img-fluid oyunlar wWfVCA a lazy">
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0  "  >
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
							<img src="images/resim.jpg" class="img-fluid oyunlar" >
						</a>
					</div>
				<?php
				}
				?>
						
				<div class="col-12 p-0  mt-2  arwWxZxyBG"  >
					<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
						<h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6>
					</a>
				</div>

				<?php
				$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
				$ToplamPuan->execute([Guvenlik($kayitlar["id"])]);
				$ToplamPuanVeri = $ToplamPuan->rowCount();
				$ToplamPuanKayitlar = $ToplamPuan->fetchAll(PDO::FETCH_ASSOC);
				if ($ToplamPuanVeri>0) {
				?>
					<?php
					$ToplamPuan=0;
					$KisiSayisi=$ToplamPuanVeri;
					foreach ($ToplamPuanKayitlar as $Puanlar) {
						$ToplamPuan+= $Puanlar["Puan"];
					}
						$OrtalamaPuan= number_format($ToplamPuan/$KisiSayisi, 2,".","");	
					?>
					
					<div class="col-12  p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
				<?php
				}else{		
				?>
					<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
				<?php
				}
				?>
				
				<?php
				$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
				$OyunPlatform->execute([Guvenlik($kayitlar["id"])]);
				$OyunPlatformSayi = $OyunPlatform->rowCount();
				$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);

				if ($OyunPlatformSayi>0) {
				?>
					<div class="col-12  mt-1 p-0" >
						<?php
						foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
						?>
							<?php echo Platform($OyunPlatform["PlatformId"])?>
						<?php		
						}
						?>
					</div>
				<?php
				}else{
				?>	

				<?php
				}
				?>
				</div>
			 
			    
			    
				
			<?php
			}
			}else{
			?>
		
			<div class="col-11 col-xl-11"  >
				<div class="row justify-content-center  align-items-center ml-1 wWfVCA ">
					<div class="col-12  text-center  mb-2" >
						<img src="images/logo.png" class="img-fluid" style="opacity: 0.1; width: 350px;height: 350px">
					</div>
					<div class="col-12 position-absolute text-center  mb-2" >
						<div class="row justify-content-center">
							<div class="col-12 col-xl-8">
								<h5 class="white">Hiçbir oyun bulamadık. Umarım gözden kaçırmıyoruzdur. Gözden kaçırdığımız bir şey varsa bunu bize iletişim kısmından bildirebilirsin.</h5>
							</div>
							<div class="col-12 mt-2">
								<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
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
			</div>	
				 

			<?php
			if($SayfaSayisi>1){
			?>
			<div class="col-12 text-center mt-3  p-0  "  >
			<?php
			if($Sayfalar>1 ){
				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='tumoyunlar/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
 				$SayfaGeri = $Sayfalar-1;
					echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='tumoyunlar/". $SayfalamaSecimi ."/".$SayfaGeri."'><i class='fas fa-caret-left'></i></a></span>";
			}
			for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
				if( ($i>0)  and ($i<=$SayfaSayisi)  ){
					if($Sayfalar==$i){
						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

					}else{
						echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='tumoyunlar/". $SayfalamaSecimi ."/". $i . "'>".$i."</a></span>";
					}
				}
			}
			if($Sayfalar!=$SayfaSayisi){
				
				$SayfaIleri = $Sayfalar+1;
				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='tumoyunlar/". $SayfalamaSecimi ."/".$SayfaIleri."'><i class='fas fa-caret-right'></i></a></span>";	
				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='tumoyunlar/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right'></i><i class='fas fa-caret-right'></i></a></span>";
			}
			?>
			</div>
			<?php
			}
			?>
		</div>
	</div>			
</div>
<script type="text/javascript">
	$(".a").css("display", "none");
	$(".a").fadeIn(1500);
</script>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() { 
	var lazyloadImages = document.querySelectorAll("img.lazy"); 
	var lazyloadThrottleTimeout;
	function lazyload () {
		if(lazyloadThrottleTimeout){ 
			clearTimeout(lazyloadThrottleTimeout); 
		}    
    
		lazyloadThrottleTimeout = setTimeout(function() { 
			var scrollTop = window.pageYOffset; 
			lazyloadImages.forEach(function(img) { 
				if(img.offsetTop < (window.innerHeight + scrollTop)) {
					img.src = img.dataset.src; 
					img.classList.remove('lazy'); 
				}
			});
			if(lazyloadImages.length == 0) {  
				document.removeEventListener("scroll", lazyload); 
				window.removeEventListener("resize", lazyload); 
				window.removeEventListener("orientationChange", lazyload); 
				
			}
		}, 20);
	}
  
	document.addEventListener("scroll", lazyload); 
	window.addEventListener("resize", lazyload); 
	window.addEventListener("orientationChange", lazyload);
});
</script>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}
?>