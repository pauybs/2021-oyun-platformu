<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"] ) ){
	if ( $KullaniciEditorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {
		
		if(isset($_POST["hs"]) and strlen($_POST["hs"])<=11 ){
			$ID = SayfaNumarasiTemizle(Guvenlik($_POST["hs"]));
		}else{
			$ID="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}
		if(isset($_POST["ui"]) and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}
		if($ID!="" and $Jeton!="" and $Uniqid!=""){
			if (Guvenlik($_SESSION["Jeton"])== $Jeton) {
				$Haber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? AND  Editor=?  AND Durum!=? and Durum!=? LIMIT 1 ");
				$Haber->execute([$ID,$Uniqid,Guvenlik($KullaniciId),4,0]);
				$Veri = $Haber->rowCount();
				if ($Veri>0){
					$HaberSil = $DatabaseBaglanti->prepare("UPDATE haberler  SET Durum=?  WHERE id=? and Editor=? LIMIT 1 ");
					$HaberSil->execute([4,$ID,Guvenlik($KullaniciId)]);
					$Data = $HaberSil->rowCount();
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