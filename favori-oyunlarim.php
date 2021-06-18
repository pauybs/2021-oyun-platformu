<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ){
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 6;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT oyunfavoriler.OyunId, oyunlar.id, oyunlar.Durum, oyunfavoriler.id, oyunfavoriler.UyeId FROM oyunfavoriler INNER JOIN oyunlar ON oyunfavoriler.OyunId = oyunlar.id WHERE oyunfavoriler.UyeId=? AND oyunlar.Durum=1 ORDER BY oyunfavoriler.id DESC   ");
$ToplamKayitSorgu->execute([Guvenlik($KullaniciId)]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>
<div class="col-12 Uizahse cvnQAAzx">	
	<div class="row justify-content-center    ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>
			<div class="col-12 col-xl-10" >
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1 class="bold font15  white"><span  >Favori Oyunlarım</span></h1>
					</div>
					<div class="col-11 mt-3 golge " style="background:  rgb(0,0,0,0.5);">
						<div class="row  justify-content-center ">
							<div class="col-12  mt-5 mb-5 JkANZMwex"  >
								<div class="row p-2 ">
								<?php
								$FavorilerSorgu = $DatabaseBaglanti->prepare("SELECT oyunfavoriler.OyunId,  oyunlar.id, oyunlar.Durum, oyunfavoriler.id, oyunfavoriler.UyeId FROM oyunfavoriler INNER JOIN oyunlar ON oyunfavoriler.OyunId = oyunlar.id WHERE oyunfavoriler.UyeId=? AND oyunlar.Durum=1 ORDER BY oyunfavoriler.id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
								$FavorilerSorgu->execute([Guvenlik($KullaniciId)]);
								$FavoriData = $FavorilerSorgu->rowCount();
								$FavoriKayit = $FavorilerSorgu->fetchAll(PDO::FETCH_ASSOC);
								if($FavoriData>0){
									foreach($FavoriKayit as $Kayitlar) {
									$Oyunlar = $DatabaseBaglanti->prepare("SELECT *  FROM oyunlar WHERE Durum=1 AND id=?   LIMIT 1 ");
									$Oyunlar->execute([Guvenlik($Kayitlar["OyunId"])]);
									$OyunKayitlar = $Oyunlar->fetch(PDO::FETCH_ASSOC);
								?>
									<div class="col-12 col-xl-6 mt-2  " id="f<?php echo IcerikTemizle($Kayitlar["id"]); ?>">
										<div class="row  p-2  align-items-center    mb-2" >
											<div class="col-12" style="background: #202020" >
												<div class="row align-items-center p-0">
												<?php
												if (file_exists("images/games/".IcerikTemizle($OyunKayitlar["AnaResim"])) and (IcerikTemizle($OyunKayitlar["AnaResim"]))) {
												?>
													<div class="col-3 col-xl-2 p-0" >
														<div class="row   ">
															<div class="col-12 ">
																<a class="bold"  style="color: black; " href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
																	<img src="images/games/<?php echo  IcerikTemizle($OyunKayitlar["AnaResim"]);?>" class="img-fluid wWfVCA"  >
																</a>        
															</div>
														</div>
													</div>
												<?php
												}else{
												?>
													<div class="col-3 col-xl-2 p-0">
														<div class="row   ">
															<div class="col-12 ">
																<a  class="bold" style="color: white;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
																	<img src="images/resim.jpg" class="img-fluid wWfVCA"  >
																</a>        
															</div>
														</div>
													</div>
												<?php
												}
												?>
													<div class="col-8 col-xl-9">
														<div class="row text-center" >
															<div class="col-12 " >
																<a class="bold"  style="color: white;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
																	<h1 class="favorio __PaQqpL_AZxZxX"> <?php echo IcerikTemizle($OyunKayitlar["OyunAdi"]); ?></h1>
																</a>  
															</div>
														</div>
													</div>
													<div class="col-1 p-0">
														<div class="row">
															<div class="col-12">
																<i style="cursor: pointer;" class="fas fa-times-circle favorio bold white fos" id="fo<?php echo IcerikTemizle($Kayitlar["id"]); ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($Kayitlar["id"]); ?>"></i>
															</div>
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
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='favorioyunlarim/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='favorioyunlarim/".$SayfaGeri."'><i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='favorioyunlarim/". $i . "'>".$i."</a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									
									$SayfaIleri = $Sayfalar+1;
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='favorioyunlarim/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
									echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='favorioyunlarim/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
								<?php
								}
								

							}else{
							?>						
								<div class="col-12  mb-3 mt-3" ><p class="font15 bold white">Favori oyunlarınıza herhangi bir şey eklememişsiniz.</p></div>					
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
<script src="assets/main_p=1.2.7.js"></script>
<?php
}else{
	header('Location: ' .$SiteLink);
	exit();
}
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>

	