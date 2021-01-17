<?php
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( AdSoyad LIKE '%" . $Arama . "%'  OR KullaniciAdi LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
} 
$SayfalarSolVeSagButonSayisi = 2;
$GosterilecekKayitSayisi =20;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  Durum=? and Kurator=? and SilinmeDurumu=? $AramaSecimi ORDER BY id Desc  ");
$ToplamKayitSorgu->execute([1,1,0]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
$Banner->execute([39,1]);
$BannerVeri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($BannerVeri>0) {
?>
<div class="col-12 text-center  mt-5">
	<div class="row justify-content-center align-items-center" >
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([39] );	
		?>
	</div>
</div>
<?php
}
?>

<div class="col-12 p-0 mt-5 mb-5">
	<div class="row justify-content-center m-0 mb-5 ">
		<div class="col-12 col-xl-8" >
			<div class="row  p-0  " >
				<div class="col-12   mb-5 ">
					<div class="row justify-content-center align-items-center">
						<div class=" col-11 col-xl-6 p-0 mb-3  ">
							<form action="kuratorler" method="post" > 
								<input placeholder="Küratör Ara..." type="search" name="Ara" class="gn-search2" style="background: #202020;width: 100%">
							</form>
						</div>
					</div>
				</div>

				<?php
				$Kuratorler = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE  Durum=? and Kurator=? and SilinmeDurumu=? $AramaSecimi ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
				$Kuratorler->execute([1,1,0]);
				$VeriSayisi = $Kuratorler->rowCount();
				$KuratorKayitlar = $Kuratorler->fetchAll(PDO::FETCH_ASSOC);
				if ($VeriSayisi>0) {
				foreach ($KuratorKayitlar as  $kayitlar) {	
				?>
				<div class="col-6 col-xl-3 mb-5  p-0">
				<?php
				if (file_exists("images/userphoto/".$kayitlar["ProfilResmi"]) and ($kayitlar["ProfilResmi"]) ) {
				?>
					<div class="col-12   "  >
						<a href="kurator/<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>">
							<img src="images/userphoto/<?php echo  IcerikTemizle($kayitlar["ProfilResmi"]);?>" class="img-fluid lYkqwAk wWfVCA a" >
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12   "  >
						<a href="kurator/<?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?>">
							<img src="images/userbackground.jpg" class="img-fluid lYkqwAk" >
						</a>
					</div>
				<?php
				}
				?>
					<div class="col-12 text-center mt-2 ksadsja" >
						<span class="bold white kuratora"><?php echo  IcerikTemizle($kayitlar["KullaniciAdi"]);?></span>
					</div>
				</div>
				<?php
				}
				}else{
				?>
					<div class="col-12">
						<div class="row justify-content-center align-items-center mb-5">
							<div class="col-12  text-center  mb-2" >
								<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
							</div>
							<div class="col-12 position-absolute text-center  mb-2" >
								<div class="row justify-content-center">
									<div class="col-12 col-xl-8">
										<h5 class="white">Bu kullanıcı adında bir küratörümüz maalesef yok. Hata yapmadığından emin ol ve tekrar dene. </h5>
									</div>
									<div class="col-12 mt-2">
										<a href="<?php echo IcerikTemizle($SiteLink) ?>">
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
				<div class="col-12 text-center mt-3   p-4"  >
					<?php
					if($Sayfalar>1 ){
						echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='kuratorler/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";
						
					}
					for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
						if( ($i>0)  and ($i<=$SayfaSayisi)  ){
							if($Sayfalar==$i){
								echo "<span class='p-2  bold  '   style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white ' class='aktif p-3'>". $i . "</span>";
							}else{
								echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='kuratorler/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
							}
						}
					}

					if($Sayfalar!=$SayfaSayisi){
						echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href=''kuratorler/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
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