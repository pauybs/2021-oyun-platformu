<?php
require_once("settings/connect.php");

if(isset($_GET["Kategori"]) and  isset($_GET["Soru"])){
	$KategoriId =SayfaNumarasiTemizle(Guvenlik($_GET["Kategori"]));
	$SoruId =SayfaNumarasiTemizle(Guvenlik($_GET["Soru"]));
	$SoruBilgiler =  $DatabaseBaglanti->prepare("SELECT * FROM  yardimsoru WHERE  id=? AND KategoriId=? LIMIT 1 ");
	$SoruBilgiler->execute([$SoruId,$KategoriId]);
	$SoruBilgilerSayi = $SoruBilgiler->rowCount();
	$SoruBilgilerKayit = $SoruBilgiler->fetch(PDO::FETCH_ASSOC);
	if ($SoruBilgilerSayi>0) {	
		$Kategoriler =  $DatabaseBaglanti->prepare("SELECT * FROM  yardimkategori WHERE id=?   LIMIT 1  ");
		$Kategoriler->execute([$SoruBilgilerKayit["KategoriId"]]);
		$KategorilerSayi = $Kategoriler->rowCount();
		$KategorilerKayit = $Kategoriler->fetch(PDO::FETCH_ASSOC);
		
		$Goruntulenme =  $DatabaseBaglanti->prepare("UPDATE yardimsoru SET Goruntulenme=Goruntulenme+1  WHERE  id=? ");
		$Goruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($SoruId))]);
?>
<div class="col-12  m-0 mt-2" style="background:white; ">
	<div class="row mt-5 mb-5">
		<div class="col-12">
			<div class="row justify-content-center">
				<div class="col-11 col-md-7 yrdmwmrkz">
					<div class="row ">
						<div class="col-12">
							<div class="row p-2">
								<div class="col-12 mt-3">
									<h3 class="black"><?php echo IcerikTemizle($SoruBilgilerKayit["Soru"]); ?></h3>
								</div>
								<div class="col-12 mt-2 mb-3">
									<div><?php echo IcerikTemizle($SoruBilgilerKayit["Cevap"]); ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-7  mt-3 mb-5 " >
					<div class="row justify-content-center">
						<div class="col-11 yrdmwmrkz">
							<div class="row">
							<?php
							$KategoriSoru =  $DatabaseBaglanti->prepare("SELECT * FROM  yardimsoru WHERE KategoriId=?  AND id!=? ");
							$KategoriSoru->execute([$KategoriId,$SoruId]);
							$KategoriSoruSayi = $KategoriSoru->rowCount();
							$KategoriSoruKayit = $KategoriSoru->fetchAll(PDO::FETCH_ASSOC);
							if ($KategoriSoruSayi>0) {
							?>
							<div   class="col-12 p-3 yrdmSEA" id="<?php echo IcerikTemizle($KategorilerKayit["id"]);?>" onClick="$.Sistem(<?php echo IcerikTemizle($KategorilerKayit["id"]);?>)">
								<div class="row justify-content-center align-items-center">
									<div class="col-10 text-left">								
										<h5 class=" black font15 m-0"><?php echo IcerikTemizle($KategorilerKayit["KategoriAdi"]); ?></h5>
									</div>
									<div class="col-2 text-center "><i class="fas fa-chevron-down"></i></div>
								</div>	
							</div>
							<div class="col-12  Goster<?php echo IcerikTemizle($KategorilerKayit["id"]); ?>  " style=" display: none"  >
								<div class="row">
								<?php
									foreach ($KategoriSoruKayit as $sorular) {
								?>
									<div class="col-12 parent p-2" >
										<a href="cevap/<?php echo SEO(IcerikTemizle($sorular["Soru"])) ?>/<?php echo IcerikTemizle($KategoriId);?>/<?php echo IcerikTemizle($sorular["id"]);?>">
											<span class="font14 ml-2 black"><?php echo IcerikTemizle($sorular["Soru"]); ?></span>
										</a>

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
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
}else{
	header("location:" .$SiteLink);
	exit();
}
}else{
	header("location:" .$SiteLink);
	exit();
}
?>