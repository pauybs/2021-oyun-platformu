<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<?php
$CokYakinda = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar Where Durum=? and $Zaman<CikisTarihi ORDER BY CikisTarihi ASC LIMIT 8");
$CokYakinda->execute([1]);
$CokYakindaVeri = $CokYakinda->rowCount();
$CokYakindaKayitlar =  $CokYakinda-> fetchAll(PDO::FETCH_ASSOC);
if ($CokYakindaVeri>0) {
?>
<div class="col-12 p-0 mb-5">
	<div class="row justify-content-center align-items-center mb-2">
	<div class="col-12  mt-3 mb-2">
			<div class="row p-2 mt-4 mb-2 justify-content-start align-items-center" style="background:#202020;border-radius:5px">
				<div class=" col-7 col-xl-10  text-left bGAfxXE" ><span >ÇOK YAKINDA</span></div>
				<?php
				if($CokYakindaVeri>4){
				?>
				  	<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL WrGYT__Xx" ><a href="yakinda"><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="swiper-container swiper10">
			<div class="swiper-wrapper">
			<?php
			foreach ($CokYakindaKayitlar as $YakindaKayitlar){	
			?>
				<div class="swiper-slide">
					<div class="col-9 col-md-12 mb-2">
						<div class="row align-items-start" >
						<?php
						if ( file_exists("images/games/".$YakindaKayitlar["AnaResim"])  and ($YakindaKayitlar["AnaResim"])) {
						?>
							<div class="col-12 p-0 gamebrd" >
								<a href="oyundetay/<?php echo SEO(IcerikTemizle($YakindaKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YakindaKayitlar["OyunUniqid"]); ?>">
									<img  src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($YakindaKayitlar["AnaResim"]) ?>" alt="<?php echo IcerikTemizle($YakindaKayitlar["OyunAdi"]);?>" title="<?php echo IcerikTemizle($YakindaKayitlar["OyunAdi"]);?>" class="img-fluid _pXxZnTY o lazy"  >
								</a>
							</div>
						<?php
						}else{
						?>
							<div class="col-12 p-0" >
								<a href="oyundetay/<?php echo  SEO(IcerikTemizle($YakindaKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YakindaKayitlar["OyunUniqid"]); ?>">
									<img src="images/resim.jpg" class="img-fluid">
								</a>
							</div>
						<?php
						}
						?>
						<div class="col-12 mt-3 p-0" >
							<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($YakindaKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YakindaKayitlar["OyunUniqid"]); ?>">
								<h2 class="uQRtXT o oyunAdi"><?php echo IcerikTemizle($YakindaKayitlar["OyunAdi"]) ?></h2>
							</a>
						</div>
						<?php
						$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
						$ToplamPuan->execute([Guvenlik($YakindaKayitlar["id"])]);
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
						$OyunPlatform->execute([Guvenlik($YakindaKayitlar["id"])]);
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
						}
						?>
						</div>
					</div>
				</div>
			<?php	
			}
			?>
			</div>
			<div class="col-12 text-center swiper-pagination10 mt-2" ></div>		 
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





