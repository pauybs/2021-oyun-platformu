<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<a style="color: white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
	<?php
	if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
	?>
		<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid VBRTERXC"  alt="">
	<?php
	}else{
	?>
		<img src="images/user.png" class="img-fluid HJidxzx" alt="<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]) ?>" >
	<?php
	}
	?>
		<span class="bold white font15"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?></span> 
	</a>
	
	<?php
	if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
	?>
		<?php	
		$TakipKontrol=$DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=? LIMIT 1" );
		$TakipKontrol->execute([Guvenlik($IncelemeSorgusuKayitlar["KuratorId"]),Guvenlik($KullaniciId)]);
		$TakipKontrolVeri = $TakipKontrol->rowCount();
		$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
		if ($TakipKontrolVeri>0) {
		?>
			<?php
			if ($IncelemeSorgusuKayitlar["KuratorId"] != $KullaniciId) {
			?>
				<span class="bold white font15">•</span> 
				<span  class="bold font13 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>"  data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?>" style="color: green;cursor:pointer;">
					<i class="fas fa-user-check font20" ></i>
				</span>
			<?php
			}
			?>
		<?php
		}else{
		?>	
			<?php
			if ($IncelemeSorgusuKayitlar["KuratorId"]!=$KullaniciId) {
			?>
				<span class="bold white font15">•</span> 
				<span  class="bold font13 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["KuratorId"]) ?>" style="color: #0aa5ff;cursor:pointer;">
				<i class="fas fa-user-plus font20" ></i></span>
			<?php
			}
			?>
		<?php
		}
		?>
	<?php
	}else{
	?>
		<span class="bold white font15">•</span> 
		<a href="girisyap" >
			<span class="bold font13" style="color: #0aa5ff">
				<i class="fas fa-user-plus font20" ></i> 
			</span>
		</a>
	<?php
	}
	?>
	
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





