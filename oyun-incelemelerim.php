<?php
require_once("settings/connect.php");

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and  ($KullaniciKuratorDurumu==1)){
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 8;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT oyunlar.Durum, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId WHERE incelemeler.KuratorId=?  and incelemeler.Durum!=? and oyunlar.Durum=? ORDER BY incelemeler.Incelemeid DESC ");
$ToplamKayitSorgu->execute([Guvenlik($KullaniciId),3,1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>
<div class=" col-12 Uizahse cvnQAAzx">
	<div class="row justify-content-center  ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
			?>
		</div>
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1 class="bold font15  white"><span  >İncelemelerim</span></h1>
					</div>
					<div class="col-12 col-xl-11 mt-3 golge "style="background:  rgb(0,0,0,0.5);" >
						<div class="row  justify-content-center ">
							<div class="col-12 mt-5 mb-5 JkANZMwex "  >
								<div class="row m-0 align-items-center">
								<?php
								$IncelemeSorgu = $DatabaseBaglanti->prepare("SELECT oyunlar.Durum, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId WHERE incelemeler.KuratorId=?  and incelemeler.Durum!=?  and incelemeler.Durum!=? AND oyunlar.Durum=?  ORDER BY incelemeler.Incelemeid DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
								$IncelemeSorgu->execute([Guvenlik($KullaniciId),3,5,1]);
								$IncelemeData = $IncelemeSorgu->rowCount();
								$IncelemeKayit = $IncelemeSorgu->fetchAll(PDO::FETCH_ASSOC);
								if($IncelemeData>0){
									foreach($IncelemeKayit as $Incelemeler) {
									$Oyunlar = $DatabaseBaglanti->prepare("SELECT *  FROM oyunlar WHERE Durum=1 AND id=?   LIMIT 1 ");
									$Oyunlar->execute([$Incelemeler["OyunId"]]);
									$OyunKayitlar = $Oyunlar->fetch(PDO::FETCH_ASSOC);
								?>
									<div class="col-6 col-xl-3 mb-3  " id="<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>" >
										<div class="row p-1">
											<div class="col-12" style="background:  #202020">
												<div class="row align-items-center" >
												<?php
												if (file_exists("images/games/".$OyunKayitlar["AnaResim"]) and ($OyunKayitlar["AnaResim"])) {
												?>
													<div class="col-12 ">
														<div class="row justify-content-center  align-items-center text-center ">
															<div class="col-12 p-0">
																<a href="incelemelerimdetay/<?php echo IcerikTemizle($KullaniciAdi)?>/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>">
																	<img src="images/games/<?php echo  IcerikTemizle($OyunKayitlar["AnaResim"]);?>" class="img-fluid wWfVCA"  <?php if ($Incelemeler["Durum"]==0) { ?> style="filter: grayscale(100%);"  <?php } ?> >
																</a>
															</div>
															<?php
															if ($Incelemeler["Durum"]==0) {
															?>
															<div class="col-12 text-center pt-md-5 p-2 position-absolute cvbnkasxczqz">
																<span class="bold white yorumk ">İncelemeni <a target="blank" style="color: #c28f2c" href="topluluk-kurallari">topluluk kurallarımız</a>  gereğince kaldırdık. Bu konuda haklı olduğunu düşünüyorsan bizimle iletişime geç.</span>
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
														<div class="row">
															<div class="col-12 p-0 ">
																<a href="incelemelerimdetay/<?php echo IcerikTemizle($KullaniciAdi)?>/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>">
																	<img src="images/resim.jpg" class="img-fluid wWfVCA" <?php if ($Incelemeler["Durum"]==0) { ?> style="filter: grayscale(100%);"  <?php } ?> >
																</a>
															</div>
															<?php
															if ($Incelemeler["Durum"]==0) {
															?>
																<div class="col-12 text-center p-2  pt-md-5 p-2 position-absolute cvbnkasxczqz">
																	<span class="bold white yorumk">İncelemeni <a target="blank" style="color: #c28f2c" href="topluluk-kurallari">topluluk kurallarımız</a>  gereğince kaldırdık. Bu konuda haklı olduğunu düşünüyorsan bizimle iletişime geç.</span>
																</div>
															<?php
															}
															?>
														</div>
													</div>
												<?php
												}
												?>
													<div class="col-12 bold white mt-1 mb-1 font15  text-center cxvanc">
														<span><?php echo IcerikTemizle($Incelemeler["Baslik"]); ?><span>
													</div>
													<div class="col-12 mt-2 mb-2 m-0 ">
														<div class="row justify-content-center align-items-center  text-center">
														<?php
														if ($Incelemeler["Durum"]==1) {
														?>
															<div class=" col-6 text-right font25" >
															    <i style="cursor:pointer" class="fas fa-trash-alt ois white" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>"> </i>
															</div>
															<div class="col-6 text-left">
																<div class="four">
																  	<div class="button-wrap button-active " data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="b<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>" data="<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>" >
																    	<div class="button-bg">
																      		<div class="button-out"></div>
																      		<div class="button-in"></div>
																      		<div class="button-switch"></div>
																    	</div>
																  	</div>
																</div>
															</div>
														<?php	
														}else if ($Incelemeler["Durum"]==2){
														?>
															<div class=" col-6 text-right font25">
															   	<i style="cursor:pointer" class="fas fa-trash-alt ois white" id="ki<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>"  data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>"> </i>
															</div>
															
															<div class="col-6 text-left">
																<div class="four">
																  	<div class="button-wrap " data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="b<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>"  data="<?php echo IcerikTemizle($Incelemeler["Incelemeid"]) ?>" >
																    	<div class="button-bg">
																      		<div class="button-out"></div>
																      		<div class="button-in"></div>
																      		<div class="button-switch"></div>
																    	</div>
																  	</div>
																</div>
															</div>
														<?php
														}else if ($Incelemeler["Durum"]==4){
														?>
															<div class=" col-12 text-center font14 mb-3 ">
															   <span class="bold white">Durum:</span> <span class="bold red">İnceleniyor</span>
															</div>
															
															
														<?php
														}else{
														?>
															<div class=" col-12 text-center font25 " style="padding: 20px" >
													    		
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
								}
								?>
								<?php
								if($SayfaSayisi>1){
								?>
								<div class="col-12 text-center mt-3   p-0"  >
								<?php
								if($Sayfalar>1 ){
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='oyunincelemelerim/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='oyunincelemelerim/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='oyunincelemelerim/". $i . "'>".$i." </a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									
									$SayfaIleri = $Sayfalar+1;
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='oyunincelemelerim/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='oyunincelemelerim/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
								<?php
								}
							}else{
							?>						
								<div class="col-12 mb-3 mt-3"><p class="font15 bold white">Yapmış olduğunuz oyun incelemesi bulunamadı.</p></div>					
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
 	<script src="assets/main_k=7.1.7.js"></script>


<?php
}else{
	header('Location: '. $SiteLink);
	exit();
}
?>

