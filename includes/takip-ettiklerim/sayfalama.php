<?php

if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
	if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
?>
	<?php
	if($SayfaSayisi>1){
	?>
	<div class="col-12 text-center mt-3   p-0"  >
	<?php
	if($Sayfalar>1 ){
		echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='takipettiklerim/". $SayfalamaSecimi ."/1'><i class='fas fa-caret-left'></i><i class='fas fa-caret-left'></i></a></span>";	
			$SayfaGeri = $Sayfalar-1;
			echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='takipettiklerim/". $SayfalamaSecimi ."/".$SayfaGeri."'> <i class='fas fa-caret-left'></i></a></span>";
	}
	for ($i=$Sayfalar-$SayfalarSolVeSagButonSayisi; $i <=$Sayfalar+$SayfalarSolVeSagButonSayisi; $i++) { 
		if( ($i>0)  and ($i<=$SayfaSayisi)  ){
			if($Sayfalar==$i){
				echo "<span class='aktif p-2 bold zcjh font11' style='color:#c28f2c' >".$i."</span>";

			}else{
				echo "<span class='p-2 xnxzrA font11'><a style='text-decoration:none;color:white' class='p-2 aktif bold xzhwE' href='takipettiklerim/". $SayfalamaSecimi ."/".$i."'>".$i."</a></span>";
			}
		}
	}
	if($Sayfalar!=$SayfaSayisi){
		
		$SayfaIleri = $Sayfalar+1;
		echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='takipettiklerim/". $SayfalamaSecimi ."/".$SayfaIleri."'><i class='fas fa-caret-right'></i></a></span>";	
		echo "<span class='p-2 xnxzrA font11' ><a class='bold' style='color:#f59f28' href='takipettiklerim/". $SayfalamaSecimi ."/". $SayfaSayisi . "'><i class='fas fa-caret-right'></i><i class='fas fa-caret-right'></i></a></span>";
	}
	?>
	</div>
	<?php
	}
	?>
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





