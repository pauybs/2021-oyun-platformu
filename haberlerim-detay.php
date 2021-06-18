<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_GET["Haber"])  and isset($_SESSION["Kullanici"] ) and ($KullaniciEditorDurumu==1)  and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ){
$HaberId=Guvenlik($_GET["Haber"]);
$HaberSorgu =  $DatabaseBaglanti->prepare("SELECT * FROM  haberler WHERE  HaberUniqid=? AND Durum!=? and Durum!=? and Durum!=?  AND Editor=?");
$HaberSorgu->execute([$HaberId,0,2,4,Guvenlik($KullaniciId)]);
$VeriSayisi = $HaberSorgu->rowCount();
$HaberKayit = $HaberSorgu->fetch(PDO::FETCH_ASSOC);
if ($VeriSayisi>0) {
?>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center   ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>
			
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1  class="bold font15 white"><?php  echo IcerikTemizle($HaberKayit["AnaBaslik"]) ?> Haberi </h1>
					</div>
					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
						<div class="row justify-content-center ">
							<div class="col-12 mt-5" >
								<div class="col-12 mb-4 mt-4  text-left" style="border-left: 5px solid #c28f2c"><h5 class="bold white mt-4">Haber Kapak Resmi</h5> </div>
								<form class="hrgf p-2" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data"  >
									<div class="row justify-content-center bvc_zZ" >
										<div class="col-12  justify-content-center  yorumk ">
											<div class="row justify-content-center hrgs"> </div>
										</div>
										<div class="col-12 ">
											<div class="row">
												<div class="col-12  mt-4 ">   
													<div class="col-12 text-left p-0 font13 bold white" >Haber Kapak Resmi <span class="red font12">(Zorunlu)</span></div>  
													<input type="hidden" name="img">     
													<input class="p-3 hbdxXzx" type="file" id="upload2" accept="image/*"  name="KapakResmi" >
													<input  type="hidden" name="h" value="<?php echo IcerikTemizle($HaberKayit["id"]) ?>" >
													<input  type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId) ?>" >

													<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">    

												</div>
												<div class="newsph"></div>
											</div>
										</div>
										
								
										<div class="col-12   text-center mb-3 mt-2 hkrb">
											<button class="call-to-action hrg" type="submit" >
												<div>
													<div>Değiştir</div>
												</div>
											</button>
										</div>		
									</div>
								</form>
							</div>
							<div class="col-12 mt-5" >
								<div class="col-12 mb-4 mt-4  text-left" style="border-left: 5px solid #c28f2c"><h5 class="bold white mt-4">Haber Bilgiler</h5> </div>
								<form class=" hb p-2" method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data"  >
									<div class="row justify-content-center bvc_zZ">

										<div class="col-12  justify-content-center  yorumk ">
											<div class="row justify-content-center hbg"> </div>
										</div>
										<div class="col-12 col-xl-6">
											<div class="row">
												<div class="col-12  mt-4 ">   
													<div class="col-12  text-left p-0 font13 bold white" >Haber Başlığı <span class="red font12">(Zorunlu)</span></div>      
													<input class="p-3 hbdxXzx" type="text" name="HaberBaslik" value="<?php echo IcerikTemizle($HaberKayit["AnaBaslik"]) ?>">
													<input  type="hidden" name="h" value="<?php echo IcerikTemizle($HaberKayit["id"]) ?>" >

												</div>
											</div>
											<div class="row">
												<div class="col-12  mt-4">   

													<div class="col-12  text-left p-0 font13 bold white">Haber Etiketler <span class="red font12">(Zorunlu)</span></div>  
													<input class="p-3 hbdxXzx" type="text" name="Etiketler" value="<?php echo IcerikTemizle($HaberKayit["Etiketler"]) ?>">



												</div>
											</div>
											<div class="row mt-4">
												<div class="col-12  mt-2">   
													<div class="col-12 text-left p-0 font13 bold white" >Haber Kaynak Url</div>      
													<input class="p-3 hbdxXzx" type="text" name="KaynakUrl" value="<?php echo IcerikTemizle($HaberKayit["KaynakUrl"]) ?>">
													<input  type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId) ?>" >	
												</div>
											</div>
										</div>
										<div class="col-12 col-xl-6">
											<div class="row">
												<div class="col-12  mt-4 mb-4">   
													<div class="col-12  text-left p-0 font13 bold white" >Haber Kapak Resmi Açıklama <span class="red font12">(Zorunlu)</span></div>      
													<textarea class="hbdxssaXzx" type="text" name="Aciklama" ><?php echo IcerikTemizle($HaberKayit["AnaAciklama"]) ?></textarea> 
													<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">    

												</div>
												<div class="col-12 mt-2"> 
                									<div class="col-12 text-left p-0 font13 bold white" >İlgili Haber</div>     
                									<select  class="js-example-disabled-results hbdxXzx" style="width:100%" name="Haber"   >
                									<option value="" >Haber seçiniz.</option>
                									<?php
                									$IlgiliHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? and HaberUniqid!=? ORDER BY KayitTarihi Desc");
                									$IlgiliHaberler->execute([1,$HaberKayit["HaberUniqid"]]);
                									$IlgiliHaberlerSayisi = $IlgiliHaberler->rowCount();
                									$IlgiliHaberlerKayitlar = $IlgiliHaberler->fetchAll(PDO::FETCH_ASSOC);
                									if ($IlgiliHaberlerSayisi>0) {
                										foreach ($IlgiliHaberlerKayitlar as $haberler){	
                										?>
                										<option value="<?php echo IcerikTemizle($haberler["HaberUniqid"]); ?>"  <?php  if( IcerikTemizle($HaberKayit["IlgiliHaber"] )== IcerikTemizle($haberler['HaberUniqid']) ){  ?> selected="selected"<?php } ?>   ><?php echo IcerikTemizle($haberler["AnaBaslik"]); ?></option>
                										<?php
                										}
                									}
                									?>
                									</select>
                								</div>
                								<div class="col-12 mt-3"> 
                									<div class="col-12 text-left p-0 font13 bold white" >İlgili Oyun</div>     
                									<select  class="js-example-disabled-results hbresav" style="width:100%" name="Oyun"   >
                									<option value="" >Oyun seçiniz.</option>
                									<?php
                									$IlgiliOyunlar = $DatabaseBaglanti->prepare("SELECT * FROM oyunlar WHERE Durum=? ORDER BY CikisTarihi Desc");
                									$IlgiliOyunlar->execute([1]);
                									$IlgiliOyunlarSayisi = $IlgiliOyunlar->rowCount();
                									$IlgiliOyunlarKayitlar = $IlgiliOyunlar->fetchAll(PDO::FETCH_ASSOC);
                									if ($IlgiliOyunlarSayisi>0) {
                										foreach ($IlgiliOyunlarKayitlar as $oyunlar){	
                											?>
                											<option value="<?php echo IcerikTemizle($oyunlar["OyunUniqid"]); ?>"   <?php  if( IcerikTemizle($HaberKayit["IlgiliOyun"] )== IcerikTemizle($oyunlar['OyunUniqid']) ){  ?> selected="selected"<?php } ?>  ><?php echo IcerikTemizle($oyunlar["OyunAdi"]); ?></option>
                											<?php
                										}
                									}
                									?>
                									</select>
                								</div>
											</div>
										</div>
										<div class="col-12 text-center mb-3 mt-4 ">
											<button class="call-to-action hbd" type="submit" >
												<div>
													<div>Kaydet</div>
												</div>
											</button>
										</div>	
									</div>
								</form>
							</div>

							<div class="col-12 mt-5 mb-5 p-4">
								<div class="row">
									<div class="col-12 col-md-12 hbs mt-4">
										<div class="col-12 mb-4 mt-4  text-left" style="border-left: 5px solid #c28f2c"><h5 class="bold white mt-4">İçerik Ekle</h5> </div>
										<div class="row " >
											<div class="col-12 cvEWZZ_zZx" >
												<form class=" hie " method="post" id="singnupFrom" action="javascript:void(0);"  enctype="multipart/form-data"  >
													<div class="row justify-content-center yorumk hss mt-3"></div>
													<div class=" mt-4 mb-4">   
														<div class="col-12 text-left p-0 font13 bold white">İçerik Başlık</div>      
														<input class="p-3 hbdxXzx"  type="text" name="IcerikBaslik" >
														<input  type="hidden" name="h" value="<?php echo IcerikTemizle($HaberKayit["id"]) ?>" >		
														<input type="hidden" name="ui" value="<?php echo IcerikTemizle($HaberId) ?>">    

													</div>
												
													<div class=" mb-4 "> 
													<div class="col-12  yorumk hrs"></div> 
													<div class="col-12 text-left p-0 font13 bold white" >İçerik Resmi</div>  
													<input type="hidden" name="img">    
													<input type="file" class="white p-3 hbresav" id="upload" accept="image/*" name="IcerikResmi">
													</div>
													<div><div class="col-12 icrkph"></div></div>
													<div class=" mt-4 mb-4">   
														<div class="col-12 text-left p-0 font13 bold white">İçerik Video Id <span class="white opacity05 font12">( Sadece Youtube Video Id'si )</span></div>      
														<input class="p-3 hbdxXzx"  type="text" name="IcerikVideo" maxlength="11" >
														
													</div>


													<div class="" >
													<div class="col-12 text-left p-0 font13 bold white" >İçerik Yazısı <span class="red font12">(Zorunlu)</span></div>      	  
													<textarea class="ckeditor" id="ckeditor1" name="Yazi"></textarea>
													<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">    

												</div>

													<div class="col-12 text-center yorumk iy mb-1"></div>
													<div class="col-12   text-center mb-4 hiyb mt-4">
														<button class="call-to-action hig" type="submit" >
															<div>
																<div> Yükle</div>
															</div>
														</button>
													</div>
												</form>
											</div>
										</div>
									</div>	

									<div class="col-12 col-md-12 mt-5  "  >
										<div class="col-12 text-left mb-4 mt-5" style="border-left: 5px solid #c28f2c"><h5  class="bold white">Eklenen İçerikler</h5> </div>
										<div class="row justify-content-center  zxzaYAZNzcxZ  ">


										<?php
										$HaberResimleri = $DatabaseBaglanti->prepare("SELECT * FROM haberresimler WHERE HaberId=? and Editor=? and Durum=? ORDER BY id ASC");
										$HaberResimleri->execute([Guvenlik($HaberKayit["id"]),Guvenlik($KullaniciId),1]);
										$HaberResimleriSayisi = $HaberResimleri->rowCount();
										$HaberResimleriKayitlar = $HaberResimleri->fetchAll(PDO::FETCH_ASSOC);
										if ($HaberResimleriSayisi>0) {
											foreach ($HaberResimleriKayitlar as $kayitlar) {
										?>
											<div class="col-12 col-md-11">
												<div class="row p-1">
													<div class=" col-12  mb-2 " id="i<?php echo $kayitlar["id"] ?>"  >
														<div class="row  justify-content-center   pt-3  mb-2" >
															<div class="col-12 col-xl-11  text-center" >
															<?php
															if (IcerikTemizle($kayitlar["Resim"]) and file_exists("images/news/contents/".$kayitlar["Resim"])) {
															?>
																<img src="images/news/contents/<?php echo IcerikTemizle($kayitlar["Resim"]) ?>"  class="img-fluid " >
															<?php
															}else{
															?>
																<img src="images/icerik.jpg"  class="img-fluid " >
															<?php
															}
															?>
															</div>
															<div class="col-12">
																<div class="row justify-content-center  font25 mt-2">

																	
																		<i  style="cursor:pointer" class="fas fa-trash-alt his white mr-5 mt-2" data-id="<?php echo Iceriktemizle($_SESSION["Jeton"]) ?>" data="<?php echo $kayitlar["id"] ?>" > </i>
																		
																		<a href="icerikdetay/<?php echo IcerikTemizle($KullaniciAdi)?>/<?php echo  SEO(IcerikTemizle($HaberKayit["AnaBaslik"]));?>/<?php echo IcerikTemizle($HaberId) ?>/<?php echo IcerikTemizle($kayitlar["id"]) ?>">
																			<span><i class="fas fa-edit white"></i></span>
																		</a>
																	
																	
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?php
												}
											}else{
											?>
												
											<?php
											}
											?>
											<div class="col-12 col-md-11">
												<div class="row ghi p-1"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="assets/main_mnd=2.4.12.js"></script>
		<script src="settings/ckeditor/ckeditor.js"></script>
			<script src="settings/croppie.js"></script>

	<link href="settings/select2.min.css" rel="stylesheet" />
	<script src="settings/select2.min.js"></script>

<script type="text/javascript">
		var $disabledResults = $(".js-example-disabled-results");
	$disabledResults.select2();
	</script>
<style type="text/css"> 
	.select2-container--default .select2-selection--single {background:#202020 !important;width: 100%;color:white;border:none !important; }
</style>
	
<?php
}else{
	header('Location:'.$SiteLink);
	exit();
}
}else{
	header('Location:'.$SiteLink);
	exit();
}
}else{
	header('Location:'.$SiteLink);
	exit();
}
?>

	

