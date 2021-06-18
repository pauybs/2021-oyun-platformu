<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OkunanHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=?  ORDER BY GunlukGoruntulenme DESC, id DESC  LIMIT 5" );
	$OkunanHaberler->execute([1]);
	$Data = $OkunanHaberler->rowCount();
	$HaberKayitlar = $OkunanHaberler->fetchAll(PDO::FETCH_ASSOC);
	if ($Data>0) {
	?>
		<?php
		foreach ($HaberKayitlar as $kayitlar) {
		?> 
		<div class="col-12 mt-3 " style="background: #202020">
			<div class="row align-items-center">
				<div class="col-3">
					<div class="row">
					<?php
					if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="") ){
					?>
						<div class="col-12 p-0" >
							<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
								<img src="images/hata.jpg" data-src="images/news/<?php echo IcerikTemizle($kayitlar["AnaResim"]); ?>" alt="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" class="img-fluid wWfVCA hdr lazy" style="width: 100%;height: auto;">
							</a>
						</div>
					<?php
					}else{
					?>
					<div class="col-12 p-0">
						<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
							<img src="images/hata.jpg" class="img-fluid" >
						</a>
					</div>
					<?php
					}
					?>
					</div>
				</div>
				<div class="col-9 ">
					<div class="row">
						<div class="col-12 mt-2 yaziAlan" >
							<a   href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
								<span class="font15 bold white "><?php	echo IcerikTemizle($kayitlar["AnaBaslik"]); ?></span>
							</a>
						</div>
						<?php
						$Editor =  $DatabaseBaglanti->prepare("SELECT * FROM  uyeler WHERE  id=? AND Durum=? and Editor=?  LIMIT 1 ");
                		$Editor->execute([SayfaNumarasiTemizle(Guvenlik($kayitlar["Editor"])),1,1]);
                		$EditorSayi = $Editor->rowCount();
                		$EditorKayit = $Editor->fetch(PDO::FETCH_ASSOC);
                		if ($EditorSayi>0) {
                			$EditorIsim=IcerikTemizle($EditorKayit["AdSoyad"]);
                			
                		}else{
                			$EditorIsim="";
                			
                		}
						?>
						<div class="col-12 font11  opacity07 uQRtXT mb-2">
						    <span class="white  uQRtXT" > <?php echo $EditorIsim ?> — <?php echo time_ago(IcerikTemizle($kayitlar["KayitTarihi"])); ?></span>
						</div>
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
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





