<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
		
	<?php
	$OyunSistemGereksinim =  $DatabaseBaglanti->prepare("SELECT * FROM  oyungereksinim WHERE  OyunId=? ");
	$OyunSistemGereksinim->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunSistemGereksinimVerisi = $OyunSistemGereksinim->rowCount();
	$OyunSistemGereksinimKayitlar = $OyunSistemGereksinim->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunSistemGereksinimVerisi>0) {
	?>
	<div class="col-12 mt-5  ksayXtAS">
		<div class="row justify-content-center p-3 p-xl-5 ">
			<div class="col-12 SAFfXxAERz bGAfxXE" >
				<span class="bold white oyunYazi">Gereksinimler</span>
			</div>
			<?php
			foreach ($OyunSistemGereksinimKayitlar as $Gereksinim) {
			$MinimumDepolama=IcerikTemizle($Gereksinim["MinimumDepolama"]);
			$MinimumNotlar=IcerikTemizle($Gereksinim["MinimumNotlar"]);
			$OnerilenIsletimSistemi=IcerikTemizle($Gereksinim["OnerilenIsletimSistemi"]);
			$OnerilenIslemci=IcerikTemizle($Gereksinim["OnerilenIslemci"]);
			$OnerilenEkranKarti=IcerikTemizle($Gereksinim["OnerilenEkranKarti"]);
			$OnerilenDirectx=IcerikTemizle($Gereksinim["OnerilenDirectx"]);
			$OnerilenRam=IcerikTemizle($Gereksinim["OnerilenRam"]);
			$OnerilenDepolama=IcerikTemizle($Gereksinim["OnerilenDepolama"]);
			$OnerilenNotlar=IcerikTemizle($Gereksinim["OnerilenNotlar"]);
			?>

			<?php
			$PlatformAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  gereksinimplatformu WHERE  id=? LIMIT 1");
			$PlatformAdi->execute([Guvenlik($Gereksinim["IsletimSistemiAdi"])]);
			$PlatformAdiVeri = $PlatformAdi->rowCount();
			$PlatformAdiKayitlar = $PlatformAdi->fetch(PDO::FETCH_ASSOC);
			if ($PlatformAdiVeri>0) {
			?>
			<div class="col-12">
				<div class="row"> 
					<div class="col-12 mt-4  p-2 asatuZADXH" id="<?php echo IcerikTemizle($Gereksinim["id"]);?>" onClick="$.Sistem(<?php echo IcerikTemizle($Gereksinim["id"]);?>)">
						<div class="row">
							<div class="col-10 col-xl-11">
								<span class="bold white oyunYazi">
									<?php echo IcerikTemizle($PlatformAdiKayitlar["PlatformAdi"]); ?>	
								</span>
							</div>
							<div class="col-2 col-xl-1">
								<span class="bold white font20">
									<i class="fas fa-chevron-down"></i>
								</span>
							</div>
						</div>
					</div>

					<div class="col-12 Goster<?php echo IcerikTemizle($Gereksinim["id"]); ?> ayznmaUAZ">	
						<div class="col-12 mt-5" >
							<div class="row justify-content-center">
								<div class="col-12 col-xl-6 mb-4">
									<div class="row">
										<div class="col-12">
											<span class="white oyunYazi bold oyunYazi opacity05" >Minimum</span>
										</div>
									</div>

									<div class="row mt-4 ">
										<div class="col-12">
											<span class="white oyunYazi opacity05" >İşletim Sistemi</span>
										</div>
										<div class="col-12">
										<?php
										$MinimumIsletimSistemi =  $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
										$MinimumIsletimSistemi->execute([Guvenlik($Gereksinim["MinimumIsletimSistemiId"])]);
										$MinimumIsletimSistemiVeri = $MinimumIsletimSistemi->rowCount();
										$MinimumIsletimSistemiKayitlar = $MinimumIsletimSistemi->fetch(PDO::FETCH_ASSOC);
										if ($MinimumIsletimSistemiVeri>0) {
											$IsletimSistemiMarka= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiMarka"]);
											$IsletimSistemiPuan= IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiPuan"]);
										?>
											<span class="UYtbbzXxZ oyunYazi" >
												<?php echo  IcerikTemizle($MinimumIsletimSistemiKayitlar["IsletimSistemiAdi"]); ?>
											</span>

											<?php
											$KullaniciIsletimSistemi =$DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE  id=? LIMIT 1");
											$KullaniciIsletimSistemi->execute([Guvenlik($KullaniciIsletimSistemiId)]);
											$KullaniciIsletimSistemiVeri = $KullaniciIsletimSistemi->rowCount();
											$KullaniciIsletimSistemiKayitlar = $KullaniciIsletimSistemi->fetch(PDO::FETCH_ASSOC);
											if ($KullaniciIsletimSistemiVeri>0) {
												$KullaniciIsletimSistemiMarka= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiMarka"]);
												$KullaniciIsletimSistemiPuan= IcerikTemizle($KullaniciIsletimSistemiKayitlar["IsletimSistemiPuan"]);
											?>	
												<?php
												if ($KullaniciIsletimSistemiMarka == $IsletimSistemiMarka) {
												?>
													<?php
													if ($KullaniciIsletimSistemiPuan >= $IsletimSistemiPuan) {
													?>
														<i class="fas fa-check-circle green "></i>
													<?php
													}else{
													?>
														<i class="fas fa-times-circle red "></i>
													<?php
													}
													?>
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >-</span>
										<?php
										}
										?>		
										</div>	
									</div>

									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05" >İşlemci</span>
										</div>
										<div class="col-12">
										<?php
										$KullaniciIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
										$KullaniciIslemci->execute([Guvenlik($KullaniciIslemciId)]);
										$KullaniciIslemciVeri = $KullaniciIslemci->rowCount();
										$KullaniciIslemciKayitlar = $KullaniciIslemci->fetch(PDO::FETCH_ASSOC);

										if ($KullaniciIslemciVeri>0) {
											$KullaniciIslemciMarka= IcerikTemizle($KullaniciIslemciKayitlar["IslemciMarka"]);
											$KullaniciIslemciPuan= IcerikTemizle($KullaniciIslemciKayitlar["IslemciPuan"]);
										?>	
											<?php
											$MinimumIslemci =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
											$MinimumIslemci->execute([Guvenlik($Gereksinim["MinimumIslemciId"])]);
											$MinimumIslemciVeri = $MinimumIslemci->rowCount();
											$MinimumIslemciKayitlar = $MinimumIslemci->fetch(PDO::FETCH_ASSOC);
											if ($MinimumIslemciVeri>0) {
												$IslemciMarka= IcerikTemizle($MinimumIslemciKayitlar["IslemciMarka"]);
												$IslemciAdi= IcerikTemizle($MinimumIslemciKayitlar["IslemciAdi"]);
												$IslemciPuan= IcerikTemizle($MinimumIslemciKayitlar["IslemciPuan"]);
											?>

											<?php
											}else{
												$IslemciMarka="";
												$IslemciPuan="";
												$IslemciAdi= "";
											}
											?>
											
											<?php	
											$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
											$MinimumIslemci2->execute([Guvenlik($Gereksinim["MinimumIslemci2Id"])]);
											$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
											$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
											if ($MinimumIslemci2Veri>0) {
												$Islemci2Marka= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciMarka"]);
												$Islemci2Adi= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
												$Islemci2Puan= IcerikTemizle($MinimumIslemci2Kayitlar["IslemciPuan"]);
											?>
											<?php
											}else{
												$Islemci2Marka="" ;
												$Islemci2Puan="" ;
												$Islemci2Adi="";
											}
											?>

											<?php
											if($KullaniciIslemciMarka == $IslemciMarka){
											?>
												<span class="UYtbbzXxZ oyunYazi" ><?php echo  IcerikTemizle($IslemciAdi); ?></span>
												
												<?php
												if ($KullaniciIslemciPuan == $IslemciPuan) {
												?>
													<i class="fas fa-angle-left  " style="color: #c28f2c" ></i>
													<i class="fas fa-angle-right " style="color: #c28f2c" ></i> 
															
												<?php
												}else if ($KullaniciIslemciPuan > $IslemciPuan){
												?>
													<?php
													$fark =$KullaniciIslemciPuan-$IslemciPuan;
													if ($fark>0 and $fark<=1999) {
													?>
														<i class="fas fa-angle-up     "style="color: #b3db00  "></i>

													<?php
													}else{
													?>

														<i class="fas fa-angle-double-up    " style="color: #077700"  ></i>
															
													<?php
													}
													?>
												<?php
												}else if($KullaniciIslemciPuan < $IslemciPuan){
												?>
													<?php
													$fark =$IslemciPuan-$KullaniciIslemciPuan;
													if ($fark>0 and $fark <=799) {
													?>
														<i class="fas fa-angle-down    " style="color: #ef5121" ></i>
													<?php
													}else{
													?>
														<i class="fas fa-angle-double-down    red"  ></i>

													<?php
													}
													?>

												<?php
												}
												?>

											<?php
											}else if($KullaniciIslemciMarka == $Islemci2Marka){
											?>
												<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
												<?php
												if ($KullaniciIslemciPuan == $Islemci2Puan) {
												?>

													<i class="fas fa-angle-left  " style="color: #c28f2c" ></i>
													<i class="fas fa-angle-right " style="color: #c28f2c" ></i> 
															
												<?php
												}else if ($KullaniciIslemciPuan > $Islemci2Puan){
												?>
													<?php
													$fark =$KullaniciIslemciPuan-$Islemci2Puan;
													if ($fark>0 and $fark<=1999) {
													?>

															<i class="fas fa-angle-up     "style="color: #b3db00  "></i>

													<?php
													}else{
													?>

															<i class="fas fa-angle-double-up    " style="color: #077700"  ></i>
															<span class="bold white font11"> Çok Yüksek Performans</span>
														
													<?php
													}
													?>
												<?php
												}else if($KullaniciIslemciPuan < $Islemci2Puan){
												?>
													<?php
													$fark =$Islemci2Puan-$KullaniciIslemciPuan;
													if ($fark>0 and $fark <=799) {
													?>

														<i class="fas fa-angle-down    " style="color: #ef5121" ></i>

													<?php
													}else{
													?>
														<i class="fas fa-angle-double-down    red"  ></i>
													<?php
													}
													?>

												<?php
												}
												?>

											<?php
											}else{
											?>
												<?php
												if ($IslemciAdi!="") {
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($IslemciAdi); ?>/</span>
												<?php
												} 
												?>

												<?php
												if($Islemci2Adi!=""){
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}else{
										?>
											<?php
											$MinimumIslemci = $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE id=? LIMIT 1");
											$MinimumIslemci->execute([Guvenlik($Gereksinim["MinimumIslemciId"])]);
											$MinimumIslemciVeri = $MinimumIslemci->rowCount();
											$MinimumIslemciKayitlar = $MinimumIslemci->fetch(PDO::FETCH_ASSOC);
											if ($MinimumIslemciVeri>0) {
												$IslemciAdi= $MinimumIslemciKayitlar["IslemciAdi"];
											?>
												<span class="UYtbbzXxZ oyunYazi"><?php echo  IcerikTemizle($IslemciAdi); ?>/</span>
												<?php	
												$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
												$MinimumIslemci2->execute([Guvenlik($Gereksinim["MinimumIslemci2Id"])]);
												$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
												$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
												if ($MinimumIslemci2Veri>0) {
													$Islemci2Adi=  IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
												<?php
												}else{
												?>

												<?php
												}
												?>
											<?php
											}else{
											?>
												<?php	
												$MinimumIslemci2 =  $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE  id=? LIMIT 1");
												$MinimumIslemci2->execute([Guvenlik($Gereksinim["MinimumIslemci2Id"])]);
												$MinimumIslemci2Veri = $MinimumIslemci2->rowCount();
												$MinimumIslemci2Kayitlar = $MinimumIslemci2->fetch(PDO::FETCH_ASSOC);
												if ($MinimumIslemci2Veri>0) {
													$Islemci2Adi=  IcerikTemizle($MinimumIslemci2Kayitlar["IslemciAdi"]);
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Islemci2Adi); ?></span>
												<?php
												}else{
												?>
													<span class="UYtbbzXxZ oyunYazi" >-</span>
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}
										?>
										</div>
									</div>

									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05">Bellek</span>
										</div>
										<div class="col-12">
										<?php
										$MinimumBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
										$MinimumBellek->execute([Guvenlik($Gereksinim["MinimumRamId"])]);
										$MinimumBellekVeri = $MinimumBellek->rowCount();
										$MinimumBellekKayitlar = $MinimumBellek->fetch(PDO::FETCH_ASSOC);
										if ($MinimumBellekVeri>0){
											$MinimumBellekPuan=  IcerikTemizle($MinimumBellekKayitlar["RamPuan"]);
										?>
											<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($MinimumBellekKayitlar["RamTuru"]); ?></span>
											
											<?php
											$KullaniciBellek =  $DatabaseBaglanti->prepare("SELECT * FROM ram WHERE  id=? LIMIT 1");
											$KullaniciBellek->execute([Guvenlik($KullaniciPcRamId)]);
											$KullaniciBellekVeri = $KullaniciBellek->rowCount();
											$KullaniciBellekKayitlar = $KullaniciBellek->fetch(PDO::FETCH_ASSOC);
											if ($KullaniciBellekVeri>0) {
												$KullaniciBellekPuan=  IcerikTemizle($KullaniciBellekKayitlar["RamPuan"]);
											?>	
												<?php
												if ($KullaniciBellekPuan >= $MinimumBellekPuan) {
												?>
													<i class="fas fa-check-circle green "></i>
												<?php
												}else{
												?>
													<i class="fas fa-times-circle red "></i>
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >-</span>
										<?php
										}
										?>	
										</div>
									</div>
									
									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05" >Ekran Kartı</span>
										</div>
										<div class="col-12">
										<?php
										$KullaniciEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
										$KullaniciEkranKarti->execute([Guvenlik($KullaniciEkranKartiId)]);
										$KullaniciEkranKartiVeri = $KullaniciEkranKarti->rowCount();
										$KullaniciEkranKartiKayitlar = $KullaniciEkranKarti->fetch(PDO::FETCH_ASSOC);
										if ($KullaniciEkranKartiVeri>0) {
											$KullaniciEkranKartiMarka=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiMarka"]);
											$KullaniciEkranKartiPuan=  IcerikTemizle($KullaniciEkranKartiKayitlar["EkranKartiPuan"]);
										?>	
											<?php
											$MinimumEkranKarti =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
											$MinimumEkranKarti->execute([Guvenlik($Gereksinim["MinimumEkranKartiId"])]);
											$MinimumEkranKartiVeri = $MinimumEkranKarti->rowCount();
											$MinimumEkranKartiKayitlar = $MinimumEkranKarti->fetch(PDO::FETCH_ASSOC);
											if ($MinimumEkranKartiVeri>0) {
												$EkranKartiMarka=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiMarka"]);
												$EkranKartiAdi=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiAdi"]);
												$EkranKartiPuan=  IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiPuan"]);
											?>
											<?php
											}else{
												$EkranKartiMarka="";
												$EkranKartiPuan="";
												$EkranKartiAdi= "";
											}
											?>
											
											<?php	
											$MinimumEkranKarti2 =  $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
											$MinimumEkranKarti2->execute([Guvenlik($Gereksinim["MinimumEkranKarti2Id"])]);
											$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
											$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
											if ($MinimumEkranKarti2Veri>0) {
												$EkranKarti2Marka=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiMarka"]);
												$EkranKarti2Adi=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiAdi"]);
												$EkranKarti2Puan=  IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiPuan"]);
											?>
											<?php
											}else{
												$EkranKarti2Marka="" ;
												$EkranKarti2Puan="" ;
												$EkranKarti2Adi="";
											}
											?>
											
											<?php
											 if($KullaniciEkranKartiMarka == $EkranKartiMarka){
											?>
												
												<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?></span>
												<?php
												if ($KullaniciEkranKartiPuan == $EkranKartiPuan) {
												?>

													<i class="fas fa-angle-left  " style="color: #c28f2c" ></i>
													<i class="fas fa-angle-right " style="color: #c28f2c" ></i> 
											
												<?php
												}else if ($KullaniciEkranKartiPuan > $EkranKartiPuan){
												?>
													<?php
													$fark =$KullaniciEkranKartiPuan-$EkranKartiPuan;
													if ($fark>0 and $fark<=799) {
													?>
														<i class="fas fa-angle-up     "style="color: #b3db00  "></i>

													<?php
													}else{
													?>

														<i class="fas fa-angle-double-up    " style="color: #077700"  ></i>
															
													<?php
													}
													?>
												<?php
												}else if($KullaniciEkranKartiPuan < $EkranKartiPuan){
												?>
													<?php
													$fark =$EkranKartiPuan-$KullaniciEkranKartiPuan;
													if ($fark>0 and $fark <=399) {
													?>

														<i class="fas fa-angle-down    " style="color: #ef5121" ></i>
													<?php
													}else{
													?>

														<i class="fas fa-angle-double-down    red"  ></i>

													<?php
													}
													?>

												<?php
												}
												?>
											<?php
											}else if ($KullaniciEkranKartiMarka == $EkranKarti2Marka) {
											?>

												<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
												<?php
												if ($KullaniciEkranKartiPuan == $EkranKarti2Puan) {
												?>

													<i class="fas fa-angle-left  " style="color: #c28f2c" ></i>
													<i class="fas fa-angle-right " style="color: #c28f2c" ></i> 
															

												<?php
												}else if ($KullaniciEkranKartiPuan > $EkranKarti2Puan){
												?>
													<?php
													$fark =$KullaniciEkranKartiPuan-$EkranKarti2Puan;
													if ($fark>0 and $fark<=799) {
													?>

														<i class="fas fa-angle-up     "style="color: #b3db00  "></i>

													<?php
													}else{
													?>
														<i class="fas fa-angle-double-up    " style="color: #077700"  ></i>
															
													<?php
													}
													?>
												<?php
												}else if($KullaniciEkranKartiPuan < $EkranKarti2Puan){
												?>
													<?php
													$fark =$EkranKarti2Puan-$KullaniciEkranKartiPuan;
													if ($fark>0 and $fark <=399) {
													?>

														<i class="fas fa-angle-down   " style="color: #ef5121" ></i>
														


													<?php
													}else{
													?>

														<i class="fas fa-angle-double-down    red"  ></i>

													<?php
													}
													?>

												<?php
												}
												?>
											<?php
											}else{
											?>
												<?php
												if ($EkranKartiAdi!=""){
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?>/</span>
												<?php
												} 
												?>

												<?php
												if($EkranKarti2Adi!=""){
												?>
													<span class="UYtbbzXxZ oyunYazi" ><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
												<?php
												}
												?>
											<?php
											}
											?>																
										<?php
										}else{
										?>
											<?php
											$MinimumEkranKarti=$DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
											$MinimumEkranKarti->execute([Guvenlik($Gereksinim["MinimumEkranKartiId"])]);
											$MinimumEkranKartiVeri = $MinimumEkranKarti->rowCount();
											$MinimumEkranKartiKayitlar = $MinimumEkranKarti->fetch(PDO::FETCH_ASSOC);
											if ($MinimumEkranKartiVeri>0) {
												$EkranKartiAdi= IcerikTemizle($MinimumEkranKartiKayitlar["EkranKartiAdi"]);
											?>
												<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKartiAdi); ?>/</span>
												<?php	
												$MinimumEkranKarti2 =$DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
												$MinimumEkranKarti2->execute([Guvenlik($Gereksinim["MinimumEkranKarti2Id"])]);
												$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
												$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
												if ($MinimumEkranKarti2Veri>0) {
													$EkranKarti2Adi= $MinimumEkranKarti2Kayitlar["EkranKartiAdi"];	
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
												<?php
												}else{
												?>

												<?php
												}
												?>
											<?php
											}else{
											?>
												<?php	
												$MinimumEkranKarti2 = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE  id=? LIMIT 1");
												$MinimumEkranKarti2->execute([Guvenlik($Gereksinim["MinimumEkranKarti2Id"])]);
												$MinimumEkranKarti2Veri = $MinimumEkranKarti2->rowCount();
												$MinimumEkranKarti2Kayitlar = $MinimumEkranKarti2->fetch(PDO::FETCH_ASSOC);
												if ($MinimumEkranKarti2Veri>0) {
													$EkranKarti2Adi= IcerikTemizle($MinimumEkranKarti2Kayitlar["EkranKartiAdi"]);	
												?>
													<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($EkranKarti2Adi); ?></span>
												<?php
												}else{
												?>
													<span class="UYtbbzXxZ oyunYazi" >-</span>
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}
										?>	
										</div>
									</div>

									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05" >Direct X</span>
										</div>
										<div class="col-12">
										<?php
										$MinimumDirectx =  $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
										$MinimumDirectx->execute([Guvenlik($Gereksinim["MinimumDirectxId"])]);
										$MinimumDirectxVeri = $MinimumDirectx->rowCount();
										$MinimumDirectxKayitlar = $MinimumDirectx->fetch(PDO::FETCH_ASSOC);
										if ($MinimumDirectxVeri>0) {
											$MinimumDirectxPuan=  IcerikTemizle($MinimumDirectxKayitlar["DirectxPuan"]);
										?>
											<span class="UYtbbzXxZ oyunYazi" ><?php echo IcerikTemizle($MinimumDirectxKayitlar["DirectxAdi"]); ?></span>

											<?php
											$KullaniciDirectx=$DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
											$KullaniciDirectx->execute([Guvenlik($KullaniciPcDirectxId)]);
											$KullaniciDirectxVeri = $KullaniciDirectx->rowCount();
											$KullaniciDirectxKayitlar = $KullaniciDirectx->fetch(PDO::FETCH_ASSOC);
											if ($KullaniciDirectxVeri>0) {
												$KullaniciDirectxPuan=  IcerikTemizle($KullaniciDirectxKayitlar["DirectxPuan"]);
											?>	
												<?php
												if ($KullaniciDirectxPuan >= $MinimumDirectxPuan) {
												?>
													<i class="fas fa-check-circle green "></i>
												<?php
												}else{
												?>
													<i class="fas fa-times-circle red "></i>
															
												<?php
												}
												?>
											<?php
											}
											?>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >-</span>
										<?php
										}
										?>
										</div>
									</div>
									
									<div class="row mt-3">
										<div class="col-12">
											<span class="white  oyunYazi opacity05">Depolama</span>
										</div>
										<div class="col-12">
										<?php
										if ($MinimumDepolama!="") {
										?>
											<span class="UYtbbzXxZ oyunYazi" ><?php echo IcerikTemizle($MinimumDepolama); ?></span>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >- </span>
										<?php
										}
										?>		
										</div>
									</div>

									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05" >Notlar</span>
										</div>
										<div class="col-12">
										<?php
										if ($MinimumNotlar!="") {
										?>
											<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($MinimumNotlar); ?></span>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >-</span>
										<?php
										}
										?>
										</div>
									</div>
								</div>

								<div class="col-12 col-xl-6">
									<div class="row">
										<div class="col-12">
											<span class="white oyunYazi bold opacity05" >Önerilen</span>
										</div>
									</div>

									<?php
									$Onerilen= array(
										array('Adi' =>"İşletim Sistemi",'Bilgi'=> $OnerilenIsletimSistemi),
										array('Adi' =>"İşlemci",'Bilgi'=> $OnerilenIslemci),
										array('Adi' =>"Bellek",'Bilgi'=> $OnerilenRam),
										array('Adi' =>"Ekran Kartı",'Bilgi'=> $OnerilenEkranKarti),
										array('Adi' =>"Direct X",'Bilgi'=> $OnerilenDirectx),
										array('Adi' =>"Depolama",'Bilgi'=> $OnerilenDepolama),
										array('Adi' =>"Notlar",'Bilgi'=> $OnerilenNotlar),
										);	
									?>

									<?php
									for($i=0;$i<count($Onerilen);$i++){
									?>
									<div class="row mt-3">
										<div class="col-12">
											<span class="white oyunYazi opacity05" ><?php echo IcerikTemizle($Onerilen[$i]["Adi"]); ?></span>
										</div>
										<div class="col-12">
										<?php
										if (IcerikTemizle($Onerilen[$i]["Bilgi"])!="") {
										?>
											<span class="UYtbbzXxZ oyunYazi"><?php echo IcerikTemizle($Onerilen[$i]["Bilgi"]); ?></span>
										<?php
										}else{
										?>
											<span class="UYtbbzXxZ oyunYazi" >-</span>
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
			<?php	
			}else{
			?>
			<?php
			}
			?>
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





