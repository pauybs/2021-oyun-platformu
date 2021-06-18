<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and ($KullaniciEditorDurumu==1)  ){
$SayfalarSolVeSagButonSayisi = 2;
$GosterilecekKayitSayisi = 8;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT  *  FROM haberler WHERE Editor=?  and Durum!=? and Durum!=? ORDER BY id ASC  ");
$ToplamKayitSorgu->execute([Guvenlik($KullaniciId),2,4]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>
<div class=" col-12 Uizahse cvnQAAzx ">
	<div class="row justify-content-center  ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1 class="bold font15  white"><span  >Haberlerim</span></h1>
					</div>
					<div class="col-12 col-xl-11 mt-3 golge "style="background:  rgb(0,0,0,0.5);" >
						<div class="row  justify-content-center ">
							<div class="col-12 mt-5 mb-5 JkANZMwex "  >
								<div class="row m-0 align-items-center">
								<?php
								$HaberlerSorgu = $DatabaseBaglanti->prepare("SELECT *  FROM haberler WHERE Editor=? and Durum!=? and Durum!=? ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
								$HaberlerSorgu->execute([Guvenlik($KullaniciId),2,4]);
								$HaberlerVeri = $HaberlerSorgu->rowCount();
								$HaberlerKayit = $HaberlerSorgu->fetchAll(PDO::FETCH_ASSOC);
								if($HaberlerVeri>0){
									foreach($HaberlerKayit as $Haberler) {
								?>
									<div class="col-12 col-xl-3 mb-3" id="he<?php echo $Haberler["id"] ?>" >
										<div class="row p-1">
											<div class="col-12" style="background:  #202020;">
												<div class="row align-items-center  " >
												<?php
												if (file_exists("images/news/".IcerikTemizle($Haberler["AnaResim"])) and (IcerikTemizle($Haberler["AnaResim"]))) {
												?>
													<div class="col-12">
														<div class="row align-items-center">
															<div class="col-12 p-0">
																<a href="haberlerimdetay/<?php echo IcerikTemizle($KullaniciAdi)?>/<?php echo  SEO(IcerikTemizle($Haberler["AnaBaslik"]));?>/<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>">
																	<img src="images/news/<?php echo IcerikTemizle($Haberler["AnaResim"]);?>" class="img-fluid wWfVCA" <?php if ($Haberler["Durum"]==0) { ?> style="filter: grayscale(100%);" <?php } ?> >
																</a>
															</div>
															<?php
															if ($Haberler["Durum"]==0) {
															?>
															<div class="col-12 text-center pt-3 p-2 position-absolute cvbnkasxczqz" >
																<span class="bold white font14">Haberini <a target="blank" style="color: #c28f2c" href="topluluk-kurallari">topluluk kurallarımız</a>  gereğince kaldırdık. Bu konuda haklı olduğunu düşünüyorsan bizimle iletişime geç.</span>
															</div>
															<?php
															}
															?>
														</div>
													</div>
												<?php
												}else{
												?>
													<div class="col-12 p-0">
														<div class="row ">
															<div class="col-12 ">
																<a href="haberlerimdetay/<?php echo IcerikTemizle($KullaniciAdi)?>/<?php echo  SEO(IcerikTemizle($Haberler["AnaBaslik"]));?>/<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>">
																	<img src="images/hata.jpg" class="img-fluid wWfVCA"  >
																</a>
															</div>
														</div>
													</div>
												<?php
												}
												?>
													<div class="col-12 bold white mt-1 mb-1 font15  text-center yazyATZB" s>
														<span><?php echo IcerikTemizle($Haberler["AnaBaslik"]); ?><span>
													</div>
													<div class="col-12 mt-2 m-0 mb-3">
														<div class="row justify-content-center align-items-center  text-center">
														<?php
														if (IcerikTemizle($Haberler["Durum"])==1) {
														?>
															<div class=" col-6 text-right font25 "  >
																<i style="cursor:pointer" class="fas fa-trash-alt hsb white " data-type="<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>"  id="eh<?php echo IcerikTemizle($Haberler["id"]) ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($Haberler["id"]) ?>"> </i>
															</div>
															<div class="col-6 text-left">
																<div class="four">
																	<div class="button-wrap button-active " data-type="<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="h<?php echo IcerikTemizle($Haberler["id"]) ?>" data="<?php echo IcerikTemizle($Haberler["id"]) ?>" >
																		<div class="button-bg">
																			<div class="button-out"></div>
																			<div class="button-in"></div>
																			<div class="button-switch"></div>
																		</div>
																	</div>
																</div>
															</div>
														<?php	
														}else if (IcerikTemizle($Haberler["Durum"])==3){
														?>
															<div class=" col-6 text-right font25" >
																<i  style="cursor:pointer" class="fas fa-trash-alt hsb white" data-type="<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>"  id="eh<?php echo IcerikTemizle($Haberler["id"]) ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($Haberler["id"]) ?>"> </i>
															</div>
															<div class="col-6 text-left">
																<div class="four">
																	<div class="button-wrap " data-type="<?php echo IcerikTemizle($Haberler["HaberUniqid"]) ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="h<?php echo IcerikTemizle($Haberler["id"]) ?>" data="<?php echo IcerikTemizle($Haberler["id"]) ?>" >
																		<div class="button-bg">
																			<div class="button-out"></div>
																			<div class="button-in"></div>
																			<div class="button-switch"></div>
																		</div>
																	</div>
																</div>
															</div>
														<?php
														}else{
														?>
															<div class=" col-12 text-center font25" style="padding: 20px" ></div>
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
								}
								?>

								<?php
								if($SayfaSayisi>1){
								?>
								<div class="col-12 text-center mt-3   p-4"  >
								<?php
								if($Sayfalar>1 ){
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28' href='haberlerim/1'> <i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28' href='haberlerim/".$SayfaGeri."'> <i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='aktif p-2 bold zcjh' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='haberlerim/". $i . "'> ". $i ." </a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									
									$SayfaIleri = $Sayfalar+1;
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28'   href='haberlerim/".$SayfaIleri."'> <i class='fas fa-caret-right  '></i>  </a></span>";	
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28'  href='haberlerim/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
								<?php
								}
							}else{
								?>						
								<div class="col-12  mb-3 mt-3" ><p class="font15 bold white">Yayınlamış olduğunuz herhangi bir haber bulunamadı.</p></div>					
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
<script src="assets/main_e=2.1.6.js"></script>

<?php
}else{
	header('Location: '.$SiteLink);
	exit();
}
}else{
	header('Location: '.$SiteLink);
	exit();
}
?>

		