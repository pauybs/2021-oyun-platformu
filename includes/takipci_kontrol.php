<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="col-12 p-1 ip mt-2">
		<figure <?php if(isset($_SESSION["Kullanici"]) and $kayitlar["KuratorId"]!=$KullaniciId ){ ?> class="m-0 kt<?php echo $kayitlar["KuratorId"] ?>" <?php }else{ ?> class="m-0" <?php } ?> >
			<?php
			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
			?>
				<?php	
				$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=?  LIMIT 1" );
				$TakipKontrol->execute([Guvenlik($kayitlar["KuratorId"]),Guvenlik($KullaniciId)]);
				$TakipKontrolVeri = $TakipKontrol->rowCount();
				$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
				if ($TakipKontrolVeri>0) {
				?>
					<?php
					if ($kayitlar["KuratorId"]==$KullaniciId) {
					?>

					<?php
					}else{
					?>
						<figcaption >
							<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
							<?php
							if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
							?>
								<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid zxczxnoth" title="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>">
							<?php
							}else{
							?>
								<img src="images/user.png" class="img-fluid zxcmryrt" >
							<?php
							}
							?>

							<span class="bold white font15">
								<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>	
							</span>
						</a>
						<span class="bold white font15">•</span>
						<span class="bold font13 t" <?php if($KullaniciId!=$kayitlar["KuratorId"]){?> data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo $kayitlar["KuratorId"] ?>" <?php } ?> style="color: green;cursor:pointer;">
							<i class="fas fa-user-check font20" ></i> 
						</span>
						</figcaption>
					<?php
					}
					?>
				<?php
				}else{
				?>	
					<?php
					if ($kayitlar["KuratorId"]==$KullaniciId) {
					?>
					<?php
					}else{
					?>
						<figcaption >
							<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
							<?php
							if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
							?>
								<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid zxczxnoth"title="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>" >
							<?php
							}else{
							?>
								<img src="images/user.png" class="img-fluid zxcmryrt" >
							<?php
							}
							?>

							<span class="bold white font15">
								<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]);?>
							</span>
						</a>
						<span class="bold white font15">•</span> 
						<span class="bold font13 t" <?php if($KullaniciId!=$kayitlar["KuratorId"]){?> data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo $kayitlar["KuratorId"] ?>"   <?php } ?>  style="color: #0aa5ff;cursor:pointer;">
							<i class="fas fa-user-plus font20" ></i>
						</span>
						</figcaption>	
					<?php
					}
					?>
				<?php
				}
				?>
			<?php
			}else{
			?>
				<figcaption >
					<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
					<?php
					if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
					?>
						<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid zxczxnoth" title="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>">
					<?php
					}else{
					?>
						<img src="images/user.png" class="img-fluid zxcmryrt">
					<?php
					}
					?>

					<span class="bold white font15"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?></span>
				</a>
				<span class="bold white font15">•</span> 
				<a href="girisyap" >
					<span class="bold font13" style="color: #0aa5ff">
						<i class="fas fa-user-plus font20"></i>
					</span>
				</a>
				
				</figcaption>
			<?php
			}
			?>											
		</figure>
		<figure class="m-0  ml-2">
		    <?php
				if($kayitlar["Begeni"]!="" and $kayitlar["Begeni"]!=0){
				?>
				    	<span class="bold white font13 ml-1 mt-1"><?php echo IcerikTemizle($kayitlar["Begeni"]); ?> beğenme</span><br>

				<?php
				}
				?>
		</figure>
		<figure class="m-0 ml-2 ">
				<?php
				$BegeniSayisi = $DatabaseBaglanti->prepare("SELECT * FROM incelemeyorumlar WHERE (Durum=? or Durum=?) and IncelemeId=? " );
        		$BegeniSayisi->execute([1,3,Guvenlik($kayitlar["Incelemeid"])]);
        		$BegeniSayisiVeri = $BegeniSayisi->rowCount();
                if($BegeniSayisiVeri>0){
				?>
				    <span class=" white opacity07 font13 ml-1"><?php echo $BegeniSayisiVeri; ?> yorum</span><br>

				<?php
				}
				?>
		</figure>
	</div>
<?php

}else{
include '../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
?>





