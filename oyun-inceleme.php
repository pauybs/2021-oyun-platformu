<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and  ($KullaniciKuratorDurumu==1)){

	if ($KullaniciKuratorBan==1 and $KullaniciKuratorBanTarih!="") {
		if ($Zaman>=$KullaniciKuratorBanTarih) {
			$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET KuratorBan=?, KuratorBanTarih=?  WHERE  id=?  LIMIT 1 ");
			$BanKaldir->execute([0,NULL,$KullaniciId]);
			$BanKaldirSayisi = $BanKaldir->rowCount();

			if ($BanKaldirSayisi>0) {
				header("Refresh:0");
				exit();

			}
		}
	}
?>
<div class="col-12 Uizahse cvnQAAzx">
	<div class="row justify-content-center">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
			?>
		</div>

			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1  class="bold font15 white">Oyun İncelemesi</h1>
					</div>
					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
						<div class="row  justify-content-center ">
							<div class="col-12 col-md-10 mt-5 mb-5 ibs">
								<form class="is" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data">
									<div class="row iss justify-content-center text-center"></div>
									<div class=" mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >Oyun Adı <span class="red font12">(Zorunlu)</span></div>
										<select  class="js-example-disabled-results pcsbnsad" style="width: 100%"  name="Oyun" >
											<option value="" >Lütfen seçiniz.</option>
											<?php
											$OyunlarSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar  where Durum=? ORDER BY id DESC");
											$OyunlarSorgu->execute([1]);
											$OyunlarSorguSayisi = $OyunlarSorgu->rowCount();
											$OyunlarSorguKayitlar = $OyunlarSorgu->fetchAll(PDO::FETCH_ASSOC);
											if($OyunlarSorguSayisi>0){
												foreach ($OyunlarSorguKayitlar as $Oyunlar){
											?>
												<option value="<?php echo $Oyunlar["id"]; ?>" ><?php echo IcerikTemizle($Oyunlar["OyunAdi"]); ?></option>
											<?php
											}
											}
											?>
										</select>
									</div>
									<div class=" mt-5">   
										<div class="col-12 text-left p-0 font13 bold white" >İnceleme Başlık <span class="red font12">(Zorunlu)</span></div>      
										<input class="p-3 oyincsad" placeholder="İnceleme Başlık"   type="text" name="Baslik" >
									</div>
									<div class=" mt-5 mb-5">   
										<input type="hidden" name="img">
										<div class="col-12 text-left p-0 font13 bold white" >Resim  <span class=" font12 white opacity05">(İsteğe Bağlı)</span></div>      
										<input  type="file" class="p-3 oyinZXcsad" id="upload" accept="image/*" name="Resim1" >
									</div>
									<div class="incph"></div>

									<div class="col-12 text-left p-0 font13 mb-2 bold white" >İnceleme Yazınız <span class="red font12">(Zorunlu)</span></div>  
									<textarea class="ckeditor" id="ckeditor1" name="Inceleme"></textarea>
									
								
									<div class=" mt-5">   
										<div class="col-12 text-left p-0 bold white font13" >İnceleme Video Linki <span class=" font12 white opacity05">(İsteğe Bağlı)</span></div>      
										<input class="p-3  oasdxX" placeholder="İnceleme Linki"  type="text" name="link" >
										<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">

									</div>
								
									<div class="col-12   text-center mt-3 ib">
										<button class="call-to-action ig" type="submit" >
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
<script src="settings/ckeditor/ckeditor.js"></script>
			<script src="settings/croppie.js"></script>


	<link href="settings/select2.min.css" rel="stylesheet" />
	<script src="settings/select2.min.js"></script>
	<style type="text/css">
.select2-container--default .select2-selection--single {
    background: #202020 !important;width: 100%;color:white;border:none !important;
}
</style>
<script src="assets/main_ginc=6.1.8.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var $disabledResults = $(".js-example-disabled-results");
	$disabledResults.select2();
	
});   
</script>

<?php
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>


