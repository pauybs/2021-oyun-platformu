<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$Gundem = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE Durum=?  ORDER BY GunlukGoruntulenme DESC, id DESC LIMIT 5" );
	$Gundem->execute([1]);
	$GundemVeri = $Gundem->rowCount();
	$GundemKayitlar = $Gundem->fetchAll(PDO::FETCH_ASSOC);
	if ($GundemVeri>0) {
	?>
		<?php
		foreach ($GundemKayitlar as $gundembilgiler) {
		$KategoriAdi = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE id=? and Durum=? LIMIT 1" );
		$KategoriAdi->execute([Guvenlik($gundembilgiler["KategoriId"]),1]);
		$KategoriAdiVeri = $KategoriAdi->rowCount();
		$KategoriAdiKayitlar = $KategoriAdi->fetch(PDO::FETCH_ASSOC);
		$UyeBilgi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=? LIMIT 1" );
		$UyeBilgi->execute([Guvenlik($gundembilgiler["UyeId"])]);
		$UyeBilgiKayitlar = $UyeBilgi->fetch(PDO::FETCH_ASSOC);
		?>	
		<div class="col-12 mt-3 " style="background: #202020">
			<div class="row justify-content-center align-items-center  mt-3 mb-3">
				<div class="col-12 xbzsWyT ">
					<a href="sozlukbaslik/<?php echo SEO(IcerikTemizle($gundembilgiler["Baslik"])) ?>/<?php echo IcerikTemizle($gundembilgiler["id"]) ?>">
						<span class="bold xbzsWyT font14"><?php echo IcerikTemizle($gundembilgiler["Baslik"]); ?></span>
					</a>
				</div>
				<div class="col-12 text-left">
					<span class="bxzj"><?php echo IcerikTemizle($UyeBilgiKayitlar["KullaniciAdi"]); ?></span>
				</div>
			</div>
		</div>
		<?php
		}
		?>
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





