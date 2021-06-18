<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ){
?>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center  ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
			?>
		</div>

			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11  p-0" >
						<span  class="bold font15 white">Güvenlik</span>
					</div>
					<div class="col-11 mt-3 golge "  style="background: rgb(0,0,0,0.5);">
						<div class="row  justify-content-center gbs">
							<div class="col-12 col-md-6 mt-5 mb-5">
								<form class=" gb" method="post" id="singnupFrom" action="javascript:void(0);">
									<div class="row gbss justify-content-center text-center"></div>
									<div class=" mt-5">      
										<div class="col-12 text-left p-0 bold font13" ><span class="white">Mevcut Şifre</span><span class="red" >*</span></div>   
										<div class="col-10 col-md-11 text-right position-absolute ">					
											<i class="fas fa-eye white circular eye link icon white position-absolute " id="pass" style="line-height: 50px"></i>
										</div>  
										<input class="white p-3 guvasas" placeholder="Mevcut Şifre"  type="password" id="password" name="MevcutSifre"  >
									</div>
									<div class=" mt-5">      
										<div class="col-12 text-left p-0 bold font13"><span class="white">Yeni Sifre</span><span class="red" >*</span></div>   
										<div class="col-10 col-md-11 text-right position-absolute">					
											<i class="fas fa-eye white circular eye link icon white position-absolute" id="pass1" style="line-height: 50px"></i>
										</div>  
										<input class="white p-3 guvasas" placeholder="Yeni Şifreniz"   type="password" id="password1" name="Sifre"  >
									</div>
									<div class=" mt-5">   
										<div class="col-12 text-left p-0 bold font13" ><span class="white">Yeni Sifre (Tekrar)</span><span class="red" >*</span></div> 
										<div class="col-10 col-md-11 text-right position-absolute">					
											<i class="fas fa-eye white circular eye link icon white position-absolute" id="pass2" style="line-height: 50px"></i>
										</div>  
										<input  class="white p-3 guvasas" placeholder="Yeni Şifrenizi Tekrar Giriniz."  id="password2"  type="password" name="SifreTekrar" >
										<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
									</div>
									<div class="col-12   text-center mt-3 gdb">
										<button class="call-to-action gg" type="submit">
											<div>
												<div>Kaydet</div>
											</div>
										</button>
									</div>
								</form>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/main_p=1.2.7.js"></script>


<?php
}else{
	header('Location: '.$SiteLink);
	exit();
}
}else{
	header('Location: '.$SiteLink);
	exit();
}
?>

