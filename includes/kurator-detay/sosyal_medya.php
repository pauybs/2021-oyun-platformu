<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	if ((IcerikTemizle($KuratorBilgilerKayitlar["Youtube"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Twitch"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Instagram"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Twitter"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Facebook"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Discord"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Dlive"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"])!="") or ( IcerikTemizle($KuratorBilgilerKayitlar["WebSite"])!="") ) {
	?>
	
		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Youtube"])!=""){
		?>
			<span class="ml-3 mb-2">
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Youtube"]) ?>">
					<i  class="fab fa-youtube white font25"></i>
				</a>
			</span>
		<?php
		}
		?>
		
		<?php
		if( IcerikTemizle($KuratorBilgilerKayitlar["Twitch"])!=""){
		?>
			<span class="ml-3 mb-2">
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitch"]) ?>">
					<i class="fab fa-twitch white font25"></i>
				</a>
			</span>
		<?php
		}
		?>

		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Instagram"])!=""){
		?>
			<span class="ml-3 mb-2">
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Instagram"]) ?>">
					<i class="fab fa-instagram white font25"></i>
				</a>
			</span>
			<?php
		}
		?>
		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Twitter"])!=""){
		?>
			<span class="ml-3  mb-2">
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Twitter"]) ?>">
					<i class="fab fa-twitter white font25 "></i>
				</a>
			</span>	
		<?php
		}
		?>

		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Facebook"])!=""){
			?>
			<span class="ml-3   mb-2 vcjcbsd" >
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Facebook"]) ?>"><img src="images/facebookgaming.png" class="img-fluid czxzcvHAS"  ></a>
			</span>
			<?php
		}
		?>

		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Discord"])!=""){
			?>
			<span class="ml-3  mb-2" >
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Discord"]) ?>"><i  class="fab fa-discord white font23"></i></a>
			</span>
			<?php
		}
		?>


		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Dlive"])!=""){
			?>
			<span class="ml-3  mb-2 xczpteer"  >
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Dlive"]) ?>"><img src="images/dlive.png" class="img-fluid ZXCajsasd"  ></a>
			</span>
			<?php
		}
		?>

		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"])!=""){
			?>
			<span class="ml-3  mb-2 xczpteer"  >
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["Nonolive"]) ?>"><img src="images/nonolive.png" class="img-fluid xvcbxcvmb"  ></a>
			</span>
			<?php
		}
		?>

		<?php
		if(IcerikTemizle($KuratorBilgilerKayitlar["WebSite"])!=""){
			?>
			<span class="ml-3  mb-2" >
				<a   ref="nofollow" rel="noreferrer" target="_blank" href="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["WebSite"]) ?>"><i   class="fas fa-globe white font23" ></i></a>
			</span>	
			<?php
		}
		?>
		
	<?php
	}
	?>
<?php
}else{
	require_once("../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





