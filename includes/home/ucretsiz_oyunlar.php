<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php 
	$UretsizOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunkategorileri inner join  oyunlar  on oyunlar.id = oyunkategorileri.OyunId  WHERE KategoriId=11 and oyunlar.Durum=1  ORDER BY oyunlar.CikisTarihi DESC  LIMIT 4");
	$UretsizOyunlar->execute();
	$UretsizOyunlarVeri = $UretsizOyunlar->rowCount();
	$UretsizOyunlarVeriler =  $UretsizOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($UretsizOyunlarVeri>3) {
	?>
	<div class="row justify-content-center align-items-center ">
		<div class="col-12 mt-3 mb-2">
			<div class="row p-2  mt-4 mb-2 justify-content-end align-items-center"  style="background:#202020;border-radius:5px">
				<div class="col-7 col-xl-10 text-left bGAfxXE"><span>ÜCRETSİZ OYUNLAR</span></div>
				<div class="col-5 col-xl-2 p-1 text-center ErYTIxKL WrGYT__Xx" ><a href="https://roakgame.com/tumoyunlar/&Ara=&c=ucretsiz/1"><span class="gxPpxXo_">DAHA FAZLA GÖSTER</span></a></div>
			</div>
		</div>
		<div class="swiper-container swiper1">
   			 <div class="swiper-wrapper">
   			 <?php
   			 foreach ($UretsizOyunlarVeriler as $UretsizKayitlar){			
   			 ?>
		 		<div class="swiper-slide ">
		 			<div class="col-9 col-md-12 mb-4">
		 				<div class="row">
		 				<?php
		 				if ( file_exists("images/games/".$UretsizKayitlar["AnaResim"])  and ($UretsizKayitlar["AnaResim"])) {
		 				?>
	 						<div class="col-12 p-0 gamebrd">
	 							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["OyunUniqid"]); ?>">
	 								<img  src="images/resim.jpg" data-src="images/games/<?php echo IcerikTemizle($UretsizKayitlar["AnaResim"]) ?>" alt="<?php echo  IcerikTemizle($UretsizKayitlar["OyunAdi"]);?>" title="<?php echo  IcerikTemizle($UretsizKayitlar["OyunAdi"]);?>"  class="img-fluid _pXxZnTY  uo lazy" style="width:100%; height:auto">
	 							</a>
	 						</div>
		 				<?php
		 				}else{
		 				?>
	 						<div class="col-12 p-0">
	 							<a href="oyundetay/<?php echo  SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["OyunUniqid"]); ?>">
	 								<img src="images/resim.jpg" class="img-fluid ">
	 							</a>
	 						</div>
	 					<?php
	 					}
	 					?>
		 					<div class="col-12 mt-3 p-0">
		 						<a   href="oyundetay/<?php echo SEO(IcerikTemizle($UretsizKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($UretsizKayitlar["OyunUniqid"]); ?>">
		 							<h2 class="uQRtXT uo oyunAdi"><?php echo IcerikTemizle($UretsizKayitlar["OyunAdi"]) ?></h2>
		 						</a>
		 					</div>
		 					<?php
		 					$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
		 					$ToplamPuan->execute([Guvenlik($UretsizKayitlar["id"])]);
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
		 						<div class="col-12 p-0"><?php echo PuanHesapla($OrtalamaPuan);?></div>
		 						<?php
		 					}else{		
		 					?>
		 						<div class="col-12 p-0"><?php echo PuanHesapla(0);?></div>
		 					<?php
		 					}
		 					?>
		 					<?php
		 					$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
		 					$OyunPlatform->execute([Guvenlik($UretsizKayitlar["id"])]);
		 					$OyunPlatformSayi = $OyunPlatform->rowCount();
		 					$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
		 					if ($OyunPlatformSayi>0) {
		 					?>
		 						<div class="col-12 mt-1 p-0">
    		 						<?php
    		 						foreach ($OyunPlatformKayitlar as  $OyunPlatform) {
    		 						?>
    	 								<?php echo Platform($OyunPlatform["PlatformId"])?>
    	 							<?php		
    	 							}
    	 							?>
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
			<div class="col-12 text-center  swiper-pagination1 mt-2"></div>
		</div>
	</div>
	<?php
	}else{
	?>
		<div class="row justify-content-center align-items-center ">
			<div class="col-12 mt-3 mb-2">
				<div class="row p-1  mt-4 mb-2 justify-content-end align-items-center">
					<div class="col-7 col-xl-10 text-left bGAfxXE"><span>ÜCRETSİZ OYUNLAR</span></div>
					<div class="col-5 col-xl-2 p-1 text-center ErYTIxKL WrGYT__Xx" ><a href="ucretsiz"><span class="gxPpxXo_">DAHA FAZLA GÖSTER</span></a></div>
				</div>
			</div>
			<div class="swiper-container swiper1">
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





