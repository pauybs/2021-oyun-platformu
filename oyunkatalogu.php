<?php
if(isset($_REQUEST["Ara"])){
	$Arama =Guvenlik($_REQUEST["Ara"]);
	$AramaSecimi = "AND ( OyunAdi LIKE '%" . $Arama . "%'  )";
	$SayfalamaSecimi = "&Ara=" . $Arama ; 
}else{
	$AramaSecimi="" ; 
	$SayfalamaSecimi = "&Ara=";
} 
$SayfalarSolVeSagButonSayisi = 2;
$GosterilecekKayitSayisi =20;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=? $AramaSecimi ORDER BY id Desc  ");
$ToplamKayitSorgu->execute([1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);	
?>
<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=?");
$Banner->execute([20,1]);
$Veri = $Banner->rowCount();
$Kayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if($Veri>0){
?>
<div class="col-12 mb-5  mt-5">
	<div class="row text-center justify-content-center align-items-center"  >	
		<div class="col-12">		
		<?php echo IcerikTemizle($Kayitlar["BannerKodu"]); ?> 		
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([$Kayitlar["id"] ]);	
		?>		
		</div>	
	</div>	
</div>
<?php
}
?>
<div class="col-12 p-0 mt-5 mb-5 " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-11 col-xl-8   mb-5 ">
			<div class="row justify-content-end align-items-center">
				<div class="col-12 col-xl-3 p-0 mb-3  ">
					<form action="tumoyunlar  " method="post" > 
						<input   placeholder="Ara..." type="search" name="Ara" class="gn-search2" style="background: #202020;width: 100%">
					</form>
				</div>
			</div>
		</div>
		<div class="col-12 col-xl-8 " >
			<div class="row   " >
			<?php
			$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  Durum=?  $AramaSecimi ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
			$Oyunlar->execute([1]);
			$OyunlarVeri = $Oyunlar->rowCount();
			$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
			if ($OyunlarVeri>0) {
				foreach ($OyunlarKayitlar as  $OyunBilgiler) {		
			?>
				<div class="col-6 col-xl-3 mb-5  p-0">
				<?php
				if (file_exists("images/games/".$OyunBilgiler["AnaResim"]) and ($OyunBilgiler["AnaResim"]) ) {
				?>
					<div class="col-12   "  >
						<a href="oyundetay/<?php echo SEO(IcerikTemizle($OyunBilgiler["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunBilgiler["id"]); ?>">
							<img src="images/games/<?php echo  IcerikTemizle($OyunBilgiler["AnaResim"]);?>" class="img-fluid lYkqwAk wWfVCA ">
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12   "  >
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunBilgiler["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunBilgiler["id"]); ?>">
							<img src="images/resim.jpg" class="img-fluid lYkqwAk" >
						</a>
					</div>
				<?php
				}
				?>

					<div class="col-12 bold mt-2  yaziAlan"  >
						<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunBilgiler["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunBilgiler["id"]); ?>">
							<h1 class="OyunAdi tEqpMQbc"><?php echo  IcerikTemizle($OyunBilgiler["OyunAdi"]);?></h1>
						</a>
					</div>	

					<?php
					$ToplamPuan = $DatabaseBaglanti->prepare("SELECT *  FROM oyunpuan WHERE OyunId=? ");
					$ToplamPuan->execute([$OyunBilgiler["id"]]);
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
								
							<div class="col-12 " ><?php echo PuanHesapla($OrtalamaPuan);?></div>
						<?php
					}else{		
					?>
						<div class="col-12  " ><?php echo PuanHesapla(0);?></div>
					<?php
					}
					?>
						
					<?php
					$OyunPlatform =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunplatform WHERE  OyunId=? ");
					$OyunPlatform->execute([$OyunBilgiler["id"]]);
					$OyunPlatformSayi = $OyunPlatform->rowCount();
					$OyunPlatformKayitlar = $OyunPlatform->fetchAll(PDO::FETCH_ASSOC);
					if ($OyunPlatformSayi>0) {
					?>
						<div class="col-12  mt-1 " >
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
			
				<?php
				}
				}else{
				?>
		
				<div class="col-11 col-xl-12"  >
					<div class="row justify-content-center  ml-1 wWfVCA">
						<div class="col-12 text-center mt-5 mb-5" >
							<div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div>
						</div>
					</div>
				</div>

				<?php
				}
				?>
			</div>	
				 

			<?php
			if($SayfaSayisi>1){
			?>
			<div class="col-12 text-center mt-3   p-4"  >
 			<?php
 			if($Sayfalar>1 ){
 				echo "<span class='p-2' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class='bold' style='text-decoration:none;color:#f59f28' href='tumoyunlar/". $SayfalamaSecimi ."/1'> <i class='fas fa-caret-left  '></i> </a></span>";	
 			}
 			for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
 				if( ($i>0)  and ($i<=$SayfaSayisi)  ){
					if($Sayfalar==$i){
 						echo "<span class='p-2  bold  '   style='border:1px solid rgb(255,255,255,0.5);text-decoration:none;background:#202020;color: white ' class='aktif p-3'>". $i . "</span>";

					}else{
						echo "<span class='p-2   ' style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a class=' p-2 aktif bold ' style=  'border-radius:10px;text-decoration:none;color: white' href='tumoyunlar/". $SayfalamaSecimi ."/". $i . "'> ". $i ." </a></span>";
					}
 				}
 			}
 					
 			if($Sayfalar!=$SayfaSayisi){
 				echo "<span class='p-2'style='border:1px solid rgb(255,255,255,0.5);background:#202020'><a style='text-decoration:none;font-weight:bold;color:#f59f28'  href=''tumoyunlar/". $SayfalamaSecimi ."/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i> </a></span>";	
 			}
 			?>
			</div>
			<?php
			}
			?>
		</div>
	</div>			
</div>
