<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
 	<?php 
	$PopulerOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum='1'  ORDER BY Goruntulenme DESC  LIMIT 8");
	$PopulerOyunlar->execute();
	$PopulerOyunlarVeri = $PopulerOyunlar->rowCount();
	$PopulerOyunlarKayitlar =  $PopulerOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($PopulerOyunlarVeri>3) {
	?>
	<div class="row justify-content-center align-items-center">
		<div class="col-12  mt-3 mb-2">
			<div class="row p-2 mt-4 mb-2 justify-content-end align-items-center"  style="background:#202020;border-radius:5px">
				<div class=" col-7 col-xl-10  text-left bGAfxXE" ><span >POPÜLER OYUNLAR</span></div>
				<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL WrGYT__Xx" ><a href="populeroyunlar"><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
			</div>
		</div>
		<div class="swiper-container swiper3">
			<div class="swiper-wrapper">
			<?php
			foreach ($PopulerOyunlarKayitlar as $PopulerKayitlar){
			?>
			<div class="swiper-slide">
				<div class="col-9 col-md-12 mb-4">
					<div class="row ">
					<?php
					if ( file_exists("images/games/".$PopulerKayitlar["AnaResim"])  and ($PopulerKayitlar["AnaResim"])) {
					?>
						<div class="col-12 p-0 gamebrd">
							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["OyunUniqid"]); ?>">
								<img  src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($PopulerKayitlar["AnaResim"]) ?>" alt="<?php echo  IcerikTemizle($PopulerKayitlar["OyunAdi"]);?>" title="<?php echo  IcerikTemizle($PopulerKayitlar["OyunAdi"]);?>" class="img-fluid _pXxZnTY  po lazy" >
							</a>
						</div>
						 	
					<?php
					}else{
					?>
						<div class="col-12 p-0" >
							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["OyunUniqid"]); ?>">
								<img src="images/resim.jpg" class="img-fluid">
							</a>
						</div>
					<?php
					}
					?>
						<div class="col-12 mt-3 p-0" >
							<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($PopulerKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($PopulerKayitlar["OyunUniqid"]); ?>">
								<h2 class="po uQRtXT oyunAdi"><?php echo IcerikTemizle($PopulerKayitlar["OyunAdi"]) ?></h2>
							</a>
						</div>
						<?php
						$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
						$ToplamPuan->execute([Guvenlik($PopulerKayitlar["id"])]);
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
							<div class="col-12 p-0" ><?php echo PuanHesapla($OrtalamaPuan);?></div>
						<?php
						}else{		
						?>
							<div class="col-12  p-0" ><?php echo PuanHesapla(0);?></div>
						<?php
						}
						?>
						<?php
						$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
						$OyunPlatform->execute([Guvenlik($PopulerKayitlar["id"])]);
						$OyunPlatformSayi = $OyunPlatform->rowCount();
						$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
						if ($OyunPlatformSayi>0) {
						?>
							<div class="col-12  mt-1 p-0" >
								<?php
								foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
								?>
									<?php echo Platform($OyunPlatform["PlatformId"])?>
								<?php		
								}
								?>
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
			<?php	
			}
			?>
			</div>
			<div class="col-12 text-center   swiper-pagination3 mt-2 " ></div>
		</div>
	</div>
	<?php
	}else{
	?>
		<div class="row justify-content-center align-items-center">
			<div class="col-12  mt-3 mb-2">
				<div class="row p-1 mt-4 mb-2 justify-content-end align-items-center">
					<div class=" col-7 col-xl-10  text-left   bGAfxXE" ><span >POPÜLER OYUNLAR</span></div>
					<div class="col-5 col-xl-2  p-1 text-center ErYTIxKL WrGYT__Xx" ><a href="populeroyunlar"><span class=" gxPpxXo_"> DAHA FAZLA GÖSTER</span></a></div>
				</div>
			</div>

			<div class="swiper-container swiper3" >
    			<div class="swiper-wrapper">
		        <?php
				for ($i=0; $i <8 ; $i++) { 
				?>
			    <div class="swiper-slide">
    				<div class="col-9 col-md-12 mb-2">
    					<div class="row " >
						    <div class="col-12 m-0 p-0" style="background: #202020;height: 400px"></div>
						     <div class="col-10 mt-2 m-0 p-0" style="background: #202020;height: 20px"></div>
						     <div class="col-6 mt-2 m-0 p-0" style="background: #202020;height: 20px"></div>
						</div>
					</div>
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
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





