<?php

if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
?>
	<span class="bold white font15" style="cursor: pointer;">Takip Edilen Küratörler</span>
	<div class="modal fade mt-5" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document" >
			<div class="modal-content" style="background: #202020">
				<div class="modal-header" >
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" style="color: white">&times;</span>
					</button>
				</div>
				<div class="modal-body " >
					<div class="col-12 text-left scrollbar" id="style-1">
						<div class="row force-overflow">
						<?php
						$Kuratorler = $DatabaseBaglanti->prepare("SELECT kuratortakip.id, kuratortakip.KuratorId, kuratortakip.TakipciId, uyeler.id, uyeler.SilinmeDurumu, uyeler.Durum, uyeler.Kurator FROM kuratortakip INNER JOIN uyeler ON kuratortakip.KuratorId = uyeler.id  WHERE kuratortakip.TakipciId=? and uyeler.Durum=1 and uyeler.SilinmeDurumu=0 and uyeler.Kurator=1  ORDER BY kuratortakip.id Desc ");
						$Kuratorler->execute([Guvenlik($KullaniciId)]);
						$KuratorlerVeri = $Kuratorler->rowCount();
						$KuratorlerKayitlar = $Kuratorler->fetchAll(PDO::FETCH_ASSOC);
						if ($KuratorlerKayitlar>0) {
							foreach ($KuratorlerKayitlar as $KuratorBilgiler) {
							$KuratorAdi = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Kurator=? and id=? LIMIT 1");
							$KuratorAdi->execute([1,Guvenlik($KuratorBilgiler["KuratorId"])]);
							$KuratorAdiVeri = $KuratorAdi->rowCount();
							$KuratorAdiKayitlar = $KuratorAdi->fetch(PDO::FETCH_ASSOC);
							if ($KuratorAdiVeri>0) {
							?>
							<div class="col-12 p-3 kt<?php echo IcerikTemizle($KuratorBilgiler["KuratorId"]) ?> cxvms">
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
								?>
									<?php	
									$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=?  LIMIT 1" );
									$TakipKontrol->execute([Guvenlik($KuratorBilgiler["KuratorId"]),Guvenlik($KullaniciId)]);
									$TakipKontrolVeri = $TakipKontrol->rowCount();
									$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
									if ($TakipKontrolVeri>0) {
									?>
										<?php
										if ($KuratorBilgiler["KuratorId"] == $KullaniciId) {
										?>

										<?php
										}else{
										?>
											<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
											<?php
											if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
											?>
												<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" title="<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
											<?php
											}else{
											?>
												<img src="images/user.png" class="img-fluid tekpedxjz" >
											<?php
											}
											?>
												<span class="bold white font15">
													<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>
												</span>
											</a>
											<span class="bold white font15"  >•</span>
											<span  class="bold font13 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>"  data="<?php echo IcerikTemizle($KuratorBilgiler["KuratorId"]) ?>" style="color:green;cursor:pointer;">
											 	<i class="fas fa-user-check font20" ></i>
											</span>
										<?php
										}
										?>
									<?php
									}else{
									?>	
										<?php
										if ($KuratorBilgiler["KuratorId"] == $KullaniciId) {
										?>

										<?php
										}else{
										?>
											<a style="color: white" href="kurator/<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
											<?php
											if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
											?>
												<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" title="<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
											<?php
											}else{
											?>
												<img src="images/user.png" class="img-fluid tekpedxjz" >
											<?php
											}
											?>

												<span class="bold white font15">
													<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>
												</span>
											</a>
											<span class="bold white font15">•</span> 
											<span class="bold font13 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo  IcerikTemizle($KuratorBilgiler["KuratorId"]) ?>" style="color: #0aa5ff;cursor:pointer;">
												<i class="fas fa-user-plus font20" ></i>
											</span>
										<?php
										}
										?>
									<?php
									}
									?>
								<?php
								}else{
								?>
									<a style="color:white" href="kurator/<?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
									<?php
									if (file_exists("images/userphoto/".$KuratorAdiKayitlar["ProfilResmi"]) and (isset($KuratorAdiKayitlar["ProfilResmi"])) and ($KuratorAdiKayitlar["ProfilResmi"]!="") ) {
									?>
										<img src="images/userphoto/<?php echo IcerikTemizle($KuratorAdiKayitlar["ProfilResmi"]) ?>" class="img-fluid xcvdsfj" title="<?php echo  IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>">
									<?php
									}else{
									?>
										<img src="images/user.png" class="img-fluid tekpedxjz" >
									<?php
									}
									?>
										<span class="bold white font15"><?php echo IcerikTemizle($KuratorAdiKayitlar["KullaniciAdi"]); ?>  
										</span>
									</a>
									<span class="bold white font15">•</span> 
									<a href="girisyap" >
										<span class="bold font13" style="color: #0aa5ff">
											<i class="fas fa-user-plus font20" ></i>
										</span>
									</a>
								<?php
								}
								?>
							</div>
							<?php
							}
							}
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}else{
include '../../settings/connect.php';
	header("location:" .$SiteLink);
  exit();
}
}else{
include '../../settings/connect.php';

	header("location:" .$SiteLink);
  exit();
}
?>






