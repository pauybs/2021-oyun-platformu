<?php
require_once("settings/connect.php");

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)   ){
?>
<div class="col-12">
	<div class="row justify-content-center  align-items-center ">
		<div class="col-12 Uizahse cvnQAAzx">
			<div class="row">
				<div class="col-12 col-xl-2 oRZNAEazx" >
					<div class="row mt-5 mb-5 p-0 justify-content-center align-items-center " >
						<?php
						if($KullaniciProfilResmi!="" and isset($KullaniciProfilResmi) ){
							?>
							<div class="col-12 mb-2 text-center">
								<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?> " class="img-fluid zaWxxZCVR" >
							</div>
							<?php
						}else{
							?>
							<div class="col-12 text-center">
								<img src="images/user.png " class="img-fluid zaWxxZCVR" >
							</div>
							<?php
						}
						?>
						<div class="col-12 white  text-center mt-2 font15 wwqeEzdCZ_ ">
							<span> <?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
						</div>
						<div class="col-12  white text-center  font15 wwqeEzdCZ_ opacity07">
							<span> @<?php echo IcerikTemizle($KullaniciAdi);?></span>
						</div>
						<div class="col-12 mt-5  p-3 aRwQzWR">
							<a href="hesapbilgileri"  ><h1 class=" font15 wwqeECZ_"><i class="fas fa-user ml-3 "></i> <span >Hesap Bilgileri</span></h1></a>
						</div>
						<div class="col-12 p-3 aRwQzWR">
							<a href="favorioyunlarim" ><h1 class=" font15 wwqeECZ_"><i class="fas fa-gamepad ml-3 " ></i> <span >Favori Oyunlarım</span></h1></a>
						</div>
						<div class="col-12 p-3 aRwQzWR">
							<a href="favorihaberlerim"><h1 class=" font15 wwqeECZ_"><i class="far fa-newspaper ml-3 " ></i> <span >Favori Haberlerim</span></h1></a>
						</div>
						<div class="col-12 p-3 aRwQzWR">
							<a href="bilgisayarim" ><h1 class="font15 wwqeECZ_" ><i class="fas fa-laptop ml-3"></i> <span >Bilgisayarım</span></h1></a>
						</div>

						<div class="col-12 p-3    aRwQzWR" >
							<label  for="menu-toggle3" style="cursor: pointer" >
								<span class="font15 wwqeEzdCZ_ white" ><i class="fab fa-readme ml-3"></i><span > Sozlük</span> <i class="fas fa-chevron-down white"></i></span> 
							</label>
						</div>
						<input type="checkbox" id="menu-toggle3"  >
						<ul id="menu3" >
							<li><div class="col-12 text-center  bold mb-3 mt-3" ><a style="color: white " href="basliklarim"><i class="fas fa-edit"></i><span> Başlıklarım</span></a></div></li>
							<li><div class="col-12 text-center bold mb-3" ><a style="color: white " href="yorumlarim"><i class="fas fa-comments"></i><span> Yorumlarım</span></a></div></li>

						</ul>
							

						<?php
						if($KullaniciEditorDurumu=="0"){
							?>
							<div class="col-12 p-3 aRwQzWR" style="cursor: pointer" >
								<a href="editorbasvuru" ><h1 class="font15 wwqeECZ_" ><i class="fas fa-user-edit ml-3"></i> <span >Editor Başvuru</span></h1></a>
							</div>
							<?php
						}else if ($KullaniciEditorDurumu=="1"){
							?>
							<div class="col-12 p-3    aRwQzWR" >
								<label  for="menu-toggle2" style="cursor: pointer" >
									<span class="font15 wwqeEzdCZ_ white" ><i class="far fa-newspaper ml-3"></i> <span >Haber</span> <i class="fas fa-chevron-down white"></i></span> 
								</label>
							</div>
							<input type="checkbox" id="menu-toggle2" >
							<ul id="menu2" >
								<li><div class="col-12 text-center  bold mb-3 mt-3" ><a class="  " style="color: white " href="haberekle"><i   class="fas fa-plus "></i> <span>Haber Ekle</span></a></div></li>
								<li><div class="col-12 text-center bold mb-3" ><a class="" style="color: white " href="haberlerim"><i class="fas fa-file-signature ml-3"></i> <span>Haberlerim</span></a></div></li>

							</ul>
							<?php
						}
						?>

						<?php
						if($KullaniciKuratorDurumu=="0"){
							?>
							<div class="col-12 p-3  aRwQzWR" style="cursor: pointer" >
								<a href="kuratorbasvuru" ><h1 class="font15 wwqeECZ_" ><i class="fas fa-user-edit ml-3"></i> <span >Kürator Başvuru</span></h1></a>
							</div>
							<?php
						}else if ($KullaniciKuratorDurumu=="1"){
							?>
							<div class="col-12 p-3 aRwQzWR" >
								<label  for="menu-toggle" style="cursor: pointer" >
									<span class="font15 wwqeEzdCZ_ white" ><i class="fas fa-user-edit ml-3 "></i> <span >Oyun İncelemesi</span> <i class="fas fa-chevron-down white"></i></span> 
								</label>
							</div>
							<input type="checkbox" id="menu-toggle" >
							<ul id="menu" >
								<li><div class="col-12 text-center  bold mb-3 mt-3" ><a style="color: white " href="oyuninceleme"><i class="fas fa-plus ml-3"></i> <span>İnceleme Yap</span></a></div></li>
								<li><div class="col-12 text-center bold mb-3" ><a class="" style="color: white " href="oyunincelemelerim"><i class="fas fa-file-signature ml-3"></i> <span>İncelemelerim</span></a></div></li>
							</ul>
							<?php
						}
						?>
						<div class="col-12 p-3   ZXyvAzZD" >
							<a href="destek"  ><h1 class=" font15 wwqeEzdCZ_"><i class="far fa-life-ring ml-3"></i> <span >Destek</span></h1></a>
						</div>
						<div class="col-12 p-3 aRwQzWR" >
							<a href="guvenlikbilgileri" ><h1 class=" font15 wwqeECZ_"><i class="fas fa-lock ml-3 "></i> <span >Güvenlik</span></h1></a>
						</div>
						<div class="col-12 p-3 aRwQzWR ">
							<a href="cikisyap"><h1 class=" font15 wwqeECZ_"><i class="fas fa-sign-out-alt ml-3 "></i> <span >Güvenli Çıkış</span></h1></a>
						</div>
					</div>
				</div>
				<div class="d-none d-xl-block col-10">
					<div class="row mt-5 mb-5 justify-content-center align-items-center">
						<div class="col-5 " ><a href="hesapbilgileri"  >
							<div class="row justify-content-center align-items-center text-center p-1">
								<div class="col-12 golge qzkkAZ___azmkdlq_" >
									<div class="row ">
										<div class="col-12 mt-5 "><i style="color: #c28f2c;" class="  fas fa-user fa-5x"></i></div>
										<div class="col-12 mt-3"><span class="rtJMZwpmkt__Df" >Hesap Bilgileri</span></div>
										<div class="col-12 mb-5 "><span class="kzzmAJEUJ_yrMZASA" >Özel bilgilerinizi düzenleyin.</span></div>
									</div>
								</div>
							</div></a>
						</div>
						<div class="col-5" ><a href="favorioyunlarim" >
							<div class="row justify-content-center align-items-center text-center p-1">
								<div class="col-12 golge qzkkAZ___azmkdlq_" >
									<div class="row ">
										<div class="col-12 mt-5 "><i style="color: #c28f2c" class="  fas fa-gamepad fa-5x"></i></div>
										<div class="col-12 mt-3 "><span class="rtJMZwpmkt__Df" >Favori Oyunlar</span></div>
										<div class="col-12 mb-5 "><span class="kzzmAJEUJ_yrMZASA" >Favori oyunlarınızı gözden geçirin.</span></div>
									</div>
								</div>
							</div></a>
						</div>				
						<div class="col-5" ><a href="favorihaberlerim" >
							<div class="row justify-content-center align-items-center text-center p-1">
								<div class="col-12 golge qzkkAZ___azmkdlq_ " >
									<div class="row ">
										<div class="col-12 mt-5 "><i style="color: #c28f2c" class="far fa-newspaper fa-5x"></i></div>
										<div class="col-12 mt-3 "><span  class="rtJMZwpmkt__Df" >Favori Haberler</span></div>
										<div class="col-12 mb-5 "><span class="kzzmAJEUJ_yrMZASA" >Favori haberlerinizi gözden geçirin</span></div>
									</div>
								</div>
							</div></a>
						</div>
						<div class="col-5" ><a href="bilgisayarim" >
							<div class="row justify-content-center align-items-center text-center p-1">
								<div class="col-12 golge qzkkAZ___azmkdlq_" >
									<div class="row ">
										<div class="col-12 mt-5 "><i style="color: #c28f2c" class="fas fa-laptop fa-5x"></i></div>
										<div class="col-12 mt-3"><span class="rtJMZwpmkt__Df" >Bilgisayarım</span></div>
										<div class="col-12 mb-5 "><span class="kzzmAJEUJ_yrMZASA" >Bilgisayarınıza en uygun oyunları bulun.</span></div>
									</div>
								</div>
							</div></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php
}else{
	header('Location: '. $SiteLink);
	exit();
}
?>