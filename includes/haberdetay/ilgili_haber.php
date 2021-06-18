<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	if(IcerikTemizle($HaberSorgusuKayit["IlgiliHaber"])!=""){
	    $IlgiliHaber = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE  HaberUniqid=? and Durum=?  LIMIT 1");
		$IlgiliHaber->execute([Guvenlik($HaberSorgusuKayit["IlgiliHaber"]),1]);
		$IlgiliHaberVeri = $IlgiliHaber->rowCount();
		$IlgiliHaberKayitlar = $IlgiliHaber->fetch(PDO::FETCH_ASSOC);
		if ($IlgiliHaberVeri>0) {
	?>
	
	    <div class="col-12 " >
	        <div class="row  align-items-center" style="background:#202020">
	            <div class="col-12 col-md-3 p-0">
                <?php
				if ( IcerikTemizle($IlgiliHaberKayitlar["AnaResim"]!="") and IcerikTemizle(isset($IlgiliHaberKayitlar["AnaResim"])) and (file_exists("images/news/".IcerikTemizle($IlgiliHaberKayitlar["AnaResim"])))) {
				?>	
					<a href="haberdetay/<?php echo  SEO(IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($IlgiliHaberKayitlar["HaberUniqid"]); ?>">
					<img src="images/news/<?php echo IcerikTemizle($IlgiliHaberKayitlar["AnaResim"]); ?>" alt="<?php echo IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]); ?>" title="<?php echo IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]); ?>" class="img-fluid hdr" style="width: 100%; height: auto">
				    </a>
				<?php
				}else{
				?>
						<img src="images/hata2.jpg" class="img-fluid hdr">
				<?php
				}
				?>
	            </div>
	            <div class="col-12 col-md-9 "  >
	                 <div class="row ">
	                     <div class="col-12 mt-2 ">
	                         <span class="font13 white m-0 opacity07">İLGİLİ HABER</span>
	                     </div>
	                     <div class="col-12 mt-1 mb-2">
	                        <a href="haberdetay/<?php echo  SEO(IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($IlgiliHaberKayitlar["HaberUniqid"]); ?>">
	                         <h6 class="bold white m-0"><?php echo  IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]) ?></h6>
	                         </a>
	                     </div>
	                      <div class="col-12">
                           <a href="haberdetay/<?php echo  SEO(IcerikTemizle($IlgiliHaberKayitlar["AnaBaslik"]));?>/<?php echo IcerikTemizle($IlgiliHaberKayitlar["HaberUniqid"]); ?>"><span class="white font12 bold  opacity07">HABERE GÖZ ATIN <i class="fas fa-angle-right"></i></span></a> 
                        </div>
	                     
	                 </div>
	            </div>
	        </div>
	    </div>
	<?php
		}
	}
	?>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





