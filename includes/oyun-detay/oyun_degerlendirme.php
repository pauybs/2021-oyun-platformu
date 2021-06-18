<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-center  p-3 p-xl-5  ">
		<div class="col-12 SAFfXxAERz bGAfxXE" style="" >
			<h6 class="m-0 bold white oyunYazi">Kullanıcı Değerlendirmesi</h6>
		</div>
		<div class="col-12 mt-5 zxZXxbstvc">
			<div class="row justify-content-center align-items-center">
				<div class="col-12 col-xl-6 mb-4"  >
					<div class="row p-4  grafik">
						<?php
						if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
						?>
							<?php
							$KullaniciPuan= $DatabaseBaglanti->prepare("SELECT * FROM oyunpuan WHERE OyunId=? AND UyeId=? LIMIT 1 ");
							$KullaniciPuan->execute([Guvenlik($OyunSorgusuKayit["id"]),Guvenlik($KullaniciId)]);
							$KullaniciPuanSayisi = $KullaniciPuan->rowCount();
							$KullaniciPuanKayitlar = $KullaniciPuan->fetch(PDO::FETCH_ASSOC);
							if ($KullaniciPuanSayisi>0){
							?>
								<div class="col-12 ">
									<div class="row  ">
										<div class="col-12 text-left mb-2 p-0 puan">
										<span class="bold white font15"><?php echo IcerikTemizle($KullaniciAdiSoyadi) ?></span>
										<span class="white oyunYazi bold puan opacity07"><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?>  için kullandığınız oy: <span class="bold" style="color:#c28f2c"><?php echo IcerikTemizle(OyunOrtPuan($KullaniciPuanKayitlar["Puan"]));?></span></span>
										</div>
									</div>
								</div>
								
							<?php
							}else{
							?>
								<div class="col-12 ">
									<div class="row  ">
										<div class="col-12 text-left mb-2 p-0 puan">
										<span class="bold white font15"><?php echo IcerikTemizle($KullaniciAdiSoyadi) ?></span>
										<span class="white oyunYazi bold opacity07"><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]);?>  için oy kullan:</span>
										</div>
									</div>
								</div>
								
								

							<?php
							}
							?>
							<div class="col-12 text-center star-rating p-2" >
									<input id="star-5x"  type="radio" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>" value="5" />
									<label for="star-5x"  >
										<i class="fa fa-star font25" alt="Çok Olumlu" ></i>
									</label>
									<input id="star-4x" type="radio" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>" value="4"/>
									<label for="star-4x" >
										<i class="fa fa-star font25"></i>
									</label>
									<input id="star-3x" type="radio" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>"  value="3"  />
									<label for="star-3x" >
										<i class="fa fa-star font25  "></i>
									</label>
									<input id="star-2x" type="radio"  data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>" value="2" />
									<label for="star-2x" >
										<i class="fa fa-star font25  "></i>
									</label>
									<input id="star-1x" type="radio" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>"  value="1" checked/>
									<label for="star-1x" >
										<i class="fa fa-star font25  "></i>
									</label>    
								</div>
								<div class="col-12 text-center "></div>

						<?php
						}else{
						?>
							<div class="col-12 text-left mb-2 p-0">
								<span class="bold white oyunYazi">Oy vermek için giriş yapınız. </span>
							</div>
							<?php
							$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
							$ToplamPuan->execute([Guvenlik($OyunSorgusuKayit["id"])]);
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
								<div class="col-12 mt-2 mb-2 p-0" ><?php echo OyunPuan($OrtalamaPuan);?></div>
							<?php
							}else{		
								$OrtalamaPuan=0;
							?>
								<div class="col-12  mt-2 mb-2p-0" ><?php echo OyunPuan(0);?></div>
							<?php
							}
							?>
						<?php
						}
						?>
						<div class="col-12 p-0">
							<div class="row">
								<div class="col-12">
									<div class="row">
										<div class="col-12">
											<span class="white bold font13" style=""> Toplam İnceleme:</span>
										</div>
										<div class="col-12">
		
										<?php
										if ($ToplamPuanVeri==0 ) {
										?>
											<span class="bold white oyunYazi ">-</span>	
										<?php
										}else{
										?>
											<span class="bold font18" style="color:#c28f2c">
												<?php echo IcerikTemizle(OyunOrtPuan($OrtalamaPuan)) ?>
											</span> 
											<span class="font14 white opacity07">
												( <?php echo $ToplamPuanVeri; ?> İnceleme )
											</span>
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
				<div class="col-12 col-xl-6 mb-4 mt-3">
				<?php
				$ToplamOySayisi =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunpuan WHERE  OyunId=? ");
				$ToplamOySayisi->execute([Guvenlik($OyunSorgusuKayit["id"])]);
				$ToplamOySayisiVerisi = $ToplamOySayisi->rowCount();
				$ToplamOySayisiKayitlar = $ToplamOySayisi->fetchAll(PDO::FETCH_ASSOC);

				if ($ToplamOySayisiVerisi>0) {
					$CokOlumsuz=0;
					$Olumsuz=0;
					$Kararsiz=0;
					$Olumlu=0;
					$CokOlumlu=0;
					foreach ($ToplamOySayisiKayitlar as  $Oylar) {
					?>
						<?php
						if ($Oylar["Puan"]==1) {
							$CokOlumsuz+=1;
						}else if ($Oylar["Puan"]==2) {
							$Olumsuz+=1;
						}else if($Oylar["Puan"]==3){
							$Kararsiz+=1;
						}else if($Oylar["Puan"]==4){
							$Olumlu+=1;
						}else if ($Oylar["Puan"]==5) {
							$CokOlumlu+=1;
						}

						?>
					<?php
					}
					$CokOlumsuzOrtalama= number_format(($CokOlumsuz/$ToplamOySayisiVerisi)*100, 2,".","");
					$OlumsuzOrtalama= number_format(($Olumsuz/$ToplamOySayisiVerisi)*100, 2,".","");
					$KararsizOrtalama= number_format(($Kararsiz/$ToplamOySayisiVerisi)*100, 2,".","");		
					$OlumluOrtalama= number_format(($Olumlu/$ToplamOySayisiVerisi)*100, 2,".","");
					$CokOlumluOrtalama= number_format(($CokOlumlu/$ToplamOySayisiVerisi)*100, 2,".","");
					?>
				<?php
				}else{
					$CokOlumsuzOrtalama=0.00;
					$OlumsuzOrtalama=0.00;
					$KararsizOrtalama=0.00;
					$OlumluOrtalama=0.00;
					$CokOlumluOrtalama=0.00;
				}
				?>
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center "> 
							<canvas  id="myChart" ></canvas>
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





