<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-center  align-items-center text-right">
	<?php	
	if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
	?>
		<?php
		$Favoriler= $DatabaseBaglanti->prepare("SELECT * FROM haberfavoriler WHERE HaberId=?  AND UyeId=?  LIMIT 1 ");
		$Favoriler->execute([SayfaNumarasiTemizle(Guvenlik($HaberSorgusuKayit["id"])),$KullaniciId]);
		$FavorilerSayisi = $Favoriler->rowCount();
		if ($FavorilerSayisi>0) {
		?>
			<div class="col-12 ">
				<span  class="hfes<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>" >
					<button type="button" class="btn btn-warning hfe favoriEklendi hfvr" id="<?php echo $HaberId ?>"  data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]); ?>" title="Favorilerden Çıkar">
						<i class="fas fa-heart bold white"  ></i>
					</button>
				</span>
			</div>
		<?php
		}else{
		?>
			<div class="col-12 ">
				<span  class="hfes<?php echo IcerikTemizle($HaberSorgusuKayit["id"]) ?>" >
					<button title="Favorilere Ekle"  type="button" class="btn btn-warning favoriEkle  hfe hfvr" id="<?php echo $HaberId ?>"  data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>"  data="<?php echo IcerikTemizle($HaberSorgusuKayit["id"]); ?>" >
						<i class="far fa-heart bold"></i>
					</button>
				</span>
			</div>
		<?php
		}
		?>
	<?php
	}else{
	?>
		<div class="col-12 ">
			<a class="favoriEkle" href="girisyap">
				<button  type="button" class="btn btn-warning">
					<i class="far fa-heart bold"></i>
				</button>
			</a>
		</div>
	<?php
	}
	?>
</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





