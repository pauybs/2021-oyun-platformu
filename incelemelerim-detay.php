<?php
require_once("settings/connect.php");

if( isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and ($KullaniciKuratorDurumu==1)  ){
	$IncelemeId=SayfaNumarasiTemizle(Guvenlik($_GET["Inceleme"]));
	$IncelemeSorgu =  $DatabaseBaglanti->prepare("SELECT * FROM  incelemeler WHERE  Incelemeid=? AND Durum!=? and Durum!=? and Durum!=? and Durum!=? AND KuratorId=?");
	$IncelemeSorgu->execute([$IncelemeId,0,3,4,5,Guvenlik($KullaniciId)]);
	$Veri = $IncelemeSorgu->rowCount();
	$IncelemeSorguKayit = $IncelemeSorgu->fetch(PDO::FETCH_ASSOC);
	if ($Veri>0) {
	?>
	<div class="col-12 Uizahse cvnQAAzx">
		<div class="row justify-content-center ">
			<div class="col-12 col-xl-2 oRZNAEazx" >
				<?php
				include 'includes/hesabim_menu.php';
				?>
			</div>

			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1 class="bold font15 white"><?php echo IcerikTemizle($IncelemeSorguKayit["Baslik"]); ?> İncelemesi Detay</h1>
					</div>
					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
						<div class="row  p-0 justify-content-center ">
							<?php
							if($IncelemeSorguKayit["Resim1"]!="" and isset($IncelemeSorguKayit["Resim1"]) and file_exists("images/inceleme/".$IncelemeSorguKayit["Resim1"]) ){
							?>
							<div class="col-3 mt-3">
								<img src="images/inceleme/<?php echo IcerikTemizle($IncelemeSorguKayit["Resim1"]) ?>" class="img-fluid ">		

							</div>
							<div class="col-12 text-center mt-2">
								<span class="igk" data="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data-id="<?php echo IcerikTemizle($IncelemeSorguKayit["Incelemeid"]); ?>"><i class="fas fa-trash-alt white"></i> <span class="bold white font14">Görseli Kaldır</span></span> 
							</div>
							<?php
							}
							?>
							
							<div class="col-12 col-md-12 mt-5 mb-5 oidfs">
								<form class="oidf p-0" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data">
									 <div class="row iss justify-content-center text-center"></div>
									<div class="col-12 mb-4">
										<div class="col-12 text-left p-0 font13 bold white" >Oyun Adı <span class="red font12">(Zorunlu)</span></div>
										<select class="js-example-disabled-results pcsbnsad" style="width: 100%" name="OyunAdi"   >
										<?php
										$OyunAdiSorgu = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar  ORDER BY id DESC ");
										$OyunAdiSorgu->execute();
										$OyunAdiSayisi = $OyunAdiSorgu->rowCount();
										$OyunAdiKayitlar = $OyunAdiSorgu->fetchAll(PDO::FETCH_ASSOC);
										if($OyunAdiSayisi>0){
											foreach ($OyunAdiKayitlar as  $OyunAdi) {										
										?>
											<option  value="<?php echo IcerikTemizle($OyunAdi['id']) ?>" <?php  if( IcerikTemizle($IncelemeSorguKayit["OyunId"] )== IcerikTemizle($OyunAdi['id']) ){  ?> selected="selected"<?php } ?>><?php echo IcerikTemizle($OyunAdi["OyunAdi"]); ?></option>
										<?php
										}
										}
										?>
										</select>
									</div>
									<div class="col-12 mb-4">
										<div class="col-12 text-left p-0 font13 bold white" >İnceleme Başlık <span class="red font12">(Zorunlu)</span></div>      
										<input placeholder="İnceleme Başlık" class="p-3 indesxcZ"  type="text" placeholder="İnceleme Başlık" name="Baslik" value="<?php echo IcerikTemizle($IncelemeSorguKayit["Baslik"]); ?>" >
										<input type="hidden" name="oi" value="<?php echo IcerikTemizle($IncelemeSorguKayit["Incelemeid"]); ?>">
									</div>
									<div class="col-12 mb-4 ">
										<input type="hidden" name="img">
										<div class="col-12 text-left p-0 font13 bold white" >Resim <span class=" font12 white opacity05">(İsteğe Bağlı)</span></div>      
										<input class="p-3 CXzzxc" type="file" id="upload"  name="Resim1" >	
									</div>
									<li><div class="incph"></div></li>
									<div class="col-12 mb-4 ">
									<div class="col-12 text-left p-0 font13 mb-2 bold white" >İnceleme Yazınız <span class="red font12">(Zorunlu)</span></div>  
									<textarea class="ckeditor" id="ckeditor1" name="Inceleme">
										<?php echo IcerikTemizle($IncelemeSorguKayit["IncelemeYazisi"]); ?>
									</textarea>
									<input type="hidden" name="tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>">

								</div>

									
									<div class="col-12 mt-4 ">
										<div class="col-12 text-left p-0 font13 bold white" >İnceleme Video Linki <span class=" font12 white opacity05">(İsteğe Bağlı)</span></div>      
										<input placeholder="İnceleme Linki" class="p-3 oyincsad" type="text" name="Link"  value="<?php echo IcerikTemizle($IncelemeSorguKayit["IncelemeLink"]); ?>">
									</div>
									<div class="col-12  mt-3 mb-3  p-0  text-center idb" >
										<button class="call-to-action  oid"  >
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
<script src="assets/main_mid=4.2.11.js"></script>
	<script src="settings/ckeditor/ckeditor.js"></script>
		<script src="settings/croppie.js"></script>


	<link href="settings/select2.min.css" rel="stylesheet" />
	<script src="settings/select2.min.js"></script>

	<script type="text/javascript">
	$(document).ready(function(){
		var $disabledResults = $(".js-example-disabled-results");
		$disabledResults.select2();
		
	});   
	</script>
	<style type="text/css">
	.select2-container--default .select2-selection--single { background: #202020 !important;width: 100%;color:white;border:none !important; }
	</style>
	<?php
	}else{
		header('location:'.$SiteLink);
		exit();
	}
}else{
	header('location:'.$SiteLink);
	exit();
}
?>
