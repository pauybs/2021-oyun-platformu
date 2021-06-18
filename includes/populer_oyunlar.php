<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php 
	$EnPopulerOyunlar=$DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? ORDER BY Goruntulenme DESC LIMIT 4");
	$EnPopulerOyunlar->execute([1]);
	$EnPopulerOyunlarVeriSayisi = $EnPopulerOyunlar->rowCount();
	$EnPopulerOyunlarVeriler =  $EnPopulerOyunlar-> fetchAll(PDO::FETCH_ASSOC);
	if ($EnPopulerOyunlarVeriSayisi>0) {
	?>
	<div class="col-12 p-0 mb-2">
		<div class="row justify-content-center align-items-center">
			<div class="col-12  mt-3 mb-2">
				<div class="row p-3 justify-content-end align-items-center">
					<div class="col-12 text-left cncxbvfv" ><span>POPÜLER OYUNLAR</span></div>
				</div>
				<div class="row justify-content-end">
					<div class="col-6 col-xl-2 p-1 text-center ErYTIxKL WrGYT__Xx">
						<a href="populeroyunlar" >
							<span class=" gxPpxXo_">DAHA FAZLA GÖSTER</span>
						</a>
					</div>
				</div>
			</div>
			<?php
			foreach ($EnPopulerOyunlarVeriler as $EnPopulerOyunlarKayitlar){
			?>
			<div class="col-6 col-xl-3 mb-4">
				<div class="row p-2">
				<?php
				if ( file_exists("images/games/".$EnPopulerOyunlarKayitlar["AnaResim"])and ($EnPopulerOyunlarKayitlar["AnaResim"])) {
				?>
					<div class="col-12 p-0 krtbrd" style="background: black" >
						<a href="oyundetay/<?php echo  SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["OyunUniqid"]); ?>">
							<img src="images/games/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["AnaResim"]) ?>" class="img-fluid po " style="border-radius:5px" title="<?php echo  IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]);?>">
						</a>
					</div>
				<?php
				}else{
				?>
					<div class="col-12 p-0">
						<a href="oyundetay/<?php echo SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["OyunUniqid"]); ?>">
							<img src="images/resim.jpg" class="img-fluid  " >
						</a>
					</div>
				<?php
				}
				?>
					<div class="col-12 mt-3 p-0" >
						<a  href="oyundetay/<?php echo  SEO(IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["OyunUniqid"]); ?>">
							<h6 class="po uQRtXT oyunAdi ">
								<?php echo IcerikTemizle($EnPopulerOyunlarKayitlar["OyunAdi"]) ?>
							</h6>
						</a>
					</div>
				</div>	
			</div>
			<?php	
			}
			?>
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





