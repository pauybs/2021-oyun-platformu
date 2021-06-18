<?php
require_once("settings/connect.php");
if(isset($_GET["ID"]) and isset($_GET["OyunID"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	$KarakterId =SayfaNumarasiTemizle(Guvenlik($_GET["ID"]));	
	$OyunId =Guvenlik($_GET["OyunID"]);	
	$OyunBilgiler =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? and Durum=? LIMIT 1 ");
	$OyunBilgiler->execute([$OyunId,1]);
	$OyunBilgilerSayi = $OyunBilgiler->rowCount();
	$OyunBilgilerKayit = $OyunBilgiler->fetch(PDO::FETCH_ASSOC);
	if ($OyunBilgilerSayi>0) {
	$KarakterSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  id=? AND OyunId=? LIMIT 1 ");
	$KarakterSorgusu->execute([$KarakterId,	$OyunBilgilerKayit["id"]]);
	$KarakterSorgusuSayi = $KarakterSorgusu->rowCount();
	$KarakterSorgusuKayit = $KarakterSorgusu->fetch(PDO::FETCH_ASSOC);
	if($KarakterSorgusuSayi>0){
	
		
		?>
			<?php	
			$Arkaplan =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunresimler WHERE  OyunId=?  ");
			$Arkaplan->execute([$OyunBilgilerKayit["id"]]);
			$ArkaplanSayi = $Arkaplan->rowCount();
			$ArkaplanKayit = $Arkaplan->fetch(PDO::FETCH_ASSOC);
			$ArkaplanResmi= $ArkaplanKayit["Resim"];
			?>
			<div class="col-12">
				<div class="row m-0 align-items-end justify-content-center">
					<div class="col-12 col-xl-10 mb-5  p-0 zjus_asasWAQ" > 
						<img src="images/games/pictures/<?php echo IcerikTemizle($ArkaplanKayit["Resim"]); ?>" class="img-fluid CVCXZZ_ZXzcf" >
					</div>
					<div class="col-10 col-xl-9 position-absolute p-0 zjus_asasWAQ"> 
						<img src="images/games/pictures/<?php echo IcerikTemizle($ArkaplanKayit["Resim"]); ?>" class="img-fluid" >
					</div>
					<div class="col-12 col-xl-9 position-absolute">
						<div class="row p-2 sadhnxzxcsw">
							<div class="col-12">
								<div class="row justify-content-center align-items-center p-2 ">
									<?php
									if (file_exists("images/games/character/".$KarakterSorgusuKayit["KarakterResim"]) and ($KarakterSorgusuKayit["KarakterResim"])) {
									?>
										<div class="col-4 col-xl-12 text-center ">
											<img src="images/games/character/<?php echo IcerikTemizle($KarakterSorgusuKayit["KarakterResim"]) ?>" class="img-fluid zxwqqoi">
										</div>
									<?php
									}else{
									?>
										
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-12 mb-5">
				<div class="row justify-content-center p-2">
					<div class="col-12 col-xl-8 mb-2">
						<div class="row justify-content-center align-items-center ">
							<div class="col-12 text-center">
								<div class="row">
									<div class="col-12"><h1 class="bold white karakter beaufortforlol"><?php echo IcerikTemizle($KarakterSorgusuKayit["KarakterAdi"]);?></h1></div>
									<div class="col-12 bold white font18"><span><?php echo IcerikTemizle($OyunBilgilerKayit["OyunAdi"]); ?></span></div>
								</div>	
							</div>
							<div class="col-12 mt-5 spiegel">
							<?php
							if (isset($KarakterSorgusuKayit["KarakterAciklama"])) {
							?>
								<div class="white oyunYazi font20"><?php echo IcerikTemizle($KarakterSorgusuKayit["KarakterAciklama"]);?></div>
							<?php
							}else{
							?>

							<?php
							}
							?>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<?php
			}else{
				header('Location:'. $SiteLink );
				exit();
			}
		}else{
			header('Location:'. $SiteLink );
			exit();
		}
	}else{
		header('Location:'. $SiteLink);
		exit();
	}
?>



