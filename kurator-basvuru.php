<?php
require_once("settings/connect.php");

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   and ($KullaniciKuratorDurumu==0) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	?>
	<div class=" col-12 Uizahse cvnQAAzx">	
		<div class="row justify-content-center    ">
			<div class="col-12 col-xl-2 oRZNAEazx" >
				<?php
				include 'includes/hesabim_menu.php';
				?>
			</div>
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1  class="bold font15 white ">Kürator Başvurusu</h1>
					</div>

					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
						<div class="row  justify-content-center ">
							<div class="col-12 col-md-6 mt-5 mb-5 kbs">
								<form class=" kb " method="post" id="singnupFrom" action="javascript:void(0);">
									<div class="row kbss justify-content-center text-center"></div>
									<div class="col-12">   
									    <div class="row">
									        <div class="col-12 text-center ">
									            <h6 class="bold white font14"> <i class="fas fa-bullhorn font14 " style="color:#c28f2c"></i> Küratör başvurusunda bulunabilmek için 17 yaşından büyük olmanız gerekmektedir.</h6>
									        </div>
									        <div class="col-12 text-center ">
									            <h6 class="bold white font14"> <i class="fas fa-bullhorn font14 " style="color:#c28f2c"></i> Küratör başvurunuzdan sonra tarafımızca olumlu bir cevap olursa e-posta adresinize dönüş sağlanacaktır. E-posta adresinizi kontrol etmeyi unutmayınız.</h6>
									        </div>
									        
									    </div>
									</div>
									<div class=" mt-5">   
										<div class="col-12 text-left p-0 font13 bold white" >Kendini bize tanıtır mısın? <span class="opacity07">(Zorunlu)</span></div>      
										<textarea class="hspadsv p-3" name="Mesaj"  required></textarea>
									</div>
									<div class=" mt-5 font13">   
										<div class="col-12 text-left p-0 bold white" >Youtube kanal linki <span class="opacity07">(İsteğe Bağlı)</span></div>      
										<input class="hspadsv p-3" type="text" name="link1" >
									</div>
									
									<div class=" mt-5 font13">   
										<div class="col-12 text-left p-0 bold white" >Yayıncı kanal linki <span class="opacity07">(İsteğe Bağlı)</span></div>      
										<input class="hspadsv p-3" type="text" name="link2" >
									</div>
									<div class="group mt-5 font13">   
										<div class="col-12 text-left p-0 bold white" >Web Sitenizin linki <span class="opacity07">(İsteğe Bağlı)</span></div>   
										<input class="hspadsv p-3" type="text" name="link3" >
										<input  type="hidden" name="tkn"  value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
									</div>
									<div class="col-12   text-center mt-3 kbb">
										<button class="call-to-action kbg" type="submit" >
											<div>
												<div>Gönder</div>
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
?>


