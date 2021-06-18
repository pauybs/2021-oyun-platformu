<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"] ) and isset($_SESSION["Jeton"] ) ){
	if (Guvenlik($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)) {			

		if(isset($_POST["ih"]) and strlen($_POST["ih"])<=11 ){
			$ID = SayfaNumarasiTemizle(Guvenlik($_POST["ih"]));
		}else{
			$ID="";
		}

		if(isset($_POST["j"]) and strlen($_POST["j"])==30){
			$Jeton = Guvenlik($_POST["j"]);
		}else{
			$Jeton="";
		}

		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton  ) {
			if($ID!=""){
				$Haber = $DatabaseBaglanti->prepare("SELECT *  FROM haberresimler WHERE id=?  AND Editor=? AND Durum=? ");
				$Haber->execute([$ID,Guvenlik($KullaniciId),1]);
				$HaberVeri = $Haber->rowCount();
				$HaberVeriKayitlar = $Haber->fetch(PDO::FETCH_ASSOC);
				if ($HaberVeri>0) {
					if (IcerikTemizle($HaberVeriKayitlar["Resim"]) and file_exists("../images/news/contents/".$HaberVeriKayitlar["Resim"]) and ($HaberVeriKayitlar["Resim"]!="")) {
						$ResimKlasorYolu= "news/contents";
						$SilinecekAnaResimYolu= "../images/".$ResimKlasorYolu."/".$HaberVeriKayitlar["Resim"];
						unlink($SilinecekAnaResimYolu);	
					}
					$HaberResimSil = $DatabaseBaglanti->prepare("DELETE  FROM haberresimler WHERE id=?  AND Editor=? ");
					$HaberResimSil->execute([$ID,Guvenlik($KullaniciId)]);
					$Veri = $HaberResimSil->rowCount();
					if($Veri >0){
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