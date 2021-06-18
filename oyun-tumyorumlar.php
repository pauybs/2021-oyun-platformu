<?php
require_once("settings/connect.php");
if(isset($_GET["OyunId"])){
$OyunId =Guvenlik($_GET["OyunId"]);	
$OyunSorgusu =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
$OyunSorgusu->execute([$OyunId,1]);
$OyunSorgusuSayi = $OyunSorgusu->rowCount();
$OyunSorgusuKayit = $OyunSorgusu->fetch(PDO::FETCH_ASSOC);
if($OyunSorgusuSayi>0){
?>

<?php
$BannerSorgu = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? and Durum=? ");
$BannerSorgu->execute([11,1]);
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
			$BannerGuncelleme->execute([11] );	
			?>
		</div>
	</div>
</div>
<?php
}
?>
<div class="col-12 p-0  mb-5 " >
	<div class="row justify-content-center m-0  mb-5 ">
		<div class="col-11 col-xl-6  ">
			<div class="row justify-content-center align-items-center wWfVCA " >
			<?php
			if (IcerikTemizle($OyunSorgusuKayit["OyunAdi"])) {
			?>	
				<div class="col-12 mt-3 mb-2"><h1 class="white bold haberDetayBaslik" ><?php echo IcerikTemizle($OyunSorgusuKayit["OyunAdi"]); ?> yorumları</h1></div>
			<?php
			}else{
			?>
				<div class="col-12"></div>
			<?php
			}
			?>
				<div class="col-12 SAFfXxAERz">
					<span class="bold white oyunYazi">Yorumlar (<?php echo IcerikTemizle($OyunSorgusuKayit["YorumSayisi"]);  ?>)</span>
				</div>
				<div class="col-12">
					<div class="row justify-content-center align-items-center text-center">
					<?php
					if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
					?>
						<div class="col-12 mt-4">
							<form class="text-center haberYorum" id="oyuny" action="javascript:void(0);" method="post" >
								<div class="group2">
									<div class="row  align-items-center mb-1">
										<div class="col-12 up">
											<figure>
										  	<?php
											if(file_exists("images/userphoto/".IcerikTemizle($KullaniciProfilResmi)) and (IcerikTemizle(isset($KullaniciProfilResmi))) and (IcerikTemizle($KullaniciProfilResmi)!="") ){
											?>
												<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid  userp" >
											<?php
											}else{
											?>
												<img src="images/user.png" class="img-fluid userp " >
											<?php
											}
											?>
											
												<figcaption>
									  				<span class=" white bold  oyunYazi "><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
												</figcaption>															
											</figure>
										</div>	
									</div>
									<textarea  name="Yorum"  placeholder="Yorumunuzu yazın..."  ></textarea>  
									<input type="hidden" name="o"  value="<?php echo  IcerikTemizle($OyunSorgusuKayit["id"]); ?>"> 
									<input type="hidden" name="ui"  value="<?php echo  IcerikTemizle($OyunId); ?>">   
  
									<input type="hidden" name="Tkn"  value="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>">  
									<span class="highlight"></span>
									<span class="bar"></span>	
								</div>
								<div class="col-12 p-0  mt-3 text-right oyb">
									<button class="call-to-action2" type="submit" id="oyg"  >
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
								<div class="col-12 mb-2 p-0 lıyTQMZLD text-left white oyunYazi" ><span>Yorum yapmak için</span> <a href="girisyap"  style="color: #c28f2c"><span class="oyunYazi" style="">giriş yap</span></a>.</div> 
								<textarea  placeholder="Yorumunuzu yazın..."   required></textarea>      
								<span class="highlight"></span>
								<span class="bar"></span>
							</div>

							<div class="col-12 mt-3 p-0 text-right">
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
					<div class="yorumlar"></div>
					<?php
					include 'includes/oyun-detay/oyun_yorumlar.php';
					?>	
				</div>
			</div>
		</div>	 
	</div>			
</div>
<?php
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
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
	<script src="assets/main_g=5.1.5.js"></script>

<?php
}
?>
<?php
}else{
	header('Location:'. $SiteLink );
	exit();
}
}else{
	header('Location:'. $SiteLink);
	exit();
}
?>

<script type="text/javascript">
	$(".ody").css("display", "none");
	$(".ody").show("slow");
	$(".odyc").css("display", "none");
	$(".odyc").show(1100);
</script>