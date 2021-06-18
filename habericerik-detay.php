<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and ($KullaniciEditorDurumu==1)){
$HaberId=Guvenlik($_GET["Haber"]);
$IcerikId=SayfaNumarasiTemizle(Guvenlik($_GET["Icerik"]));

$HaberSorgu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum!=? and Durum!=? and Durum!=? AND Editor=?");
$HaberSorgu->execute([$HaberId,0,2,4,Guvenlik($KullaniciId)]);
$HaberSorguVeri = $HaberSorgu->rowCount();
$HaberSorguKayit = $HaberSorgu->fetch(PDO::FETCH_ASSOC);
if ($HaberSorguVeri>0) {
$IcerikSorgu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberresimler WHERE  id=? and HaberUniqid=? AND Durum!=? and Durum!=?  AND Editor=?");
$IcerikSorgu->execute([$IcerikId,$HaberId,0,2,Guvenlik($KullaniciId)]);
$IcerikVeri = $IcerikSorgu->rowCount();
$IcerikSorguKayit = $IcerikSorgu->fetch(PDO::FETCH_ASSOC);
if ($IcerikVeri>0) {
?>	
<div class=" col-12 Uizahse cvnQAAzx">
	<div class="row justify-content-center   ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>

		<div class="col-12 col-xl-10">
			<div class="row mt-5 mb-5  justify-content-center align-items-center">
				<div class="col-11 p-0 " >
					<h1  class="bold font15 white"><?php echo IcerikTemizle($HaberSorguKayit["AnaBaslik"]); ?> Haberi İçerik Detay</h1>
				</div>
				<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
					<div class="row  justify-content-center ">
						<div class="col-12 col-md-12  mt-5 mb-5  hids ">
							<form class="higs" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data"  >
								<?php
								if (IcerikTemizle($IcerikSorguKayit["Video"])) {
								?>
									<div class="row justify-content-center">
										<div class="col-12 col-xl-4 mt-3 mb-3">
											<iframe width="100%" height="250" src="https://www.youtube.com/embed/<?php  echo IcerikTemizle($IcerikSorguKayit["Video"]) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
										</div>
									</div>
									
								<?php	
								}
								?>
								<div class=" mt-4 mb-4">   
									<div class="col-12 text-left p-0 font13 bold white" >İçerik Başlık</div>      
									<input class="white p-3" placeholder="İçerik Başlık" style="background:#202020;font-size:13px;border:none;width:100%" type="text" name="IcerikBaslik" value="<?php echo IcerikTemizle($IcerikSorguKayit["ResimBaslik"])  ?>">
									<input class="white" type="hidden" name="h" value="<?php echo IcerikTemizle($HaberSorguKayit["id"] )?>" >
									<input class="white" type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId )?>" >
									<input class="white"  type="hidden" name="i" value="<?php echo IcerikTemizle($IcerikId) ?>" >
								</div>
								<div class=" mb-4 "> 
									<div class="col-12  yorumk hrs"></div> 
									<div class="col-12 text-left p-0 font13 bold white">İçerik Resmi</div>    
									<input type="hidden" name="img">     
									<input type="file" class="white p-3" id="upload" accept="image/*" style="background: #202020;overflow: hidden;font-size:13px;border:none;width:100%" name="IcerikResmi" >
								</div>
								<div><div class="col-12 icrkph"></div></div>
								<div class=" mt-4 mb-4">   
									<div class="col-12 text-left p-0 font13 bold white">İçerik Video Id <span class="white opacity05 font12">( Sadece Youtube Video Id'si )</span></div>       
									<input class="white p-3" placeholder="İçerik Video" style="background:#202020;font-size:13px;border:none;width:100%" type="text" name="IcerikVideo" maxlength="11" value="<?php echo IcerikTemizle($IcerikSorguKayit["Video"])?>">
									
								</div>
								<div class="" >
									<div class="col-12 text-left p-0 font13 bold white" >İçerik Yazısı <span class="red font12">(Zorunlu)</span></div>      	  
									<textarea class="ckeditor" id="ckeditor1" name="Yazi"><?php echo IcerikTemizle($IcerikSorguKayit["ResimAciklama"])  ?></textarea>
									<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">

								</div>
								<div class="col-12 text-center yorumk iy mb-1"></div>
								<div class="col-12   text-center mb-3  hib">
									<button class="call-to-action hig" type="submit" >
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
<script src="assets/main_e=2.1.6.js"></script>
<script src="assets/main_cd=2.2.13.js"></script>
	<script src="settings/ckeditor/ckeditor.js"></script>
		<script src="settings/croppie.js"></script>


<?php
}else{
	header('Location: '.$SiteLink);
	exit();
}
}else{
	header('Location: '.$SiteLink);
	exit();
}
}else{
	header('Location: '.$SiteLink);
	exit();
}
}else{
	header('Location: '.$SiteLink);
	exit();
}
?>



