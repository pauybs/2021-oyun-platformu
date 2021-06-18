<?php
try{
	$DatabaseBaglanti = new PDO("mysql:host=localhost;dbname=;charset=UTF8","","");
}catch(PDOException  $error ){
	//echo "Bağlantı Hatası <br/>" .$error->getMessage(); // sonradan sil kullanıcılar görmesin
	die();

}
$AyarlarSorgusu = $DatabaseBaglanti->prepare("SELECT * FROM ayarlar ");
$AyarlarSorgusu->execute();
$VeriSayisi = $AyarlarSorgusu->rowCount();
$Kayitlar = $AyarlarSorgusu->fetch(PDO::FETCH_ASSOC);

if($VeriSayisi>0){
	$SiteName          = $Kayitlar["SiteAdi"];
	$SiteTitle         = $Kayitlar["Title"];
	$SiteDescription   = $Kayitlar["Description"];
	$SiteKeywords      = $Kayitlar["Keywords"];
	$SiteSozlukKeywords      = $Kayitlar["SozlukKeywords"];
	$SiteCopyright     = $Kayitlar["Copyright"];
	$SiteLogo          = $Kayitlar["Logo"];
	$SiteIcon         = $Kayitlar["Icon"];
	$SiteLink         = $Kayitlar["Link"];
	$SiteMail          = $Kayitlar["Mail"];
	$SiteMailPassword  = $Kayitlar["MailPassword"];
	$SiteMailHost     = $Kayitlar["MailHost"];
	$Facebook          = $Kayitlar["Facebook"];
	$Twitter           = $Kayitlar["Twitter"];
	$Instagram         = $Kayitlar["Instagram"];
	$Telegram         = $Kayitlar["Telegram"];
	$Youtube         = $Kayitlar["Youtube"];



}else{

	die();
}


$Resimler = $DatabaseBaglanti->prepare("SELECT * FROM resimler LIMIT 1");
$Resimler->execute();
$ResimlerSayisi = $Resimler->rowCount();
$ResimKayitlar = $Resimler->fetch(PDO::FETCH_ASSOC);

if($ResimlerSayisi>0){
	$AnasayfaAksiyon          	= $ResimKayitlar["AnasayfaAksiyon"];
	$AnasayfaYaris         		= $ResimKayitlar["AnasayfaYaris"];
	$AnasayfaBasitEglence   	= $ResimKayitlar["AnasayfaBasitEglence"];
	$AnasayfaCokoyunculu      	= $ResimKayitlar["AnasayfaCokoyunculu"];
	$AnasayfaMacera     		= $ResimKayitlar["AnasayfaMacera"];
	$AnasayfaRolYapma          	= $ResimKayitlar["AnasayfaRolYapma"];
	$AnasayfaSpor         		= $ResimKayitlar["AnasayfaSpor"];
	$AnasayfaStrateji          	= $ResimKayitlar["AnasayfaStrateji"];
	$AnasayfaUcretsiz          	= $ResimKayitlar["AnasayfaUcretsiz"];
	$AnasayfaSimulasyon  		= $ResimKayitlar["AnasayfaSimulasyon"];
	$AnasayfaMobil     			= $ResimKayitlar["AnasayfaMobil"];
	$AnasayfaHayattaKalma       = $ResimKayitlar["AnasayfaHayattaKalma"];
	$HakkimizdaBir         		= $ResimKayitlar["HakkimizdaBir"];
	$HakkimizdaIki         		= $ResimKayitlar["HakkimizdaIki"];
	$GirisYap        = $ResimKayitlar["GirisYap"];
	$UyeOl        = $ResimKayitlar["UyeOl"];


}else{

	$AnasayfaAksiyon          	= "";
	$AnasayfaYaris         		= "";
	$AnasayfaBasitEglence   	= "";
	$AnasayfaCokoyunculu      	= "";
	$AnasayfaMacera     		= "";
	$AnasayfaRolYapma          	= "";
	$AnasayfaSpor         		= "";
	$AnasayfaStrateji          	= "";
	$AnasayfaUcretsiz          	= "";
	$AnasayfaSimulasyon  		="";
	$AnasayfaMobil     			= "";
	$AnasayfaHayattaKalma       = "";
	$HakkimizdaBir         		="";
	$HakkimizdaIki         		= "";
	$AnasayfaCokYakinda         = "";
	$AnasayfaTumOyunlar         = "";
	$CokYakindaArkaplan         = "";
	$TumOyunlarArkaplan         = "";

}

if(isset($_SESSION["Kullanici"] )){
	$KullaniciSorgusu = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ? LIMIT 1 ");
	$KullaniciSorgusu->execute([$_SESSION["Kullanici"]]);
	$KullaniciVeriSayisi = $KullaniciSorgusu->rowCount();
	$KullaniciKayitlar = $KullaniciSorgusu->fetch(PDO::FETCH_ASSOC);
	
	if ($KullaniciVeriSayisi>0) {
		$KullaniciId          		= $KullaniciKayitlar["id"];
		$KullaniciMail             	= $KullaniciKayitlar["Email"];
		$KullaniciSifre             = $KullaniciKayitlar["Sifre"];
		$KullaniciAdiSoyadi         = $KullaniciKayitlar["AdSoyad"];
		$KullaniciAdi          		= $KullaniciKayitlar["KullaniciAdi"];
		$KullaniciProfilResmi       = $KullaniciKayitlar["ProfilResmi"];
		$KullaniciDurum             = $KullaniciKayitlar["Durum"];
		$KullaniciKayitTarih        = $KullaniciKayitlar["KayitTarihi"];
		$KullaniciKayitIpAdresi     = $KullaniciKayitlar["IpAdresi"];
		$KullaniciAktivasyonKodu    = $KullaniciKayitlar["AktivasyonKodu"];
		$KullaniciKuratorDurumu     = $KullaniciKayitlar["Kurator"];
		$KullaniciEditorDurumu      = $KullaniciKayitlar["Editor"];
		$KullaniciSilinmeDurum      = $KullaniciKayitlar["SilinmeDurumu"];
		$KullaniciFacebook       	= $KullaniciKayitlar["Facebook"];
		$KullaniciTwitter       	= $KullaniciKayitlar["Twitter"];
		$KullaniciTwitch       		= $KullaniciKayitlar["Twitch"];
		$KullaniciInstagram       	= $KullaniciKayitlar["Instagram"];
		$KullaniciYoutube       	= $KullaniciKayitlar["Youtube"];
		$KullaniciDlive      		= $KullaniciKayitlar["Dlive"];
		$KullaniciWebSite      		= $KullaniciKayitlar["WebSite"];
		$KullaniciNonolive      	= $KullaniciKayitlar["Nonolive"];

		$KullaniciEditorBan      	= $KullaniciKayitlar["EditorBan"];
		$KullaniciEditorBanTarih    = $KullaniciKayitlar["EditorBanTarih"];
		$KullaniciKuratorBan      	= $KullaniciKayitlar["KuratorBan"];
		$KullaniciKuratorBanTarih    = $KullaniciKayitlar["KuratorBanTarih"];

		$KullaniciProfilResimBan      	= $KullaniciKayitlar["ProfilResimBan"];
		$KullaniciProfilResimBanTarih    = $KullaniciKayitlar["ProfilResimBanTarih"];
		$KullaniciYorumBan      	= $KullaniciKayitlar["YorumBan"];
		$KullaniciYorumBanTarih    = $KullaniciKayitlar["YorumBanTarih"];
	}else{
		die();
	}
}

if(isset($_SESSION["Kullanici"] )){
	$KullaniciPc = $DatabaseBaglanti->prepare("SELECT * FROM uyebilgisayar WHERE UyeId=$KullaniciId  LIMIT 1 ");
	$KullaniciPc->execute();
	$KullaniciPcVeriSayisi = $KullaniciPc->rowCount();
	$KullaniciPcKayitlar = $KullaniciPc->fetch(PDO::FETCH_ASSOC);

	if ($KullaniciPcVeriSayisi>0){

		$KullaniciIsletimSistemiId    = $KullaniciPcKayitlar["IsletimSistemiId"];
		$KullaniciIslemciId    		= $KullaniciPcKayitlar["IslemciId"];
		$KullaniciPcRamId        		= $KullaniciPcKayitlar["RamId"];
		$KullaniciEkranKartiId      	= $KullaniciPcKayitlar["EkranKartiId"];
		$KullaniciPcDirectxId       	= $KullaniciPcKayitlar["DirectxId"];

	}else{
		$KullaniciIsletimSistemiId    = "";
		$KullaniciIslemciId    		= "";
		$KullaniciPcRamId        		= "";
		$KullaniciEkranKartiId      	= "";
		$KullaniciPcDirectxId       	= "";
	}

}else{
	$KullaniciIsletimSistemiId    = "";
	$KullaniciIslemciId    		= "";
	$KullaniciPcRamId        		= "";
	$KullaniciEkranKartiId      	= "";
	$KullaniciPcDirectxId       	= "";

}




$Sozlesmeler = $DatabaseBaglanti->prepare("SELECT * FROM sozlesmeler LIMIT 1");
$Sozlesmeler ->execute();
$VeriSayisi  = $Sozlesmeler->rowCount();
$Kayitlar = $Sozlesmeler->fetch(PDO::FETCH_ASSOC);

if($VeriSayisi>0){

	$GizlilikSozlesme     = $Kayitlar["Gizlilik"];
	$UyelikSozlesme      = $Kayitlar["Uyelik"];
	$Hakkimizda      = $Kayitlar["Hakkimizda"];
	$ToplulukKurallari      = $Kayitlar["ToplulukKurallari"];



}else{

	die();
}


if(isset($_SESSION["Yonetici"])){
	$YoneticiSorgusu = $DatabaseBaglanti->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi= ? LIMIT 1 ");
	$YoneticiSorgusu->execute([$_SESSION["Yonetici"]]);
	$YoneticiSorgusuSayisi = $YoneticiSorgusu->rowCount();
	$YoneticiSorgusuKayitlar = $YoneticiSorgusu->fetch(PDO::FETCH_ASSOC);
	
	if ($YoneticiSorgusuSayisi>0) {

		$YoneticiId          	= $YoneticiSorgusuKayitlar["id"];
		$YoneticiKullaniciAdi  	= $YoneticiSorgusuKayitlar["KullaniciAdi"];
		$YoneticiSifre         	= $YoneticiSorgusuKayitlar["Sifre"];
		$YoneticiAdSoyad       	= $YoneticiSorgusuKayitlar["AdSoyad"];
		$YoneticiTelefon       	= $YoneticiSorgusuKayitlar["TelefonNo"];
		$YoneticiEmail        	= $YoneticiSorgusuKayitlar["Email"];
		$YoneticiDurumu        	= $YoneticiSorgusuKayitlar["SilinmeyenYoneticiDurumu"];
		
	}else{
		die();
	}
}

?>