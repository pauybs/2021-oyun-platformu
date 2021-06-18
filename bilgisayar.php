<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
?>
<style type="text/css"> 
	.select2-container--default .select2-selection--single {background:#202020 !important;width: 100%;color:white;border:none !important; }
</style>

<link href="settings/select2.min.css" rel="stylesheet" />
<script src="settings/select2.min.js"></script>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center  ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
			</div>

			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1  class="bold font15 white ">Bilgisayarım</h1>
					</div>
					<div class="col-11 mt-3 golge"style="background:  rgb(0,0,0,0.5);">
						<div class="row  justify-content-center ">
						    <div class="col-12 mt-4">
						        <div class="row justify-content-center">
						           
						            <div class="col-12 text-center opacity07">
						                <i class="fas fa-info-circle font14" style="color:#c28f2c"></i> <span class="bold white font14">Donanım sistemleri - oyun sistem gereksinimleri karşılaştırması değişiklik gösterebilmektedir.</span>
						            </div>
						             <div class="col-12 text-center opacity07 mt-2">
						                <i class="fas fa-bullhorn font14 " style="color:#c28f2c"></i> <i class="fas fa-bullhorn font14 " style="color:#c28f2c"></i> <span class="bold white font14">30.03.2021 Tarihli Sistem Bilgileri Güncellemesi Nedeniyle Bilgisayar Donanım Bilgilerinizi Tekrar Girmeniz Gerekmektedir.</span> 
						            </div>
						        </div>
						    </div>
							<div class="col-12 col-md-6  mb-5 pcs" >
								<form class=" pc" method="post" id="singnupFrom"  action="javascript:void(0);">
									<div class="group mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >İşletim Sistemi</div>
										<select   class="js-example-disabled-results pcsbnsad" style="width:100%" name="IsletimSistemi" >
										<option value="" >Lütfen seçiniz.</option>
										<?php
										$IsletimSistemleri = $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri  ORDER BY id DESC");
										$IsletimSistemleri->execute();
										$IsletimSistemleriSayisi = $IsletimSistemleri->rowCount();
										$IsletimSistemleriKayitlar = $IsletimSistemleri->fetchAll(PDO::FETCH_ASSOC);
										if ($IsletimSistemleriSayisi>0) {
											foreach ($IsletimSistemleriKayitlar as $isletisistemleri){	
											?>
												<option value="<?php echo IcerikTemizle($isletisistemleri["id"]); ?>" <?php  if( IcerikTemizle($KullaniciIsletimSistemiId )== IcerikTemizle($isletisistemleri['id']) ){  ?> selected="selected"<?php } ?>  ><?php echo IcerikTemizle($isletisistemleri["IsletimSistemiAdi"]) ?></option>
											<?php
											}
										}
										?>
										</select>
									</div>

									<div class=" mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >İşlemci</div>
										<select  class="js-example-disabled-results pxchxzc" style="width:100%" name="Islemci"   >
										<option value="" >Lütfen seçiniz.</option>
										<?php
										$Islemci = $DatabaseBaglanti->prepare("SELECT * FROM islemciler ORDER BY id ASC");
										$Islemci->execute();
										$IslemciSayisi = $Islemci->rowCount();
										$IslemciKayitlar = $Islemci->fetchAll(PDO::FETCH_ASSOC);
										if ($IslemciSayisi>0) {
											foreach ($IslemciKayitlar as $islemciler){	
												?>
												<option value="<?php echo IcerikTemizle($islemciler["id"]); ?>" <?php  if( IcerikTemizle($KullaniciIslemciId )== IcerikTemizle($islemciler['id']) ){  ?> selected="selected"<?php } ?>  ><?php echo IcerikTemizle($islemciler["IslemciAdi"]); ?></option>
												<?php
											}
										}
										?>
										</select>
									</div>

									<div class=" mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >Ekran Kartı</div>
										<select class="js-example-disabled-results pcsbnsad" style="width:100%" name="EkranKarti"   >
										<option value="" >Lütfen seçiniz.</option>
										<?php
										$EkranKarti = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari ORDER BY id ASC");
										$EkranKarti->execute();
										$EkranKartiSayisi = $EkranKarti->rowCount();
										$EkranKartiKayitlar = $EkranKarti->fetchAll(PDO::FETCH_ASSOC);
										if ($EkranKartiSayisi>0) {
											foreach ($EkranKartiKayitlar as $ekrankartlari){	
												?>
												<option value="<?php echo IcerikTemizle($ekrankartlari["id"]); ?>" <?php  if( IcerikTemizle($KullaniciEkranKartiId )== IcerikTemizle($ekrankartlari['id']) ){  ?> selected="selected"<?php } ?>  ><?php echo IcerikTemizle($ekrankartlari["EkranKartiAdi"]); ?></option>
												<?php
											}
										}
										?>
										</select>
									</div>

									<div class="group mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >Bellek</div>
										<select  class="js-example-disabled-results pcsbnsad" style="width:100%" name="Bellek"   >
										<option value="" >Lütfen seçiniz.</option>
										<?php
										$RamSorgu = $DatabaseBaglanti->prepare("SELECT * FROM ram  ORDER BY RamPuan DESC");
										$RamSorgu->execute();
										$RamSayisi = $RamSorgu->rowCount();
										$RamKayitlar = $RamSorgu->fetchAll(PDO::FETCH_ASSOC);
										if($RamSayisi>0){
											foreach ($RamKayitlar as $Ramlar){
												?>
												<option value="<?php echo IcerikTemizle($Ramlar["id"]); ?>" <?php  if( IcerikTemizle($KullaniciPcRamId) == IcerikTemizle($Ramlar['id']) ){  ?> selected="selected"<?php } ?>><?php echo IcerikTemizle($Ramlar["RamTuru"]); ?></option>
												<?php
											}
										}
										?>
										</select>
									</div>

									<div class=" mt-5"> 
										<div class="col-12 text-left p-0 font13 bold white" >DirectX</div>
										<select  class="js-example-disabled-results pcsbnsad" style="width:100%" name="DirectX"   >
										<option value="" >Lütfen seçiniz.</option>
										<?php
										$directxSorgu = $DatabaseBaglanti->prepare("SELECT * FROM directx  ORDER BY DirectxPuan DESC");
										$directxSorgu->execute();
										$directxSayisi = $directxSorgu->rowCount();
										$directxKayitlar = $directxSorgu->fetchAll(PDO::FETCH_ASSOC);
										if($directxSayisi>0){
											foreach ($directxKayitlar as  $directx) {										
												?>
												<option value="<?php echo IcerikTemizle($directx['id']) ?>" <?php  if( IcerikTemizle($KullaniciPcDirectxId )== IcerikTemizle($directx['id']) ){  ?> selected="selected"<?php } ?>><?php echo IcerikTemizle($directx["DirectxAdi"]); ?></option>
												<?php
											}
										}
										?>
										</select>
										<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
									</div>
									<div class="col-12   text-center mt-3 pk">
										<button class="call-to-action pcg" type="submit">
											<div>
												<div>Kaydet</div>
											</div>
										</button>
									</div>
									
									
								</form>
							
							</div>
							
							<div class="col-12 mb-4 mt-2 ">
								<div class="row justify-content-center ">
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-angle-double-up  font20   "style="color: #077700 "></i> <span class="bold white font12" >Çok Yüksek Performans</span>

											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-angle-up   font20 " style="color: #b3db00"  ></i> <span class="bold white font12" >Yüksek Performans</span>

											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												
												<i class="fas fa-angle-left  font20" style="color: #c28f2c" ></i>
												<i class="fas fa-angle-right font20" style="color: #c28f2c" ></i>
												<span class="bold white font12" >Minimum Performans</span>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-angle-down   font20 " style="color: #ef5121" ></i> 															
												<span class="bold white font12" >Düşük Performans</span>


											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-angle-double-down   font20 red"  ></i>
												<span class="bold white font12" >Çok Düşük Performans</span>

											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-check-circle green   font20 "  ></i>
												<span class="bold white font12" >Destekliyor</span>

											</div>
										</div>
									</div>
									<div class="col-12 col-md-3 mb-2">
										<div class="row">
											<div class="col-12 text-center">
												<i class="fas fa-times-circle red  font20 red"  ></i>
												<span class="bold white font12" >Desteklemiyor</span>

											</div>
										</div>
									</div>
								</div>
							</div>
    							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/main_p=1.2.7.js"></script>
	<script type="text/javascript">
		var $disabledResults = $(".js-example-disabled-results");
	$disabledResults.select2();
	</script>
	
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

