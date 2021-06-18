<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row">
		<div class="col-12">
			<a style="color: white" href="oyundetay/<?php echo  SEO(IcerikTemizle($OyunBilgilerKayit["OyunAdi"]));?>/<?php echo IcerikTemizle($OyunBilgilerKayit["OyunUniqid"]); ?>">
				<i class="fas fa-gamepad white "></i>
				 <span class="bold white font14"><?php echo IcerikTemizle($OyunAdi);?></span>
			</a>
		</div>
		<?php
		$EditorPuan= $DatabaseBaglanti->prepare("SELECT * FROM oyunpuan WHERE OyunId=? AND UyeId=? LIMIT 1 ");
		$EditorPuan->execute([Guvenlik($IncelemeSorgusuKayitlar["OyunId"]),Guvenlik($IncelemeSorgusuKayitlar["KuratorId"])]);
		$EditorPuanSayisi = $EditorPuan->rowCount();
		$EditorPuanKayitlar = $EditorPuan->fetch(PDO::FETCH_ASSOC);
		if ($EditorPuanSayisi>0){
		?>
		<div class="col-12">
			<span class="bold white font14">Kurator Puanı: </span>
			<span class="bold font14" style="color:#c28f2c">
				<?php echo IcerikTemizle(OyunOrtPuan($EditorPuanKayitlar["Puan"]));?>
			</span>
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





