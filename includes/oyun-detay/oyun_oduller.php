<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
		<?php
		$OyunOduller =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunoduller WHERE  OyunId=? ");
		$OyunOduller->execute([Guvenlik($OyunSorgusuKayit["id"])]);
		$OyunOdullerVerisi = $OyunOduller->rowCount();
		$OyunOdullerKayitlar = $OyunOduller->fetchAll(PDO::FETCH_ASSOC);
		if ($OyunOdullerVerisi>0) {
		?>
		<div class="row justify-content-center align-items-center  p-3 p-xl-5  ">
			<div class="col-12 SAFfXxAERz bGAfxXE" >
				<h6 class="m-0 bold white oyunYazi">Ödüller</h6>
			</div>
			<div class="col-12 mt-3">
				<div class="row justify-content-center align-items-center">
				<?php
				foreach ($OyunOdullerKayitlar as $Odul) {
				?>
					<div class="col-12">
						<span>
							<i class="fas fa-trophy" style="color: #c28f2c"></i> 
						</span> 
						<span class="bold white oyunYazi">
							<?php echo IcerikTemizle($Odul["Odul"]); ?>
						</span>
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





