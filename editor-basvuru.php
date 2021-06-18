<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"] ) and (IcerikTemizle($KullaniciEditorDurumu)==0) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
?>
<div class=" col-12 Uizahse cvnQAAzx" >	
	<div class="row justify-content-center">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
			</div>
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1  class="bold font15 white ">Editör Başvurusu</h1>
					</div>
					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
					    
					    <?php
					    $Durum=0;
					    if($Durum==1)
					    {
					    ?>
					        	<div class="row  justify-content-center ">
							<div class="col-12 col-md-6 mt-5 mb-5 kbs">
								<form class=" eb " method="post" id="singnupFrom" action="javascript:void(0);">
									<div class="row ebss justify-content-center text-center"></div>
									<div class="mt-5">   
										<div class="col-12 text-left p-0 font13 bold white" >Kendini bize tanıtır mısın? <span class="opacity07">(Zorunlu)</span></div>      
										<textarea  style="background: #202020;width: 100%;width: 100%;border: none;" class=" white font13 "  name="Mesaj"  required></textarea>
										<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
									</div>
									<div class="col-12   text-center mt-3 ebb">
										<button class="call-to-action ebg" type="submit" >
											<div>
												<div>Gönder</div>
											</div>
										</button>
									</div>
								</form>
							</div>	
						</div>
					    <?php
					    }else{
					    ?>
					       <div class="row  justify-content-center ">
							<div class="col-12 col-md-6 mt-5 mb-5 kbs text-center">
								<h5 class="bold white mt-5 mb-5">Editörlük Başvurusu Aktif Değildir.</h5>
							</div>	
						</div>
					    
					    
					    <?php
					    }
					    
					    ?>
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if($Durum==1){
	?>
	
	<script src="assets/main_p=1.2.7.js"></script>
	<?php
	}
	?>
		



<?php
}else{
	header('Location: ' .$SiteLink);
	exit();
}
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>



