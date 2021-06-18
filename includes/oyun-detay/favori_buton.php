<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row">
		<div class="col-12">
			<?php
			if (IcerikTemizle($OyunSorgusuKayit["OyunSitesi"])) {
			?>
				<a class="white"   ref="nofollow" rel="noreferrer" target="_blank" style="color: #c28f2c" href="<?php echo IcerikTemizle($OyunSorgusuKayit["OyunSitesi"]); ?>">
					<button type="button" class="btn btn-warning bold" style="padding:3px">
					 	<span class="websitesi bold">Web Sitesine Git</span>
					</button>
				</a>
			<?php
			}
			?>
			<?php
			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
			?>
				<?php
				$Favoriler= $DatabaseBaglanti->prepare("SELECT * FROM oyunfavoriler WHERE OyunId=? AND UyeId=? LIMIT 1");
				$Favoriler->execute([Guvenlik($OyunSorgusuKayit["id"]),Guvenlik($KullaniciId)]);
				$FavorilerSayisi = $Favoriler->rowCount();
				if ($FavorilerSayisi>0) {
				?>
					<span class="ofes<?php echo IcerikTemizle($OyunSorgusuKayit["id"]); ?>">
						<button type="button" class="btn btn-warning ofe ofvr" id="<?php echo $OyunId ?>"  data-id="<?php echo Iceriktemizle($_SESSION["Jeton"]) ?>" style="padding:3px" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>" title="Favorilerden Çıkar">
							<i class="fas fa-heart bold white" ></i>
						</button>
					</span>
					<?php
				}else{
				?>
					<span class="ofes<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>">
						<button title="Favorilere Ekle" type="button" style="padding:3px" class="btn btn-warning favoriEkle  ofe ofvr" id="<?php echo $OyunId ?>" data-id="<?php echo Iceriktemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($OyunSorgusuKayit["id"]) ?>">
							<i class="far fa-heart bold"></i>
						</button>
					</span>
				<?php
				}
				?>
			<?php
			}else{
			?>
				<a class="favoriEkle" href="girisyap">
					<button type="button" style="padding:3px" class="btn btn-warning" title="Favorilere Ekle">
						<i class="far fa-heart bold"></i>
					</button>
				</a>
			<?php
			}
			?>	
		</div>
	</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





