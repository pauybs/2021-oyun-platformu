<?php header('Content-type: application/xml; charset="utf8"',true);  ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php
require_once("settings/connect.php");
require_once("settings/functions.php");
?>

<?php 
$Haberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? ORDER BY id Desc" );
$Haberler->execute([1]);
$HaberData = $Haberler->rowCount();
$HaberKayitlar = $Haberler->fetchAll(PDO::FETCH_ASSOC);
if ($HaberData>0) {
  foreach ($HaberKayitlar as $haberkayit) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>haberdetay/<?php echo SEO(IcerikTemizle($haberkayit["AnaBaslik"])); ?>/<?php echo $haberkayit["HaberUniqid"]; ?></loc>
  <lastmod><?php echo map($haberkayit["KayitTarihi"]); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.00</priority>
</url>
<?php
  }
}
?>

<?php
$Oyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? ORDER BY CikisTarihi Desc" );
$Oyunlar->execute([1]);
$OyunlarData = $Oyunlar->rowCount();
$OyunlarKayitlar = $Oyunlar->fetchAll(PDO::FETCH_ASSOC);
if ($OyunlarData>0) {
  foreach ($OyunlarKayitlar as $oyunkayit) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>oyundetay/<?php echo SEO(IcerikTemizle($oyunkayit["OyunAdi"])); ?>/<?php echo $oyunkayit["OyunUniqid"]; ?></loc>
  <changefreq>daily</changefreq>
  <priority>1.00</priority>
</url>
<?php
  }
}
?>


<url>
  <loc><?php echo $SiteLink; ?>sistemineozel</loc>
    <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>

<url>
  <loc><?php echo $SiteLink; ?>haber</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<url>
  <loc><?php echo $SiteLink; ?>tumoyunlar</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>


<url>
  <loc><?php echo $SiteLink; ?>kuratorler</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<url>
  <loc><?php echo $SiteLink; ?>roak-video</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<url>
  <loc><?php echo $SiteLink; ?>sozluk</loc>
  <changefreq>daily</changefreq>
  <priority>1.00</priority>
</url>
<url>
  <loc><?php echo $SiteLink; ?>okunanhaberler</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<url>
  <loc><?php echo $SiteLink; ?>konusulanhaberler</loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>








<?php 
$Kuratorler = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Durum=?  and Kurator=?" );
$Kuratorler->execute([1,1]);
$KuratorlerData = $Kuratorler->rowCount();
$KuratorlerKayitlar = $Kuratorler->fetchAll(PDO::FETCH_ASSOC);
if ($KuratorlerData>0) {
  foreach ($KuratorlerKayitlar as $kuratorkayit) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>kurator/<?php echo IcerikTemizle($kuratorkayit["KullaniciAdi"]); ?></loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<?php
  }
}
?>

<?php 
$sozlukkategori = $DatabaseBaglanti->prepare("SELECT * FROM sozlukkategoriler WHERE Durum=?  " );
$sozlukkategori->execute([1]);
$sozlukkategoriData = $sozlukkategori->rowCount();
$sozlukkategoriKayitlar = $sozlukkategori->fetchAll(PDO::FETCH_ASSOC);
if ($sozlukkategoriData>0) {
  foreach ($sozlukkategoriKayitlar as $sozlukkategorikayit) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>sozlukkategori/<?php echo SEO(IcerikTemizle($sozlukkategorikayit["KategoriAdi"])); ?>/<?php echo IcerikTemizle($sozlukkategorikayit["id"]); ?></loc>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<?php
  }
}
?>




<?php
$sozlukbasliklar = $DatabaseBaglanti->prepare("SELECT * FROM sozlukyazilar WHERE Durum=? " );
$sozlukbasliklar->execute([1]);
$sozlukbasliklarData = $sozlukbasliklar->rowCount();
$sozlukbasliklarKayitlar = $sozlukbasliklar->fetchAll(PDO::FETCH_ASSOC);
if ($sozlukbasliklarData>0) {
  foreach ($sozlukbasliklarKayitlar as $sozlukkayit) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>sozlukbaslik/<?php echo SEO(IcerikTemizle($sozlukkayit["Baslik"])); ?>/<?php echo $sozlukkayit["id"]; ?></loc>
  <lastmod><?php echo map($sozlukkayit["Tarih"]); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>1.00</priority>
</url>
<?php
  }
}
?>


<?php
$Incelemeler = $DatabaseBaglanti->prepare("SELECT * FROM incelemeler WHERE Durum=? " );
$Incelemeler->execute([1]);
$IncelemelerData = $Incelemeler->rowCount();
$IncelemelerKayitlar = $Incelemeler->fetchAll(PDO::FETCH_ASSOC);
if ($IncelemelerData>0) {
  foreach ($IncelemelerKayitlar as $incelemekayit) {
    $OyunAdi = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE id=? " );
    $OyunAdi->execute([$incelemekayit["OyunId"]]);
    $OyunAdiData = $OyunAdi->rowCount();
    $OyunAdiKayitlar = $OyunAdi->fetch(PDO::FETCH_ASSOC);


    $Kurator = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE id=?   " );
    $Kurator->execute([$incelemekayit["KuratorId"]]);
    $KuratorData = $Kurator->rowCount();
   $KuratorKayitlar = $Kurator->fetch(PDO::FETCH_ASSOC);

    if ($OyunAdiData>0 and  $KuratorData>0) {
  ?>
  <url>
  <loc><?php echo $SiteLink ?>incelemedetay/<?php echo SEO(IcerikTemizle($OyunAdiKayitlar["OyunAdi"])); ?>/<?php echo IcerikTemizle($KuratorKayitlar["KullaniciAdi"]); ?>/<?php echo IcerikTemizle($incelemekayit["Incelemeid"]); ?></loc>
  <lastmod><?php echo map($incelemekayit["Tarih"]); ?></lastmod>
  <changefreq>daily</changefreq>
  <priority>0.9</priority>
</url>
<?php
 }
  }
}
?>



</urlset>

