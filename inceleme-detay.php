<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if(isset($_GET["Inceleme"])){
		$IncelemeId =SayfaNumarasiTemizle(Guvenlik($_GET["Inceleme"]));
		$Curator =Guvenlik($_GET["kurator"]);
		$IncelemeSorgusu = $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.Incelemeid=? and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? and uyeler.KullaniciAdi=? and uyeler.SilinmeDurumu=? LIMIT 1");
		$IncelemeSorgusu->execute([$IncelemeId,1,1,1,$Curator,0]);
		$IncelemeSorgusuVeri = $IncelemeSorgusu->rowCount();
		$IncelemeSorgusuKayitlar = $IncelemeSorgusu->fetch(PDO::FETCH_ASSOC);
		if($IncelemeSorgusuVeri>0){
			$IncelemeYorumSorgusu = $DatabaseBaglanti->prepare("SELECT * from incelemeyorumlar where (Durum=? or Durum=? ) and IncelemeId=?");
			$IncelemeYorumSorgusu->execute([1,3,$IncelemeId]);
			$IncelemeYorumSorgusuVeri = $IncelemeYorumSorgusu->rowCount();

			$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
			$Banner->execute([36,1]);
			$BannerVeri = $Banner->rowCount();
			$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
			if ($BannerVeri>0) {
			?>
			<div class="col-12 text-center mt-5 d-none d-md-block ">
				<div class="row justify-content-center align-items-center" >
				    <div class="col-10  ">

					<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
					<?php
					$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
					$BannerGuncelleme->execute([36] );	
					?>
					</div>
				</div>
			</div>
			<div class="col-12 text-center mt-5 d-block d-md-none ">
				<div class="row justify-content-center align-items-center" >
				    <div class="col-10  ">  
				    <ins class="adsbygoogle"
		             style="display:inline-block;width:100%;height:90px"
		             data-ad-client="ca-pub-6491655414364653"
		             data-ad-slot="1630401356"></ins>
			        <script>
			             (adsbygoogle = window.adsbygoogle || []).push({});
			        </script>
					</div>
				</div>
			</div>
			<?php
			}
			
			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
				if ($IncelemeSorgusuKayitlar["KuratorId"] != $KullaniciId) {
				$Goruntulenme=$DatabaseBaglanti->prepare("UPDATE incelemeler SET Goruntulenme=Goruntulenme+1 WHERE Incelemeid=? AND Durum=? LIMIT 1");
				$Goruntulenme->execute([$IncelemeId,1]);
				
					$GunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE incelemeler SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE Incelemeid=? AND Durum=? LIMIT 1");
				    $GunlukGoruntulenme->execute([$IncelemeId,1]);
				}
			}else{
				$Goruntulenme=$DatabaseBaglanti->prepare("UPDATE incelemeler SET Goruntulenme=Goruntulenme+1 WHERE Incelemeid=? AND Durum=? LIMIT 1");
				$Goruntulenme->execute([$IncelemeId,1]);
					$GunlukGoruntulenme=$DatabaseBaglanti->prepare("UPDATE incelemeler SET GunlukGoruntulenme=GunlukGoruntulenme+1 WHERE Incelemeid=? AND Durum=? LIMIT 1");
				    $GunlukGoruntulenme->execute([$IncelemeId,1]);
			}
			
			$OyunBilgiler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  id=? and Durum=? LIMIT 1 ");
			$OyunBilgiler->execute([Guvenlik($IncelemeSorgusuKayitlar["OyunId"]),1]);
			$OyunBilgilerVeri = $OyunBilgiler->rowCount();
			$OyunBilgilerKayit = $OyunBilgiler->fetch(PDO::FETCH_ASSOC);
			if ($OyunBilgilerVeri>0) {
				$OyunAdi= IcerikTemizle($OyunBilgilerKayit["OyunAdi"]);
				$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=1 and id=? " );
				$KuratorAdi->execute([Guvenlik($IncelemeSorgusuKayitlar["KuratorId"])]);
				$KuratorAdiVeri = $KuratorAdi->rowCount();
				$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
				?>
				<div class="col-12 mt-4">
					<?php
					include 'includes/inceleme-detay/oyun_resimler.php';
					?>
				</div>
				
				<div class="col-12  mb-2 ">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 col-md-10 mb-2 mt-2" >
							<div class="row justify-content-center align-items-center">
								<div class="col-6">
									<div class="row align-items-center">
										<button type="button"  class="btn " style="background:#3b5998;border:none; "><a   ref="nofollow" rel="noreferrer"  href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $SiteLink ?>incelemedetay/<?php echo SEO(IcerikTemizle($OyunBilgilerKayit["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"])) ?>/<?php echo IcerikTemizle($IncelemeId) ?>" target="_blank" ><i class="fab fa-facebook-f white font20 pr-1 pl-1"></i></a></button>	
	                                    <button type="button"  class="btn " style="background:#00acee ;border:none; "><a   ref="nofollow" rel="noreferrer"  href="https://twitter.com/share?url=<?php echo $SiteLink ?>incelemedetay/<?php echo SEO(IcerikTemizle($OyunBilgilerKayit["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"])) ?>/<?php echo IcerikTemizle($IncelemeId) ?>"  target="_blank" ><i  class="fab fa-twitter white font20 p-0 "></i></a></button>	
	                                    <button type="button"  class="btn " style="background:#0088cc ;border:none; "><a   ref="nofollow" rel="noreferrer"  href="https://t.me/share/url?url=<?php echo $SiteLink ?>incelemedetay/<?php echo SEO(IcerikTemizle($OyunBilgilerKayit["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"])) ?>/<?php echo IcerikTemizle($IncelemeId) ?>&text=<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Baslik"]); ?>" target="_blank" ><i  class="fab fa-telegram-plane white font20 p-0 "></i></a></button>
									</div>
								</div>
								<div class="col-6 text-right">
								<?php
								if(isset($_SESSION["Kullanici"])){
								?>
									<?php
									if ($KullaniciId!=$IncelemeSorgusuKayitlar["KuratorId"]) {
									?>
										<span class="bold white idetaya seb" data-toggle="modal" data-target="#sikayet" style="cursor:pointer;">
											<i style="color:#c28f2c" class="fas fa-flag white"></i> Şikayet Et
										</span>
									<?php
									}
									?>
								<?php	
								}
								?>
								</div>
							</div>
						</div>
					
						<div class="col-12 col-xl-10 p-4 asdxzcbzxcvZX">
							<div class="row justify-content-center align-items-center">
								<div class="col-12 col-xl-8 text-center text-xl-left mb-xs-2  mt-1 kt<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?> ">
									<?php
									include 'includes/inceleme-detay/takip_kontrol.php';
									?>
								</div>
								<div class="col-12 col-xl-4 text-center mt-1 mb-xs-2 text-xl-right">
									<?php
									include 'includes/inceleme-detay/kurator_puan.php';
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-12 mt-2 mb-3">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 col-xl-10 p-3 bold asdxzcbzxcvZX" >
							<h1 class="white bold idetayb"><?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Baslik"]); ?></h1>
						</div>
						<div class="col-12 col-xl-10 mt-3 p-4  white  asdxzcbzxcvZX" >
							<div  class="idetaya"><?php echo IcerikTemizle($IncelemeSorgusuKayitlar["IncelemeYazisi"]); ?></div>
							<div class="col-12 mt-4 ">
								<?php
								include 'includes/inceleme-detay/begeni_kontrol.php';
								?>
							</div>
						</div>
					</div>
				</div>

				<?php
				if (IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) and file_exists("images/inceleme/".$IncelemeSorgusuKayitlar["Resim1"]) and ($IncelemeSorgusuKayitlar["Resim1"]!="")) {
				?>
				<div class="col-12 mt-2 mb-3">
					<div class="row justify-content-center align-items-center">
						<div class="col-12 col-xl-10">
							<div class="row justify-content-center asdxzcbzxcvZX">
								<div class="col-12 p-4">
									<span class="bold white idetaya">İnceleme Görseller</span>
								</div>
								<div class="col-6">
									<div class="row justify-content-center align-items-center  text-center">
										<div class="col-12  p-0 m-3 col-xl-8">
											<a href="images/inceleme/<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) ?>" style="overflow: hidden;"  data-lightbox="image-1" >
												<img src="images/inceleme/<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Resim1"]) ?>" class="img-fluid" alt="<?php echo $OyunAdi; ?>">
											</a> 
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
				$BannerAlt = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
				$BannerAlt->execute([18,1]);
				$BannerAltVeri = $BannerAlt->rowCount();
				$BannerAltKayitlar = $BannerAlt->fetch(PDO::FETCH_ASSOC);
				if ($BannerAltVeri>0){
				?>
				<div class="col-12 mt-2 mb-3"  >
					<div class="row justify-content-center align-items-center" >
						<div class="col-10">
							<div class="row">
								<?php echo IcerikTemizle($BannerAltKayitlar["BannerKodu"]); ?> 
								<?php
								$BannerGuncelleme2 = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
								$BannerGuncelleme2->execute([18]);	
								?>	
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				?>

				<div class="col-12 mt-1 mb-3 m-0 p-0">
					<div class="row  justify-content-center  m-0">
						<div class="col-12 col-xl-10 p-3 "  >
							<div class="row">
								<div class="col-12">
									<div class="row">
										<div class="col-12 col-md-8 asdxzcbzxcvZX mb-3">
											<div class="row p-1 ">
												<div class="col-12 mb-3">
													<?php
													include 'includes/inceleme-detay/inceleme_yorumlar.php';
													?>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-4  mb-3">
											<div class="row p-1 ">
												<div class="col-12 ">
													<div class="row">
														<?php
														include 'includes/inceleme-detay/kurator_incelemeler.php';
														?>
													</div>
												</div>
												<div class="col-12 ">
													<div class="row">
														<?php
														include 'includes/inceleme-detay/oyun_incelemeler.php';
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<link href="settings/lightbox.css" rel="stylesheet" />
		        <script src="settings/lightbox.js"></script>
			    <?php
				if (isset($_SESSION["Kullanici"]) and ($IncelemeSorgusuKayitlar["KuratorId"]!=$KullaniciId) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
				?>
					<script src="assets/main_incd=4.1.10.js"></script>
					<?php
					if ($KullaniciId!=$IncelemeSorgusuKayitlar["KuratorId"]) {
					?>
						<script src="assets/main_id=13.3.04.js"></script>
						<div class="modal fade mt-5" id="sikayet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
							<div class="modal-dialog" role="document">
								<div class="modal-content" style="background: #202020">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" class="white">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="col-12 text-center  mt-2 iss"></div>
										<div class="col-12 text-center isb mt-2"></div>
										<form class=" isg " method="post" action="javascript:void(0);">
											<div class="col-12 mt-2">
												<div class="col-12 text-left p-0 white bold font13"  >Şikayetiniz <span class="red font11 bold">(Zorunlu)</span></div>         
												<textarea type="text" id="textt" style="background: black;color:white;width: 100%;border:none" name="Sikayet" maxlength="250"></textarea>
												<input type="hidden" name="in" value="<?php echo IcerikTemizle($IncelemeId) ?>">
												<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
												<div id="character" class="bold  font13" style="color:#585858">Maksimum karakter:250</div>
											</div>
											<div class="col-12  mt-3 mb-3  p-0  text-center  " >
												<button class="call-to-action2  ise" >
													<div>
														<div>Gönder</div>
													</div>
												</button>
											</div>	
										</form>
									</div>
								</div>
							</div>
						</div>
					<?php
					}
					?>
				<?php
				}
				?>
		    	<script src="assets/main_indy=17.04.30.js"></script>
            	<link rel="stylesheet" href="settings/swiper-bundle.min.css">
            	<script src="settings/swiper-bundle.min.js"></script>

			<?php
			}else{
				header('Location: '.$SiteLink );
				exit();
			}
		}else{
			header('Location: '.$SiteLink );
			exit();
		}
	}else{
		header('Location: '.$SiteLink);
		exit();
	}
}else{
		header('Location: '.$SiteLink);
		exit();
	}
?>

