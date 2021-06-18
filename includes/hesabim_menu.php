<?php

if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
?>
	<div class="row mt-5 mb-5 p-0 justify-content-center align-items-center">
		<div class="col-12  text-center">
		<?php
		if($KullaniciProfilResmi!="" and isset($KullaniciProfilResmi) and file_exists("images/userphoto/".$KullaniciProfilResmi) ){
		?>
			
			<div class="col-12 mb-2 text-center">
				<img src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?>" class="img-fluid zaWxxZCVR">		
			</div>
			<?php
			if ($MetaVeri[1]=="hesapbilgileri") {
			?>
			<span data-toggle="modal" data-target="#profil" class="bold white font13 opacity07" style="cursor: pointer;" >Değiştir</span>
			<span class="bold white">-</span>  
			<span  style="cursor: pointer;" class="opacity07 bold white font13 prk prks" data="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">Kaldır</span>
			<div class="modal fade mt-5" id="profil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background: #202020">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-12">
									<span class="bold white"> Profil resmi kuralları</span>
								</div>
								<div class="col-11 white bold opacity07 font13" >
									<span >Profil resminizin <a href="topluluk-kurallari" style="opacity: 1;color: #c28f2c" class="bold "> Topluluk Kurallarımıza</a> uygun olması ve şu ölçütleri karşılaması gerekir:</span> <span >JPG, JPEG veya PNG dosyası.</span> <span>Önerilen 300 X 300 piksel resim </span>
								</div>	
							</div>
							<div class="col-12 text-center prs mt-2"></div>
							<form class=" pr " method="post" action="javascript:void(0);">
								<input type="hidden" name="img">
								<div class="col-12 mt-2 mb-2">
									<div class="col-12 text-left p-0 white bold" >Profil Resmi</div>      
									<input type="file" class="p-2 hspbdzZX" id="upload" accept="image/*" name="ProfilResim" >
									<input type="hidden"  name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" >
								</div>
								<li><div class="userph"></div></li>
								<div class="col-12  mt-3 mb-3  p-0  text-center  pb" >
									<button class="call-to-action2  pry " >
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
			<?php
			}
			?>
		<?php
		}else{
		?>
			<div class="col-12 text-center">
				<img src="images/user.png " class="img-fluid zaWxxZCVR">
			</div>
			<?php
			if ($MetaVeri[1]=="hesapbilgileri") {
			?>
			<span style="cursor:pointer;" data-toggle="modal" data-target="#profil" class="bold white font13">Değiştir</span>
			<div  class="modal fade mt-5" id="profil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background: #202020">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="white">&times;</span>
							</button>
						</div>
						<div class="modal-body "  >
							<div class="row justify-content-center">
								<div class="col-12">
									<span class="bold white"> Profil resmi kuralları</span>
								</div>
								<div class="col-11 white bold opacity07 font13" >
									<span >Profil resminizin <a href="topluluk-kurallari" style="opacity: 1;color: #c28f2c" class="bold "> Topluluk Kurallarımıza</a> uygun olması ve şu ölçütleri karşılaması gerekir:</span> <span >JPG, JPEG veya PNG dosyası.</span> <span > Önerilen 300 X 300 piksel resim </span>
								</div>
							</div>
							<div class="col-12 text-center prs"></div>
							<form class=" pr " method="post" action="javascript:void(0);">
								<input type="hidden" name="img">
								<div class="col-12 mt-2 mb-2">
									<div class="col-12 text-left p-0 white bold" >Profil Resmi</div>      
									<input type="file" class="p-2 hspbdzZX"  id="upload" accept="image/*"  name="ProfilResim">
									<input type="hidden"  name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" >
								</div>
								<li><div class="userph"></div></li>
								<div class="col-12  mt-3 mb-3  p-0  text-center  pb" >
									<button class="call-to-action2  pry " >
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
			<?php
			}
			?>
		<?php
		}
		?>	
		</div>

		<div class="col-12 mt-2  text-center  font15 wwqeEzdCZ_ ">
			<span> <?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span>
		</div>
		<div class="col-12  text-center  font15 wwqeEzdCZ_ opacity07">
			<span> @<?php echo IcerikTemizle($KullaniciAdi);?></span>
		</div>
		<div class="col-12 mt-4 p-3 font15 <?php if($MetaVeri[1] =="hesapbilgileri"){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<a  href="hesapbilgileri" ><h1 class=" font15 wwqeEzdCZ_"> <i class="fas fa-user ml-3  "></i> <span >Hesap Bilgileri</span></h1></a>
		</div>
		<div class="col-12 p-3   <?php if($MetaVeri[1] =="favorioyunlarim"){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<a href="favorioyunlarim"  ><h1 class=" font15 wwqeEzdCZ_"><i class="fas fa-gamepad ml-3 " ></i> <span >Favori Oyunlarım</span></h1></a>
		</div>
		<div class="col-12 p-3  <?php if($MetaVeri[1] =="favorihaberlerim"){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<a href="favorihaberlerim"  ><h1 class=" font15 wwqeEzdCZ_"><i class="far fa-newspaper ml-3 " ></i> <span >Favori Haberlerim</span></h1></a>
		</div>

		<div class="col-12 p-3   <?php if($MetaVeri[1] =="bilgisayarim"){?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<a href="bilgisayarim" ><h1 class="font15 wwqeEzdCZ_" ><i class="fas fa-laptop ml-3"></i> <span >Bilgisayarım</span></h1></a>
		</div>
		<div class="col-12 p-3   <?php if($MetaVeri[1] =="basliklarim" || $MetaVeri[1] =="yorumlarim"){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<label  for="menu-toggle3" style="cursor: pointer">
				<span class="font15 wwqeEzdCZ_ white" ><i class="fab fa-readme ml-3"></i><span > Sozlük</span> <i class="fas fa-chevron-down white"></i></span> 
			</label>
		</div>
		<input type="checkbox" id="menu-toggle3"    <?php if($MetaVeri[1] =="basliklarim" || $MetaVeri[1] =="yorumlarim"){ ?> checked="checked" <?php }else{ ?>  <?php } ?> >
		<ul id="menu3" >
			<li><div class="col-12 text-center  bold mb-3 mt-3" ><a style="color: white " href="basliklarim"><i class="fas fa-edit"></i><span> Başlıklarım</span></a></div></li>
			<li><div class="col-12 text-center bold mb-3" ><a style="color: white " href="yorumlarim"><i class="fas fa-comments"></i><span> Yorumlarım</span></a></div></li>

		</ul>
					
		<?php
		if($KullaniciEditorDurumu=="0"){
		?>
		<div class="col-12 p-3  <?php if($MetaVeri[1] =="editorbasvuru"){?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  " style="cursor: pointer" >
			<a href="editorbasvuru"  ><h1 class="font15 wwqeECZ_" ><i class="fas fa-user-edit ml-3"></i> <span >Editor Başvuru</span></h1></a>
		</div>
		<?php
		}else if ($KullaniciEditorDurumu=="1"){
		?>
		<div class="col-12 p-3    <?php if($MetaVeri[1] =="haberekle" || $MetaVeri[1] =="haberlerim" || $MetaVeri[1] =="habericerik" || $MetaVeri[1] =="haberlerimdetay" || $MetaVeri[1] =="icerikdetay"){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<label  for="menu-toggle2" style="cursor: pointer" >
				<span class="font15 wwqeEzdCZ_ white" ><i class="far fa-newspaper ml-3"></i> <span >Haber</span> <i class="fas fa-chevron-down white"></i></span> 
			</label>
		</div>
		<input type="checkbox" id="menu-toggle2"  <?php if($MetaVeri[1] =="haberekle" || $MetaVeri[1] =="haberlerim" || $MetaVeri[1] =="habericerik" || $MetaVeri[1] =="haberlerimdetay" || $MetaVeri[1] =="icerikdetay"){ ?> checked="checked"  <?php }else{ ?>  <?php } ?>>
		<ul id="menu2" >
			<li><div class="col-12 text-center  bold mb-3 mt-3" ><a style="color: white " href="haberekle"><i   class="fas fa-plus "></i> <span>Haber Ekle</span></a></div></li>
			<li><div class="col-12 text-center bold mb-3" ><a style="color: white " href="haberlerim"><i class="fas fa-file-signature ml-3"></i> <span>Haberlerim</span></a></div></li>
			
		</ul>
		<?php
		}
		?>
		
	<?php
		if($KullaniciKuratorDurumu=="0"){
		?>
		<div class="col-12 p-3  <?php if($MetaVeri[1] =="kuratorbasvuru"){?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  " style="cursor: pointer" >
			<a href="kuratorbasvuru" ><h1 class="font15 wwqeEzdCZ_" ><i class="fas fa-user-edit ml-3"></i> <span >Kürator Başvuru</span></h1></a>
		</div>
		<?php
		}else if ($KullaniciKuratorDurumu=="1"){
		?>
		<div class="col-12 p-3   <?php if($MetaVeri[1] =="oyuninceleme" || $MetaVeri[1] =="oyunincelemelerim" || $MetaVeri[1] =="incelemelerimdetay" ){ ?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  " >
			<label  for="menu-toggle" style="cursor: pointer" >
				<span class="font15 wwqeEzdCZ_" ><i class="fas fa-user-edit ml-3"></i> <span>Oyun İncelemesi</span> <i class="fas fa-chevron-down white"></i></span> 
			</label>
		</div>
		<input type="checkbox" id="menu-toggle"  <?php if($MetaVeri[1] =="oyuninceleme" || $MetaVeri[1] =="oyunincelemelerim" || $MetaVeri[1] =="incelemelerimdetay" ){ ?> checked="checked" <?php }else{ ?>  <?php } ?>  >
		<ul id="menu" >
			<li><div class="col-12 text-center  bold mb-3 mt-3 white" ><a  style="color: black " href="oyuninceleme"><i class="fas fa-plus ml-3 white"></i> <span class="white">İnceleme Yap</span></a></div></li>
			<li><div class="col-12  text-center bold mb-3 white" ><a style="color: black " href="oyunincelemelerim"><i class="fas fa-file-signature ml-3 white"></i> <span class="white">İncelemelerim</span></a></div></li>
		</ul>
		<?php
		}
		?>
		
		<div class="col-12 p-3  <?php if($MetaVeri[1] =="destek"){?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  " >
			<a href="destek"  ><h1 class=" font15 wwqeEzdCZ_"><i class="far fa-life-ring ml-3"></i> <span >Destek</span></h1></a>
		</div>
		<div class="col-12 p-3   <?php if($MetaVeri[1] =="guvenlikbilgileri"){?> aWzQMzy <?php }else{ ?> ZXyvAzZD <?php } ?>  ">
			<a href="guvenlikbilgileri"  ><h1 class=" font15 wwqeEzdCZ_"><i class="fas fa-lock ml-3 "></i> <span >Güvenlik</span></h1></a>
		</div>
		<div class="col-12 p-3  ZXyvAzZD  ">
			<a href="cikisyap"><h1 class=" font15 wwqeEzdCZ_"><i class="fas fa-sign-out-alt ml-3 "></i> <span >Güvenli Çıkış</span></h1></a>
		</div>
	</div>
	
<?php
}else{
include '../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
}else{
include '../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
?>






