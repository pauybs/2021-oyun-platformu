<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
    
if( isset($_GET["Haber"])and  isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and (IcerikTemizle($KullaniciEditorDurumu)==1) ){
$HaberId =Guvenlik($_GET["Haber"]);
$EditorKontrol =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Editor=? and Durum=? ");
$EditorKontrol->execute([$HaberId,Guvenlik($KullaniciId),2]);
$EditorKontrolSayi = $EditorKontrol->rowCount();
$EditorKontrolKayit = $EditorKontrol->fetch(PDO::FETCH_ASSOC);
if ($EditorKontrolSayi>0) {
	if ($KullaniciEditorBan==1 and $KullaniciEditorBanTarih!="") {
		if ($Zaman>=$KullaniciEditorBanTarih) {
			$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET EditorBan=?, EditorBanTarih=?  WHERE  id=?  LIMIT 1 ");
			$BanKaldir->execute([0,NULL,$KullaniciId]);
			$BanKaldirSayisi = $BanKaldir->rowCount();

			if ($BanKaldirSayisi>0) {
				header("Refresh:0");
				exit();

			}
		}
	}
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
						<h1 class="bold font15 white"><?php echo IcerikTemizle($EditorKontrolKayit["AnaBaslik"]) ?> Haberi İçerik Ekleme</h1>
					</div>
					<div class="col-11 mt-3 golge his" style="background: rgb(0,0,0,0.5);">
						<div class="row p-2">
							<div class="col-12 hbs"><div class="col-12 mb-4 mt-4  text-left" style="border-left: 5px solid #c28f2c"><h5 class="bold white mt-4">İçerik Ekle</h5> </div>
								<div class="row " >
									
									<div class="col-12 cvbnkasxcz">
										<form class=" hie" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data">
											<div class="row justify-content-center mt-4 yorumk hss"></div>
											<div class=" mt-4 mb-4">   
												<div class="col-12 text-left p-0 font13 bold white" >İçerik Başlık</div>      
												<input class="white p-3 hbredklfja"  placeholder="İçerik Başlık" type="text" name="IcerikBaslik" >
												<input class="white"  type="hidden" name="h" value="<?php echo IcerikTemizle($EditorKontrolKayit["id"]) ?>" >
											</div>
											<div class=" mb-4 "> 
												<div class="col-12  yorumk hrs"></div> 
												<div class="col-12 text-left p-0 font13 bold white" >İçerik Resmi</div>  
												<input type="hidden" name="img">    
												<input class="white"  type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId) ?>" >

												<input type="file" class="white p-3 hbresav" id="upload" accept="image/*" name="IcerikResmi">

											</div>
											<div><div class="col-12 icrkph"></div></div>
											<div class=" mt-4 mb-4">   
												<div class="col-12 text-left p-0 font13 bold white">İçerik Video Id <span class="white opacity05 font12">( Sadece Youtube Video Id'si )</span></div>      
												<input class="white p-3 hbredklfja"  maxlength="11" placeholder="İçerik Video" type="text" name="IcerikVideo" >
												<input class="white"  type="hidden" name="h" value="<?php echo IcerikTemizle($EditorKontrolKayit["id"]) ?>" >
											</div>
											
											

											<div class="" >
												<div class="col-12 text-left p-0 font13 bold white" >İçerik Yazısı <span class="red font12"> (Zorunlu)</span></div>      	  
												<textarea class="ckeditor" id="ckeditor1" name="Yazi"></textarea>
												<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
											</div>
											<div class="col-12 text-center yorumk mt-4 iy mb-1"></div>
											
											<div class="col-12 text-center mb-3 higb">
												<button class="call-to-action hig" type="submit" >
													<div>
														<div>Yükle</div>
													</div>
												</button>
											</div>
											

											
										</form>
									</div>
								</div>
							</div>	

							<div class="col-12  mt-5 " >
								<div class="col-12 text-left mb-4 mt-5" style="border-left: 5px solid #c28f2c"><h5  class="bold white">Eklenen Haber İçerikleri</h5> </div>
								<div class="row  zxzaYAZNzcxZ">
								<?php
								$HaberResimleri = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler WHERE HaberId=? and HaberUniqid=? and Durum=? and Editor=? ORDER BY id ASC");
								$HaberResimleri->execute([Guvenlik($EditorKontrolKayit["id"]),$HaberId,1,Guvenlik($KullaniciId)]);
								$HaberResimleriSayisi = $HaberResimleri->rowCount();
								$HaberResimleriKayitlar = $HaberResimleri->fetchAll(PDO::FETCH_ASSOC);
								if ($HaberResimleriSayisi>0) {
									foreach ($HaberResimleriKayitlar as $resimkayitlar) {
								?>
									<div class="col-12 mb-5 mt-5" id="i<?php echo $resimkayitlar["id"] ?>">
										<div class="row  justify-content-center   " >
											<div class="col-11  text-center" >
											<?php
											if (IcerikTemizle($resimkayitlar["Resim"]) and file_exists("images/news/contents/".$resimkayitlar["Resim"])) {
											?>
												<img src="images/news/contents/<?php echo IcerikTemizle($resimkayitlar["Resim"]) ?>" class="img-fluid">
											<?php
											}else{
											?>
												<img src="images/icerik.jpg" class="img-fluid">
											<?php
											}
											?>
												<div class="row justify-content-center mt-1">
													<?php
													if (IcerikTemizle($resimkayitlar["Video"])) {
													?>
														<div class="col-12 col-xl-6 mt-3 mb-3">
																<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?php  echo IcerikTemizle($resimkayitlar["Video"]) ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
															</div>
													<?php	
													}
													?>
													
													
													<div class="col-11 p-0 text-left mb-1 mt-2 bold white">İçerik Başlık</div>
													<div class=" col-12 col-xl-11 p-2 text-left white " style="background:#202020;width: 100%;"><?php echo IcerikTemizle($resimkayitlar["ResimBaslik"]) ?></div>
													<div class="col-11 p-0 text-left mb-1 mt-4 bold white">İçerik Açıklama</div>
													<div class="col-11 p-2 text-left cvxcvqszZ peditor font15"><?php  echo IcerikTemizle($resimkayitlar["ResimAciklama"]) ?></div> 
												</div>
											</div>
										</div>

										<div class="row justify-content-center mb-3 mt-3">
											<div class="col-7 col-xl-3">
												<button class="btn-block btn ihk bold white" id="hi<?php echo $resimkayitlar["id"] ?>" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo $resimkayitlar["id"] ?>" type="submit" style="background-color: red;color:white; "> İçerik Kaldır </button>
											</div>
										</div>
									</div>
								<?php
									}
								}else{
								?>		
									<div class="col-12  hib">
										<div class="row justify-content-center align-items-center text-center p-5 " >
											<div class="col-12 mt-5 mb-5"></div>
										</div>
									</div>		
								<?php
								}
								?>	
									<div class="col-12 ">
										<div class="row ghi"></div>
									</div>
								</div>
							</div>
							<div class="col-12  mt-5 mb-5" >
								<div class="row  justify-content-center  text-center">
									<form class=" hit " method="post" id="singnupFrom" action="javascript:void(0);"   >
										<div class="col-12">
											<input type="checkbox"  name="Yayinla" value="1"> <span class="bold font15 white">Sitede Yayınla </span>
											<input type="hidden" name="h" value="<?php echo IcerikTemizle($EditorKontrolKayit["id"]) ?>">
											<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
											<input class="white"  type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId) ?>" >

										</div>
									
										<div class="col-12   mt-3  p-0 ">
											<button class="call-to-action ht hd"   type="submit" >
												<div>
													<div>Tamamla</div>
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
	</div>
	
	<script src="assets/main_c=2.3.7.js"></script>
		<script src="settings/ckeditor/ckeditor.js"></script>
	<script src="settings/croppie.js"></script>

	

<?php
}else{
	header('Location:' .$SiteLink);
	exit();
}
}else{
	header('Location:' .$SiteLink);
	exit();
}
}else{
	header('Location:' .$SiteLink);
	exit();
}
?>





