<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
    <?php
    $Sayfa=$_SERVER['REQUEST_URI'];
    $MetaVeri = explode ("/",$Sayfa);
    if ($MetaVeri[1]=="index.php") {
    	header("location:" .$SiteLink);
    	exit();
    }
    if ($MetaVeri!="") {
    	if ($MetaVeri[1]=="haberdetay"  and $MetaVeri[2]!="" and $MetaVeri[3]!="") {
    		$HaberEtiket =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum=? LIMIT 1 ");
    		$HaberEtiket->execute([Guvenlik($MetaVeri[3]),1]);
    		$HaberEtiketSayi = $HaberEtiket->rowCount();
    		$HaberEtiketKayit = $HaberEtiket->fetch(PDO::FETCH_ASSOC);
    		if ($HaberEtiketSayi>0) {
    			if ($HaberEtiketKayit["Etiketler"]!="") {
    				$Keyw= IcerikTemizle($HaberEtiketKayit["Etiketler"]);
    			}else{
    				$Keyw= IcerikTemizle($SiteKeywords);
    			}
    
    			if ($HaberEtiketKayit["AnaAciklama"]!="") {
    				$Desc=strip_tags(IcerikTemizle(substr($HaberEtiketKayit["AnaAciklama"],0,306)));
    			}else{
    				$Desc= IcerikTemizle($SiteDescription);
    			}
    
    			if ($HaberEtiketKayit["AnaBaslik"]!="") {
    				$Tit= IcerikTemizle($HaberEtiketKayit["AnaBaslik"]);
    			}else{
    				$Tit= IcerikTemizle($SiteTitle);
    			}
    
    			$FbWebSite='<meta property="og:type" content="website"/>';
    			$FbSiteIsim='<meta property="og:site_name" content="Roakgame">';
    			$FbBaslik='<meta property="og:title" content="'.IcerikTemizle($HaberEtiketKayit["AnaBaslik"]).'"/>'; 
    			$FbAciklama='<meta property="og:description" content="'.strip_tags(IcerikTemizle(substr($HaberEtiketKayit["AnaAciklama"],0,300))).' devamı..."/>' ;
    			$FbSayfaUrl='<meta property="og:url" content="'.$SiteLink."haberdetay/".SEO(IcerikTemizle($HaberEtiketKayit["AnaBaslik"]))."/".IcerikTemizle($HaberEtiketKayit["HaberUniqid"]).'"/>'; 
    			$FbSayfaTr='<meta property="og:locale" content="tr-TR">';
    			$FbHaberResim='<meta property="og:image" content="'.$SiteLink."images/news/".IcerikTemizle($HaberEtiketKayit["AnaResim"]).'">';
    			
    			$TwCard='<meta name="twitter:card" content="summary">';
    			$TwSite='<meta name="twitter:site" content="@roakgame">';
    			$TwTitle='<meta name="twitter:title" content="'.IcerikTemizle($HaberEtiketKayit["AnaBaslik"]).'">';
    			$TwUrl='<meta name="twitter:url" content="'.$SiteLink."haberdetay/".SEO(IcerikTemizle($HaberEtiketKayit["AnaBaslik"]))."/".IcerikTemizle($HaberEtiketKayit["HaberUniqid"]).'">';
    			$TwAciklama='<meta name="twitter:description" content="'.strip_tags(IcerikTemizle(substr($HaberEtiketKayit["AnaAciklama"],0,300))).' devamı...">';
    			$TwResim='<meta name="twitter:image" content="'.$SiteLink.'images/news/'.$HaberEtiketKayit["AnaResim"].'"> ';
    			$Canonical=$SiteLink."haberdetay/".SEO(IcerikTemizle($HaberEtiketKayit["AnaBaslik"]))."/".IcerikTemizle($HaberEtiketKayit["HaberUniqid"]);
    		}else{
    			$Keyw= IcerikTemizle($SiteKeywords);
    			$FbWebSite='';
    			$FbSiteIsim='';
    			$FbBaslik=''; 
    			$FbAciklama='' ;
    			$FbSayfaUrl=''; 
    			$FbSayfaTr='';
    			$FbHaberResim='';
    
    			$TwCard='';
    			$TwSite='';
    			$TwTitle='';
    			$TwUrl='';
    			$TwAciklama='';
    			$TwResim='';
    			$Desc= IcerikTemizle($SiteDescription);
    			$Tit=  IcerikTemizle($SiteTitle);
    			$Canonical=$SiteLink;
    			
    		}
    
    	}else if($MetaVeri[1]=="oyundetay" and $MetaVeri[2]!="" and $MetaVeri[3]!=""){
    		$OyunEtiket =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
    		$OyunEtiket->execute([Guvenlik($MetaVeri[3]),1]);
    		$OyunEtiketSayi = $OyunEtiket->rowCount();
    		$OyunEtiketKayit = $OyunEtiket->fetch(PDO::FETCH_ASSOC);
    		if ($OyunEtiketSayi>0) {
    			if ($OyunEtiketKayit["Etiketler"]!="") {
    				$Keyw= IcerikTemizle($OyunEtiketKayit["Etiketler"]);
    			}else{
    				$Keyw= IcerikTemizle($SiteKeywords);
    			}
    			if ($OyunEtiketKayit["OyunHakkinda"]!="" and $OyunEtiketKayit["OyunAdi"]!="") {
    				$Desc= IcerikTemizle($OyunEtiketKayit["OyunAdi"])." ";
    				$Desc.= strip_tags(IcerikTemizle(substr($OyunEtiketKayit["OyunHakkinda"],0,260)));
    				$Tit= "Roakgame - ".IcerikTemizle($OyunEtiketKayit["OyunAdi"]);
    			$Canonical=$SiteLink."oyundetay/".SEO(IcerikTemizle($OyunEtiketKayit["OyunAdi"]))."/".IcerikTemizle($OyunEtiketKayit["OyunUniqid"]);
    
    			}else{
    				$Desc= IcerikTemizle($SiteDescription);
    				$Tit= IcerikTemizle($SiteTitle);
    			$Canonical=$SiteLink;
    
    
    			}
    
    		
    		}else{
    			$Keyw= IcerikTemizle($SiteKeywords);
    			$Desc=IcerikTemizle($SiteDescription);
    			$Tit= IcerikTemizle($SiteTitle);
    			$Canonical=$SiteLink;
    
    
    		}
    	}else if($MetaVeri[1]=="oyunincelemeler"){
    		$Tit= "Roakgame - İncelemeler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="takipettiklerim"){
    		$Tit= "Roakgame - Takip Ettiklerim";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    					$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="incelemedetay" and $MetaVeri[2]!="" and $MetaVeri[3]!="" and $MetaVeri[4]!=""){
    
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Inceleme =  $DatabaseBaglanti->prepare("SELECT incelemeler.Incelemeid, incelemeler.KuratorId, incelemeler.OyunId, incelemeler.Baslik, incelemeler.IncelemeYazisi, incelemeler.IncelemeLink, incelemeler.Resim1, incelemeler.IpAdres, incelemeler.Durum, incelemeler.Begeni, incelemeler.Goruntulenme, oyunlar.id, oyunlar.Durum, oyunlar.AnaResim as oyunresim, oyunlar.OyunAdi, uyeler.id, uyeler.Durum, uyeler.Kurator, uyeler.KullaniciAdi FROM oyunlar INNER JOIN incelemeler ON oyunlar.id = incelemeler.OyunId INNER JOIN uyeler ON incelemeler.KuratorId = uyeler.id  WHERE incelemeler.Incelemeid=? and incelemeler.Durum=? and uyeler.Kurator=? and oyunlar.Durum=? and uyeler.SilinmeDurumu=? LIMIT 1");
    		$Inceleme->execute([Guvenlik($MetaVeri[4]),1,1,1,0]);
    		$IncelemeSayi = $Inceleme->rowCount();
    		$IncelemeKayit = $Inceleme->fetch(PDO::FETCH_ASSOC);
    		if ($IncelemeSayi>0) {
    			$Tit= "RoakGame: " .IcerikTemizle($IncelemeKayit["Baslik"]);
    		
    			$FbWebSite='<meta property="og:type" content="website"/>';
    			$FbSiteIsim='<meta property="og:site_name" content="Roakgame">';
    			$FbBaslik='<meta property="og:title" content="'.IcerikTemizle($IncelemeKayit["Baslik"]).'"/>'; 
    			$FbAciklama='<meta property="og:description" content="'.strip_tags(IcerikTemizle(substr($IncelemeKayit["Baslik"],0,300))).' devamı..."/>' ;
    			$FbSayfaUrl='<meta property="og:url" content="'.$SiteLink."incelemedetay/".SEO(IcerikTemizle($IncelemeKayit["OyunAdi"]))."/".IcerikTemizle($IncelemeKayit["KullaniciAdi"])."/".IcerikTemizle($IncelemeKayit["Incelemeid"]).'"/>'; 
    			$FbSayfaTr='<meta property="og:locale" content="tr-TR">';
    			$FbHaberResim='<meta property="og:image" content="'.$SiteLink.'images/games/'.$IncelemeKayit["oyunresim"].'">';
    		
    			$TwCard='<meta name="twitter:card" content="summary">';
    			$TwSite='<meta name="twitter:site" content="@roakgame">';
    			$TwTitle='<meta name="twitter:title" content="'.IcerikTemizle($IncelemeKayit["Baslik"]).'">';
    			$TwUrl='<meta name="twitter:url" content="'.$SiteLink."incelemedetay/".SEO(IcerikTemizle($IncelemeKayit["OyunAdi"]))."/".IcerikTemizle($IncelemeKayit["KullaniciAdi"])."/".IcerikTemizle($IncelemeKayit["Incelemeid"]).'">';
    			$TwAciklama='<meta name="twitter:description" content="'.strip_tags(IcerikTemizle(substr($IncelemeKayit["Baslik"],0,300))).' devamı...">';
    			$TwResim='<meta name="twitter:image" content="'.$SiteLink.'images/games/'.$IncelemeKayit["oyunresim"].'"> ';
    						$Canonical=$SiteLink."incelemedetay/".SEO(IcerikTemizle($IncelemeKayit["OyunAdi"]))."/".IcerikTemizle($IncelemeKayit["KullaniciAdi"])."/".IcerikTemizle($IncelemeKayit["Incelemeid"]);
    
    		}else{
    			$Keyw= IcerikTemizle($SiteKeywords);
    			$FbWebSite='';
    			$FbSiteIsim='';
    			$FbBaslik=''; 
    			$FbAciklama='' ;
    			$FbSayfaUrl=''; 
    			$FbSayfaTr='';
    			$FbHaberResim='';
    			$TwCard='';
    			$TwSite='';
    			$TwTitle='';
    			$TwUrl='';
    			$TwAciklama='';
    			$TwResim='';
    			$Tit= IcerikTemizle($SiteTitle);
    			$Canonical=$SiteLink;
    
    			
    		}
    
    	}else if($MetaVeri[1]=="kuratorler"){
    		$Tit= "Roakgame - Küratörler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="tumoyunlar"){
    		$Tit= "Roakgame - Oyun Keşfet";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."tumoyunlar";
    
    
    	}else if($MetaVeri[1]=="populeroyunlar"){
    		$Tit= "Roakgame - Popüler Oyunlar";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."populeroyunlar";
    
    
    	}else if($MetaVeri[1]=="kurator"){
    		$Tit= "Roakgame (".IcerikTemizle($MetaVeri[2]).")";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink;
    
    	}else if($MetaVeri[1]=="haber"){
    		$Tit= "Roakgame - Haberler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."haber";
    
    
    	}else if($MetaVeri[1]=="okunanhaberler"){
    		$Tit= "Roakgame - Okunan Haberler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."okunanhaberler";
    
    	}else if($MetaVeri[1]=="konusulanhaberler"){
    		$Tit= "Roakgame - Konuşulan Haberler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."konusulanhaberler";
    
    
    	}else if($MetaVeri[1]=="habertumyorumlar" and $MetaVeri[2]!="" and $MetaVeri[3]!=""){
    		$HaberBaslik =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum=? LIMIT 1 ");
    		$HaberBaslik->execute([Guvenlik($MetaVeri[3]),1]);
    		$HaberBaslikSayi = $HaberBaslik->rowCount();
    		$HaberBaslikKayit = $HaberBaslik->fetch(PDO::FETCH_ASSOC);
    		if ($HaberBaslikSayi>0) {
    			$Tit= IcerikTemizle($HaberBaslikKayit["AnaBaslik"])." yorumları";
    			$Desc=IcerikTemizle($SiteDescription);
    		    $Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    		}else{
    			$Tit= "Roakgame - Yorumlar";
    			$Desc=IcerikTemizle($SiteDescription);
    	    	$Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    
    		}
    	
    		
    	}else if($MetaVeri[1]=="oyuntumyorumlar" and $MetaVeri[2]!="" and $MetaVeri[3]!=""){
    		$OyunBaslik =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
    		$OyunBaslik->execute([Guvenlik($MetaVeri[3]),1]);
    		$OyunBaslikSayi = $OyunBaslik->rowCount();
    		$OyunBaslikKayit = $OyunBaslik->fetch(PDO::FETCH_ASSOC);
    		if ($OyunBaslikSayi>0) {
    			$Tit= IcerikTemizle($OyunBaslikKayit["OyunAdi"])." yorumları";
    			$Desc=IcerikTemizle($SiteDescription);
    		    $Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    		}else{
    			$Tit= "Roakgame - Yorumlar";
    			$Desc=IcerikTemizle($SiteDescription);
    		    $Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    		}
    	
    		
    
    	}else if($MetaVeri[1]=="oyunkarakterler"  and $MetaVeri[2]!="" and $MetaVeri[3]!="" ){
    		$OyunBaslik =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
    		$OyunBaslik->execute([Guvenlik($MetaVeri[3]),1]);
    		$OyunBaslikSayi = $OyunBaslik->rowCount();
    		$OyunBaslikKayit = $OyunBaslik->fetch(PDO::FETCH_ASSOC);
    		if ($OyunBaslikSayi>0) {
    			$Tit= IcerikTemizle($OyunBaslikKayit["OyunAdi"])." Karakterleri";
    			$Desc=IcerikTemizle($SiteDescription);
    	    	$Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    			
    		}else{
    			$Tit= "Roakgame - Karakterler";
    			$Desc=IcerikTemizle($SiteDescription);
    		    $Keyw= IcerikTemizle($SiteKeywords);
    			$Canonical=$SiteLink;
    
    		}
    	
    		
    
    	}else if($MetaVeri[1]=="karakterdetay" and $MetaVeri[2]!="" and $MetaVeri[3]!=""  and $MetaVeri[4]!="" ){
    		$OyunBaslik =  $DatabaseBaglanti->prepare("SELECT * FROM  oyunlar WHERE  OyunUniqid=? AND Durum=? LIMIT 1 ");
    		$OyunBaslik->execute([Guvenlik($MetaVeri[4]),1]);
    		$OyunBaslikSayi = $OyunBaslik->rowCount();
    		$OyunBaslikKayit = $OyunBaslik->fetch(PDO::FETCH_ASSOC);
    		if ($OyunBaslikSayi>0) {
    			$Tit= IcerikTemizle($OyunBaslikKayit["OyunAdi"])." - ".IcerikTemizle($MetaVeri[3]);
    				$Desc=IcerikTemizle($SiteDescription);
    	    	$Keyw= IcerikTemizle($SiteKeywords);
    					$Canonical=$SiteLink;
    
    
    		}else{
    			$Tit= "Roakgame - Karakter";
    			$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    					$Canonical=$SiteLink;
    
    
    		}
    	
    	
    	}else if($MetaVeri[1]=="bizkimiz"){
    		$Tit= "Roakgame - Hakkımızda";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    							$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="gizlilikpolitikasi"){
    		$Tit= "Roakgame - Gizlilik Politikası";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    							$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="uyeliksozlesme"){
    		$Tit= "Roakgame - Üyelik Sözleşmesi";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    							$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="topluluk-kurallari"){
    		$Tit= "Roakgame - Topluluk Kuralları";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    							$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="bizeulasin"){
    		$Tit= "Roakgame - İletişim";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    							$Canonical=$SiteLink;
    
    
    	}else if($MetaVeri[1]=="sistemineozel"){
    		$Tit= "Roakgame - Bilgisayar Sistemine Özel Oyun Bul";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."sistemineozel";
    
    
    	}else if($MetaVeri[1]=="indirimler"){
    		$Tit= "Roakgame - İndirimler";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteKeywords);
    		$Canonical=$SiteLink."sistemineozel";
    
    
    	}else if( $MetaVeri[1]=="sozlukbaslik"   || $MetaVeri[1]=="sozlukbaslikara" ) {
    
    		if ($MetaVeri[1]=="sozlukbaslik" and $MetaVeri[2]!="" and $MetaVeri[3]!="") {
    			$BaslikAdi =  $DatabaseBaglanti->prepare("SELECT uyeler.id, sozlukyazilar.id, sozlukyazilar.UyeId, sozlukyazilar.KategoriId, sozlukyazilar.Baslik, sozlukyazilar.Goruntulenme, sozlukyazilar.Tarih, sozlukyazilar.IpAdresi, sozlukyazilar.Durum, uyeler.SilinmeDurumu FROM sozlukyazilar INNER JOIN uyeler ON sozlukyazilar.UyeId = uyeler.id WHERE uyeler.SilinmeDurumu=? and sozlukyazilar.id=? and sozlukyazilar.Durum=? LIMIT 1");
    			$BaslikAdi->execute([0,$MetaVeri[3],1]);
    			$BaslikAdiVeri = $BaslikAdi->rowCount();
    			$BaslikAdiKayitlar = $BaslikAdi->fetch(PDO::FETCH_ASSOC);
    		}else if ($MetaVeri[1]=="sozlukbaslikara" and $MetaVeri[2]!="" and $MetaVeri[3]!="" and $MetaVeri[4]!=""){
    			$BaslikAdi =  $DatabaseBaglanti->prepare("SELECT uyeler.id, sozlukyazilar.id, sozlukyazilar.UyeId, sozlukyazilar.KategoriId, sozlukyazilar.Baslik, sozlukyazilar.Goruntulenme, sozlukyazilar.Tarih, sozlukyazilar.IpAdresi, sozlukyazilar.Durum, uyeler.SilinmeDurumu FROM sozlukyazilar INNER JOIN uyeler ON sozlukyazilar.UyeId = uyeler.id WHERE uyeler.SilinmeDurumu=? and sozlukyazilar.id=? and sozlukyazilar.Durum=? LIMIT 1");
    			$BaslikAdi->execute([0,$MetaVeri[4],1]);
    			$BaslikAdiVeri = $BaslikAdi->rowCount();
    			$BaslikAdiKayitlar = $BaslikAdi->fetch(PDO::FETCH_ASSOC);
    		}else{
    			$BaslikAdiKayitlar=0;
    		}
    
    		if ($BaslikAdiKayitlar>0) {
    			if ($BaslikAdiKayitlar["Baslik"]!="") {
    			    	$Keyw= IcerikTemizle($SiteSozlukKeywords);
    				$Desc=strip_tags(IcerikTemizle(substr($BaslikAdiKayitlar["Baslik"],0,306)));
    				$Tit= IcerikTemizle($BaslikAdiKayitlar["Baslik"]);
    				
    				$FbWebSite='<meta property="og:type" content="website">';
        			$FbSiteIsim='<meta property="og:site_name" content="Roakgame - Sozluk">';
        			$FbBaslik='<meta property="og:title" content="'.IcerikTemizle($BaslikAdiKayitlar["Baslik"]).'"/>'; 
        			$FbAciklama='<meta property="og:description" content="'.strip_tags(IcerikTemizle(substr($BaslikAdiKayitlar["Baslik"],0,300))).' devamı..."/>' ;
        			$FbSayfaUrl='<meta property="og:url" content="'.$SiteLink."sozlukbaslik/".SEO(IcerikTemizle($BaslikAdiKayitlar["Baslik"]))."/".$BaslikAdiKayitlar["id"].'"/>'; 
        			$FbSayfaTr='<meta property="og:locale" content="tr-TR">';
        			$FbHaberResim='<meta property="og:image" content="'.$SiteLink.'images/sozlukicon.jpg">';
        		
        			$TwCard='<meta name="twitter:card" content="summary">';
        			$TwSite='<meta name="twitter:site" content="@roakgame">';
        			$TwTitle='<meta name="twitter:title" content="'.IcerikTemizle($BaslikAdiKayitlar["Baslik"]).'"/>'; 
        			$TwUrl='<meta name="twitter:url" content="'.$SiteLink."sozlukbaslik/".SEO(IcerikTemizle($BaslikAdiKayitlar["Baslik"]))."/".$BaslikAdiKayitlar["id"].'">';
        			$TwAciklama='<meta name="twitter:description"  content="'.strip_tags(IcerikTemizle(substr($BaslikAdiKayitlar["Baslik"],0,300))).' devamı..."/>' ;
        			$TwResim='<meta name="twitter:image" content="'.$SiteLink.'images/sozlukicon.jpg"> ';
        								$Canonical=$SiteLink."sozlukbaslik/".SEO(IcerikTemizle($BaslikAdiKayitlar["Baslik"]))."/".$BaslikAdiKayitlar["id"];
    
    
    			}else{
    			    $Keyw= IcerikTemizle($SiteSozlukKeywords);
    				$Desc= IcerikTemizle($SiteDescription);
    				$Tit=  IcerikTemizle($SiteTitle);
    				
    				$FbWebSite='';
        			$FbSiteIsim='';
        			$FbBaslik=''; 
        			$FbAciklama='' ;
        			$FbSayfaUrl=''; 
        			$FbSayfaTr='';
        			$FbHaberResim='';
        		
        			$TwCard='';
        			$TwSite='';
        			$TwTitle=''; 
        			$TwUrl='';
        			$TwAciklama='' ;
        			$TwResim='';
        		$Canonical=$SiteLink;
    
    
    			}
    
    			
    		
    		}else{
    		    
    			$Keyw= IcerikTemizle($SiteSozlukKeywords);
    			$Desc= IcerikTemizle($SiteDescription);
    			$Tit=  IcerikTemizle($SiteTitle);
    			
    			$FbWebSite='';
    			$FbSiteIsim='';
    			$FbBaslik=''; 
    			$FbAciklama='' ;
    			$FbSayfaUrl=''; 
    			$FbSayfaTr='';
    			$FbHaberResim='';
    		
    			$TwCard='';
    			$TwSite='';
    			$TwTitle=''; 
    			$TwUrl='';
    			$TwAciklama='' ;
    			$TwResim='';
    			$Canonical=$SiteLink;
    
    
    
    		}
    
    	}else if($MetaVeri[1]=="sozluk" || $MetaVeri[1]=="sozlukara"  ){
    		$Tit= "Roakgame - Sozluk";
    		$Desc=IcerikTemizle($SiteDescription);
    		$Keyw= IcerikTemizle($SiteSozlukKeywords);
    							$Canonical=$SiteLink."sozluk";
    
    
    	}else{
    		if ($MetaVeri[1]=="sozlukkategori" || $MetaVeri[1]=="sozlukkategoriara") {
    
    			if ($MetaVeri[1]=="sozlukkategori"  and $MetaVeri[2]!="" and $MetaVeri[3]!="" ) {
    				$Bolum =  $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE Durum=? and id=? LIMIT 1");
    				$Bolum->execute([1,$MetaVeri[3]]);
    				$BolumVeri = $Bolum->rowCount();
    				$BolumKayitlar = $Bolum->fetch(PDO::FETCH_ASSOC);
    				if ($BolumVeri>0) {
    					$Tit=  "Sozluk - ".IcerikTemizle($BolumKayitlar["KategoriAdi"]);
    					$Desc=IcerikTemizle($SiteDescription);
    					$Keyw= IcerikTemizle($SiteSozlukKeywords).",".IcerikTemizle($BolumKayitlar["KategoriAdi"]);
    										$Canonical=$SiteLink;
    
    				}else{
    					$Desc=IcerikTemizle($SiteDescription);
    					$Keyw= IcerikTemizle($SiteKeywords);
    					$Tit=  IcerikTemizle($SiteTitle);
    										$Canonical=$SiteLink;
    
    				}
    			}else if($MetaVeri[1]=="sozlukkategoriara"  and $MetaVeri[2]!="" and $MetaVeri[3]!=""  and $MetaVeri[4]!="" and $MetaVeri[5]!=""){
    				$Bolum =  $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE Durum=? and id=? LIMIT 1");
    				$Bolum->execute([1,$MetaVeri[5]]);
    				$BolumVeri = $Bolum->rowCount();
    				$BolumKayitlar = $Bolum->fetch(PDO::FETCH_ASSOC);
    				if ($BolumVeri>0) {
    					$Tit=  "Sozluk - ".IcerikTemizle($BolumKayitlar["KategoriAdi"]);
    					$Desc=IcerikTemizle($SiteDescription);
    					$Keyw= IcerikTemizle($SiteSozlukKeywords).",".IcerikTemizle($BolumKayitlar["KategoriAdi"]);
    										$Canonical=$SiteLink;
    
    				}else{
    					$Desc=IcerikTemizle($SiteDescription);
    					$Keyw= IcerikTemizle($SiteKeywords);
    					$Tit=  IcerikTemizle($SiteTitle);
    										$Canonical=$SiteLink;
    
    				}
    			}else{
    				$Desc=IcerikTemizle($SiteDescription);
    					$Keyw= IcerikTemizle($SiteKeywords);
    					$Tit=  IcerikTemizle($SiteTitle);
    										$Canonical=$SiteLink;
    
    			}
    			
    
    		}else{
    			$Desc=IcerikTemizle($SiteDescription);
    			$Keyw= IcerikTemizle($SiteKeywords);
    			$Tit=  IcerikTemizle($SiteTitle);
    								$Canonical=$SiteLink;
    
    		}
    
    		
    	}
    }else{
    	$Desc=IcerikTemizle($SiteDescription);
    	$Keyw= IcerikTemizle($SiteKeywords);
    	$Tit=  IcerikTemizle($SiteTitle);
    					$Canonical=$SiteLink;
    }
    
    if ($MetaVeri!="") {
    	if (  $MetaVeri[1]=="bizeulasin" ||  $MetaVeri[1]=="topluluk-kurallari" || $MetaVeri[1]=="uyeliksozlesme" || $MetaVeri[1]=="gizlilikpolitikasi" || $MetaVeri[1]=="sifremiunuttum" || $MetaVeri[1]=="hesabim"  || $MetaVeri[1]=="profilbilgileri"  || $MetaVeri[1]=="favorioyunlarim"  || $MetaVeri[1]=="favorihaberlerim"  || $MetaVeri[1]=="bilgisayarim"  || $MetaVeri[1]=="haberekle"  || $MetaVeri[1]=="habericerik"  || $MetaVeri[1]=="haberlerim"  || $MetaVeri[1]=="haberlerimdetay"  || $MetaVeri[1]=="icerikdetay"  || $MetaVeri[1]=="oyuninceleme"  || $MetaVeri[1]=="oyunincelemelerim"  || $MetaVeri[1]=="incelemelerimdetay"  || $MetaVeri[1]=="guvenlikbilgileri"  || $MetaVeri[1]=="takipettiklerim"  || $MetaVeri[1]=="yenisifreolustur"  || $MetaVeri[1]=="cikisyap" ) {
    		$googlebot="noindex, nofollow, noarchive";
    	}else{
    		$googlebot="index, follow";
    	}
    }else{
    	$googlebot="noindex, nofollow, noarchive";
    }
    
    
    ?>
<?php
}else{
	require_once("../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





