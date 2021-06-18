<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$OyunDiller = $DatabaseBaglanti->prepare("SELECT * FROM oyundiller WHERE OyunId=?");
	$OyunDiller->execute([Guvenlik($OyunSorgusuKayit["id"])]);
	$OyunDillerVerisi = $OyunDiller->rowCount();
	$OyunDillerKayitlar = $OyunDiller->fetchAll(PDO::FETCH_ASSOC);
	if ($OyunDillerVerisi>0){
	?>
	<div class="row justify-content-center align-items-center  p-3 p-xl-5  ">
		<div class="col-12 SAFfXxAERz  bGAfxXE" >
			<h6 class="m-0 bold white oyunYazi">Diller</h6>
		</div>
		<div class="col-12 mt-5 saUZNXA2WAQ gamlngtbl lngt" >
			<div class="row text-center">
				<div class="col-12 SASZaz" >
					<div class="row p-2">
						<div class="col-4 "></div>
						<div class="col-2 bold white dil ">Arayüz</div>
						<div class="col-4  bold white dil" >Seslendirme</div>
						<div class="col-2 p-0 bold white dil" >Altyazı</div>
					</div>
				</div>
				<?php
				$Turk=0;
				foreach ($OyunDillerKayitlar as $Diller) {
			    	$DilId= IcerikTemizle($Diller["DilId"]);
			    	if($DilId==1){
			    	    	$Turk++;
			    	}
				}
				?>
				<?php
				if($Turk==0){
				?>
				<div class="col-12 _PaQqpL_AZxZxXQDXC" >
						<div class="row justify-content-center align-items-center p-2"> 
							<div class="col-4  bold white dil">Türkçe</div>
						
								
							<div class="col-8 bold white dil text-center">
								Desteklemiyor
							</div>
					
						</div>
					</div>
				<?php
				}
				?>
				<?php
				foreach ($OyunDillerKayitlar as $Diller) {
					$DilId= IcerikTemizle($Diller["DilId"]);
				?>
				
					<?php
					$DilAdi =  $DatabaseBaglanti->prepare("SELECT * FROM  diller WHERE  id=? ");
					$DilAdi->execute([Guvenlik($DilId)]);
					$DilAdiVerisi = $DilAdi->rowCount();
					$DilAdiKayitlar = $DilAdi->fetch(PDO::FETCH_ASSOC);
					if ($DilAdiVerisi>0) {
					?>
					<div class="col-12 _PaQqpL_AZxZxXQDXC" >
						<div class="row justify-content-center align-items-center p-2"> 
							<div class="col-4  bold white dil"><?php echo  IcerikTemizle($DilAdiKayitlar["DilAdi"]); ?></div>
							<div class="col-2 bold white dil">
								<?php
								if ($Diller["Arayuz"]!=0) {
								?>
									<i class="fas fa-check green"></i>
								<?php
								}else{
								?>
									<span>-</span>
								<?php
								}
								?>
							</div>

							<div class="col-4 bold white dil">
								<?php
								if ($Diller["Seslendirme"]!=0) {
								?>
									<i class="fas fa-check green"></i>
								<?php
								}else{
								?>
									<span>-</span>
								<?php
								}
								?>
							</div>
								
							<div class="col-2 bold white dil">
								<?php
								if ($Diller["Altyazi"]!=0) {
								?>
									<i class="fas fa-check green"></i>
								<?php
								}else{
								?>
									<span>-</span>
								<?php
								}
								?>
							</div>
						<?php
						}
						?>
						</div>
					</div>
				<?php
				}
				?>

			</div>
		</div>
		<?php
		if ($OyunDillerVerisi>4){
        ?>
		<div class="col-12 lngtbl lng p-2 text-center font11" style="background: linear-gradient(0deg,#121212 0,transparent 100%);"><<span class="bold white">Tümünü Görüntüle</span> <i class="fas fa-angle-down white"></i></div>
	    <?php
		}
		?>
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





