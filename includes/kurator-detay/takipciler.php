<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-center align-items-center">
		<div class="col-12">
			<div class="row align-items-center">
				<div class="col-4  text-left col-xl-2">
					<div class="row justify-content-center align-items-center text-center">
						<div class="col-12">
						<?php	
						$KuratorTakipSayi = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=?");
						$KuratorTakipSayi->execute([Guvenlik($KuratorBilgilerKayitlar["id"])]);
						$KuratorTakipSayiVeri = $KuratorTakipSayi->rowCount();
						?>
							<span class="bold white kurator">
								<?php echo IcerikTemizle(number_format_short($KuratorTakipSayiVeri)); ?>
							</span>
						</div>
						<div class="col-12">
							<span class="bold white kurator opacity07">Takipçi</span>
						</div>
					</div>
				</div>

				<div class="col-4 text-left col-xl-2">
					<div class="row justify-content-center align-items-center text-center">
						<div class="col-12">
						<?php	
						$KuratorIncelemeSayi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? and Durum=?");
						$KuratorIncelemeSayi->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),1]);
						$KuratorIncelemeSayiVeri = $KuratorIncelemeSayi->rowCount();
						?>
						<span class="bold white kurator">
							<?php echo IcerikTemizle(number_format_short($KuratorIncelemeSayiVeri)); ?> 
						</span>
						</div>
						<div class="col-12">
							<span class="bold white kurator opacity07">İnceleme</span>
						</div>
					</div>
				</div>
				
				<div class="col-4 text-left col-xl-2">
					<div class="row justify-content-center align-items-center text-center">
						<div class="col-12">
						<?php	
						$KuratorBegeniSayi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? And Durum=?");
						$KuratorBegeniSayi->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),1]);
						$KuratorBegeniSayiVeri = $KuratorBegeniSayi->rowCount();
						$KuratorBegeniSayiKayit = $KuratorBegeniSayi->fetchAll(PDO::FETCH_ASSOC);
						$ToplamBegeni=0;
						foreach ($KuratorBegeniSayiKayit as $Begeni) {
							$ToplamBegeni+= $Begeni["Begeni"];
						}
						?>
							<span class="bold white kurator">
								<?php echo IcerikTemizle(number_format_short($ToplamBegeni));?> 
							</span>
						</div>
						<div class="col-12">
							<span class="bold white kurator opacity07">Beğeni</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





