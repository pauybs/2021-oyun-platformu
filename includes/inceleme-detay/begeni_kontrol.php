<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-end align-items-center">
		<div class="col-12 text-center text-xl-right ib<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>">
		<?php
		if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
		?>
			<?php	
			$BegeniKontrol = $DatabaseBaglanti->prepare("SELECT * FROM  incelemebegeni WHERE IncelemeId=? and UyeId=? LIMIT 1 " );
			$BegeniKontrol->execute([$IncelemeId,Guvenlik($KullaniciId)]);
			$BegeniKontrolVeri = $BegeniKontrol->rowCount();
			$BegeniKontrolKayitlar = $BegeniKontrol->fetch(PDO::FETCH_ASSOC);
			if ($BegeniKontrolVeri>0) {
			?>
				<?php
				if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
				?>
					<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span>
				<?php
				}else{
				?>
					<span class="white bold font12 opacity07">
						(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)
					</span>
					 <i style="cursor: pointer; color:#c28f2c;" class="font20 fas fa-thumbs-up white mr-2 ibb "  data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>"></i> 
				<?php
				}
				?>
			<?php
			}else{
			?>	
				<?php
				if ($IncelemeSorgusuKayitlar["KuratorId"] == $KullaniciId) {
				?>
					<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span>
				<?php
				}else{
				?>
					<span class="white bold font12 opacity07">(<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Begeni"]) ?>)</span> <i style="cursor: pointer;"  class="font20 far fa-thumbs-up  white mr-2 ibb" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["Incelemeid"]) ?>" ></i> 
				<?php
				}
				?>
				<?php
			}
			?>
		<?php
		}else{
		?>
			<a href="girisyap">
				<span class="white bold font12 opacity07">(<?php echo IcerikTemizle(number_format_short($IncelemeSorgusuKayitlar["Begeni"])) ?>)</span> 
				<i class="far fa-thumbs-up  white mr-2 font20" ></i> 
			</a>
		<?php
		}
		?>
			<?php
			if (IcerikTemizle($IncelemeSorgusuKayitlar["IncelemeLink"])!="") {
			?>
				| <a  class="ml-2 idetaya" style="color: #0aa5ff" href="<?php echo IcerikTemizle($IncelemeSorgusuKayitlar["IncelemeLink"])  ?>"  ref=”nofollow” target="_blank">Daha fazlasını görmek için...</a>
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





