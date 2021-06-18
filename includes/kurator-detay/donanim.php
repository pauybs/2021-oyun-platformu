<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$Donanim = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar WHERE UyeId=? LIMIT 1");
	$Donanim->execute([Guvenlik($KuratorBilgilerKayitlar["id"])]);
	$DonanimVeri = $Donanim->rowCount();
	$DonanimKayitlar = $Donanim->fetch(PDO::FETCH_ASSOC);
	if ($DonanimVeri>0) {
	?>
		<?php
		if ($DonanimKayitlar["IsletimSistemiId"]!="") {
		?>
			<?php
			$IsletimSistemi = $DatabaseBaglanti->prepare("SELECT * FROM isletimsistemleri WHERE id=? LIMIT 1");
			$IsletimSistemi->execute([Guvenlik($DonanimKayitlar["IsletimSistemiId"])]);
			$IsletimSistemiVeri = $IsletimSistemi->rowCount();
			$IsletimSistemiKayitlar = $IsletimSistemi->fetch(PDO::FETCH_ASSOC);
			if ($IsletimSistemiVeri>0) {
			?>
				<div class="col-12 mt-2 incelemeb">
					<span class=" white bold">İşletim Sistemi:</span>
					<span class=" white opacity07">
						<?php echo IcerikTemizle($IsletimSistemiKayitlar["IsletimSistemiAdi"]); ?>
					</span>
				</div>
			<?php
			}
			?>
		<?php
		}
		?>

		<?php
		if ($DonanimKayitlar["IslemciId"]!="") {
		?>
			<?php
			$Islemci = $DatabaseBaglanti->prepare("SELECT * FROM islemciler WHERE id=? LIMIT 1");
			$Islemci->execute([Guvenlik($DonanimKayitlar["IslemciId"])]);
			$IslemciVeri = $Islemci->rowCount();
			$IslemciKayitlar = $Islemci->fetch(PDO::FETCH_ASSOC);
			if ($IslemciVeri>0) {
			?>
				<div class="col-12 mt-2 incelemeb">
					<span class="white bold">İşlemci:</span>
					<span class="white opacity07">
						<?php echo IcerikTemizle($IslemciKayitlar["IslemciAdi"]); ?>
					</span>
				</div>
			<?php
			}
			?>
		<?php
		}
		?>

		<?php
		if ($DonanimKayitlar["EkranKartiId"]!="") {
		?>
			<?php
			$EkranKarti = $DatabaseBaglanti->prepare("SELECT * FROM ekrankartlari WHERE id=? LIMIT 1");
			$EkranKarti->execute([Guvenlik($DonanimKayitlar["EkranKartiId"])]);
			$EkranKartiVeri = $EkranKarti->rowCount();
			$EkranKartiKayitlar = $EkranKarti->fetch(PDO::FETCH_ASSOC);
			if ($EkranKartiVeri>0) {
				?>
				<div class="col-12 mt-2 incelemeb">
					<span class=" white bold">Ekran Kartı:</span>
					<span class=" white opacity07">
						<?php echo IcerikTemizle($EkranKartiKayitlar["EkranKartiAdi"]); ?>	
					</span>
				</div>
			<?php
			}
			?>
		<?php
		}
		?>


		<?php
		if ($DonanimKayitlar["RamId"]!="") {
		?>
			<?php
			$Ram=$DatabaseBaglanti->prepare("SELECT * FROM ram WHERE id=? LIMIT 1");
			$Ram->execute([Guvenlik($DonanimKayitlar["RamId"])]);
			$RamVeri = $Ram->rowCount();
			$RamKayitlar = $Ram->fetch(PDO::FETCH_ASSOC);
			if ($RamVeri>0) {
			?>
				<div class="col-12 mt-2 incelemeb">
					<span class=" white bold">Bellek:</span>
					<span class=" white opacity07">
						<?php echo IcerikTemizle($RamKayitlar["RamTuru"]); ?>
					</span>
				</div>
			<?php
			}
			?>
		<?php
		}
		?>

		<?php
		if ($DonanimKayitlar["DirectxId"]!="") {
		?>
			<?php
			$directx = $DatabaseBaglanti->prepare("SELECT * FROM directx WHERE id=? LIMIT 1");
			$directx->execute([Guvenlik($DonanimKayitlar["DirectxId"])]);
			$directxVeri = $directx->rowCount();
			$directxKayitlar = $directx->fetch(PDO::FETCH_ASSOC);
			if ($directxVeri>0) {
			?>
				<div class="col-12 mt-2 incelemeb">
					<span class=" white bold">DirectX:</span>
					<span class=" white opacity07">
						<?php echo IcerikTemizle($directxKayitlar["DirectxAdi"]); ?>
					</span>
				</div>
			<?php
			}
			?>
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





