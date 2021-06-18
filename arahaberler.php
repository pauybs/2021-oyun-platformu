<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){


if(isset($_GET["Ara"])){
	$Arama =Guvenlik($_GET["Ara"]);
	$AramaSecimi = "AND ( AnaBaslik LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$Arama="";
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "";
} 
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 10;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id Desc  ");
$ToplamKayitSorgu->execute([1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);		
?>
<?php
if($Arama!=""){
?>	

<?php
$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=?");
$BannerSorgu->execute([16,1]);
$Data = $BannerSorgu->rowCount();
$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
if ($Data>0) {		
?>
<div class="col-12 col-xl-12 text-center mt-5">
	<div class="row justify-content-center align-items-center">
	    <div class="col-9">

		<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 	
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([16]);	
		?>
				</div>	

	</div>	
</div>
<?php
}
?>		

<div class="col-12  mt-5 mb-5 ">
	<div class="row justify-content-center">
		<div class="col-11 col-xl-10" >
			<div class="row justify-content-center">
				<div class="col-12 col-xl-9 mt-4 wWfVCA">
					<div class="row">
						<div class="col-12">
							<div class="row justify-content-start align-items-center text-center p-4">
								<div class="col-12 text-left mb-5 loOpTys_">
									<span class="aIyTJNZx">"<?php echo IcerikTemizle($Arama); ?>" İçin Arama Sonuçları</span>
								</div>
								<div class="col-6 col-xl-2 p-1 Powt_aWY" >
									<span>Haberler</span>
								</div>
								<div class="col-6 col-xl-2  p-1 Uytm_QZMM__"  >
									<a style="color: white" href='oyunarama/<?php echo IcerikTemizle($Arama); ?>'><span>Oyunlar</span></a>
								</div>
							</div>
							
							<div class="p-0">
								<div class="col-12">
								<?php
								$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? $AramaSecimi ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
								$Haberler->execute([1]);
								$Data = $Haberler->rowCount();
								$HaberKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
								if ($Data>0) {
									foreach ($HaberKayitlar as  $kayitlar) {
								?>
									<div class="row p-0 justify-content-center align-items-center mb-3">
									<?php
									if (file_exists("images/news/".IcerikTemizle($kayitlar["AnaResim"])) and (IcerikTemizle($kayitlar["AnaResim"])) ) {
									?>
										<div class="col-12 col-xl-3 p-0" style="background: black" >
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
												<img src="images/news/<?php echo  IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" class="img-fluid haberResim ah">
											</a>
										</div>
									<?php
									}else{
									?>
										<div class="col-12 col-xl-3">
											<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
												<img src="images/hata2.jpg" class="img-fluid haberResim">
											</a>
										</div>
									<?php
									}
									?>

										<div class="col-12 mt-2 col-xl-9">
											<div class="row">
												<div class="col-12 ">
													<a  href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>"><span class="_XXx_ADgT">Haber</span></a>
												</div>
												<div class="col-12 yazyATZB">
													<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>"><h1 class="___RrSxX__aAeWq_"><?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?></h1></a>
												</div>
												<div class="col-12 poUyrXz">
													<i class="fas fa-clock"></i> <?php echo  time_ago(IcerikTemizle($kayitlar["KayitTarihi"]));?> 
												</div>
											</div>
										</div>
									</div>
												
									<?php
									}
								}else{
								?>
									<div class="row justify-content-center align-items-center mb-5">
										<div class="col-12  text-center  mb-2" >
											<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
										</div>
										<div class="col-12 position-absolute text-center  mb-2" >
											<div class="row justify-content-center">
												<div class="col-12 col-xl-8">
													<h5 class="white">Aradığını haberi bulamadık. Umarım bize darılmazsın. Ana sayfaya bir bak belki gönlünü alırız</h5>
												</div>
												<div class="col-12 mt-2">
													<a href="index.php">
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
								<?php
								}
								?>
								</div>

								<?php
								if($SayfaSayisi>1){
								?>
								<div class="col-12 text-center mt-3   p-0"  >
								<?php
								if($Sayfalar>1 ){
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='haberlerarama/". $SayfalamaSecimi ."/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='haberlerarama/". $SayfalamaSecimi ."/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
				 						echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='haberlerarama/". $SayfalamaSecimi ."/". $i . "'>".$i."</a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									
				 				$SayfaIleri = $Sayfalar+1;
				 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='haberlerarama/". $SayfalamaSecimi ."/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
				 				echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='haberlerarama/". $SayfalamaSecimi ."/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
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
<script type="text/javascript">
	$(".ah").css("display", "none");
	$(".ah").fadeIn(1500);
</script>
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

