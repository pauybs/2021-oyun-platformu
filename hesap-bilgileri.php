<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){

	if ($KullaniciProfilResimBan==1 and $KullaniciProfilResimBanTarih!="") {
		if ($Zaman>=$KullaniciProfilResimBanTarih) {
			$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET ProfilResimBan=?, ProfilResimBanTarih=?  WHERE  id=?  LIMIT 1 ");
			$BanKaldir->execute([0,NULL,$KullaniciId]);
			$BanKaldirSayisi = $BanKaldir->rowCount();

			if ($BanKaldirSayisi>0) {
				header("Refresh:0");
				exit();

			}
		}
	}
?>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
		<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>
		<div class="col-12 col-xl-10">
			<div class="row mt-5 mb-5  justify-content-center align-items-center">
				<div class="col-11 p-0 " >
					<h1 class="bold font15 white ">Hesap Bilgileri</h1>
				</div>
				<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
					<div class="row  justify-content-center ">
						<div class="col-12 col-md-6 mt-5 mb-5 hbs" >
							<form class=" hb " method="post" id="singnupFrom" action="javascript:void(0);">
								<div class="row hbss justify-content-center text-center"></div>
								<div class=" mt-5">      
									<div class="col-12 text-left p-0 font13 bold white" >E-Posta Adresi</div>   
									<input placeholder="E-Posta Adresi" class="p-3 hspadsv"  placeholder="E-Posta Adresi" type="email" name="Mail" value="<?php echo IcerikTemizle($KullaniciMail); ?>" >
								</div>
								<div class=" mt-5">   
									<div class="col-12 text-left p-0 font13 bold white">Ad ve Soyad</div>      
									<input placeholder="Ad ve Soyad" class="p-3 hspadsv"  placeholder="Ad ve Soyad" type="text" name="AdSoyad" value="<?php echo IcerikTemizle($KullaniciAdiSoyadi); ?>">
								</div>
								<div class=" mt-5">   
									<div class="col-12 text-left p-0 font13 bold white" >Kullanıcı Adı</div>      
									<input placeholder="Kullanıcı Adı" class="p-3 hspadsv" placeholder="Kullanıcı Adı" type="text" name="KullaniciAdi" value="<?php echo IcerikTemizle($KullaniciAdi); ?>" >
									<input type="hidden"  name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
								</div>
								<div class="col-12   text-center mt-3 hbgb">
									<button class="call-to-action hbg" type="submit" >
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
	<script src="settings/croppie.js"></script>

	 	 
	

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



