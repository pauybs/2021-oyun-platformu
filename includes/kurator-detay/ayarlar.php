<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row justify-content-center align-items-center ">
		<div class="col-12">
			<span <?php if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){ ?> class="kt<?php echo  IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>" <?php }else{ ?> <?php } ?>>
				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
				?>
					<?php	
					$TakipKontrol = $DatabaseBaglanti->prepare("SELECT * FROM kuratortakip WHERE KuratorId=? and TakipciId=? LIMIT 1" );
					$TakipKontrol->execute([Guvenlik($KuratorBilgilerKayitlar["id"]),Guvenlik($KullaniciId)]);
					$TakipKontrolVeri = $TakipKontrol->rowCount();
					$TakipKontrolKayitlar = $TakipKontrol->fetch(PDO::FETCH_ASSOC);
					if ($TakipKontrolVeri>0) {
					?>
						<?php
						if ($KuratorBilgilerKayitlar["id"] == $KullaniciId) {
						?>
							<?php
							if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
							?>
								<button style="background: #202020" data-toggle="modal" data-target=".bd-example-modal-xl" type="button" class="btn bold kurator pt-0 pb-0">
									<span class="bold kurator white" ><i class="fas fa-cog font15" ></i> Özelleştir</span>
								</button>
							<?php	
							}
							?>
						<?php
						}else{
						?>
							<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
								<i class="fas fa-user-check white font15" ></i> <span class="white"> Takip Ediliyor</span>
							</button>
						<?php
						}
						?>
					<?php
					}else{
					?>	
						<?php
						if ($KuratorBilgilerKayitlar["id"] == $KullaniciId){
						?>

							<?php
							if ($KullaniciId==$KuratorBilgilerKayitlar["id"]) {
								?>
								<button style="background: #202020" data-toggle="modal" data-target=".bd-example-modal-xl" type="button" class="btn bold kurator pt-0 pb-0">
									<span class="bold kurator white" ><i class="fas fa-cog font15" ></i> Özelleştir</span>
								</button>
							<?php	
							}
							?>
						<?php
						}else{
						?>
							<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 t" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" data="<?php echo IcerikTemizle($KuratorBilgilerKayitlar["id"]) ?>">
								<span class="bold kurator white" > <i class="fas fa-user-plus"></i> Takip Et</span>
							</button>
						<?php
						}
						?>
					<?php
					}
					?>
				<?php
				}else{
				?> 
					<a href="girisyap" >
						<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0">
							<span class="bold kurator white"> <i class="fas fa-user-plus"></i> Takip Et</span>
						</button>
					</a>
				<?php
				}
				?>
			</span> 
			<?php 
			if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
			?>
				<?php
				if ($KuratorBilgilerKayitlar["id"] != $KullaniciId) {
				?>
					<span>
						<button style="background: #202020"  type="button" class="btn bold kurator pt-0 pb-0 ml-3 keb" data-toggle="modal" data-target="#sikayet"><span class="white">Şikayet Et</span></button>
					</span>
				<?php
				}
				?>
			<?php
			}else{
			?> 
				<a href="girisyap">
					<button style="background: #202020" type="button" class="btn bold kurator pt-0 pb-0 ml-3 "><span class="white">Şikayet Et</span></button>
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





