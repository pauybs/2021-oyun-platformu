<?php
require_once("settings/connect.php");

if(isset($_GET["Oyun"]) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){
$OyunId =Guvenlik($_GET["Oyun"]);	


$OyunDurum=  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE Durum=? and OyunUniqid=?   ");
$OyunDurum->execute([1,$OyunId]);
$OyunDurumSayi = $OyunDurum->rowCount();
$OyunDurumKayit = $OyunDurum->fetch(PDO::FETCH_ASSOC);

if($OyunDurumSayi>0){	

	$OyunSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=?   ");
$OyunSorgusu->execute([$OyunDurumKayit["id"]]);
$OyunSorgusuSayi = $OyunSorgusu->rowCount();
	if($OyunSorgusuSayi>4){
?>
	<?php
	$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
	$BannerSorgu->execute([38,1]);
	$Data = $BannerSorgu->rowCount();
	$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
	if ($Data>0) {
	?>
	<div class="col-12 text-center mt-5  ">
		<div class="row justify-content-center align-items-center" >
			<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([38] );	
			?>
		</div>
	</div>
	<?php
	}
	?>
<div class="col-12 p-0 mt-5 mb-5 " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-11 col-xl-8" >
			<div class="row  " >
				<?php
				$OyunKarakter =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunkarakter WHERE  OyunId=? ORDER BY id ASC ");
				$OyunKarakter->execute([$OyunDurumKayit["id"]]);
				$OyunKarakterSayi = $OyunKarakter->rowCount();
				$OyunKarakterKayitlar = $OyunKarakter->fetchAll(PDO::FETCH_ASSOC);
				if ($OyunKarakterSayi>0) {
					$OyunAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE OyunUniqid=? and Durum=? LIMIT 1 ");
					$OyunAdi->execute([$OyunId,1]);
					$OyunAdiSayi = $OyunAdi->rowCount();
					$OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);
					if ($OyunAdiSayi>0) {
				?>
				<div class="col-12"  >
					<div class="row justify-content-center align-items-center " >	
						<div class="col-12  m-0" >
							<div class="row justify-content-center    ">
								<div class="col-12 text-center beaufortforlol font30 white">
									<span ><?php echo IcerikTemizle($OyunAdiKayitlar["OyunAdi"]) ?> Karakterleri</span>
								</div>
								<div class="col-12 mt-4" >
									<div class="row text-center">
									<?php
									foreach ($OyunKarakterKayitlar as  $Karakter) {		
									?>
									<div class=" col-6 col-xl-3 mb-4 " >
										<div class="row p-1" >	
											<div class="col-12  p-1" >
											<?php
											if (file_exists("images/games/character/".$Karakter["KarakterResim"]) and (isset($Karakter["KarakterResim"])) and ($Karakter["KarakterResim"]!="") ){
											?>
												<div class="col-12 "  >
													<a  href="karakterdetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"])) ?>/<?php echo SEO(IcerikTemizle($Karakter["KarakterAdi"])); ?>/<?php echo  SEO(IcerikTemizle($OyunId));?>/<?php echo  SEO(IcerikTemizle($Karakter["id"]));?>">
													    <img   src="images/games/character/<?php echo IcerikTemizle($Karakter["KarakterResim"]); ?>" style="border-radius: 5px"  class="img-fluid imgbrd" style"border-radius:5px"/>
													    </a>
												</div>		
											<?php
											}else{
											?>
												<div class="col-12"></div>
											<?php
											}
											?>
											
											<?php
											if ( isset($Karakter["KarakterAdi"])) {
											?>
											<div class="col-12 mt-2 mb-1">
												<span class="bold white beaufortforlol font18 "><?php echo IcerikTemizle($Karakter["KarakterAdi"]) ?></span>
											</div>
											<?php			
											}
											?>
											</div>	
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
	header('Location:'. $SiteLink );
	exit();
}
}else{
	header('Location:'. $SiteLink);
	exit();
}
?>
