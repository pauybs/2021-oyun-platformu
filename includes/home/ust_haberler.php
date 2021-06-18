<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<div class="col-12 col-xl-3">
	<div class="row justify-content-center align-items-center">
	<?php 
	$SolHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 1,2");
	$SolHaber->execute([1]);
	$SolHaberVeri = $SolHaber->rowCount();
	$SolHaberKayitlar =  $SolHaber-> fetchAll(PDO::FETCH_ASSOC);
	if ($SolHaberVeri>0) {
	?>
		<?php
		foreach ($SolHaberKayitlar as $solusthaber){
		?>
		<div class="col-6 col-xl-12">
			<div class="row p-1">
				<div class="col-12">
					<div class="row align-items-end">
					<?php
					if (file_exists("images/news/".$solusthaber["AnaResim"]) and ($solusthaber["AnaResim"]) ) {
					?>
						<div class="col-12 p-0">
							<a href="haberdetay/<?php echo SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["HaberUniqid"]); ?>">
								<img src="images/news/<?php echo IcerikTemizle($solusthaber["AnaResim"]) ?>" alt="<?php echo  IcerikTemizle($solusthaber["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($solusthaber["AnaBaslik"]);?>" class="img-fluid resim wWfVCA a" style="width: 100%;height: auto;">		 
							</a>						
						</div>
						
						<div class="col-12 position-absolute p-0 __aSFczza">
							<div class="row p-2">
								<div class="col-12">	
									<a href="haberdetay/<?php echo  SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["HaberUniqid"]); ?>">
										<h2  class="a uQRtXT haberYan p-0 m-0"><?php echo IcerikTemizle($solusthaber["AnaBaslik"]); ?></h2>
									</a>
								</div>
								<?php
								$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                        		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($solusthaber["Editor"])),1,1]);
                        		$EditorSayi = $Editor->rowCount();
                        		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                        		if ($EditorSayi>0) {
                        			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                        		}else{
                        			$EditorIsim="";
                        		}
								?>
								<div class="col-12 font11 opacity07 uQRtXT">
								    <span class="white uQRtXT"> <?php echo $EditorIsim ?> — <?php echo time_ago(IcerikTemizle($solusthaber["KayitTarihi"])); ?></span>
								</div>
							</div>										
						</div>
					<?php
					}else{
					?>
						<div class="col-12 p-0" style="background: #202020;height: 190px">
							<a href="haberdetay/<?php echo SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["HaberUniqid"]); ?>">
								
							</a>	
						</div>
						<div class="col-12 position-absolute p-0 __aSFczza" >
							<div class="row p-2">
								<div class="col-12">	
									<a href="haberdetay/<?php echo SEO(IcerikTemizle($solusthaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($solusthaber["HaberUniqid"]);?>">
										<h2  class="uQRtXT haberYan mt-2"><?php echo IcerikTemizle($solusthaber["AnaBaslik"]); ?></h2>
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
		for ($i=0; $i <2 ; $i++) { 
		?>
		<div class="col-6 col-xl-12 m-0 ">
			<div class="row p-1">
				<div class="col-12 m-0 p-0" style="background: #202020;height: 190px"></div>
			</div>
		</div>
		<?php	
		}
		?>
	<?php
	}
	?>	
	</div>
</div>

<?php 
$OrtaHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 1");
$OrtaHaber->execute([1]);
$OrtaHaberVeri = $OrtaHaber->rowCount();
$OrtaHaberKayitlar =  $OrtaHaber-> fetchAll(PDO::FETCH_ASSOC);
if ($OrtaHaberVeri>0) {
?>
<div class="col-12 col-xl-6 ">
    <?php
    foreach ($OrtaHaberKayitlar as $OrtaSonHaber){
    ?>
	<div class="row p-1">
		<div class="col-12">
			<div class="row align-items-end">
				<?php
				if (file_exists("images/news/".$OrtaSonHaber["AnaResim"])  and ($OrtaSonHaber["AnaResim"]) ) {
				?>
				<div class="col-12 p-0 " >
					<a href="haberdetay/<?php echo  SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"])); ?>/<?php echo IcerikTemizle($OrtaSonHaber["HaberUniqid"]); ?>" >
						<img src="images/news/<?php echo IcerikTemizle($OrtaSonHaber["AnaResim"]); ?>" alt="<?php echo  IcerikTemizle($OrtaSonHaber["AnaBaslik"]); ?>" title="<?php echo  IcerikTemizle($OrtaSonHaber["AnaBaslik"]); ?>" class="img-fluid resim wWfVCA a" style="width: 100%;height: auto;">		 
					</a>						
				</div>
				<div class="col-12   position-absolute	 p-0 __aSFczza" >
					<div class="row p-2 ">
						<div class="col-12 ">	
							<a href="haberdetay/<?php echo  SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["HaberUniqid"]); ?> " >
								<h1  class="a uQRtXT haberAna  p-0 m-0"><?php	echo IcerikTemizle($OrtaSonHaber["AnaBaslik"]); ?>	</h1>
							</a>
						</div>
						<?php
						$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($OrtaSonHaber["Editor"])),1,1]);
                		$EditorSayi = $Editor->rowCount();
                		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                		if ($EditorSayi>0) {
                			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                			
                		}else{
                			$EditorIsim="";
                			
                		}
						?>
						<div class="col-12 font11 opacity07 uQRtXT">
						    <span class="white  " > <?php echo $EditorIsim ?></span> <span class="white"> — <?php echo time_ago(IcerikTemizle($OrtaSonHaber["KayitTarihi"])); ?></span>
						</div>
					</div>										
				</div>
			<?php
			}else{
			?>
				<div class="col-12 p-0" style="background: #202020;height: 390px">
					<a href="haberdetay/<?php echo SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["HaberUniqid"]); ?>"></a>	
				</div>
				<div class="col-12 position-absolute p-0">
					<div class="row p-2">
						<div class="col-12 ">	
							<a href="haberdetay/<?php echo SEO(IcerikTemizle($OrtaSonHaber["AnaBaslik"]));?>/<?php echo IcerikTemizle($OrtaSonHaber["HaberUniqid"]); ?>">
								<h2 class="uQRtXT haberAna mt-2"><?php echo IcerikTemizle($OrtaSonHaber["AnaBaslik"]) ?></h2>
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
    <?php	
    }
    ?>
</div>
<?php
}else{
?>	
<div class="col-12 col-xl-6 ">
	<div class="row p-0">
		<div class="col-12 m-0 p-0"  style="background: #202020;height: 390px">	</div>
	</div>
</div>
<?php
}
?>

<div class="col-12 col-xl-3">
<div class="row">
<?php 
$SagHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE   Durum=?  ORDER BY id DESC  LIMIT 3,2");
$SagHaber->execute([1]);
$SagHaberVeri = $SagHaber->rowCount();
$SagHaberKayitlar =  $SagHaber-> fetchAll(PDO::FETCH_ASSOC);
if ($SagHaberVeri>0) {
?>

<?php
foreach ($SagHaberKayitlar as $SagUst){
?>
<div class="col-6 col-xl-12 ">
	<div class="row p-1">
		<div class="col-12">
			<div class="row align-items-end">
				<?php
				if (file_exists("images/news/".$SagUst["AnaResim"])  and ($SagUst["AnaResim"]) ) {
				?>
					<div class="col-12 p-0">
						<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"])); ?>/<?php echo IcerikTemizle($SagUst["HaberUniqid"]); ?>">
							<img src="images/news/<?php echo IcerikTemizle($SagUst["AnaResim"]);?>" alt="<?php echo  IcerikTemizle($SagUst["AnaBaslik"]); ?>"  title="<?php echo  IcerikTemizle($SagUst["AnaBaslik"]); ?>" class="img-fluid resim wWfVCA a" style="width: 100%;height: auto;">	
						</a>	
					</div>
					<div class="col-12 position-absolute p-0 __aSFczza">
						<div class="row p-2 ">
						      
							<div class="col-12 ">	
								<a href="haberdetay/<?php echo SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["HaberUniqid"]); ?> ">
									<h2 class="a uQRtXT haberYan  p-0 m-0">
										<?php echo IcerikTemizle($SagUst["AnaBaslik"]); ?>
									</h2>
								</a>
							</div>
							<?php
							$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                    		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($SagUst["Editor"])),1,1]);
                    		$EditorSayi = $Editor->rowCount();
                    		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                    		if ($EditorSayi>0) {
                    			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                    			
                    		}else{
                    			$EditorIsim="";
                    			
                    		}
							?>
							<div class="col-12 font11 opacity07 uQRtXT">
							    <span class="white  " > <?php echo $EditorIsim ?></span> <span class="white"> —  <?php echo time_ago(IcerikTemizle($SagUst["KayitTarihi"])); ?></span>
								
							</div>
						</div>										
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0" style="background: #202020;height: 190px">
						<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["HaberUniqid"]); ?>">
							
						</a>	
					</div>
					<div class="col-12 position-absolute p-0">
						<div class="row p-2 ">
							<div class="col-12 ">	
								<a href="haberdetay/<?php echo  SEO(IcerikTemizle($SagUst["AnaBaslik"]));?>/<?php echo IcerikTemizle($SagUst["HaberUniqid"]); ?> " >
									<h2  class="uQRtXT haberYanmt-2">
										<?php echo IcerikTemizle($SagUst["AnaBaslik"]); ?>
									</h2>
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
	for ($i=0; $i <2 ; $i++) { 
	?>
	<div class="col-6 col-xl-12 m-0 ">
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
</div>
</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





