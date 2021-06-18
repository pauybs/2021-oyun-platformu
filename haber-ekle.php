
<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and (IcerikTemizle($KullaniciEditorDurumu)==1) ){

	if ($KullaniciEditorBan==1 and $KullaniciEditorBanTarih!="") {
		if ($Zaman>=$KullaniciEditorBanTarih) {
			$BanKaldir =  $DatabaseBaglanti->prepare("UPDATE uyeler SET EditorBan=?, EditorBanTarih=?  WHERE  id=?  LIMIT 1 ");
			$BanKaldir->execute([0,NULL,$KullaniciId]);
			$BanKaldirSayisi = $BanKaldir->rowCount();

			if ($BanKaldirSayisi>0) {
				header("Refresh:0");
				exit();

			}
		}
	}
	
?>

<div class=" col-12 Uizahse cvnQAAzx">
	<div class="row justify-content-center   ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
		?>
		</div>

		<div class="col-12 col-xl-10">
			<div class="row mt-5 mb-5 justify-content-center align-items-center">
				<div class="col-11 p-0">
					<h1 class="bold font15 white">Haber Ekleme</h1>
				</div>
				<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
					<div class="row  justify-content-center ">
						<div class="col-12 col-md-10 mt-5 mb-5 hbs">
							<form class=" hs " method="post"  action="javascript:void(0);"  enctype="multipart/form-data" >
								<div class="row hss justify-content-center text-center"></div>
								<div class=" mt-5">   
									<div class="col-12 text-left p-0 font13 bold white" >Haber Başlık <span class="red font12"> (Zorunlu)</span></div>      
									<input  class="white font13 p-3 hbredklfja" placeholder="Haber Başlık" type="text" name="Baslik" >
									
								</div>
								<div class=" mt-5 mb-3">   
									<div class="col-12 text-left p-0 font13 bold white" >Haber Kapak Resmi <span class="red font12"> (Zorunlu)</span></div> 
									<input type="hidden" name="img">     
									<input type="file" class="white p-3 hbresav" id="upload" accept="image/*"  name="KapakResmi" >
								</div>
								<div class="newsph"></div>
								<div class=" mt-5">   
									<div class="col-12 text-left p-0 font13 bold white">Haber Kapak Resmi Açıklama <span class="red font12"> (Zorunlu)</span></div><textarea type="text" class="white font13 hbredklfja" style="height: 100px" placeholder="Kapak Resmi Açıklama Yazısı"  name="KapakResmiA" ></textarea>
								</div>
								
						        	<div class=" mt-5 mb-4">   
									<div class="col-12 text-left p-0 font13 bold white" >Haber Etiketler <span class="red font12"> (Zorunlu)</span><span class="red font12"></span> </div>
										<input  class="white font13 p-3 hbredklfja" placeholder="Haber Etiketleri (Örnek: roakgame, roak)" type="text" name="Etiketler" >
										<div class="col-12 text-left p-0 font13 bold white opacity07" >Lütfen her etiket arasında virgül ile ayırarak ve virgülden sonra boşluk bırakarak ekleyiniz.</div>


									</div> 
									
								<div class=" mt-5"> 
									<div class="col-12 text-left p-0 font13 bold white" >İlgili Haber</div>     
									<select  class="js-example-disabled-results hbresav" style="width:100%" name="Haber"   >
									<option value="" >Haber seçiniz.</option>
									<?php
									$IlgiliHaberler = $DatabaseBaglanti->prepare("SELECT * FROM haberler WHERE Durum=? ORDER BY KayitTarihi Desc");
									$IlgiliHaberler->execute([1]);
									$IlgiliHaberlerSayisi = $IlgiliHaberler->rowCount();
									$IlgiliHaberlerKayitlar = $IlgiliHaberler->fetchAll(PDO::FETCH_ASSOC);
									if ($IlgiliHaberlerSayisi>0) {
										foreach ($IlgiliHaberlerKayitlar as $haberler){	
											?>
											<option value="<?php echo IcerikTemizle($haberler["HaberUniqid"]); ?>"   ><?php echo IcerikTemizle($haberler["AnaBaslik"]); ?></option>
											<?php
										}
									}
									?>
									</select>
								</div>
								<div class=" mt-5"> 
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
											<option value="<?php echo IcerikTemizle($oyunlar["OyunUniqid"]); ?>"   ><?php echo IcerikTemizle($oyunlar["OyunAdi"]); ?></option>
											<?php
										}
									}
									?>
									</select>
								</div>
								<div class=" mt-5">   
									<div class="col-12 text-left p-0 font13 bold white">Haber Kaynağı Url</div>      
									<input  type="text" class="white font13 p-3 hbredklfja" placeholder="Haber Kaynak Url" name="KaynakUrl" >
									<input type="hidden" name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">

								</div>
								
								<div class="col-12   text-center mt-3 hgb">
									<button class="call-to-action hg" type="submit" >
										<div>
											<div>Devam Et</div>
										</div>
									</button>
								</div>
								
								
							</form>
							<form></form>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="assets/main_e=2.1.6.js"></script>
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
	header('Location: ' .$SiteLink);
	exit();
}
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>

