<?php
session_start();
ob_start();
require_once("settings/connect.php");
require_once("settings/functions.php");
require_once("settings/pages.php");
if(isset($_REQUEST["Pages"])){
	$PagesValue = SayfaNumarasiTemizle($_REQUEST["Pages"]);
}else{
	$PagesValue =0;
}
if(isset($_REQUEST["Sayfalar"])){
	$Sayfalar = SayfaNumarasiTemizle($_REQUEST["Sayfalar"]);
}else{
	$Sayfalar = 1;
}
?>
<?php
require_once("includes/seo.php");
?>
<!DOCTYPE html>
<html lang="tr-TR">
<head>
     <script data-ad-client="ca-pub-6491655414364653" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
   <!-- <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NTL9NN6');</script>-->
	<base href="https://roakgame.com/">
	<title><?php echo IcerikTemizle($Tit);?></title>
	<link type="image/" rel="icon"  href="images/<?php echo IcerikTemizle($SiteIcon);?>" > 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta http-equiv="Content-Language" content="tr">
	<meta name="robots" content="<?php echo IcerikTemizle($googlebot) ?>">
	<meta name="googlebot" content="<?php echo IcerikTemizle($googlebot) ?>">
	<meta name="revisit-after" content="7 Days">
	<meta name="description" content="<?php echo IcerikTemizle($Desc);?>">
	<link rel="stylesheet" type="text/css" href="settings/bootstrap.min.css">
	<meta name="yandex-verification" content="22a6e731a530cedb" />
	<script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=G-QBDEF148BG"></script>-->
	<?php
    if( $Canonical!="" and isset($Canonical)){
    ?>
        <link rel="canonical" href="<?php echo IcerikTemizle($Canonical) ?>"/>
    <?php
    }
    ?>
	<?php
	if ($MetaVeri[1]=="haberdetay" || $MetaVeri[1]=="incelemedetay"  || $MetaVeri[1]=="sozlukbaslik" || $MetaVeri[1]=="sozlukbaslikara" ) {
	?>
    <meta property="fb:app_id" content="256990865950018" >
    <?php
    if( $FbWebSite!="" and isset($FbWebSite)){
    ?>
    <?php echo $FbWebSite; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbSiteIsim!="" and isset($FbSiteIsim)){
    ?>
    <?php echo $FbSiteIsim; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbBaslik!="" and isset($FbBaslik)){
    ?>
    <?php echo $FbBaslik; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbAciklama!="" and isset($FbAciklama)){
    ?>
    <?php echo $FbAciklama; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbSayfaUrl!="" and isset($FbSayfaUrl)){
    ?>
    <?php echo $FbSayfaUrl; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbSayfaTr!="" and isset($FbSayfaTr)){
    ?>
    <?php echo $FbSayfaTr; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $FbHaberResim!="" and isset($FbHaberResim)){
    ?>
    <?php echo $FbHaberResim; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwCard!="" and isset($TwCard)){
    ?>
    <?php echo $TwCard; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwSite!="" and isset($TwSite)){
    ?>
    <?php echo $TwSite; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwTitle!="" and isset($TwTitle)){
    ?>
    <?php echo $TwTitle; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwUrl!="" and isset($TwUrl)){
    ?>
    <?php echo $TwUrl; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwAciklama!="" and isset($TwAciklama)){
    ?>
    <?php echo $TwAciklama; "<br>"?> 
    <?php
    }
    ?>
    <?php
    if( $TwResim!="" and isset($TwResim)){
    ?>
    <?php echo $TwResim; "<br>"?> 
    <?php
    }
    ?>
	<?php
	}
	?>
	<script type="text/javascript" src="settings/jquery-3.3.1.js" language="javascript" ></script>
	<script type="text/javascript" src="settings/functions.js" language="javascript"></script>
	<script type="text/javascript" src="settings/bootstrap.min.js" ></script>
	<!--<script type="text/javascript" src="settings/jquery-2.1.1.js" language="javascript" ></script>-->
	<!--	 <script type="text/javascript" src="settings/jquery-3.5.1.min.js" language="javascript" ></script> -->
    <!--<script type="text/javascript" src="settings/jquery-ui.min.js" language="javascript" ></script>    -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
    <!-- <link rel="stylesheet" href="settings/fontawesome.min.css"> -->
	<link type="text/css" rel="stylesheet"  href="settings/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<script src="settings/modernizr.js"></script> 
	<script src="settings/jquery.menu-aim.js"></script> 
	<script src="settings/main.js"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>-->
	<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
	<script src="settings/classie.js"></script>
	<script src="settings/gnmenu.js"></script>
	<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
	<script src="settings/swiper-bundle.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="settings/cookie.min.js"></script>
	<!--<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-QBDEF148BG');</script>-->
    <script>window.addEventListener("load",function(){window.cookieconsent.initialise({palette:{popup:{background:"#000000",text:"#ffffff"},button:{background:"#c28f2c",text:"#ffffff"}},theme:"classic",content:{message:"Sitemizden en iyi şekilde faydalanabilmeniz için çerezler kullanılmaktadır. Sitemize giriş yaparak çerez kullanımını kabul etmiş sayılıyorsunuz.",dismiss:"ANLADIM",link:"Daha fazla bilgi",href:"https://roakgame.com/gizlilikpolitikasi"}})});</script>
</head>
<body>
<!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NTL9NN6"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
	<div id="loader-wrapper" >
		<div id="loader"></div>
		<div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
	</div>
	<div class="row indAX">
		<div class="col-12 jKlkXmn ">
			<ul id="gn-menu" class="gn-menu-main">
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"><span>Menu</span></a>
					<nav class="gn-menu-wrapper" >
						<div class="gn-scroller">
							<ul class="gn-menu">
								<li class=" white ">
									<form action="haberara" method="post" >
										<i class="fas fa-search ml-3"></i>
										<input placeholder="Oyun,Haber Ara..." type="search" name="Ara" class="inseajhxcb" >
									</form>
								</li>
								<li>
									<ul class="gn-submenu">
									<?php
									if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
									?>
										<li class="d-block d-xl-none">
											<a href="hesabim">
											<?php
											if(file_exists("images/userphoto/".$KullaniciProfilResmi) and (isset($KullaniciProfilResmi)) and ($KullaniciProfilResmi!="") ){
											?>
												<img alt="<?php echo IcerikTemizle($KullaniciAdi) ?>" src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?> " class="img-fluid ml-2 inxzkj" >
											<?php
											}else{
											?>
												<img src="images/user.png" class="img-fluid invbnv" alt="<?php echo IcerikTemizle($KullaniciAdi) ?>">
											<?php
											}
											?>
												<span class="ml-1"><?php echo IcerikTemizle($KullaniciAdiSoyadi);?></span></a>
										</li>

										<?php
										if ($KullaniciKuratorDurumu==1) {		
										?>
											<li class="d-block d-xl-none">
												<a href="kurator/<?php  echo IcerikTemizle($KullaniciAdi) ?>">
													<span class="ml-3">Küratör</span> 
												</a>
											</li>
										<?php
										}
										?>	
									<?php
									}
									?>
										<li>
											<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
												<i class="fas fa-home ml-3 "></i> 
												<span class="ml-3"> Anasayfa</span>
											</a>
										</li>
									</ul>
								</li>

								<li>
									<a href="haber"> 
										<i class="far fa-newspaper ml-3"></i>
										<span class="ml-3"> Haberler</span>
									</a>
								</li>
								
								<li >
									<a href="oyunincelemeler">
										<img src="images/inceleme.svg" alt="inceleme" class="inzxvvn img-fluid ml-3" >
										<span class="ml-3">İncelemeler</span>
									</a>
								</li>
								<li >
									<a  href="kuratorler">
										<i class="fas fa-crown ml-3"></i>

										<span class="ml-3">Küratörler</span>
									</a>
								</li>

								<li  >
									<a class="" href="tumoyunlar">
										<img src="images/oyun_kesfet.svg" alt="kesfet" class="inxpbn img-fluid ml-3" >
										<span class="ml-3"> Oyun Keşfet</span>
									</a>
								</li>
									<li  >
									<a class="" href="sistemineozel">
								    	<i class="fas fa-user-cog ml-3"></i>
										<span class="ml-3">Sistemine Özel Oyun Bul</span>
									</a>
								</li>
								<li  >
									<a class="" href="sozluk">
										<i class="fab fa-readme ml-3"></i>
										<span class="ml-3">Sözlük</span>
									</a>
								</li>
								<li  >
									<a class="" href="indirimler">
										<i class="fas fa-percent ml-3"></i>
										<span class="ml-3">İndirimler</span>
									</a>
								</li>
							
								<li  >
									<a class="" href="roak-video">
										<i class="fas fa-play-circle ml-3"></i>
										<span class="ml-3">Roak Game Video</span>
									</a>
								</li>
								
								<?php
								if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
								?>
									<li class="d-block d-xl-none">
										<a href="cikisyap">
											<i class="fas fa-sign-out-alt ml-3 font16" ></i> 
											<span class="ml-3"> Çıkış Yap</span> 
										</a>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</nav>
				</li>
				<li>
					<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
						<img src="images/<?php echo IcerikTemizle($SiteLogo) ?>" class="img-fluid sitelogo"  alt="Roak Game">
					</a>
				</li>
				<li class="d-none d-xl-block" >
					<a href="<?php echo IcerikTemizle($SiteLink)  ?>">
						<span>Anasayfa</span>
					</a>
				</li>
				<li class="d-none d-xl-block" >
					<a  href="haber">
						<span>Haberler</span>
					</a>
				</li>
				<li class="d-none d-xl-block " >
					<div class="dropdown ">
						<button class="dbutton" style="padding: 0 30px;"> 
							<span>İncelemeler</span>
							<i class="fas fa-angle-down ml-1"></i> 
						</button>
						<div class="dcontent">
							<a class="mylink" href="oyunincelemeler">İncelemeler</a>
							<a class="mylink" href="kuratorler">Küratörler</a>
						</div>
					</div>
				</li>
				<li class="d-none d-xl-block " >
					<div class="dropdown ">
						<button class="dbutton" style="padding: 0 30px;"> 
							<span>Oyun Keşfet</span>
							<i class="fas fa-angle-down ml-1"></i> 
						</button>
						<div class="dcontent">
							<a class="mylink" href="sistemineozel">Sistemine Özel</a>
								<a class="mylink" href="tumoyunlar">Oyunlar</a>
						</div>
					</div>
				</li>
				<li class="d-none d-xl-block" >
					<a  href="sozluk">
						<span>Sözlük</span>
					</a>
				</li>
				<li class="d-none d-xl-block" >
					<a  href="indirimler">
						<span>İndirimler</span>
					</a>
				</li>
				<?php
				if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)){
				?>
				<li class="d-none d-xl-block ">
					<div class="dropdown ">
						<button class="dbutton"> 
						<?php
						if(file_exists("images/userphoto/".$KullaniciProfilResmi) and (isset($KullaniciProfilResmi)) and ($KullaniciProfilResmi!="") ){
						?>
							<img alt="<?php echo IcerikTemizle($KullaniciAdi) ?>" src="images/userphoto/<?php echo IcerikTemizle($KullaniciProfilResmi) ?> " class="img-fluid ml-2 indxzcn" >
						<?php
						}else{
						?>
							<img src="images/user.png" class="img-fluid inxbvzx" alt="<?php echo IcerikTemizle($KullaniciAdi) ?>">
						<?php
						}
						?>
							<?php echo IcerikTemizle($KullaniciAdiSoyadi);?> 
							<i class="fas fa-angle-down"></i> 
						</button>
						<div class="dcontent">
						<?php
						if ($KullaniciKuratorDurumu==1) {
						?>
							<a class="mylink" href="kurator/<?php echo IcerikTemizle($KullaniciAdi) ?>">Küratör</a>
						<?php
						}
						?>
							<a class="mylink" href="hesabim">Hesabım</a>
							<a class="mylink" href="cikisyap">Çıkış</a>
						</div>
					</div>
				</li>
				<?php
				}else{
				?>
					<li >
						<a href="girisyap" >
							<i class="fas fa-user font20" >
							</i>
						</a>
					</li>
				<?php	
				}
				?>
			</ul>
			<script>
				new gnMenu( document.getElementById( 'gn-menu' ) );
			</script>
		</div>
	</div>

	<div class="row m-0 mt-5 "  >
		<?php
		if((!$PagesValue) or ($PagesValue =="") or ($PagesValue == 0)){
			include($Pages[0]);
		}else{
			include($Pages[$PagesValue]);
		}
		?>
	</div>
	<div class="col-12 footer">
	    <div class="row m-0  justify-content-center align-items-center  footerYazi text-center " >	
			<div class="col-12 col-md-9 mb-2 mt-4">
				<div class="row footer justify-content-center  fot  " >
					<div class="col-12 MaxWaY" >
						<div class="row justify-content-center ">
						    <div class="col-6 col-lg-3 mt-3 ">
						        <div class="row justify-content-start align-items-center text-center p-2">
						        	<div class="col-12 text-left  p-0" ><span class="bold white">Roak Game</span></div>
						            <div class="col-1 mb-3"style="border-bottom:5px solid #c28f2c">	</div>
						            <div class="col-12  mb-2 text-left p-0"><a href="bizkimiz"><span class="font13">Hakkımızda</span></a> </div>
						             <div class="col-12  mb-2 text-left p-0"><a href="editorler"><span class="font13">Editörler</span></span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="roak-video"><span class="font13">Roak Game Video</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="yardim"><span class="font13">Yardım Merkezi</span></a> </div>
						            <div class="col-12  mb-2 text-left text-xs-center text-md-left p-0"><a href="bizeulasin"><span class="font13">İletişim</span></a> </div>
						        </div>
						    </div>
						    <div class="col-6 col-lg-3 mt-3">
						        <div class="row justify-content-start align-items-center text-center p-2">
						        	<div class="col-12 text-left  p-0" ><span class="bold white">Haberler</span></div>
                                    <div class="col-1 mb-3"style="border-bottom:5px solid #c28f2c">	</div>
						            <div class="col-12  mb-2 text-left p-0"><a href="haber"><span class="font13">Tüm Haberler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="okunanhaberler"><span class="font13">Çok Okunan Haberler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="konusulanhaberler"><span class="font13">Çok Konuşulan Haberler</span></a> </div>
						        </div>
						    </div>
						     <div class="col-6 col-lg-3 mt-3">
						        <div class="row justify-content-start align-items-center text-center p-2">
						        	<div class="col-12 text-left  p-0" ><span class="bold white">İncelemeler</span></div>
						        	<div class="col-1 mb-3"style="border-bottom:5px solid #c28f2c">	</div>
						            <div class="col-12  mb-2 text-left p-0"><a href="oyunincelemeler"><span class="font13">Tüm İncelemeler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="<?php echo IcerikTemizle($SiteLink) ?>/oyunincelemeler/&Ara=&srl=1/1"><span class="font13">Popüler İncelemeler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="<?php echo IcerikTemizle($SiteLink) ?>/oyunincelemeler/&Ara=&srl=3/1"><span class="font13">Beğenilen İncelemeler</span></a> </div>
						        </div>
						    </div>
						    <div class="col-6 col-lg-2 mt-3">
						        <div class="row justify-content-start align-items-center text-center p-2">
						        	<div class="col-12 text-left  p-0" ><span class="bold white">Oyunlar</span></div>
						        	<div class="col-1 mb-3"style="border-bottom:5px solid #c28f2c">	</div>
						            <div class="col-12  mb-2 text-left p-0"><a href="tumoyunlar"><span class="font13">Tüm Oyunlar</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="populeroyunlar"><span class="font13">Popüler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="yakinda"><span class="font13">Çok Yakında</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="https://roakgame.com/tumoyunlar/&Ara=&c=ucretsiz/1"><span class="font13">Ücretsiz</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="indirimler"><span class="font13">İndirimler</span></a> </div>
						            <div class="col-12  mb-2 text-left p-0"><a href="sistemineozel"><span class="font13">Sistemine Özel Oyun Bul</span></span></a> </div>

						        </div>
						    </div>
						  </div>
					</div>
				    <div class="col-12  mb-3 foradE" >
				    	<div class="row  justify-content-start align-items-center p-1 ">
				    		<div class="col-12  col-lg-8 ">
				    			<div class="row align-items-center">
				    				<div class="col-12">
				    					<div class="row justify-content-center align-items-center">
				    						<div class="col-12 col-lg-3 text-left font18  mb-2" >
								    			<div class="row ">
								    				<div class="col-12">
								    					<a href="<?php echo IcerikTemizle($SiteLink) ?>"><span style="color: #c28f2c">roak</span><span class="bold white ">game.com</span></a>
								    				</div>
								    			</div>
								    		</div>
								    		<div class="col-6 col-lg-3 text-left mb-2">
								    			<div class="row">
								    				<div class="col-12">
									    			<a href="gizlilikpolitikasi"><span class="bold font13 ">Gizlilik Politikası</span></a>
									    			</div>
								    			</div>
								    		</div>
								    		<div class="col-6 col-lg-3 text-left mb-2">
								    			<div class="row">
								    				<div class="col-12">
								    					<a href="uyeliksozlesme"><span class="bold font13 ">Üyelik Sözleşmesi</span></a>
								    				</div>
								    			</div>
								    		</div>
								    		<div class="col-6 col-lg-3 text-left mb-2">
								    			<div class="row" >
								    				<div class="col-12">
								    					<a href="topluluk-kurallari">
								    						<span class="bold font13">Topluluk Kuralları</span>
								    					</a>
								    				</div>
								    			</div>
								    		</div>
								    		<div class="col-6 col-lg-3 text-left d-block d-lg-none mb-2">
								    			<div class="row" >
								    				<div class="col-12">
								    					<a href="bizeulasin"><span class="bold  font13">
								    						İletişim</span></a>
								    				</div>
								    			</div>
								    		</div>

				    					</div>
				    				</div>
				    			</div>
				    		</div>
				    		<div class="col-12  col-lg-4 mt-3 mb-3 mt-lg-0 mb-lg-0">
				    			<div class="row align-items-center">
				    				<div class="col-12 text-center  text-lg-right">
				    					<div class="row justify-content-center ">
				    						<div class="col-2 col-md-2">
				    							<a  ref="nofollow" rel="noreferrer" href="<?php echo IcerikTemizle($Instagram);?>" target="_blank" ><i class="fab fa-instagram font23 white mb-2"></i></a>
				    						</div>
				    						<div class="col-2 col-md-2">
				    							<a ref="nofollow" rel="noreferrer" href="<?php echo IcerikTemizle($Youtube);?>" target="_blank"><i class="fab fa-youtube font23 white mb-2"></i></a>
				    						</div>
				    						<div class="col-2 col-md-2">
				    							<a   ref="nofollow" rel="noreferrer"  href="https://discord.gg/KC5dHbWP" target="_blank"><i class="fab fa-discord font23 white mb-2"></i></a>
				    						</div>
				    						<div class="col-2 col-md-2">
				    							<a  ref="nofollow" rel="noreferrer" href="<?php echo IcerikTemizle($Twitter);?>" target="_blank" ><i class="fab fa-twitter font23 white mb-2"></i></a>
				    						</div>
				    						<div class="col-2 col-md-2">
				    							<a ref="nofollow" rel="noreferrer" href="<?php echo IcerikTemizle($Telegram);?>" target="_blank"><i class="fab fa-telegram font23 white mb-2"></i></a>
				    						</div>
				    						<div class="col-2 col-md-2">
				    							<a  ref="nofollow" rel="noreferrer" href="<?php echo IcerikTemizle($Facebook);?>" target="_blank"><i class="fab fa-facebook font23 white mb-2"></i></a>
				    						</div>
				    					</div>	
						    		</div>
				    			</div>
				    		</div>
				    	</div>
				    </div>
				    <div class="col-12 col-md-6 text-xs-center text-md-left  mt-3 p-0 ">
            		<a href="//www.dmca.com/Protection/Status.aspx?ID=9ed89843-771b-4442-8710-7a772394e351" ref="nofollow" rel="noreferrer" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/dmca_protected_sml_120m.png?ID=9ed89843-771b-4442-8710-7a772394e351"  alt="DMCA.com Protection Status" /></a>  
            		</div>
        			<div class="col-12 col-md-6 text-center text-lg-right mt-3 mb-5">
            			<span class="bold white "><?php echo IcerikTemizle($SiteCopyright);?></span>
            		</div>
				</div>
			</div>
	   </div>
	</div>
</body>
</html>
<?php
$DatabaseBaglanti =null;
ob_end_flush();
?>

