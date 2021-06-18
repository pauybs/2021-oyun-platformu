<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_GET["HaberId"]) ){
$HaberId =Guvenlik($_GET["HaberId"]);	
$HaberSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum=? LIMIT 1 ");
$HaberSorgusu->execute([$HaberId,1]);
$HaberSorgusuSayi = $HaberSorgusu->rowCount();
$HaberSorgusuKayit = $HaberSorgusu->fetch(PDO::FETCH_ASSOC);
if($HaberSorgusuSayi>0){
?>
<?php
$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
$BannerSorgu->execute([12,1]);
$Data = $BannerSorgu->rowCount();
$Banner = $BannerSorgu->fetch(PDO::FETCH_ASSOC);
if ($Data>0) {
?>	
<div class="col-12 mt-5 mb-5">
	<div class="row justify-content-center align-items-center text-center" >
		<div class="col-12">
			<?php echo IcerikTemizle($Banner["BannerKodu"]); ?> 
			<?php
			$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
			$BannerGuncelleme->execute([12] );	
			?>
		</div>
	</div>
</div>
<?php
}
?>

<div class="col-12 p-0 mb-5 " >
	<div class="row justify-content-center m-0  mb-5 ">
		<div class="col-11 col-xl-6  ">
			<div class="row justify-content-center align-items-center  wWfVCA" >
			<?php
			if (IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) {
			?>	
				<div class="col-12 mt-3 mb-2"><h1 class="white bold haberDetayBaslik"><?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?> yorumları</h1></div>
			<?php
			}
			?>
						
			<div class="col-12 mt-5">
				<div class="row">
					<div class="col-12">
						<span style="color:#c28f2c;" class="bold  haberdra">Yorumlar (<?php echo IcerikTemizle($HaberSorgusuKayit["YorumSayisi"]); ?>)</span>
					</div>
					<?php
					if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
					?>
					<div class="col-12 mt-4 text-center haberYorum">
						<form id="habery"  action="javascript:void(0);" method="post" >
							<div class="group2">
								<div class="row  align-items-center mb-2  align-items-center">
									<div class="col-12 up ">
										<figure>
									  	<?php
										if(file_exists("images/userphoto/".IcerikTemizle($KullaniciProfilResmi)) and (IcerikTemizle(isset($KullaniciProfilResmi))) and (IcerikTemizle($KullaniciProfilResmi)!="") ){
										?>
											<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid ml-2 userp" >
										<?php
										}else{
										?>
											<img src="images/user.png" class="img-fluid userp " >
										<?php
										}
										?>
										
											<figcaption>
								  				<span class=" white bold haberdra asztwrtwcx "><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
											</figcaption>															
										</figure>
									</div>	
								</div>
								<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."  ></textarea> 
								<input type="hidden" name="ui"  value="<?php echo IcerikTemizle($HaberId) ?>">    
								<input type="hidden" name="h"  value="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>"> 
								<input type="hidden" name="Tkn"  value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>"> 

								<span class="highlight"></span>
								<span class="bar"></span>
							</div>
							<div class="col-12 p-0  mt-3 text-right ">
								<button class="call-to-action2" type="submit" id="hyg"  >
									<div>
										<div>Gönder</div>
									</div>
								</button>
							</div>
						</form>
					</div>
					<?php
					}else{
					?>
						<div class="col-12 mt-4 haberYorum">
							<div class="group2">
								<div class="col-12 mb-2 p-0 white bold haberdra" >
									<span>Yorum yapmak için</span> <a href="girisyap"  style="color: #c28f2c"><span style="">giriş yap</span></a>.
								</div> 
								<textarea  placeholder="Yorumunuzu yazın..." required></textarea>      
								<span class="highlight"></span>
								<span class="bar"></span>
							</div>
							<div class="col-12  mt-3  p-0  text-right " >
								<button class="call-to-action2" >
									<div>
										<div>Gönder</div>
									</div>
								</button>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
			<div class="col-12  mb-5 ">
				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
					if ($KullaniciYorumBan==1 and $KullaniciYorumBanTarih!="") {
						if ($Zaman>=$KullaniciYorumBanTarih) {
							$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET YorumBan=?, YorumBanTarih=?  WHERE  id=?  LIMIT 1 ");
							$BanKaldir->execute([0,NULL,$KullaniciId]);
							$BanKaldirSayisi = $BanKaldir->rowCount();

							if ($BanKaldirSayisi>0) {
								header("Refresh:0");
								exit();

							}
						}
					}
				?>
				<script src="assets/main_n=3.1.4.js"></script>
				<?php
				}
				?>
				<div class="yorumlar"></div>
				<?php
				include 'includes/haberdetay/haber_yorumlar.php';
				?>
			</div>
		</div>	 
	</div>			
</div>

<script type="text/javascript">
$(".hdy").css("display", "none");
$(".hdy").show("slow");

$(".hdyc").css("display", "none");
$(".hdyc").show(1100);
</script>
<?php
}else{
	header('Location: '.$SiteLink );
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

