<?php
require_once("settings/connect.php");

if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)  ){
  header('Location: '.$SiteLink);
  exit();
?>
<?php
}else{
?>
  <?php
    if(isset($_GET["aktivasyon"])){
      $Aktivasyon= Guvenlik($_GET["aktivasyon"]);
    }else{
      $Aktivasyon="";
    }

    if(isset($_GET["email"])){
      $Mail= Guvenlik($_GET["email"]);
      
    }else{
      $Mail="";
    }

    if(($Mail!="") and  ($Aktivasyon!="") ){
      $UyeKontrol = $DatabaseBaglanti->prepare("SELECT * FROM uyeler WHERE Email= ?  AND AktivasyonKodu= ? AND Durum=?");
      $UyeKontrol->execute([$Mail,$Aktivasyon,1]);
      $Veri = $UyeKontrol->rowCount();
      $UyeKayitlar = $UyeKontrol->fetch(PDO::FETCH_ASSOC);
    if ($Veri>0) {
?>
<div class="col-12 mb-5">
  <div class="row justify-content-center mt-5 mb-5">
    <div class="col-12 col-md-5 mb-5 mt-5  yss"> 
        <div class="col-12 text-center mt-2" > <h5 class="bold white" >YENİ ŞİFRE OLUŞTUR</h5>  </div>
          <div class="row justify-content-center ss text-center"></div>
            <form class=" ys mb-4" method="post" id="singninFrom" action="javascript:void(0);">
              <div class=" mt-3"> 
                <div class="col-12 text-left p-0 white bold" >Şifre<span class="red">*</span></div>  
                 <div class="col-10 col-md-11 text-right position-absolute">         
                      <i class="fas fa-eye white circular eye link icon white position-absolute" id="pass" style="line-height: 50px"></i>
                    </div>   
                <input type="password" class="p-3 ynsZXx_Ad"  placeholder="Yeni Şifrenizi Giriniz." id="password" name="Sifre"   >
                <input type="hidden" name="m" value="<?php echo $Mail ?>">
              </div>
              <div class=" mt-4"> 
                <div class="col-12 text-left p-0 white bold" >Şifre(Tekrar)<span style="color:red">*</span></div>  
                 <div class="col-10 col-md-11 text-right position-absolute">         
                      <i class="fas fa-eye white circular eye link icon white position-absolute" id="pass1" style="line-height: 50px"></i>
                    </div>   
                <input type="password" class="p-3 ynsZXx_Ad" placeholder="Yeni Şifrenizi Tekrar Giriniz." id="password1"  name="SifreTekrar"    >
                 <input type="hidden" name="a" value="<?php echo $Aktivasyon ?>">

              </div>
              
              <div class="row justify-content-center  mt-4 text-center">
                <div class="col-12">
                   <div class=" bold red mt-2 mb-2 font12 aa"></div>
                </div>
                <div class=" d-none d-md-block col-md-3"></div>
                <div class="col-12 col-md-4"> <div class=" g-recaptcha mb-3" data-sitekey="6Lf5VHoaAAAAAMyNXUg7K_Ne6T7dzGK96o4tRnIT"></div></div>
                <script src="assets/main.js"></script>

                <div class=" d-none d-md-block col-md-4"></div>
              </div>
              <div class="col-12   text-center mt-3 ysg">
                <button class="call-to-action" type="submit">
                  <div>
                    <div>Kaydet</div>
                  </div>
                </button>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
	<script src='https://www.google.com/recaptcha/api.js'></script>

<?php
}else{
    header('Location: '.$SiteLink);
    exit();
  }
}else {
header('Location:'.$SiteLink);
    exit();
}
?>
<?php
}
?>

