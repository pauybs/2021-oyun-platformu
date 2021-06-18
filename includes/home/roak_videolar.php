<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<?php
	$Videolar = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo Where Durum=?" );
	$Videolar->execute([1]);
	$VideolarVeri = $Videolar->rowCount();
	$VideolarKayitlar = $Videolar->fetchAll(PDO::FETCH_ASSOC);
	if ($VideolarVeri>0) {
	?>
	<div class="col-12  " >
		<div class="row p-1">
			<div class="col-12 " >
				<div class="row justify-content-center align-items-center" >
					<div class="col-12 mb-3">
        				<div class="row p-2   justify-content-end align-items-center"  style="background:#202020;border-radius:5px">
        					<div class="col-7 col-xl-10 text-left bGAfxXE"><span>ROAK GAME VİDEO</span></div>
        					<div class="col-5 col-xl-2  text-center  WrGYT__Xx"  style="background:#c4302b;border-radius:5px " ><a  ref="nofollow" rel="noreferrer" href=" <?php echo IcerikTemizle($Youtube);?>" target="_blank"><i class="fab fa-youtube  white "></i> <span class="gxPpxXo_">YouTube</span></a></div>
        				</div>
        			</div>
					<div class="col-12">
						<div class="row align-items-center " >
							<div class="vid-main-wrapper clearfix">
							<?php 
							$SonVideo = $DatabaseBaglanti->prepare("SELECT * FROM roakvideo WHERE   Durum=1  ORDER BY id DESC  LIMIT 1");
							$SonVideo->execute([1]);
							$SonVideoVeri = $SonVideo->rowCount();
							$SonVideoKayitlar =  $SonVideo-> fetch(PDO::FETCH_ASSOC);
							if ($SonVideoVeri>0 ){
							?>
							<div class="col-12  p-0 vid-container" >
						      <iframe id="vid_frame" width="100%" src="https://www.youtube.com/embed/<?php echo IcerikTemizle($SonVideoKayitlar["Url"]) ?>?rel=0&showinfo=0&autohide=1" frameborder="0" width="560" height="315"></iframe>
						    </div>	
							<?php	
							}
							?>
							</div>
						</div>
					</div>
				</div>
		  	</div>
	  	</div>
    </div>
	<?php
	}
	?>
<?php
}else{
	require_once("../../settings/connect.php");
	header("location:" .$SiteLink);
    exit();
}
?>





