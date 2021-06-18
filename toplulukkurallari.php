<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<div class="col-12 p-0 mt-2" style="background:#e7e6e3; ">
	<div class="wrapper">
  		<div class="news-item standard-item2 " ></div>
  		<div class="position-absolute  col-12 text-center "style="margin-top: 120px; "><span class="HakkimizdaYazi "  >Topluluk Kuralları</span></div>
	</div>


	<div class="col-12 mt-5 mb-5">
		<div class="row justify-content-center hakkimizda mt-5">
			<div class="col-12 col-xl-10  HakkimizdaAciklama mt-5">
				<?php echo IcerikTemizle($ToplulukKurallari);?>
			</div>
		</div>
	</div>
</div>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}
?>