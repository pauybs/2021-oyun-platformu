<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	if(IcerikTemizle($HaberSorgusuKayit["IlgiliOyun"])!=""){
	    $IlgiliOyun = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE  OyunUniqid=? and Durum=?  LIMIT 1");
		$IlgiliOyun->execute([Guvenlik($HaberSorgusuKayit["IlgiliOyun"]),1]);
		$IlgiliOyunVeri = $IlgiliOyun->rowCount();
		$IlgiliOyunKayitlar = $IlgiliOyun->fetch(PDO::FETCH_ASSOC);
		if ($IlgiliOyunVeri>0) {
	?>
    <div class="col-12 " >
        <div class="row  align-items-center" >
            <div class="col-12 col-md-6 mt-2">
                <div class="row p-md-1 ">
                    <div class="col-12" style="background:#202020">
                        <div class="row align-items-center">
                            <div class=" col-3 p-0">
                            <?php
        					if ( IcerikTemizle($IlgiliOyunKayitlar["AnaResim"]!="") and IcerikTemizle(isset($IlgiliOyunKayitlar["AnaResim"])) and (file_exists("images/games/".IcerikTemizle($IlgiliOyunKayitlar["AnaResim"])))) {
        					?>	
        					    <a href="oyundetay/<?php echo  SEO(IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunUniqid"]); ?>">
        						<img src="images/games/<?php echo IcerikTemizle($IlgiliOyunKayitlar["AnaResim"]); ?>" alt="<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]); ?>" title="<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]); ?>" class="img-fluid hdr" style="width: 100%; height: auto">
        					    </a>
        					<?php
        					}else{
        					?>
        							<img src="images/resim.jpg" class="img-fluid hdr">
        					<?php
        					}
        					?>
                            </div>
                             <div class=" col-9">
                                 <div class="row">
                                     <div class="col-12 mt-2 ">
				                        <a href="oyundetay/<?php echo  SEO(IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunUniqid"]); ?>">
                                        <span class="font13 white m-0 opacity07">İLGİLİ OYUN</span>
                                        </a>
				                     </div>
				                     <div class="col-12 mt-1 mb-2">
				                           <a href="oyundetay/<?php echo  SEO(IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunUniqid"]); ?>">
				                         <h6 class="bold white m-0"><?php echo  IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]) ?></h6></a>
				                     </div>
				                     <div class="col-12">
	                                    	<a href="oyundetay/<?php echo  SEO(IcerikTemizle($IlgiliOyunKayitlar["OyunAdi"]));?>/<?php echo IcerikTemizle($IlgiliOyunKayitlar["OyunUniqid"]); ?>">
                                                <span class="white font12 bold opacity07">OYUNA GÖZ ATIN <i class="fas fa-angle-right"></i></span></a> 
	                                </div>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6  mt-2">
                <div class="row  p-1 align-items-center" style="background:#202020">
                    <div class="col-12">
                        <div class="row m-0 justify-content-center align-items-center" >
                            <div class=" col-3 p-0" >
                                <div class="row align-items-center">
                                    <div class="col-12"><a href="tumoyunlar"> <img src="images/resim.jpg" class="img-fluid hdr"></a></div>
                                     <div class="col-12 position-absolute text-right"><a href="tumoyunlar"><i class="fas fa-gamepad fa-2x white p-2" style="background:#c28f2c;border-radius:100%"></i></a></div>

                                </div>

	                    </div>
	                    <div class=" col-9 ">
	                        <div class="row">
	                            <div class="col-12">
	                                <a href="tumoyunlar"><span class="white font13 opacity07">OYUN</span></a>
	                            </div>
	                             <div class="col-12">
	                               <a href="tumoyunlar"><span class="white font12 bold  opacity07">TÜM OYUNLARA GÖZ ATIN <i class="fas fa-angle-right"></i></span></a> 
	                            </div>
	                        </div>
	                    </div> 
                        </div>
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





