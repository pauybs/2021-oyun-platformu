<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$HaberResimler =  $DatabaseBaglanti->prepare("SELECT * FROM  haberresimler WHERE Durum=? and HaberId=? ");
	$HaberResimler->execute([1,SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"]))]);
	$HaberResimlerSayi = $HaberResimler->rowCount();
	$HaberResimlerKayitlar = $HaberResimler->fetchAll(PDO::FETCH_ASSOC);
	if ($HaberResimlerSayi>0) {
		foreach ($HaberResimlerKayitlar as  $Resimler) {
		?>
			<?php
			if(IcerikTemizle($Resimler["ResimBaslik"])) {
			?>	
				<div class="col-12  mt-4 mb-4  "  style="padding-left:30px">
				    <div class="row p-2 "style="border-left:5px solid #c28f2c">
				        <h2 class="white  haberDetayAltBaslik bold white"  ><?php echo IcerikTemizle($Resimler["ResimBaslik"]); ?></h2>
				    </div>
					
				</div>
			<?php
			}
			?>

			<?php
			if ( IcerikTemizle($Resimler["Resim"]!="") and IcerikTemizle(isset($Resimler["Resim"])) and file_exists("images/news/contents/".IcerikTemizle($Resimler["Resim"])) ) {
			?>	
				<div class="col-12  mt-1 mb-4" style="background: #202020">
					<img src="images/news/contents/<?php echo IcerikTemizle($Resimler["Resim"]); ?>" alt="<?php echo IcerikTemizle($Resimler["ResimBaslik"]); ?>" title="<?php echo IcerikTemizle($Resimler["ResimBaslik"]); ?>" class="img-fluid hdr" style="width: 100%; height: auto">
				</div>
			<?php
			}
			?>

			<?php
			if (IcerikTemizle($Resimler["Video"])) {
			?>	
				<div class="col-12  mt-1 mb-4">
					<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php echo  IcerikTemizle($Resimler["Video"]) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			<?php
			}
			?>

			<?php
			if (IcerikTemizle($Resimler["ResimAciklama"])) {
			?>	
				<div class="col-12  mt-1 mb-4">
					<div class="white haberdra aqQazcyr"  ><?php echo IcerikTemizle($Resimler["ResimAciklama"]); ?></div>
				</div>
			<?php
			}
			?>
		<?php
		}
	}
	?>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





