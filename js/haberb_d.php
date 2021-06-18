<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if (isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])  )  {
	if(IcerikTemizle($KullaniciEditorDurumu)==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ){
		if(isset($_POST["HaberBaslik"])){
			$Baslik = Guvenlik($_POST["HaberBaslik"]);
			if (strlen($Baslik)<100) {
				$Baslik = Guvenlik($_POST["HaberBaslik"]);
			}else{
				$Data = [
	            'statu' => "long",
	        	];
	 			echo json_encode($Data);
				exit();
			}
		}else{
			$Baslik="";
		}
		if(isset($_POST["h"])  and strlen($_POST["h"])<=11 ){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{
			$HaberId="";
		}
		if(isset($_POST["Aciklama"])){
			$KapakResmiAciklama = Guvenlik($_POST["Aciklama"]);
		}else{
			$KapakResmiAciklama="";
		}
		if(isset($_POST["Etiketler"])){
			$Etiketler = Guvenlik($_POST["Etiketler"]);
		}else{
			$Etiketler="";
		}
		if(isset($_POST["KaynakUrl"])){
			$KaynakUrl = Guvenlik($_POST["KaynakUrl"]);
		}else{
			$KaynakUrl="";
		}
		if( isset($_POST["Oyun"])  and strlen($_POST["Oyun"])==20 ){
			$OyunId = Guvenlik($_POST["Oyun"]);
			$OyunKontrol = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? and OyunUniqid=?");
			$OyunKontrol->execute([1,$OyunId]);
			$OyunKontrolSayisi = $OyunKontrol->rowCount();
			if ($OyunKontrolSayisi>0) {
				$OyunId = Guvenlik($_POST["Oyun"]);
			}else{
				$OyunId=NULL;
			}
		}else{
			$OyunId=NULL;
		}
		if( isset($_POST["Haber"])  and strlen($_POST["Haber"])==22 ){
			$IlgiliHaberId = Guvenlik($_POST["Haber"]);
			$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? and HaberUniqid=? ");
			$HaberKontrol->execute([1,$IlgiliHaberId]);
			$HaberKontrolSayisi = $HaberKontrol->rowCount();
			if ($HaberKontrolSayisi>0) {
				$IlgiliHaberId = Guvenlik($_POST["Haber"]);
			}else{
				$IlgiliHaberId=NULL;
			}
		}else{
			$IlgiliHaberId=NULL;
		}

		if(isset($_POST["Tkn"])  and strlen($_POST["Tkn"])==30){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{
			$Jeton="";
		}

		if(isset($_POST["ui"])  and strlen($_POST["ui"])==22){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{
			$Uniqid="";
		}

		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton and ($Uniqid!="") and ($HaberId!="")) {
			$HaberKontrol=$DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? and Durum!=? and Durum!=? and Durum!=? and Editor=? LIMIT 1 ");
			$HaberKontrol->execute([$HaberId,$Uniqid,0,4,2,Guvenlik($KullaniciId)]);
			$HaberKontrolSayisi = $HaberKontrol->rowCount();
			$HaberKontrolKayitlar = $HaberKontrol->fetch(PDO::FETCH_ASSOC);
			

			if ($HaberKontrolKayitlar>0) {
				if( ($Baslik!="")  and ($KapakResmiAciklama!="")  and  ($Etiketler!="") ){
				    
			$KayitliResim =$HaberKontrolKayitlar["AnaResim"];
            $ResimAdidizi = explode ("-",$KayitliResim);
            $idveri = count($ResimAdidizi);
            $ResimId=$ResimAdidizi[$idveri-1];
            $Uniqid = explode (".",$ResimId);
            										
            //$EklenecekYeniAnaResim= SEO($_POST["HaberBaslik"])."-".$ResimId;
            
            $HaberBaslik = str_replace(array(',','.'),'',$Baslik);
            $EklenecekYeniAnaResim=  SEO($HaberBaslik)."-".$ResimId;



        



$yol="../images/news/";
					$HaberGuncelle=$DatabaseBaglanti->prepare("UPDATE haberler SET AnaResim=?,AnaBaslik=?,AnaAciklama=?,KaynakUrl=?,Etiketler=?,IlgiliHaber=?,IlgiliOyun=? WHERE id=? and Editor=? ");
					$HaberGuncelle->execute([$EklenecekYeniAnaResim,$Baslik,$KapakResmiAciklama,$KaynakUrl,$Etiketler,$IlgiliHaberId,$OyunId,$HaberId,Guvenlik($KullaniciId)]);
					$HaberGuncelleKontrol =$HaberGuncelle->rowCount();
					$sonuc = rename($yol.$KayitliResim , $yol.$EklenecekYeniAnaResim);
                    if ($sonuc){
                        $Data = [
    					'statu' => "success", 
    					];
    					echo json_encode($Data);
    					exit();
                    }else{
                    		$Data = [
					'statu' => "error", 
					];
					echo json_encode($Data);
					exit();
                    }

				
				}else{
					$Data = [
					'statu' => "null", 
					];
					echo json_encode($Data);
					exit();
				}	
			}else{
					$Data = [
					'statu' => "error", 
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

