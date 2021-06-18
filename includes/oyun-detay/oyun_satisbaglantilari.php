<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunSatisBaglanti =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunsatisplatformlari WHERE  OyunId=? ");
	$OyunSatisBaglanti->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunSatisBaglantiVerisi = $OyunSatisBaglanti->rowCount();
	$OyunSatisBaglantiKayitlar = $OyunSatisBaglanti->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunSatisBaglantiVerisi>0) {
	?>
	<div class="row justify-content-center p-3 p-xl-5">
		<div class="col-12 SAFfXxAERz bGAfxXE">
			<h6 class="m-0 bold white oyunYazi">Satış Bağlantıları</h6>
		</div>
		<div class="col-12 mt-5">
			<div class="row align-items-center text-center">
				<?php
				foreach($OyunSatisBaglantiKayitlar as $Satis) {
				?>
					<?php
					$SatisPlatformAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  satisplatformlari WHERE  id=? LIMIT 1");
					$SatisPlatformAdi->execute([Guvenlik($Satis["PlatformId"])]);
					$SatisPlatformAdiVerisi = $SatisPlatformAdi->rowCount();
					$SatisPlatformAdiKayitlar = $SatisPlatformAdi->fetch(PDO::FETCH_ASSOC);
					?>
					<div class="col-3 col-xl-3 mb-5">
						<div class="row  align-items-center">
							<div class="col-12 mb-2">
								<a  ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($Satis["PlatformLink"])  ?>">
									<?php echo IcerikTemizle(SatisPlatform($SatisPlatformAdiKayitlar["id"])); ?>
								</a>
							</div>
							
						</div>
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


<?php
}else{
	require_once("../../settings/connect.php");
	header("location:" .$SiteLink);
 	 exit();
}
?>





