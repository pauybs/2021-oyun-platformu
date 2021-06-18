<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="row align-items-center ">
		<div class="col-12  text-center ">
			<div class="row align-items-center">
				<div class="col-12 text-left ">
				<button type="button"  class="btn" style="background:#3b5998;border:none; "><a  ref="nofollow" rel="noreferrer" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $SiteLink ?>haberdetay/<?php echo SEO(IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) ?>/<?php echo (IcerikTemizle($HaberSorgusuKayit["HaberUniqid"])) ?>" target="_blank" ><i class="fab fa-facebook-f white font20 pr-1 pl-1"></i></a></button>	
				<button type="button"  class="btn " style="background:#00acee ;border:none; "><a  ref="nofollow" rel="noreferrer" href="https://twitter.com/share?url=<?php echo $SiteLink ?>haberdetay/<?php echo SEO(IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) ?>/<?php echo (IcerikTemizle($HaberSorgusuKayit["HaberUniqid"])) ?>" target="_blank" ><i  class="fab fa-twitter white font20 p-0 "></i></a></button>	
                <button type="button"  class="btn " style="background:#0088cc ;border:none; "><a  ref="nofollow" rel="noreferrer" href="https://t.me/share/url?url=<?php echo $SiteLink ?>haberdetay/<?php echo SEO(IcerikTemizle($HaberSorgusuKayit["AnaBaslik"])) ?>/<?php echo (IcerikTemizle($HaberSorgusuKayit["HaberUniqid"])) ?>&text=<?php echo IcerikTemizle($HaberSorgusuKayit["AnaBaslik"]); ?>" target="_blank" ><i  class="fab fa-telegram-plane white font20 p-0 "></i></a></button>
				</div>
			</div>
		</div>
	</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





