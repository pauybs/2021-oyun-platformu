<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(IcerikTemizle($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
		if(isset($_POST["his"]) and strlen($_POST["his"])<=11 ){
			$ID = SayfaNumarasiTemizle(Guvenlik($_POST["his"]));
		}else{
			$ID="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30 ){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}

		if($ID!="" and $Jeton!="" and Guvenlik($_SESSION["Jeton"])==$Jeton){
			$Resim = $DatabaseBaglanti->prepare("SELECT *  FROM haberresimler WHERE id=?  AND Editor=? and Durum=? LIMIT 1 ");
			$Resim->execute([$ID,Guvenlik($KullaniciId),1]);
			$ResimVeri = $Resim->rowCount();
			if ($ResimVeri>0) {
				$ResimSil = $DatabaseBaglanti->prepare("UPDATE haberresimler  SET Durum=?  WHERE id=? and Editor=? LIMIT 1 ");
				$ResimSil->execute([2,$ID,Guvenlik($KullaniciId)]);
				$Data = $ResimSil->rowCount();
				if($Data >0){
					$Data = [
					'statu' => true, 
					];
					echo json_encode($Data);
					exit();
				}else{
					$Data = [
					'statu' => false, 
					];
					echo json_encode($Data);
					exit();
				}
			}else{
				$Data = [
				'statu' => false, 
				];
				echo json_encode($Data);
				exit();
			}
		}else{
			header("location:".$SiteLink);
			exit();
		}
	}else{
		header("location:".$SiteLink);
		exit();
	}			
}else{
	header("location:" .$SiteLink);
	exit();	
}
?>