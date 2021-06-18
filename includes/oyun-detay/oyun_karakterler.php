<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunKarakter =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=? LIMIT 4 ");
	$OyunKarakter->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunKarakterSayi = $OyunKarakter->rowCount();
	$OyunKarakterKayitlar = $OyunKarakter->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunKarakterSayi>0) {
	?>
	<div class="row justify-content-center  align-items-center p-3 p-xl-5   ">
		<div class="col-5 col-xl-10 SAFfXxAERz bGAfxXE" >
			<h6 class="m-0 bold white oyunYazi">Karakterler</h6>
		</div>
		<?php
		$OyunKarakterSayisi =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=? ");
		$OyunKarakterSayisi->execute([Guvenlik($OyunSorgusuKayit["id"])]);
		$KarakterVerisi = $OyunKarakterSayisi->rowCount();
		if ($KarakterVerisi>4) {
		?>
		<div class="col-7 col-xl-2  ">
			<div class="row p-0 justify-content-end">
				<div class="col-12 p-1 text-center ErYTIxKL  WrGYT__Xx"  >
					<a href="oyunkarakterler/<?php echo SEO(IcerikTemizle($OyunSorgusuKayit["OyunAdi"])) ?>/<?php echo IcerikTemizle($OyunSorgusuKayit["OyunUniqid"]) ?>" >
						<span class=" gxPpxXo_ font10 ">DAHA FAZLA GÖSTER</span>
					</a>
				</div>
			</div>
		</div>
		<?php
		}else{
		?>
		<div class="col-7 col-xl-2  ">
			<div class="row p-0 justify-content-end">
				<div class="col-12 p-1 "  >
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<div class="col-12 mt-4" >
		    <div class="swiper-container swiper8" >
            	<div class="swiper-wrapper">
				<?php
				foreach ($OyunKarakterKayitlar as $Karakter) {
				?>
					<div class="swiper-slide ">
						<div class="col-9 col-xl-12 mb-4">
							<div class="row p-1">	
								<div class="col-12 p-0">
								<?php
								if (file_exists("images/games/character/".$Karakter["KarakterResim"]) and (isset($Karakter["KarakterResim"])) and ($Karakter["KarakterResim"]!="") ){
								?>
									<div class="col-12">
											<a  href="karakterdetay/<?php echo SEO(IcerikTemizle($OyunSorgusuKayit["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($Karakter["KarakterAdi"])) ?>/<?php echo  SEO(IcerikTemizle($OyunId));?>/<?php echo  SEO(IcerikTemizle($Karakter["id"]));?>">
												<img src="images/games/character/<?php echo IcerikTemizle($Karakter["KarakterResim"]); ?>" class="img-fluid zxwqqoi imgbrd" style"border-radius:5px" /> 
											</a>
									</div>		
								<?php
								}else{
								?>
									<div class="col-12"></div>
								<?php
								}
								?>

								<?php
								if (isset($Karakter["KarakterAdi"])) {
								?>
									<div class="col-12 mt-2 mb-1">
											<a  href="karakterdetay/<?php echo SEO(IcerikTemizle($OyunSorgusuKayit["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($Karakter["KarakterAdi"])) ?>/<?php echo  SEO(IcerikTemizle($OyunId));?>/<?php echo  SEO(IcerikTemizle($Karakter["id"]));?>">
											<span class="bold white oyunYazi "><?php echo IcerikTemizle($Karakter["KarakterAdi"]) ?></span>
										</a>
									</div>
								<?php			
								}
								?>
								</div>	
							</div>
						</div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-12 text-center  swiper-pagination8"></div>
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





