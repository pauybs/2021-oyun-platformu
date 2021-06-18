<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$FavorilerSorgu = $DatabaseBaglanti->prepare("SELECT oyunfavoriler.OyunId, oyunlar.id, oyunlar.Durum, oyunfavoriler.id, oyunfavoriler.UyeId FROM oyunfavoriler INNER JOIN oyunlar ON oyunfavoriler.OyunId = oyunlar.id WHERE oyunfavoriler.UyeId=? AND oyunlar.Durum=1 ORDER BY oyunfavoriler.id DESC   ");
	$FavorilerSorgu->execute([Guvenlik($KuratorBilgilerKayitlar["id"])]);
	$FavoriData = $FavorilerSorgu->rowCount();
	$FavoriKayit = $FavorilerSorgu->fetchAll(PDO::FETCH_ASSOC);
	if($FavoriData>0){
		foreach($FavoriKayit as $Kayitlar) {		
		$Oyunlar = $DatabaseBaglanti->prepare("SELECT *  FROM oyunlar WHERE Durum=1 AND id=?   LIMIT 1 ");
		$Oyunlar->execute([Guvenlik($Kayitlar["OyunId"])]);
		$OyunKayitlar = $Oyunlar->fetch(PDO::FETCH_ASSOC);
	?>
		<div class="col-6 col-xl-3">
			<div class="row  align-items-center mb-2" >
				<div class="col-12" >
					<div class="row align-items-center p-1">
					<?php
					if (file_exists("images/games/".$OyunKayitlar["AnaResim"]) and ($OyunKayitlar["AnaResim"])) {
					?>
						<div class="col-12 p-0 krtbrd">
							<div class="row">
								<div class="col-12 ">
									<a class="bold" style="color: black" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
										<img src="images/resim.jpg" data-src="images/games/<?php echo  IcerikTemizle($OyunKayitlar["AnaResim"]);?>" class="img-fluid wWfVCA lazy" style="border-radius:5px" title="<?php echo  IcerikTemizle($OyunKayitlar["OyunAdi"]);?>">
									</a>        
								</div>
							</div>
						</div>
					<?php
					}else{
					?>
						<div class="col-12 p-0 krtbrd">
							<div class="row">
								<div class="col-12 ">
									<a class="bold" style="color: white;" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
										<img src="images/resim.jpg" class="img-fluid wWfVCA"  style="border-radius:5px">
									</a>        
								</div>
							</div>
						</div>
					<?php
					}
					?>
						<div class="col-12 mt-2 p-0" >
							<div class="row text-left">
								<div class="col-12 " >
									<a class="bold"  style= "color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunKayitlar["OyunUniqid"]); ?>" >
										<h1 class="favorio __PaQqpL_AZxZxX">
										 <?php echo IcerikTemizle($OyunKayitlar["OyunAdi"]); ?>
										 </h1>
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
	}else{
	?>						
		<div class="col-12 mb-3">
			<div class="row justify-content-center mb-5 m-0">
				<div class="col-12 text-center mb-2 mt-4" >
					<span ><i class="fas fa-gamepad white font45"></i></span>
				</div>
				<div class="col-12 text-center mb-4 white font15">
					<span>Favori oyun bulunmamaktadır.</span>
				</div>
				<?php
				include 'includes/populer_oyunlar.php';
				?>		
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





