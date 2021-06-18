<?php
session_start();
require_once("../settings/functions.php");
require_once("../settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) ){
	if (IcerikTemizle($KullaniciEditorDurumu)==1  and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) ) {
		if(isset($_POST["h"])  and strlen($_POST["h"])<=11 ){
			$HaberId = SayfaNumarasiTemizle(Guvenlik($_POST["h"]));
		}else{	
			$HaberId="";
		}
		if(isset($_POST["Yayinla"])){
			$Durum= 1;
		}else{	
			$Durum= 2;
		}

		if(isset($_POST["ui"])  and strlen($_POST["ui"])==22 ){
			$Uniqid = Guvenlik($_POST["ui"]);
		}else{	
			$Uniqid="";
		}

		if(isset($_POST["Tkn"])  and strlen($_POST["Tkn"])==30 ){
			$Jeton = Guvenlik($_POST["Tkn"]);
		}else{	
			$Jeton="";
		}

		if ( ($Jeton!="") and Guvenlik($_SESSION["Jeton"])==$Jeton  ) {
			if(($HaberId!="") and ($Durum!="") and ($Uniqid!="") ){

				if ($KullaniciEditorBan==1 and $KullaniciEditorBanTarih!="") {
					if ($Zaman>=$KullaniciEditorBanTarih) {
						$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET EditorBan=?, EditorBanTarih=?  WHERE  id=? and Editor=? LIMIT 1 ");
						$BanKaldir->execute([0,NULL,$KullaniciId,1]);
						$BanKaldirSayisi = $BanKaldir->rowCount();
						if ($BanKaldirSayisi>0) {
							$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? and Editor=? and Durum=?");
							$HaberKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
							$HaberKontrolVeri = $HaberKontrol->rowCount();
							$HaberKontrolKayitlar = $HaberKontrol->fetch(PDO::FETCH_ASSOC);
							if ($HaberKontrolKayitlar>0) {
								if ($Durum==1) {
									$HaberYayinda = $DatabaseBaglanti->prepare("SELECT * FROM haberler  WHERE  id=? and HaberUniqid=?   AND Editor=? and Durum=?");
									$HaberYayinda->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
									$HaberYayindaSayisi = $HaberYayinda->rowCount();
									if($HaberYayindaSayisi>0){
										$HaberYayinla = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?  ");
										$HaberYayinla->execute([1,$HaberId]);
										$HaberYayinlaVeri = $HaberYayinla->rowCount();
										if ($HaberYayinlaVeri>0) {
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
								}else if($Durum==2){
									$HaberYayinda = $DatabaseBaglanti->prepare("SELECT * FROM haberler  WHERE  id=?  and HaberUniqid=?  AND Editor=? and Durum=?");
									$HaberYayinda->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
									$HaberYayindaSayisi = $HaberYayinda->rowCount();
									if($HaberYayindaSayisi>0){
										$HaberYayinla = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?  ");
										$HaberYayinla->execute([3,$HaberId]);
										$HaberYayinlaVeri = $HaberYayinla->rowCount();
										if ($HaberYayinlaVeri>0) {
											$Data = [
									       	'statu' => true,
									    	];
									    	echo json_encode($Data); 
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
		           		 'statu' => "block",
		           		 'date' => TarihCevir2(IcerikTemizle($KullaniciEditorBanTarih)),
		        		];
		 				echo json_encode($Data);
						exit();			
					}
				}else{
					$HaberKontrol = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE id=? and HaberUniqid=? and Editor=? and Durum=?");
					$HaberKontrol->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
					$HaberKontrolVeri = $HaberKontrol->rowCount();
					$HaberKontrolKayitlar = $HaberKontrol->fetch(PDO::FETCH_ASSOC);
					if ($HaberKontrolKayitlar>0) {
						if ($Durum==1) {
							$HaberYayinda = $DatabaseBaglanti->prepare("SELECT * FROM haberler  WHERE  id=? and HaberUniqid=?  AND Editor=? and Durum=?");
							$HaberYayinda->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
							$HaberYayindaSayisi = $HaberYayinda->rowCount();
							if($HaberYayindaSayisi>0){
								$HaberYayinla = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?  ");
								$HaberYayinla->execute([1,$HaberId]);
								$HaberYayinlaVeri = $HaberYayinla->rowCount();
								if ($HaberYayinlaVeri>0) {
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
						}else if($Durum==2){
							$HaberYayinda = $DatabaseBaglanti->prepare("SELECT * FROM haberler  WHERE  id=? and HaberUniqid=? AND Editor=? and Durum=?");
							$HaberYayinda->execute([$HaberId,$Uniqid,Guvenlik($KullaniciId),2]);
							$HaberYayindaSayisi = $HaberYayinda->rowCount();
							if($HaberYayindaSayisi>0){
								$HaberYayinla = $DatabaseBaglanti->prepare("UPDATE haberler SET Durum=? WHERE id=?  ");
								$HaberYayinla->execute([3,$HaberId]);
								$HaberYayinlaVeri = $HaberYayinla->rowCount();
								if ($HaberYayinlaVeri>0) {
									$Data = [
							       	'statu' => true,
							    	];
							    	echo json_encode($Data); 
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
						$Data = [
				       	'statu' => false,
				    	];
				    	echo json_encode($Data); 
						exit();	
					}
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