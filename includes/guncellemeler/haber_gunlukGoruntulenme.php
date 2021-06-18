<?php
require_once("../../settings/connect.php");
$OkunanHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler  where Durum=? and GunlukGoruntulenme>? ORDER BY GunlukGoruntulenme DESC LIMIT 5");
$OkunanHaberler->execute([1,0]);
$OkunanHaberlerVeri = $OkunanHaberler->rowCount();
$OkunanHaberlerKayitlar = $OkunanHaberler->fetchAll(PDO::FETCH_ASSOC);
$OkunanHaber= array();
if ($OkunanHaberlerVeri>0) {
	foreach ($OkunanHaberlerKayitlar as $Okunankayitlar) {	
		array_push($OkunanHaber,$Okunankayitlar["id"]);	
	}
}

$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler ");
$Haberler->execute([]);
$HaberlerVeri = $Haberler->rowCount();
$HaberlerKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
if ($HaberlerVeri>0) {
	foreach ($HaberlerKayitlar as $kayitlar) {	
		$Sifirla = $DatabaseBaglanti->prepare("UPDATE haberler SET GunlukGoruntulenme=? WHERE id=?  ");
		$Sifirla->execute([0,$kayitlar["id"]]);
	}
}

$HaberPuan=5;
for ($i=0; $i <count($OkunanHaber); $i++) { 
	$Guncelle = $DatabaseBaglanti->prepare("UPDATE haberler SET GunlukGoruntulenme=? WHERE id=?  ");
	$Guncelle->execute([$HaberPuan,$OkunanHaber[$i]]);	
	$HaberPuan--;
}	

$OkunanIncelemeler=$DatabaseBaglanti->prepare("SELECT * FROM incelemeler where Durum=? and GunlukGoruntulenme>? ORDER BY GunlukGoruntulenme DESC LIMIT 5 ");
$OkunanIncelemeler->execute([1,0]);
$OkunanIncelemelerVeri = $OkunanIncelemeler->rowCount();
$OkunanIncelemelerKayitlar = $OkunanIncelemeler->fetchAll(PDO::FETCH_ASSOC);
$OkunanInceleme= array();
if ($OkunanIncelemelerVeri>0) {
	foreach ($OkunanIncelemelerKayitlar as $OkunanIncelemekayitlar) {	
		array_push($OkunanInceleme,$OkunanIncelemekayitlar["Incelemeid"]);	
	}
}


$Incelemeler = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler ");
$Incelemeler->execute([]);
$IncelemelerVeri = $Incelemeler->rowCount();
$IncelemelerKayitlar = $Incelemeler->fetchAll(PDO::FETCH_ASSOC);
if ($IncelemelerVeri>0) {
	foreach ($IncelemelerKayitlar as $kayitlar) {	
		$Sifirla = $DatabaseBaglanti->prepare("UPDATE incelemeler SET GunlukGoruntulenme=? WHERE Incelemeid=?  ");
		$Sifirla->execute([0,$kayitlar["Incelemeid"]]);
	}
}

$IncelemePuan=5;
for ($i=0; $i <count($OkunanInceleme); $i++) { 
	$IncelemeGuncelle = $DatabaseBaglanti->prepare("UPDATE incelemeler SET GunlukGoruntulenme=? WHERE Incelemeid=?  ");
	$IncelemeGuncelle->execute([$IncelemePuan,$OkunanInceleme[$i]]);	
	$IncelemePuan--;
	
}	


$OkunanSozluk = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar where Durum=? and GunlukGoruntulenme>? order by GunlukGoruntulenme DESC LIMIT 5 ");
$OkunanSozluk->execute([1,0]);
$OkunanSozlukVeri = $OkunanSozluk->rowCount();
$OkunanSozlukKayitlar = $OkunanSozluk->fetchAll(PDO::FETCH_ASSOC);
$OkunanSozlukBasliklar= array();
if ($OkunanSozlukVeri>0) {
	foreach ($OkunanSozlukKayitlar as $OkunanSozlukkayitlar) {	
		array_push($OkunanSozlukBasliklar,$OkunanSozlukkayitlar["id"]);	
	}
}


$Sozluk = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar ");
$Sozluk->execute([]);
$SozlukVeri = $Sozluk->rowCount();
$SozlukKayitlar = $Sozluk->fetchAll(PDO::FETCH_ASSOC);
if ($SozlukVeri>0) {
	foreach ($SozlukKayitlar as $kayitlar) {	
		$Sifirla = $DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET GunlukGoruntulenme=? WHERE id=?  ");
		$Sifirla->execute([0,$kayitlar["id"]]);
	}
}

$SozlukPuan=5;
for ($i=0; $i <count($OkunanSozlukBasliklar); $i++) { 
	$SozlukGuncelle = $DatabaseBaglanti->prepare("UPDATE sozlukyazilar SET GunlukGoruntulenme=? WHERE id=?  ");
	$SozlukGuncelle->execute([$SozlukPuan,$OkunanSozlukBasliklar[$i]]);	
	$SozlukPuan--;
	
}	
?>





