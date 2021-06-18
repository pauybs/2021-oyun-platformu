<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-center p-3 p-xl-5">
		<div class="col-12 SAFfXxAERz bGAfxXE" >
			<h6 class=" m-0 bold white oyunYazi">Oyun Hakkında</h6>
		</div>
		<div class="col-12 mt-5" >
			<div class="row">
				<div class="col-12 col-xl-4 mb-4">
					<div class="row">
						<div class="col-12 white oyunYazi" >
							<span class="opacity05">Geliştirici</span>
						</div>
						<div class="col-12 white oyunYazi">
						<?php
						if (IcerikTemizle($OyunSorgusuKayit["Gelistirici"])){
						?>
							<span>
								<?php echo IcerikTemizle($OyunSorgusuKayit["Gelistirici"]);?>			
							</span>
						<?php
						}else{
						?>
							<span>-</span>
						<?php
						}
						?>
						</div>
					</div>
				</div>

				<div class="col-12 col-xl-4 mb-4">
					<div class="row">
						<div class="col-12 white oyunYazi" >
							<span class="opacity05 ">Yayıncı</span>
						</div>
						<div class="col-12 white oyunYazi">
						<?php
						if (IcerikTemizle($OyunSorgusuKayit["Yayinci"])) {
						?>
							<span>
								<?php echo IcerikTemizle($OyunSorgusuKayit["Yayinci"]);?>
							</span>
						<?php
						}else{
						?>
							<span>-</span>
						<?php
						}
						?>
						</div>
					</div>
				</div>

				<div class="col-12 col-xl-4 mb-4">
					<div class="row">
						<div class="col-12 white oyunYazi" >
							<span class="opacity05 ">Çıkış Tarihi</span>
						</div>
						<div class="col-12 white oyunYazi">
						<?php
						if (IcerikTemizle($OyunSorgusuKayit["CikisTarihi"])) {
							$tarih  = OyunTarih($OyunSorgusuKayit["CikisTarihi"]);
	                          $array1=explode('-',$tarih);
	                          $gün=$array1[2];
	                          $ay=OyunAyTarih($array1[1]);
	                          $yil=$array1[0];

						?>
							<span>
								<?php echo $gün." ".$ay." ".$yil ?>
							</span>
						<?php
						}else{
						?>
							<span>-</span>
						<?php
						}
						?>
						</div>
					</div>
				</div>

				<div class="col-12 col-xl-4 mb-4">
					<div class="row">
						<div class="col-12 white oyunYazi" >
							<span class="opacity05 ">Platform</span>
						</div>
						<div class="col-12 white oyunYazi">				
						<?php
						$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
						$OyunPlatform->execute([Guvenlik($OyunSorgusuKayit["id"])]);
						$OyunPlatformSayi = $OyunPlatform->rowCount();
						$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);

						if ($OyunPlatformSayi>0) {
						?>
							<div class="col-12 mt-1 p-0">
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
				</div>
				<div class="col-12 col-xl-4 mb-4">
					<div class="row">
						<div class="col-12 white oyunYazi" >
							<span class="opacity05 ">Kategori</span>
						</div>
						<div class="col-12 white oyunYazi">				
						<?php
						$OyunKategori =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkategorileri WHERE  OyunId=? ");
						$OyunKategori->execute([Guvenlik($OyunSorgusuKayit["id"])]);
						$OyunKategoriSayi = $OyunKategori->rowCount();
						$OyunKategoriKayitlar = $OyunKategori->fetchAll(PDO::FETCH_ASSOC);
						if ($OyunKategoriSayi>0) {
						?>
							<div class="col-12 mt-1 p-0">
							<?php
							foreach ($OyunKategoriKayitlar as  $OyunKategori) {
								$OyunKategoriAdi =$DatabaseBaglanti->prepare("SELECT * FROM  kategoriler WHERE  id=? ");
								$OyunKategoriAdi->execute([Guvenlik($OyunKategori["KategoriId"])]);
								$OyunKategoriAdiSayi = $OyunKategoriAdi->rowCount();
								$OyunKategoriAdiKayitlar = $OyunKategoriAdi->fetch(PDO::FETCH_ASSOC);
								if ($OyunKategoriAdiSayi>0) {
								?>
									<?php echo $OyunKategoriAdiKayitlar["KategoriAdi"]."," ?>
								<?php
								}		
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
				$OyunHakkinda =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunaciklama WHERE  OyunId=? ");
				$OyunHakkinda->execute([Guvenlik($OyunSorgusuKayit["id"])]);
				$OyunHakkindaSayi = $OyunHakkinda->rowCount();
				$OyunHakkindaKayitlar = $OyunHakkinda->fetchAll(PDO::FETCH_ASSOC);
				if ($OyunHakkindaSayi>0) {
				?>
				<div class="sozsXzv y">
				    <?php
					foreach ($OyunHakkindaKayitlar as  $Hakkinda) {
				?>
				<div class="col-12 mt-4 ">
					<div class="row">
					<?php
					if ( IcerikTemizle($Hakkinda["OyunHakkindaBaslik"]) ) {
					?>	
						<div class="col-12  " >
							<h1 class="white oyunYazi bold" >
								<?php echo IcerikTemizle($Hakkinda["OyunHakkindaBaslik"]);?>
							</h1>	
						</div>
					<?php
					}
					?>
					
					<?php
					if(IcerikTemizle($Hakkinda["OyunHakkindaAciklama"]) ) {
					?>	
						<div class="col-12 white oyunYazi mt-2  opacity07"  >
							<div ><?php echo IcerikTemizle($Hakkinda["OyunHakkindaAciklama"]);?></div>
						</div>
						
						
					<?php
					}
					?>
					</div>
				</div>
				<?php
					}
				?>
				</div>
				<div class="col-12 dvm d p-2 text-center font11" style="background: linear-gradient(0deg,#121212 0,transparent 100%);"><<span class="bold white"> DEVAMINI OKU</span> <i class="fas fa-angle-down white"></i></div>
				<?php
				}
				?>
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





