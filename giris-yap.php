<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  ){
	header('Location: ' .$SiteLink);
	exit();	
	?>
	<?php
}else{
?>
<div class="col-xl-12">
	<div class="row justify-content-center  ">
		<div class="ZXCVXCV Uyelik">
			<div class="forms-container">
				<div class="signin-signup ">
					<form action="javascript:void(0);" method="post" class="sign-in-form giriss">
						<div class=" girisyap"></div>
						<div class="input-field">
							<i class="fas fa-user"></i>
							<input  type="email" name="Mail" placeholder="E-Posta" required>
						</div>
						<div class="input-field">
							<i class="fas fa-lock"></i>
							<input  type="password" name="Sifre"  placeholder="Şifre" id="password"  required>
							<div class="col-11 position-absolute text-right">
								<i class="fas fa-eye white circular eye link icon white position-absolute" id="pass"></i>
</div>
						</div>
						<div class="bold red mt-2 mb-2 font12 aa"></div>
						<div class="g-recaptcha  rpcHAZ" data-sitekey="6Lf5VHoaAAAAAMyNXUg7K_Ne6T7dzGK96o4tRnIT" ></div>
						<script src="assets/main.js"></script>

						<a class="ArhQqWwZx font12" style="color: white" href="sifremiunuttum"><span>Şifremi unuttum?</span> </a>
						<div class="gb">
							<button class="call-to-action mt-3 giris" type="submit">
								<div style="background: #c28f2c">
									<div >Giriş Yap</div>
								</div>
							</button>
						</div>
						<span class="d-block d-xl-none bold opacity05 white font12">Hesabın yok mu?</span>
						<span id="sign-up-btn2" class="ArhQqWwZx d-block d-xl-none font12" style="color: white;cursor:pointer;">Üye Ol</span>
					</form>

					<form action="javascript:void(0);" method="post" class="sign-up-form uyes">
						<div class="uyelik"></div>
						<div class="input-field">
							<i class="fas fa-envelope"></i>
							<input type="email" name="UyeMail"  placeholder="E-Posta*"  required>
						</div>
						<div class="input-field">
							<i class="fas fa-user"></i>
							<input type="text" name="UyeAdSoyad" placeholder="Ad Soyad*"  required>
						</div>
						<div class="input-field">
							<i class="fas fa-user"></i>
							<input type="text" name="UyeKullaniciAdi" placeholder="Kullanıcı Adı*"  required>
						</div>
						<div class="input-field">
							<i class="fas fa-lock"></i>
							<input type="password" name="UyeSifre"  placeholder="Şifre*" id="password1" required>
							<div class="col-11 position-absolute text-right">
								<i class="fas fa-eye white circular eye link icon white position-absolute" id="pass1"></i>
</div>
						</div>
						<div class="input-field">
							<i class="fas fa-lock"></i>
							<input type="password" name="UyeSifreTekrar" id="password2"  placeholder="Şifre-(Tekrar)*"  required>
							<div class="col-11 position-absolute text-right">
								<i class="fas fa-eye white circular eye link icon white position-absolute" id="pass2"></i>
</div>
						</div>
						<div class="row text-left p-0 justify-content-center align-items-center mt-1 ">   
							<div class="col-2 col-xl-1 p-2 text-center">
								<input style="background-color: rgb(245,245,245,1);" type="radio" name="SozlesmeOnay" value="1" id="SozlesmeOnay"    required>
							</div>
							<div class="col-9 col-xl-9  font12" >
								<span class="bezZX">Okudum ve onaylıyorum</span> 
								<span>
									<a class="xwezZX " style="color: white" href="uyeliksozlesme" target="_blank"> Üyelik Sözleşmesi,</a>
								</span>
								<span>
									<a class="xwezZX " style="color: white" href="gizlilikpolitikasi" target="_blank"> Gizlilik Politikası</a>
								</span>
								<span>
									<a class="xwezZX " style="color: white" href="topluluk-kurallari" target="_blank"> Topluluk Kuralları</a>
								</span>
							</div>
						</div>
						<div class="ub">
							<button class="call-to-action mt-3 uye"  type="submit">
								<div style="background: #c28f2c">
									<div>Üye Ol</div>
								</div>
							</button>
						</div>
						<span class="d-block d-xl-none bold opacity05 white font12">Hesabın var mı?</span>
						<span id="sign-in-btn2" class="ArhQqWwZx d-block d-xl-none font12" style="color: white;cursor:pointer;">Giriş Yap</span>
					</form>
				</div>
			</div>

			<div class="panels-container">
				<div class="d-none d-xl-block panel left-panel">
					<div class="content">
						<h3 class="bold font13">Hey sen!</h3>
						<span class="bold font14">Oyunlar hakkında en güncel bilgileri kaçırmak istemiyorsan</span>
						<div class="col-12 text-center mt-1 ">
							<button class="call-to-action3" id="sign-up-btn">
								<div>
									<div>ÜYE OL</div>
								</div>
							</button>
						</div>
					</div>
					<img src="images/<?php echo IcerikTemizle($GirisYap) ?>" class="image" alt="" />
				</div>
				<div class="d-none d-xl-block panel right-panel">
					<div class="content">
						<h3 class="bold font13">Zaten aramızda mısın?</h3>
						<span class="bold font14" >Ne duruyorsun giriş yapsana.</span>
						<div class="col-12 text-center mt-1 ">
							<button class="call-to-action3" id="sign-in-btn">
								<div>
									<div>Giriş Yap</div>
								</div>
							</button>
						</div>	
					</div>
					<img src="images/<?php echo IcerikTemizle($UyeOl) ?>" class="image" alt="" />
				</div>
			</div>
		</div>
	</div>
</div>
	<script src='https://www.google.com/recaptcha/api.js'></script>


<script type="text/javascript">
$(document).ready(function(){
	const sign_in_btn = document.querySelector("#sign-in-btn");
	const sign_up_btn = document.querySelector("#sign-up-btn");
	const sign_in_btn2 = document.querySelector("#sign-in-btn2");
	const sign_up_btn2 = document.querySelector("#sign-up-btn2");
	const container = document.querySelector(".ZXCVXCV");
	sign_up_btn.addEventListener("click", () => {
		container.classList.add("sign-up-mode");
	});
	sign_in_btn.addEventListener("click", () => {
		container.classList.remove("sign-up-mode");
	});
	sign_up_btn2.addEventListener("click", () => {
		container.classList.add("sign-up-mode");
	});
	sign_in_btn2.addEventListener("click", () => {
		container.classList.remove("sign-up-mode");
	});
});
</script>

<?php
}

}else{
    header("location:".$SiteLink);
    exit();
}
?>


