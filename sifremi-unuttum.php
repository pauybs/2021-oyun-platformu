<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail) and basename($_SERVER['PHP_SELF'])!=basename(__FILE__)  ){
  header('Location: '.$SiteLink);
  exit();
?>
<?php
}else{
?>
<div class="col-12">
    <div class="row justify-content-center mt-3 mb-5">
      <div class="col-11 p-2 col-md-5 mt-5 mb-5 ss"> 
        <div class="col-12 text-center mt-5"> 
          <span class="bold font20 white">ŞİFREMİ UNUTTUM</span>  
        </div>
        <div class="col-12 text-center">
          <p class="bold white opacity05 font14">Şifre sıfırlama talebi, e-posta adresinize gönderilecektir.</p>
        </div>
        <form  method="post" action="javascript:void(0);" class="unuttums">
          <div class="mt-4 row justify-content-center">
              <div class="col-10 col-md-6"> 
                <div class="  sifremiunuttum"></div>
                <div class=" p-0 input-field">
                  <i class="fas fa-envelope"></i>
                  <input type="email" name="Mail" placeholder="E-Posta Adresiniz*" required>
                </div>
              </div>
              <div class="col-12">
                <div class="row justify-content-center text-center">
                    <div class="bold col-12 red mb-1 font12 aa"></div>
                    <div class="g-recaptcha mb-3 rpcHAZ" data-sitekey="6Lf5VHoaAAAAAMyNXUg7K_Ne6T7dzGK96o4tRnIT"></div>
                    <script src="assets/main.js"></script>
                </div>
              </div>
          </div>
          <div class="col-12   text-center mb-5 us">
            <button class="call-to-action  unuttum"  type="submit">
              <div style="background: #c28f2c">
                <div>Gönder</div>
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
}
?>
