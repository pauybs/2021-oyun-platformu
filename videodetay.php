<?php
require_once("settings/connect.php");

if(isset($_GET["ID"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){
	$VideoId =Guvenlik($_GET["ID"]);	
	$VideoSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  roakvideo WHERE  id=? AND Durum=? LIMIT 1 ");
	$VideoSorgusu->execute([$VideoId,1]);
	$VideoSorgusuSayi = $VideoSorgusu->rowCount();
	$VideoSorgusuKayit = $VideoSorgusu->fetch(PDO::FETCH_ASSOC);
	if($VideoSorgusuSayi>0){

	
			$Goruntulenme =  $DatabaseBaglanti->prepare("UPDATE roakvideo SET Goruntulenme=Goruntulenme+1  WHERE  id=? AND Durum=? LIMIT 1 ");
			$Goruntulenme->execute([SayfaNumarasiTemizle(Guvenlik($VideoSorgusuKayit["id"])),1]);
			$GoruntulenmeSayisi = $Goruntulenme->rowCount();
		

		
	?>

	
	<?php
	$BannerUst = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE id=? and Durum=? ORDER BY GosterimSayisi LIMIT 1");
	$BannerUst->execute([9,1]);
	$BannerUstVeri = $BannerUst->rowCount();
	$BannerUstKayitlar = $BannerUst->fetch(PDO::FETCH_ASSOC);
	if ($BannerUstVeri>0) {
	?>
		<div class="col-12 col-md-12 text-center mb-1  mt-5">
			<div class="row justify-content-center align-items-center"  >
				<?php echo IcerikTemizle($BannerUstKayitlar["BannerKodu"]); ?> 
				<?php
				$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
				$BannerGuncelleme->execute([9 ]);	
				?>		
			</div>	
		</div>
	<?php
	}
	?>
	<div class="col-12 mt-5 mb-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-6"><iframe width="100%" height="450" src="https://www.youtube.com/embed/<?php echo IcerikTemizle($VideoSorgusuKayit["Url"]) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
		</div>
		
	</div>
	
	<div class="col-12 mt-4 mb-5">
		<div class="row">
			<div class="col-12">
				<div class="row justify-content-center">
					<div class="col-12 col-md-10" >
						<div class="row justify-content-center">
							<div class="col-12">
								<div class="row">
									<?php
									$Videolar = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo Where Durum=? and id!=? ORDER BY id DESC LIMIT 12" );
									$Videolar->execute([1,$VideoId]);
									$VideolarVeri = $Videolar->rowCount();
									$VideolarKayitlar = $Videolar->fetchAll(PDO::FETCH_ASSOC);
									if ($VideolarVeri>0) {
										if ($VideolarVeri>12) {
										?>
										<div class="col-12 col-md-12 mb-3">
											<div class="row justify-content-end">
												<div class="col-5 col-md-2  p-1 text-center ErYTIxKL  WrGYT__Xx" ><a href="roak-video" ><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
											</div>
										</div>
										<?php
										}
										?>
										<?php
										foreach ($VideolarKayitlar as  $kayitlar) {		
									?>
									<div class="col-6 col-md-3 mb-4" >
										<div class="row justify-content-center align-items-center p-2" >
											<div class="col-12">
												<div class="row justify-content-center align-items-center  " >
													<div class="col-12 p-0">
														<a href="video-detay/<?php echo SEO(IcerikTemizle($kayitlar["VideoAdi"])) ?>/<?php echo IcerikTemizle($kayitlar["id"]) ?>"><img src="https://i.ytimg.com/vi/<?php echo IcerikTemizle($kayitlar["Url"]) ?>/sddefault.jpg" class="img-fluid" style="opacity: 0.7"></a>
													</div>
													
													<div class="col-12 col-md-2 text-center position-absolute" >
														<a href="video-detay/<?php echo SEO(IcerikTemizle($kayitlar["VideoAdi"])) ?>/<?php echo IcerikTemizle($kayitlar["id"]) ?>">
															<span><i class="fas fa-play white fa-2x vid"></i></span>
														</a>
													</div>
												</div>
											</div>
											<div class="col-12 p-2"  style="">
												<a href="video-detay/<?php echo SEO(IcerikTemizle($kayitlar["VideoAdi"])) ?>/<?php echo IcerikTemizle($kayitlar["id"]) ?>"><h6 style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis" class="bold white font14 "><?php echo  IcerikTemizle($kayitlar["VideoAdi"]); ?></h6></a>	
											</div>
										</div>
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
			</div>
		</div>
	</div>
	
	<?php
	}else{
		header('Location: ' .$SiteLink );
		exit();
	}
}else{
	header('Location: ' .$SiteLink );
	exit();
}
?>

