<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)   ){
$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 8;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE UyeId=? and Durum=?  ORDER BY id DESC ");
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
					<h1 class="bold font15 white"><span >Başlıklarım</span></h1>
				</div>
				<div class="col-11 mt-3 golge " style="background:  rgb(0,0,0,0.5);">
					<div class="row  justify-content-center ">
						<div class="col-12  mt-5 mb-5 JkANZMwex" >
							<div class="row justify-content-center p-2 mt-5">
								<div class="col-12 col-xl-11 tlanxsA">
									<div class="row">
										<div class="col-12 p-2"><h6 class="bold white font14 m-0">Başlık</h6></div>
									</div>
								</div>
							<?php
							$BasliklarSorgu = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE UyeId=? and Durum=? ORDER BY id DESC  LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi");
							$BasliklarSorgu->execute([Guvenlik($KullaniciId),1]);
							$BasliklarData = $BasliklarSorgu->rowCount();
							$BasliklarKayit = $BasliklarSorgu->fetchAll(PDO::FETCH_ASSOC);
							if($BasliklarData>0){
								foreach($BasliklarKayit as $Kayitlar) {		
							
							?>
							
										<div class="col-12 col-xl-11 p-2 chTLPAs" >
											<a href="sozlukbaslik/<?php echo SEO(IcerikTemizle($Kayitlar["Baslik"])) ?>/<?php echo IcerikTemizle($Kayitlar["id"]) ?>">
											<h6 class="bold white m-0 bslbXcva" ><?php echo IcerikTemizle($Kayitlar["Baslik"]); ?></h6>
											</a>
										</div>
								
								<?php
								
								}
								?>

								<?php
								if($SayfaSayisi>1){
								?>
								<div class="col-12 text-center mt-3   p-4"  >
								<?php
								if($Sayfalar>1 ){
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28' href='basliklarim/1'> <i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i> </a></span>";	
					 				$SayfaGeri = $Sayfalar-1;
										echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28' href='basliklarim/".$SayfaGeri."'> <i class='fas fa-caret-left'></i>  </a></span>";
								}
								for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
									if( ($i>0)  and ($i<=$SayfaSayisi)  ){
										if($Sayfalar==$i){
											echo "<span class='aktif p-2 bold zcjh' style='color:#c28f2c' >".$i."</span>";

										}else{
											echo "<span class='p-2 xnxzrA'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='basliklarim/". $i . "'> ". $i ." </a></span>";
										}
									}
								}
								if($Sayfalar!=$SayfaSayisi){
									
									$SayfaIleri = $Sayfalar+1;
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28'   href='basliklarim/".$SayfaIleri."'> <i class='fas fa-caret-right  '></i>  </a></span>";	
									echo "<span class='p-2 xnxzrA' ><a class='bold' style='color:#f59f28'  href='basliklarim/". $SayfaSayisi . "'> <i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
								}
								?>
								</div>
								<?php
								}
							}else{
							?>						
								<div class="col-12 col-xl-11  pt-5 pb-5 text-center font14 bold white"  style="background: #101010">
									<p> Herhangi bir başlık bulunamadı.</p>
								</div>					
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

<?php
}else{
	header('Location: '. $SiteLink);
	exit();
}
?>

