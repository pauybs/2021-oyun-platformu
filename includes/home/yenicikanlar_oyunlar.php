<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php 
	$YeniOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join oyunlar on oyunlar.id=oyunkategorileri.OyunId WHERE KategoriId=13 and oyunlar.Durum=1 ORDER BY oyunlar.CikisTarihi DESC LIMIT 8");
	$YeniOyunlar->execute();
	$YeniOyunlarVeri = $YeniOyunlar->rowCount();
	$YeniOyunlarKayitlar =  $YeniOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($YeniOyunlarVeri>3) {
	?>
	<div class="row justify-content-center align-items-center mb-2">
		<div class="col-12 mt-3 mb-2">
			<div class="row p-2 justify-content-end mt-4 mb-2" style="background:#202020;border-radius:5px">
				<div class="col-12 text-left bGAfxXE" ><span >YENİ ÇIKAN OYUNLAR</span></div>
			</div>
		</div>
		<div class="swiper-container swiper4">
			<div class="swiper-wrapper">
			<?php
			foreach ($YeniOyunlarKayitlar as $YeniOyunKayitlar){	
			?>
				<div class="swiper-slide">
					<div class="col-9 col-md-12 mb-2">
						<div class="row align-items-start" >
						<?php
						if ( file_exists("images/games/".$YeniOyunKayitlar["AnaResim"])  and ($YeniOyunKayitlar["AnaResim"])) {
						?>
							<div class="col-12 p-0 gamebrd" >
								<a href="oyundetay/<?php echo SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["OyunUniqid"]); ?>">
									<img  src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($YeniOyunKayitlar["AnaResim"]) ?>" alt="<?php echo IcerikTemizle($YeniOyunKayitlar["OyunAdi"]);?>" title="<?php echo IcerikTemizle($YeniOyunKayitlar["OyunAdi"]);?>" class="img-fluid _pXxZnTY o lazy"  >
								</a>
							</div>
						<?php
						}else{
						?>
							<div class="col-12 p-0" >
								<a href="oyundetay/<?php echo  SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["OyunUniqid"]); ?>">
									<img src="images/resim.jpg" class="img-fluid">
								</a>
							</div>
						<?php
						}
						?>
							<div class="col-12 mt-3 p-0" >
								<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($YeniOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($YeniOyunKayitlar["OyunUniqid"]); ?>">
									<h2 class="uQRtXT o oyunAdi"><?php echo IcerikTemizle($YeniOyunKayitlar["OyunAdi"]) ?></h2>
								</a>
							</div>
							<?php
							$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
							$ToplamPuan->execute([Guvenlik($YeniOyunKayitlar["id"])]);
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
							$OyunPlatform->execute([Guvenlik($YeniOyunKayitlar["id"])]);
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
			<div class="col-12 text-center swiper-pagination4 mt-2" ></div>		 
		</div>
	</div>
	<?php
	}else{
	?>
		<div class="col-12 mt-3 mb-2">
			<div class="row p-1 justify-content-end mt-4 mb-2">
				<div class="col-12 text-left bGAfxXE" ><span >YENİ ÇIKAN OYUNLAR</span></div>
			</div>
		</div>
		<div class="swiper-container swiper4">
			<div class="swiper-wrapper">
		   	<?php
			for ($i=0; $i <8 ; $i++) { 
			?>
		    <div class="swiper-slide">
				<div class="col-9 col-md-12 mb-2">
					<div class="row " >
					    <div class="col-12 m-0 p-0" style="background: #202020;height: 400px"></div>
					     <div class="col-10 mt-2 m-0 p-0" style="background: #202020;height: 20px"></div>
					     <div class="col-6 mt-2 m-0 p-0" style="background: #202020;height: 20px"></div>
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
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





