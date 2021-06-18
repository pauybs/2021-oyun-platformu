<div class="col-12 m-0 mt-2" style="background:white; ">
	<div class="row mb-5" style="background: #e7e6e3;">
		<div class="col-12 text-center mt-5">
			<i class="far fa-question-circle fa-5x "  style="color: #c28f2c"></i>
		</div>
		<div class="col-12 text-center mt-2 mb-5">
			<h2 style="color: #202020">Size nasıl yardımcı olabiliriz?</h2>
		</div>
	</div>
	<div class="row mt-5 mb-5">
		<div class="col-12 mt-5 mb-5" >
			<div class="row justify-content-center">
				<div class="col-11 col-md-6 yrdmwmrkz mt-5 mb-5" >
				<?php
				$Kategoriler =  $DatabaseBaglanti->prepare("SELECT * FROM  yardimkategori   ");
				$Kategoriler->execute([]);
				$KategorilerSayi = $Kategoriler->rowCount();
				$KategorilerKayit = $Kategoriler->fetchAll(PDO::FETCH_ASSOC);
				if ($KategorilerSayi>0) {
					foreach ($KategorilerKayit as $kategori) {
				?>
					<div class="row">
						<?php
						$KategoriSoru =  $DatabaseBaglanti->prepare("SELECT * FROM  yardimsoru WHERE KategoriId=? ORDER BY Goruntulenme desc ");
						$KategoriSoru->execute([Guvenlik($kategori["id"])]);
						$KategoriSoruSayi = $KategoriSoru->rowCount();
						$KategoriSoruKayit = $KategoriSoru->fetchAll(PDO::FETCH_ASSOC);
						if ($KategoriSoruSayi>0) {
						?>
						<div class="col-12 p-3 yrdmSEA" id="<?php echo IcerikTemizle($kategori["id"]);?>" onClick="$.Sistem(<?php echo IcerikTemizle($kategori["id"]);?>)">
							<div class="row justify-content-center align-items-center">
								<div class="col-10 text-left">								
									<h5 class=" black font15 m-0"><?php echo IcerikTemizle($kategori["KategoriAdi"]); ?></h5>
								</div>
								<div class="col-2 text-center "><i class="fas fa-chevron-down"></i></div>
							</div>	
						</div>
						<div class="col-12  Goster<?php echo IcerikTemizle($kategori["id"]); ?>  " style=" display: none"  >
						<div class="row">
						<?php
							foreach ($KategoriSoruKayit as $sorular) {
						?>
							<div class="col-12 parent p-2" >
								<a href="cevap/<?php echo SEO(IcerikTemizle($sorular["Soru"])) ?>/<?php echo IcerikTemizle($kategori["id"]);?>/<?php echo IcerikTemizle($sorular["id"]);?>"><span class="font14 ml-2 black"><?php echo IcerikTemizle($sorular["Soru"]); ?></span></a>
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
				<?php
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

