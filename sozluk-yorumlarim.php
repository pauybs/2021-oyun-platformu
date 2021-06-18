<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 9;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyorumlar WHERE UyeId=? and Durum=? ORDER BY id DESC   ");
$ToplamKayitSorgu->execute([Guvenlik($KullaniciId),1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center  ">
		<div class="col-12 col-xl-2 oRZNAEazx">
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>
	
		
	<div class="col-12 col-xl-10">
		<div class="row mt-5 mb-5  justify-content-center align-items-center">
			<div class="col-11 p-0 " >
				<h1 class="bold font15 white"><span >Yorumlarım</span></h1>
			</div>

			<div class="col-11 mt-3 golge " style="background:  rgb(0,0,0,0.5);">
				<div class="row  justify-content-center ">
					<div class="col-12 col-md-12 mt-5 mb-5 JkANZMwex" >
						<div class="row p-3">
						<?php
						$YorumlarSorgu = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyorumlar WHERE UyeId=? and Durum=? ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
						$YorumlarSorgu->execute([Guvenlik($KullaniciId),1]);
						$YorumlarData = $YorumlarSorgu->rowCount();
						$YorumlarKayit = $YorumlarSorgu->fetchAll(PDO::FETCH_ASSOC);
						if($YorumlarData>0){
							foreach($YorumlarKayit as $Kayitlar) {		
							$Baslik = $DatabaseBaglanti->prepare("SELECT *  FROM sozlukyazilar WHERE id=? and Durum=?  LIMIT 1 ");
							$Baslik->execute([Guvenlik($Kayitlar["YaziId"]),1]);
							$BaslikKayitlar = $Baslik->fetch(PDO::FETCH_ASSOC);	
						?>
							<div class="col-12 col-xl-4  mb-2" id="y<?php echo $Kayitlar["id"] ?>" >
								<div class="row  p-2 justify-content-center  align-items-center"  >
									<div class="col-12" style="background: #202020;">
										<div class="row">
											<div class="col-12  mb-4  mt-2" >
												<div class="row justify-content-center align-items-center ">
													<div class="col-7 text-left">
														<a style=" color: white;" href="sozlukbaslik/<?php echo  SEO(IcerikTemizle($BaslikKayitlar["Baslik"]));?>/<?php echo IcerikTemizle($BaslikKayitlar["id"]); ?>">
															<span class="font13 bold" style="color: #c28f2c">Başlık Görüntüle</span>
														</a>
													</div>
													<div class="col-5 text-right">
														<i style="cursor: pointer;" class="fas fa-times-circle favorio bold white s" data-id="<?php echo IcerikTemizle($_SESSION["Jeton"]); ?>" data="<?php echo IcerikTemizle($Kayitlar["id"]); ?>"></i>
													</div>
												</div>
											</div>
											<div class="col-12 ">
												<div class="row ">
													<div class="col-12 ">
														<textarea class="bycvxc"><?php echo IcerikTemizle($Kayitlar["Yorum"]); ?></textarea >
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php
						}
						?>

						<?php
						if($SayfaSayisi>1){
						?>
						<div class="col-12 text-center mt-3   p-0"  >
						<?php
						if($Sayfalar>1 ){
							echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='yorumlarim/1'> <i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
			 				$SayfaGeri = $Sayfalar-1;
								echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='yorumlarim/".$SayfaGeri."'> <i class='fas fa-caret-left'></i></a></span>";
						}
						for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
							if( ($i>0)  and ($i<=$SayfaSayisi)  ){
								if($Sayfalar==$i){
									echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

								}else{
									echo "<span class='p-2 xnxzrA font11'><a style='color:white' class='p-2 aktif bold xzhwE' href='yorumlarim/". $i . "'>".$i."</a></span>";
								}
							}
						}
						if($Sayfalar!=$SayfaSayisi){
							
							$SayfaIleri = $Sayfalar+1;
							echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='yorumlarim/".$SayfaIleri."'><i class='fas fa-caret-right  '></i> </a></span>";	
							echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='yorumlarim/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
						}
						?>
						</div>
						<?php
						}
						}else{
						?>						
							<div class="col-12  mb-3 mt-3 font15 bold white" ><p>Herhangi bir yorumunuz bulunamadı.</p></div>					
						<?php
						}
						?>	
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
	<script src="assets/main_p=1.2.7.js"></script>


<?php
}else{
	header('Location: '. $SiteLink);
	exit();
}
?>

