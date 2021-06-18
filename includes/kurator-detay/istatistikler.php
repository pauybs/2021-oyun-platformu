<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row p-2" >
		<div class="col-12 MCVXAxsA" >
			<div class="row justify-content-center align-items-center">
				<div class="col-12 text-center">
					<div class="row">
						<div class="col-12 bold mt-4" style="color: #c28f2c">
						<?php	
						$Erisim = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE KuratorId=? And Durum=? " );
						$Erisim->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),1]);
						$ErisimVeri = $Erisim->rowCount();
						$ErisimKayit = $Erisim->fetchAll(PDO::FETCH_ASSOC);
						$ToplamErisim=0;
						foreach ($ErisimKayit as $Erisimler) {
							$ToplamErisim+= $Erisimler["Goruntulenme"];
						}
						if ($ToplamErisim==0) {
							$ErisimSayisi= "-";
						}else{
							$ErisimSayisi=$ToplamErisim;
						}
						?>

							<h4><?php echo IcerikTemizle(number_format_short($ErisimSayisi)); ?></h4>
						</div>
						<div class="col-12 bold white"><h6>Erişim</h6></div>
						<div class="col-12 bold mt-4 " style="color: #c28f2c">
						<?php	
						if ($KuratorIncelemeSayiVeri==0) {
							$IncelemeSayisi= "-";
						}else{
							$IncelemeSayisi=$KuratorIncelemeSayiVeri;
						}
						?>
							<h4><?php echo IcerikTemizle(number_format_short($IncelemeSayisi)); ?></h4>
						</div>
						<div class="col-12 bold white"><h6>İnceleme</h6></div>
						<div class="col-12 bold mt-4 " style="color: #c28f2c">
						<?php	
							if ($ToplamBegeni==0) {
								$ToplamBegeni= "-";
							}
							?>
							<h4><?php echo IcerikTemizle(number_format_short($ToplamBegeni)); ?></h4>
						</div>
						<div class="col-12 bold white mb-2"><h6>Beğeni</h6></div>
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





