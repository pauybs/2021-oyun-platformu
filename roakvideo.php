<?php
require_once("settings/connect.php");

$SayfalarSolVeSagButonSayisi = 1;
$GosterilecekKayitSayisi = 12;
$ToplamKayitSorgu = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo Where Durum=? ORDER BY id DESC   ");
$ToplamKayitSorgu->execute([1]);
$ToplamKayitSayisi = $ToplamKayitSorgu->rowCount();
$BaslangicKayitSayisi =($Sayfalar*$GosterilecekKayitSayisi)-$GosterilecekKayitSayisi;
$SayfaSayisi = ceil($ToplamKayitSayisi / $GosterilecekKayitSayisi);
?>

<?php
$Banner = $DatabaseBaglanti->prepare("SELECT * FROM banner WHERE  id=? AND Durum=? ORDER BY GosterimSayisi LIMIT 1");
$Banner->execute([8,1]);
$Veri = $Banner->rowCount();
$BannerKayitlar = $Banner->fetch(PDO::FETCH_ASSOC);
if ($Veri>0) {
?>
<div class="col-12  text-center mb-5 mt-5 ">
	<div class="row justify-content-center align-items-center" >
		<div class="col-8 ">
		<?php echo IcerikTemizle($BannerKayitlar["BannerKodu"]); ?> 
		<?php
		$BannerGuncelleme = $DatabaseBaglanti->prepare("UPDATE banner SET GosterimSayisi=GosterimSayisi+1 WHERE id=? LIMIT 1");
		$BannerGuncelleme->execute([8]);	
		?>			
		</div>
	</div>
</div>
<?php
}
?>

<div class="col-12 p-0  " >
	<div class="row  justify-content-center  m-0  mb-5 ">
		<div class="col-12 col-xl-8" >
			<div class="row  justify-content-center " >
			<?php
			$AnaVideo = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo Where Durum=? ORDER BY id Desc LIMIT 1" );
			$AnaVideo->execute([1]);
			$AnaVideoVeri = $AnaVideo->rowCount();
			$AnaVideoKayitlar = $AnaVideo->fetch(PDO::FETCH_ASSOC);
			if ($AnaVideoVeri>0) {
			?>			
				<div class="col-12 col-md-9  p-0 vid-container" >
		          <iframe id="vid_frame" width="100%" src="https://www.youtube.com/embed/<?php echo IcerikTemizle($AnaVideoKayitlar["Url"]) ?>?rel=0&showinfo=0&autohide=1" frameborder="0" width="560" height="450"></iframe>
		      	</div>	
			<?php
			}else{
				header("location:" .$SiteLink);
				exit();
			}
			?>
					
			<div class="col-12 mt-4">
				<div class="row">	
				<?php
				$Videolar = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo Where Durum=? ORDER BY id DESC LIMIT $BaslangicKayitSayisi,$GosterilecekKayitSayisi" );
				$Videolar->execute([1]);
				$VideolarVeri = $Videolar->rowCount();
				$VideolarKayitlar = $Videolar->fetchAll(PDO::FETCH_ASSOC);
				if ($VideolarVeri>0) {
					foreach ($VideolarKayitlar as  $kayitlar) {		
				?>
				<div class="col-6 col-md-3 mb-3" >
					<div class="row justify-content-center align-items-center p-2" >
						<div class="col-12">
							<div class="row justify-content-center align-items-center  " >
								<div class="col-12 p-0">
									 <a href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://youtube.com/embed/<?php echo IcerikTemizle($kayitlar["Url"]) ?>?autoplay=1&rel=0&showinfo=0&autohide=1'"><img src="https://i.ytimg.com/vi/<?php echo IcerikTemizle($kayitlar["Url"]) ?>/sddefault.jpg" class="img-fluid" style="opacity: 0.7"></a>
								</div>
								
								<div class="col-12 col-md-2 text-center position-absolute" >
									 <a href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://youtube.com/embed/<?php echo IcerikTemizle($kayitlar["Url"]) ?>?autoplay=1&rel=0&showinfo=0&autohide=1'">
										<span><i class="fas fa-play white fa-2x vid"></i></span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-12 p-2"  style="">
							 <a href="javascript:void();" onClick="document.getElementById('vid_frame').src='https://youtube.com/embed/<?php echo IcerikTemizle($kayitlar["Url"]) ?>?autoplay=1&rel=0&showinfo=0&autohide=1'"><h6 style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis" class="bold white"><?php echo  IcerikTemizle($kayitlar["VideoAdi"]); ?></h6></a>	
						</div>
					</div>
				</div>
				<?php
				}
				}else{
					header("location:" .$SiteLink);
					exit();
				}
				?>
				</div>
			</div>
		</div>	
				 

			<?php
			if($SayfaSayisi>1){
			?>
				<div class="col-12 text-center mt-3   p-0"  >
				<?php
				if($Sayfalar>1 ){
					echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='roak-video/1'> <i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
	 				$SayfaGeri = $Sayfalar-1;
						echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='roak-video/".$SayfaGeri."'><i class='fas fa-caret-left'></i></a></span>";
				}
				for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
					if( ($i>0)  and ($i<=$SayfaSayisi)  ){
						if($Sayfalar==$i){
							echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

						}else{
							echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='roak-video/". $i . "'>".$i."</a></span>";
						}
					}
				}
				if($Sayfalar!=$SayfaSayisi){
					
					$SayfaIleri = $Sayfalar+1;
					echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'   href='roak-video/".$SayfaIleri."'><i class='fas fa-caret-right  '></i>  </a></span>";	
					echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28'  href='roak-video/". $SayfaSayisi . "'><i class='fas fa-caret-right  '></i><i class='fas fa-caret-right'></i> </a></span>";
				}
				?>
				</div>
			<?php
			}
			?>
		</div>
	</div>			
</div>
<script type="text/javascript">
	$(".a").css("display", "none");
	$(".a").fadeIn(1500);
</script>