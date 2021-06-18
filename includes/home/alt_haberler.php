<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php 
	$AltHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 5,4");
	$AltHaberler->execute([1]);
	$AltHaberlerVeri = $AltHaberler->rowCount();
	$AltHaberlerKayitlar =  $AltHaberler-> fetchAll(PDO::FETCH_ASSOC);
	if ($AltHaberlerVeri>0) {
	?>
	<?php
	foreach ($AltHaberlerKayitlar as $AltHaberlerkayitlar){
	?>	
	<div class="col-6 col-xl-3 ">
		<div class="row p-1 ">
			<div class="col-12">
				<div class="row align-items-end">
				<?php
				if (file_exists("images/news/".$AltHaberlerkayitlar["AnaResim"])  and ($AltHaberlerkayitlar["AnaResim"]) ) {
			    ?>
				<div class="col-12 p-0">
					<a href="haberdetay/<?php echo  SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["HaberUniqid"]); ?>" >
						<img src="images/news/<?php echo IcerikTemizle($AltHaberlerkayitlar["AnaResim"]) ?>" alt="<?php echo  IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]);?>" class="img-fluid  resim wWfVCA a" style="width: 100%;height: auto;">
					</a>						
				</div>
				<div class="col-12 position-absolute p-0 __aSFczza" >
					<div class="row p-2 ">
						<div class="col-12 ">	
							<a href="haberdetay/<?php echo  SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["HaberUniqid"]); ?> " style="text-decoration: none">
								<h2 class="a uQRtXT haberYan  p-0 m-0"><?php	echo IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]); ?></h2>
							</a>
						</div>
						<?php
						$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($AltHaberlerkayitlar["Editor"])),1,1]);
                		$EditorSayi = $Editor->rowCount();
                		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                		if ($EditorSayi>0) {
                			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                		}else{
                			$EditorIsim="";
                		}
						?>
						<div class="col-12 font11 opacity07 uQRtXT">
						    <span class="white  " > <?php echo $EditorIsim ?></span> <span class="white"> — <?php echo time_ago(IcerikTemizle($AltHaberlerkayitlar["KayitTarihi"])); ?></span>
							
						</div>
					</div>										
				</div>
				<?php
				}else{
				?>
					<div class="col-12 xkLYTM p-0" style="background: #202020;height: 190px">
						<a href="haberdetay/<?php echo SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["HaberUniqid"]); ?>" >	</a>	
					</div>
					<div class="col-12 position-absolute p-0">
						<div class="row p-4">
							<div class="col-12 ">	
								<a href="haberdetay/<?php echo SEO(IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($AltHaberlerkayitlar["HaberUniqid"]); ?> ">
									<h2 class="uQRtXT haberYan mt-2">	<?php echo IcerikTemizle($AltHaberlerkayitlar["AnaBaslik"]); ?>	</h2>
								</a>
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
	<?php	
	}
	?>
	<?php
	}else{
	?>
	    <?php
		for ($i=0; $i <4 ; $i++) { 
		?>
		<div class="col-6 col-xl-3 m-0 ">
			<div class="row p-1">
				<div class="col-12 m-0 p-0" style="background: #202020;height: 190px">
					
				</div>
			</div>
		</div>
		<?php	
		}
		?>
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





