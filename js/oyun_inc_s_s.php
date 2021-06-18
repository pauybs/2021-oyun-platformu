<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if ($KullaniciKuratorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {

		if(isset($_POST["ois"]) and strlen($_POST["ois"])<=11){
			$ID = SayfaNumarasiTemizle(Guvenlik($_POST["ois"]));
		}else{
			$ID="";
		}
		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if($ID!=""){
				$Inceleme = $DatabaseBaglanti->prepare("SELECT *  FROM incelemeler WHERE Incelemeid= ?  AND KuratorId=? and Durum!=? and Durum!=? LIMIT 1 ");
				$Inceleme->execute([$ID,Guvenlik($KullaniciId),3,0]);
				$IncelemeVeri = $Inceleme->rowCount();
				if ($IncelemeVeri>0) {
					$IncelemeSil = $DatabaseBaglanti->prepare("UPDATE incelemeler  SET Durum=?  WHERE Incelemeid=? and KuratorId=? LIMIT 1 ");
					$IncelemeSil->execute([3,$ID,Guvenlik($KullaniciId)]);
					$Data = $IncelemeSil->rowCount();
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