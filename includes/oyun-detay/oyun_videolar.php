<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunVideolar = $DatabaseBaglanti->prepare("SELECT * FROM  oyunvideo WHERE  OyunId=? ");
	$OyunVideolar->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunVideolarSayi = $OyunVideolar->rowCount();
	$OyunVideolarKayitlar = $OyunVideolar->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunVideolarSayi>0) {
	?>
	<div class="row justify-content-center  p-3 p-xl-5  ">
		<div class="col-12 SAFfXxAERz bGAfxXE" >
			<h6 class="m-0 bold white oyunYazi">Videolar</h6>
		</div>
		<div class="col-12 mt-5">
			<div class="row justify-content-center align-items-center text-center">
				<div id="demo" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
					<?php
					$i=0;
					foreach ($OyunVideolarKayitlar as  $Video) {
					$i++;
					?>
						<?php
						if ($i==1) {
						?>
							<?php
							if ((IcerikTemizle($Video["VideoUrl"])!="") and IcerikTemizle(isset($Video["VideoUrl"]))) {
							?>
								<div class="carousel-item active">
									<iframe class="example" <?php  echo IcerikTemizle($Video["VideoUrl"]); ?> ></iframe>
								</div>
							<?php
							}	
							?>	
						<?php
						}else{
						?>
							<?php
							if ((IcerikTemizle($Video["VideoUrl"])!="") and IcerikTemizle(isset($Video["VideoUrl"]))) {
							?>
								<div class="carousel-item">
									<iframe class="example" <?php echo IcerikTemizle($Video["VideoUrl"]); ?> ></iframe>
								</div>
							<?php
							}	
							?>
						<?php
						}
						?>
					<?php
					}
					?>  
					</div>
					<a class="carousel-control-prev" href="#demo" data-slide="prev" >
						<span class="carousel-control-prev-icon"></span>
					</a>
					<a class="carousel-control-next" href="#demo" data-slide="next">
						<span class="carousel-control-next-icon"></span>
					</a>
				</div>
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





