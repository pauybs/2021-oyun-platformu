<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
require_once("../Frameworks/Verot/src/class.upload.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"])){
	if ($KullaniciKuratorDurumu==1 and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["tkn"]) and strlen($_POST["tkn"])==30 ){
			$Jeton = Guvenlik($_POST["tkn"]);
		}else{	
			$Jeton="";
		}
		if (($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton) {
			if(isset($_POST["Biyo"])){
				$Biyo = Guvenlik($_POST["Biyo"]);
			}else{	
				$Biyo="";
			}

			if($_POST["Instagram"]!=""){
				$url  = $_POST["Instagram"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.instagram.com" || $sonuc[0]=="https://instagram.com") {
				 		$Instagram = Guvenlik($_POST["Instagram"]);
				 	}else{
				 		$Data = [
				    	'statu' => "insta", 
						];
						echo json_encode($Data);
						exit();
				 	}
				}else{
					$Data = [
			    	'statu' => "insta", 
					];
					echo json_encode($Data);
					exit();
				}
				
			}else{	
				$Instagram="";
			}
			
			if($_POST["Youtube"]!=""){
				$url  = $_POST["Youtube"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.youtube.com" || $sonuc[0]=="https://youtube.com") {
				 		 $Youtube=Guvenlik($_POST["Youtube"]);
				 	}else{
				 		$Data = [
				    	'statu' => "youtube", 
						];
						echo json_encode($Data);
						exit();
				 	}
				}else{
					$Data = [
			    	'statu' => "youtube", 
					];
					echo json_encode($Data);
					exit();
				}
			}else{	
				$Youtube="";
			}

			if($_POST["Twitch"]!=""){
				$url  = $_POST["Twitch"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.twitch.tv" || $sonuc[0]=="https://twitch.tv") {
				 		 $Twitch=Guvenlik($_POST["Twitch"]);
				 	}else{
				 		$Data = [
				    	'statu' => "twitch", 
						];
						echo json_encode($Data);
						exit();
				 	}
				}else{
					$Data = [
				    	'statu' => "twitch", 
						];
						echo json_encode($Data);
						exit();
				}
			}else{	
				$Twitch="";
			}

			if($_POST["Twitter"]!=""){
				$url  = $_POST["Twitter"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.twitter.com" || $sonuc[0]=="https://twitter.com") {
				 		 $Twitter=Guvenlik($_POST["Twitter"]);
				 	}else{
				 		$Data = [
				    	'statu' => "twitter", 
						];
						echo json_encode($Data);
						exit(); 
				 	}
				}else{
					$Data = [
				    	'statu' => "twitter", 
						];
						echo json_encode($Data);
						exit(); 
				}
			}else{	
				$Twitter="";
			}

			
			if($_POST["FacebookG"]!=""){
				$url  = $_POST["FacebookG"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.facebook.com" || $sonuc[0]=="https://facebook.com") {
				 		 $FacebookG=Guvenlik($_POST["FacebookG"]);
				 	}else{
				 		$Data = [
				    	'statu' => "facebook", 
						];
						echo json_encode($Data);
						exit();  
				 	}
				}else{
					$Data = [
				    	'statu' => "facebook", 
						];
						echo json_encode($Data);
						exit(); 
				}
			}else{	
				$FacebookG="";
			}

			if($_POST["Discord"]!=""){
				$url  = $_POST["Discord"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.discord.gg" || $sonuc[0]=="https://discord.gg") {
				 		 $Discord=Guvenlik($_POST["Discord"]);
				 	}else{
				 		$Data = [
				    	'statu' => "discord", 
						];
						echo json_encode($Data);
						exit(); 
				 	}
				}else{
					$Data = [
				    	'statu' => "discord", 
						];
						echo json_encode($Data);
						exit(); 
				}
			}else{	
				$Discord="";
			}

			if($_POST["Dlive"]!=""){
				$url  = $_POST["Dlive"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.dlive.tv" || $sonuc[0]=="https://dlive.tv") {
				 		 $Dlive=Guvenlik($_POST["Dlive"]);
				 	}else{
				 		$Data = [
				    	'statu' => "dlive", 
						];
						echo json_encode($Data);
						exit(); 
				 	}
				}else{
					$Data = [
				    	'statu' => "dlive", 
						];
						echo json_encode($Data);
						exit(); 
				}
			}else{	
				$Dlive="";
			}

			if($_POST["Nonolive"]!=""){
				$url  = $_POST["Nonolive"];
				$kontrol  = "/(http(s)?:\/\/.)?(www\.)?[a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]{2,256}\.[a-z]{2,6}\b([a-zA-Z0-9\.\:\+\-\_\#\=\%\~\@]*)/";
				preg_match($kontrol, $url,$sonuc);
				if (!empty($sonuc)) {
					 if ($sonuc[0]=="https://www.nonolive.com" || $sonuc[0]=="https://nonolive.com") {
				 		 $Nonolive=Guvenlik($_POST["Nonolive"]);
				 	}else{
				 		$Data = [
				    	'statu' => "nonolive", 
						];
						echo json_encode($Data);
						exit(); 
				 	}
				}else{
					$Data = [
				    	'statu' => "nonolive", 
						];
						echo json_encode($Data);
						exit(); 
				}
			}else{	
				$Nonolive="";
			}

			if($_POST["WebSite"]!=""){
				$WebSite = Guvenlik($_POST["WebSite"]);
			}else{	
				$WebSite="";
			}
			if(isset($_POST["Wall"]) and strlen($_POST["Wall"])<=11 ){
				$Arkaplan = SayfaNumarasiTemizle(Guvenlik($_POST["Wall"]));
				if ($Arkaplan==0) {
					$Arkaplan="";
				}else{
					$Kontrol= $DatabaseBaglanti->prepare("SELECT * FROM  wallpapers WHERE id=?  LIMIT 1 ");
					$Kontrol->execute([$Arkaplan]);
					$KontrolVeri = $Kontrol->rowCount();
					if ($KontrolVeri>0) {
						$Arkaplan = SayfaNumarasiTemizle(Guvenlik($_POST["Wall"]));
					}else{
						$Arkaplan="";
					}
					
				}
			}else{	
				$Arkaplan="";
			}
					
			$KuratorGuncelle = $DatabaseBaglanti->prepare("UPDATE uyeler SET Facebook=?,Twitter=?,Twitch=?,Instagram=?,Youtube=?,Dlive=?,Nonolive=?,Discord=?,WebSite=?,Hakkinda=?,ArkaplanRengi=? WHERE id=? LIMIT 1");
			$KuratorGuncelle->execute([$FacebookG,$Twitter,$Twitch,$Instagram,$Youtube,$Dlive,$Nonolive,$Discord,$WebSite,$Biyo,$Arkaplan,Guvenlik($KullaniciId)]);
			$Data = [
	    	'statu' => "success", 
			];
			echo json_encode($Data);
			exit();
			
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

