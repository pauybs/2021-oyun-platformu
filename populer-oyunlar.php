<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
$BannerSorgu->execute([19,1]);
$Data = $BannerSorgu->rowCount();
$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
if($Data>0){
?>
<div class="col-12 mb-5  mt-5">
	<div class="row text-center justify-content-center align-items-center"  >	
	<div class="col-9">		
		<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
		<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([Guvenlik($Banner["id"])]);	
		?>		
	</div>	
</div>	
</div>
<?php
}
?>
<div class="col-12 p-0 mt-5 mb-5 " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-12 col-xl-9" >
			<div class="row  " >
			<?php
			$PopulerOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE   Durum=?   ORDER BY CikisTarihi DESC  LIMIT 20" );
			$PopulerOyunlar->execute([1]);
			$Data = $PopulerOyunlar->rowCount();
			$PopulerOyunlarKayitlar = $PopulerOyunlar->fetchAll(PDO::FETCH_ASSOC);
			if ($Data>0) {
				foreach ($PopulerOyunlarKayitlar as  $kayitlar) {
			?>
				<div class="col-6 col-xl-3 mb-5 ">
					<div class="row ">
					<?php
					if (file_exists("images/games/".$kayitlar["AnaResim"]) and ($kayitlar["AnaResim"]) ) {
					?>
					<div class="col-12 ">
						<a href="oyundetay/<?php echo SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
							<img src="images/games/<?php echo IcerikTemizle($kayitlar["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" style="border-radius:5px"  title="<?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?>" class="img-fluid oyunlar gamebrd" style="background: #202020">
						</a>
					</div>
					<?php
					}else{
					?>
						<div class="col-12">
							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>">
								<img src="images/resim.jpg" class="img-fluid oyunlar" >
							</a>
						</div>
					<?php
					}
					?>
						<div class="col-12  mt-2  "  >
							<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($kayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($kayitlar["OyunUniqid"]); ?>"><h6 class="oyunAdi bold yaziAlan"><?php echo  IcerikTemizle($kayitlar["OyunAdi"]);?></h6></a>
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
							<div class="col-12" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
						<?php
						}else{		
						?>
							<div class="col-12 " ><?php echo PuanHesapla(0);?></div>
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
							<div class="col-12  mt-1 " >
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
				</div>
				<?php
				}
				}else{
				?>
		
				<div class="col-11 col-xl-11"  >
					<div class="row justify-content-center  ml-1 "style="background: #202020;">
						<div class="col-12 text-center mt-5 mb-5" >
							<div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div>
						</div>
					</div>
				</div>

				<?php
				}
				?>
			</div>	
		</div>
	</div>			
</div>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}
?>