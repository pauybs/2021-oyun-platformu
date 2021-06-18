<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<div class="col-12 p-0 mt-2" style="background:#e7e6e3; ">
	<div class="wrapper">
  		<div class="news-item hero-item " ></div>
  		<div class="position-absolute  col-12 text-center "style="margin-top: 150px; "><span class="HakkimizdaYazi "  >Hakkımızda</span></div>
	</div>

	<?php
	if ($Hakkimizda and isset($Hakkimizda)) {
	?>
	<div class="col-12 mt-5 mb-5">
		<div class="row justify-content-center hakkimizda mt-5">
			<div class="col-12 col-xl-6 text-center HakkimizdaAciklama mt-5">
				<p class="mt-5"><?php echo IcerikTemizle($Hakkimizda); ?></p>
			</div>
		</div>
	</div>
	<?php
	}
	?>
	

	<?php
	if ($HakkimizdaBir and isset($HakkimizdaBir)) {
	?>
	<div class="col-12 mt-5 mb-5">
		<div class="row justify-content-center  align-items-center hakkimizda mt-5">
			<div class="col-12 col-xl-5  mt-5">
				<div class="row text-center  ">
					<div class="col-12  mt-2">
						<h1 class="HakkimizdaBaslik">Güncel Haberler</h1>
					</div>
					<div class="col-12 HakkimizdaAltBaslik  text-center">
						<span>Oyun dünyasından en son haberlere anında ulaşın. </span>
					</div>

					<div class="col-12   text-center mt-3">
						<a href="haber"><button class="call-to-action">
  							<div>
    							<div>Haberler</div>
 							 </div>
						</button></a>
					</div>
				</div>
			</div>
			<div class="col-12 col-xl-5 zoomEffect_1  ">
				<img src="images/<?php echo IcerikTemizle($HakkimizdaBir); ?>" class="img-fluid mt-5" >
			</div>
		</div>
	</div>
	<?php
	}
	?>

	<?php
	if ($HakkimizdaIki and isset($HakkimizdaIki)) {
	?>
	<div class="col-12 mt-5 mb-5 d-none d-xl-block">
		<div class="row justify-content-center  align-items-center hakkimizda mt-5">
			<div class="col-12 col-xl-5 zoomEffect_1  ">
				<img src="images/<?php echo IcerikTemizle($HakkimizdaIki); ?>" class="img-fluid mt-5" >
			</div>

			<div class="col-12 col-xl-5  mt-5">
				<div class="row text-center  ">
					<div class="col-12  mt-2">
						<h1 class="HakkimizdaBaslik">Oyun Bilgileri</h1>
					</div>
					<div class="col-12 HakkimizdaAltBaslik  text-center">
						<span>Yeni oyunlar keşfedin, oyunlar hakkındaki bilgilere ulaşın. </span>
					</div>

					<div class="col-12   text-center mt-3">
						<a href="tumoyunlar"><button class="call-to-action">
  							<div>
    							<div>Oyunlar</div>
 							 </div>
						</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>

	<?php
	if ($HakkimizdaIki and isset($HakkimizdaIki)) {
	?>
	<div class="col-12 mt-5 mb-5 d-block d-xl-none">
		<div class="row justify-content-center  align-items-center hakkimizda mt-5">
			<div class="col-12 col-xl-5  mt-5">
				<div class="row text-center  ">
					<div class="col-12  mt-2">
						<h1 class="HakkimizdaBaslik">Oyunlar Bilgileri</h1>
					</div>
					<div class="col-12 HakkimizdaAltBaslik  text-center">
						<span>Yeni oyunlar keşfedin, oyunlar hakkındaki bilgilere ulaşın. </span>
					</div>

					<div class="col-12   text-center mt-3">
						<a href="tumoyunlar">
							<button class="call-to-action">
  								<div>
    								<div>Oyunlar</div>
 							 	</div>
							</button>
						</a>
					</div>
				</div>
			</div>
			<div class="col-12 col-xl-5 zoomEffect_1  ">
				<img src="images/<?php echo IcerikTemizle($HakkimizdaIki); ?>" class="img-fluid mt-5" >
			</div>
		</div>
	</div>
	<?php
	}
	?>


	<div class="col-12 mt-5 mb-5 ">
		<div class="row justify-content-center text-center align-items-center hakkimizda mt-5">
			<div class="col-12 col-xl-5 mt-5">
				<div class="row">
					<div class="col-12  "><h3 class="bold HakkimizdaBaslik"> Ve çok daha fazlası için...</h3></div>
					<div class="col-12"> <span>Haberler okuyun, yeni oyunlar keşfedin ve daha fazlasını yapın.</span></div>
				</div>
			</div>

			<div class="col-12 col-xl-5 mt-5">
				<a href="<?php echo IcerikTemizle($SiteLink) ?>">
					<button class="call-to-action">
  						<div>
    						<div>Göz At <img src="images/<?php echo IcerikTemizle($SiteLogo);?>" class="img-fluid" style="height: 35px; width: 35px"></div>
 						</div>
					</button>
				</a>
			</div>
		</div>
	</div>
</div>
<?php
}else{
    header("location:".$SiteLink);
    exit();
}
?>