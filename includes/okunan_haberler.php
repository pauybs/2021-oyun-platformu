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
	<div class="col-12 white " >
		<div class="row p-0" >
			<div class="col-12  text-left    p-1  bold white font15 " style="background:#202020;border-left:3px solid #c28f2c" >
				<span>Bugün Çok Okunanlar</span>
			</div>

			<div class="col-12 mt-2 mb-2 " >
				<?php
				foreach ($HaberKayitlar as $kayitlar) {
				?>
				<div class="row mb-4 justify-content-center align-items-center ">
					<?php
					if (file_exists("images/news/".$kayitlar["AnaResim"]) and (isset($kayitlar["AnaResim"])) and ($kayitlar["AnaResim"]!="") ){
					?>
						<div class="col-12 p-0" >
							<a href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
								<img src="images/news/<?php echo IcerikTemizle($kayitlar["AnaResim"]); ?>" alt="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" title="<?php echo  IcerikTemizle($kayitlar["AnaBaslik"]);?>" class="img-fluid wWfVCA hdr" >
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
					<div class="col-12 mt-2 p-0" >
						<a   href="haberdetay/<?php echo  SEO(IcerikTemizle($kayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($kayitlar["HaberUniqid"]); ?>">
							<h2 class="font15 bold white yaziAlan">
								<?php	echo IcerikTemizle($kayitlar["AnaBaslik"]); ?>
							</h2>
						</a>
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
	require_once("../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





