<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunResimler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunresimler WHERE  OyunId=? ");
	$OyunResimler->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunResimlerVeri = $OyunResimler->rowCount();
	$OyunResimlerKayitlar = $OyunResimler->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunResimlerVeri>0) {
	?>
	<div class="row justify-content-center">
		<div class="col-12 col-md-9">
			<div class="swiper-container swiper6">
				<div class="swiper-wrapper mb-5" >
				<?php
				foreach ($OyunResimlerKayitlar as  $Resimler) {
				?>
					<?php
					if (IcerikTemizle($Resimler["Resim"]!="") and IcerikTemizle(isset($Resimler["Resim"])) and file_exists("images/games/pictures/".$Resimler["Resim"]) ) {
					?>	
						<div class="swiper-slide"> 
							<img  src="images/games/pictures/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" class="img-fluid " alt="<?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]); ?>"/>
							
						</div>
					<?php
					}else{
					?>	
						<div class="swiper-slide">
							<img   src="images/hata2.jpg" class="img-fluid "/>
						</div>
					<?php
					}
					?>
				<?php
				}
				?>
				</div>
			    <div class="swiper-button-next"></div>
			    <div class="swiper-button-prev"></div>
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





