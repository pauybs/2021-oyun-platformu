<?php
if (isset($_SESSION["Kullanici"] )) {
	$TakipciKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE TakipciId=? ");
	$TakipciKontrol->execute([$KullaniciId]);
	$TakipciKontrolData = $TakipciKontrol->rowCount();
if ($TakipciKontrolData>0) {
	
	if(isset($_REQUEST["Ara"])){
		$Arama =Guvenlik($_REQUEST["Ara"]);
		$AramaSecimi = "AND ( incelemeler.Baslik LIKE '%" . $Arama . "%' OR oyunlar.OyunAdi LIKE '%" . $Arama . "%' )";
		$SayfalamaSecimi = "&Ara=" . $Arama ; 
	}else{
		$AramaSecimi="" ; 
		$SayfalamaSecimi = "&Ara=";
	} 
	$SayfalarSolVeSagButonSayisi = 2;
	$GosterilecekKayitSayisi = 12;

	$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT kuratortakip.*, incelemeler.*, oyunlar.*, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Durum, kuratortakip.KuratorId, kuratortakip.TakipciId, oyunlar.id, oyunlar.Durum FROM incelemeler INNER JOIN kuratortakip ON  incelemeler.KuratorId = kuratortakip.KuratorId INNER JOIN oyunlar ON  oyunlar.id = incelemeler.OyunId WHERE incelemeler.Durum=1 AND oyunlar.Durum=1 AND kuratortakip.TakipciId=$KullaniciId $AramaSecimi ORDER BY incelemeler.Incelemeid Desc");
	$ToplamKayitSorgu->execute();
	$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
	$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
	$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  BannerAlani='HaberlerUst' ORDER BY GosterimSayisi LIMIT 1");
$Banner->execute();
$BannrVeri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($BannrVeri>0) {
?>	
<div class="col-12 col-xl-12 text-center  mb-3  mt-5">
	<div class="row justify-content-center align-items-center"  >
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([$BannerKayitlar["id"] ]);	
		?>		
	</div>	
</div>
<?php
}
?>

<div class="col-12">
	<div class="row justify-content-center   m-0  mb-5 ">
		<div class="col-12 col-xl-10  mt-1 mt-xl-5 mb-5 " >
			<div class="row  justify-content-center m-0 ">
				<div class=" col-12   " >
					<div class="row justify-content-center   align-items-center">
						<div class="col-6 p-0 d-none d-xl-block">
							<div class="row align-items-center   " >
								<div class="col-2">
									<a class="bold font15 opacity07" style="color: white " href="oyunincelemeler">
										<span>İncelemeler</span>
									</a>
								</div>
								<?php
								if(isset($_SESSION["Kullanici"] )){
								?>
									<div class="col-3">
										<a  class="bold font15 " style="color: white" href="takipettiklerim">
											<span>Takip Ettiklerim</span>
										</a>
									</div>
								<?php
								}
								?>
							</div>
						</div>
						
						<div class="col-12 col-xl-6 text-right">
							<div class="row justify-content-end align-items-center ">
								<div class="col-12 col-xl-4 p-3 text-center" data-toggle="modal" data-target="#exampleModal" style="background: #202020;">
									<span class="bold white font15" style="cursor: pointer;">Takip Edilen Küratörler</span>
								</div>
								<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document" >
										<div class="modal-content" style="background: #202020">
											<div class="modal-header" >
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true" style="color: white">&times;</span>
												</button>
											</div>
											<div class="modal-body " >
												<div class="col-12 text-left scrollbar" id="style-1">
													<div class="row force-overflow">
													<?php
													$Kuratorler = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip  WHERE TakipciId=?   ORDER BY id Desc ");
													$Kuratorler->execute([$KullaniciId]);
													$KuratorlerVeri = $Kuratorler->rowCount();
													$KuratorlerKayitlar = $Kuratorler->fetchAll(PDO::FETCH_ASSOC);
													if ($KuratorlerKayitlar>0) {
														foreach ($KuratorlerKayitlar as $KuratorBilgiler) {
														$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Kurator=? and id=? LIMIT 1");
														$KuratorAdi->execute([1,$KuratorBilgiler["KuratorId"]]);
														$KuratorAdiVeri = $KuratorAdi->rowCount();
														$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
														if ($KuratorAdiVeri>0) {
														?>
														<div class="col-12 p-3 kt<?php echo IcerikTemizle($KuratorBilgiler["KuratorId"]) ?> cxvms">
															<?php
															if(isset($_SESSION["Kullanici"] )){
															?>
																<?php	
																$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=?  LIMIT 1" );
																$TakipKontrol->execute([$KuratorBilgiler["KuratorId"],$KullaniciId]);
																$TakipKontrolVeri = $TakipKontrol->rowCount();
																$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
																if ($TakipKontrolVeri>0) {
																?>
																	<?php
																	if ($KuratorBilgiler["KuratorId"] == $KullaniciId) {
																	?>

																	<?php
																	}else{
																	?>
																		<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
																		<?php
																		if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
																		?>
																			<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" >
																		<?php
																		}else{
																		?>
																			<img src="images/user.png" class="img-fluid" style="width: 30px;height: 30px">
																		<?php
																		}
																		?>
																			<span class="bold white font15">
																				<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>
																			</span>
																		</a>
																		<span class="bold white font15"  >•</span>
																		<span  class="bold font13 kte" data="<?php echo IcerikTemizle($KuratorBilgiler["KuratorId"]) ?>" style="color:green;cursor:pointer;">
																		 	<i class="fas fa-user-check" style="font-size: 20px"></i>
																		</span>
																	<?php
																	}
																	?>
																<?php
																}else{
																?>	
																	<?php
																	if ($KuratorBilgiler["KuratorId"] == $KullaniciId) {
																	?>

																	<?php
																	}else{
																	?>
																		<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
																		<?php
																		if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
																		?>
																			<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" >
																		<?php
																		}else{
																		?>
																			<img src="images/user.png" class="img-fluid" style="width: 30px;height: 30px">
																		<?php
																		}
																		?>

																			<span class="bold white font15">
																				<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>
																			</span>
																		</a>
																		<span class="bold white font15">•</span> 
																		<span class="bold font13 kte" data="<?php echo  IcerikTemizle($KuratorBilgiler["KuratorId"]) ?>" style="color: #0aa5ff;cursor:pointer;">
																			<i class="fas fa-user-plus" style="font-size: 20px"></i>
																		</span>
																	<?php
																	}
																	?>
																<?php
																}
																?>
															<?php
															}else{
															?>
																<a style="color:white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
																<?php
																if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
																?>
																	<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" >
																<?php
																}else{
																?>
																	<img src="images/user.png" class="img-fluid" style="width: 30px;height: 30px">
																<?php
																}
																?>


																	<span class="bold white font15"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>  
																	</span>
																</a>
																<span class="bold white font15">•</span> 
																<a href="girisyap" style="text-decoration: none;">
																	<span class="bold font13" style="color: #0aa5ff">
																		<i class="fas fa-user-plus" style="font-size: 20px"></i>
																	</span>
																</a>
															<?php
															}
															?>
														</div>
														<?php
														}
														}
													}
													?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-xl-4  mb-2 mt-2">
									<form action="takipettiklerim  " method="post" > 
										<input placeholder="İnceleme Ara..." type="search" name="Ara" class="gn-search2 wWfVCA " style="background: #202020;width: 100%" >
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="d-block d-xl-none col-12 mb-2">
				<?php
				if(isset($_SESSION["Kullanici"] )){
				?>
					<div class="row justify-content-center align-items-center">
						<div class="col-12 text-center iaQeezXzC___" >
							<label class="mt-3 mb-0" for="menu-toggle">
								<p class="bold  white" style="cursor: pointer;">
									<span class="font13">Takip Ettiklerim</span> 
									<i class="fas fa-chevron-down"></i>
								</p> 
							</label>
						</div>
						<input type="checkbox" id="menu-toggle" />
						<ul id="menu" class="wWfVCA" >
							<li>
								<div class="col-12 mt-3 mb-3 text-center" >
									<a class="t_RwAMWz_" style="color: white " href="oyunincelemeler">
										<span  class="font12">İncelemeler</span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				<?php
				}
				?>
				</div>
				
				<div class="col-12 p-1" >
					<div class="row">
					<?php
					$Inceleme = $DatabaseBaglanti->prepare("SELECT kuratortakip.*, incelemeler.*, oyunlar.*, incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Durum, kuratortakip.KuratorId, kuratortakip.TakipciId, oyunlar.id, oyunlar.Durum FROM incelemeler INNER JOIN kuratortakip ON  incelemeler.KuratorId = kuratortakip.KuratorId INNER JOIN oyunlar ON  oyunlar.id = incelemeler.OyunId WHERE incelemeler.Durum=1 AND oyunlar.Durum=1 AND kuratortakip.TakipciId=$KullaniciId $AramaSecimi ORDER BY incelemeler.Incelemeid Desc LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
					$Inceleme->execute();
					$IncelemeData = $Inceleme->rowCount();
					$IncelemeKayitlar = $Inceleme->fetchAll(PDO::FETCH_ASSOC);
					if ($IncelemeData>0) {
						foreach ($IncelemeKayitlar as  $kayitlar) {
						$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
						$KuratorAdi->execute([$kayitlar["KuratorId"]]);
						$KuratorAdiVeri = $KuratorAdi->rowCount();
						$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);

						$OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=1 and id=? " );
						$OyunAdi->execute([$kayitlar["OyunId"]]);
						$OyunAdiVeri = $OyunAdi->rowCount();
						$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
					?>
						<div class="col-12 col-xl-3 mb-3">
							<div class="row p-1">
								<div class="col-12">
									<div class="row align-items-end">
										<div class="col-12 p-0" style="background: black" >
										<?php
										if (file_exists("images/games/".$OyunAdiKayitlar["AnaResim"]) and ($OyunAdiKayitlar["AnaResim"])) {
										?>
											<a href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
												<img src="images/games/<?php echo IcerikTemizle($OyunAdiKayitlar["AnaResim"]);?>" class="img-fluid opacity05">	  
											</a>
										<?php
										}else{
										?>	
											<a href="incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo  SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>">
												<img src="images/resim.jpg" class="img-fluid">		  
											</a> 
										<?php
										}
										?>
										</div>

										<div class="col-12 position-absolute p-0 zxcbwqri">
											<div class="row align-items-center p-2 ">
												<div class="col-12 mt-5 czxvncr" >
													<a  href="incelemedetay/<?php echo  SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"]));?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]));?>/<?php echo IcerikTemizle($kayitlar["Incelemeid"]); ?>" >
														<span class="bold white incelemb">
															<?php echo IcerikTemizle($kayitlar["Baslik"]); ?>
														</span> 
													</a>

													<p class="kt<?php echo $kayitlar["KuratorId"] ?>">  
													<?php
													if(isset($_SESSION["Kullanici"] )){
													?>
														<?php	
														$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=?  LIMIT 1" );
														$TakipKontrol->execute([$kayitlar["KuratorId"],$KullaniciId]);
														$TakipKontrolVeri = $TakipKontrol->rowCount();
														$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
														if ($TakipKontrolVeri>0) {
														?>
															<?php
															if ($kayitlar["KuratorId"] == $KullaniciId) {
															?>

															<?php
															}else{
															?>
															<a style="text-decoration: none;color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
																
																<?php
																if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
																?>
																	<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" >
																<?php
																}else{
																?>
																	<img src="images/user.png" class="img-fluid" style="width: 30px;height: 30px">
																<?php
																}
																?>
																<span class="bold white font15">
																	<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>	
																</span>
															</a>
															<span class="bold white font15">•</span> 
															<span  class="bold font13 kte" data="<?php echo $kayitlar["KuratorId"] ?>" style="color: green;cursor:pointer;">
																<i class="fas fa-user-check" style="font-size:20px"></i>
															</span>

															<?php
															}
															?>
														<?php
														}else{
														?>	
															<?php
															if ($kayitlar["KuratorId"] == $KullaniciId) {
															?>

															<?php
															}else{
															?>
																<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
																	<?php
																	if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
																	?>
																	<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj">
																	<?php
																	}else{
																	?>
																		<img src="images/user.png" class="img-fluid" style="width: 30px;height: 30px">
																	<?php
																	}
																	?>
																	<span class="bold white font15">
																		<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>  
																	</span>
																</a>
																<span class="bold white font15">•</span> 
																<span  class="bold font13 kte" data="<?php echo $kayitlar["KuratorId"] ?>" style="color: #0aa5ff;cursor:pointer;">
																	<i class="fas fa-user-plus" style="font-size: 20px"></i>
																</span>
															<?php
															}
															?>
														<?php
														}
														?>
													<?php
													}else{
													?>
														<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
															<?php
															if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
															?>
																<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj">
															<?php
															}else{
															?>
																<img src="images/user.png" class="img-fluid" style="width:30px;height: 30px">

															<?php
															}
															?>
															<span class="bold white font15">
																<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>  
															</span>
														</a>
														<span class="bold white font15">•</span> 
														<a href="girisyap" style="text-decoration: none;">
															<span class="bold font13" style="color: #0aa5ff">
																<i class="fas fa-user-plus" style="font-size: 20px"></i>
															</span>
														</a>
													<?php
													}
													?>
													</p>
												</div>
											</div>										
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					}else{
					?>
						<div class="col-12" >
							<div class="row justify-content-center align-items-center mb-5">
								<div class="col-12  text-center  mb-2" >
									<img src="images/logo.png" class="img-fluid tznzuy7YQ" >
								</div>
								<div class="col-12 position-absolute text-center  mb-2" >
									<div class="row justify-content-center">
										<div class="col-12 col-xl-8">
											<h5 class="white">Hiçbir inceleme bulunamadı. Umarım en kısa zamanda küratörlerimiz  inceleme yaparlar.</h5>
										</div>
										<div class="col-12 mt-2">
											<a href="<?php echo IcerikTemizle($SiteLink) ?>">
												<button class="call-to-action2 p-0" style="height: 50px" >
													<div>
														<div>Anasayfa</div>
													</div>
												</button>
											</a>
										</div>
									</div>
								</div>
							</div>		
						</div>
					<?php
					}
					?>	
					</div> 
				</div>

				<?php
				if($SayfaSayisi>1){
				?>
				<div class="col-12 text-center mt-3   p-4"  >
				<?php
				if($Sayfalar>1 ){
					echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='takipettiklerim/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";																	
				}

				for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
					if( ($i>0)  and ($i<=$SayfaSayisi)  ){
						if($Sayfalar==$i){
							echo "<span class='p-2  bold  '   style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white ' class='aktif p-3'>". $i . "</span>";
						}else{
							echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='takipettiklerim/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
						}
					}
				}

				if($Sayfalar!=$SayfaSayisi){													
					echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href='takipettiklerim/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
				}
				?>
				</div>
				<?php
				}
				?>	
			</div>			
		</div>
	</div>
</div>
<?php
}else{
	header('Location: '. $SiteLink);
	exit();
}
}else{
	header('Location: '. $SiteLink);
	exit();
}
?>

<?php
if (isset($_SESSION["Kullanici"])) {
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('body').on('click' , '.kte', function() {
		i=$(this).attr('data'); 
		$.ajax({
			type:"post",
			url:"k_tkp.php",
			data:{te:i}, 
			success:function(a){
				$(".kt"+i).html(a);
			}
		});    
	});
});
</script>
<?php
}
?>
<script type="text/javascript">
	$(".h").css("display", "none");
	$(".h").fadeIn("slow");
</script>