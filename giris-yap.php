<?php
if(isset($_SESSION["Kullanici"] )){
	header('Location: '. $SiteLink);
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
							<input  type="password" name="Sifre" placeholder="Şifre" required>
						</div>
						<div class="bold red mt-2 mb-2 font12 aa"></div>
						<div class="g-recaptcha mb-3" data-sitekey=""></div>
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
							<input type="password" name="UyeSifre" placeholder="Şifre*"  required>
						</div>
						<div class="input-field">
							<i class="fas fa-lock"></i>
							<input type="password" name="UyeSifreTekrar"  placeholder="Şifre-(Tekrar)*"  required>
						</div>
						<div class="row text-left p-0 align-items-center mt-1 ">   
							<div class="col-2 col-xl-1 p-2 text-center">
								<input style="background-color: rgb(245,245,245,1);" type="radio" name="SozlesmeOnay" value="1" id="SozlesmeOnay"    required>
							</div>
							<div class="col-10 col-xl-11  font12" >
								<span class="bezZX">Okudum ve onaylıyorum</span> 
								<span>
									<a class="xwezZX " style="color: white" href="uyeliksozlesme" target="_blank"> Üyelik Sözleşmesi</a>
								</span>
							</div>
						</div>
						<div class="ub">
							<button class="call-to-action mt-3 uye"  type="submit">
								<div style="background: #c28f2c">
									<div>Aktivasyon</div>
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
					<img src="images/<?php echo $GirisYap ?>" class="image" alt="" />
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
					<img src="images/<?php echo $UyeOl ?>" class="image" alt="" />
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('click' , '.uye', function() {
		var duzenli =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if ( duzenli.test( $("input[name=UyeMail]").val() ) == false ) {
			$("input[name=UyeMail]").css({"border": "2px solid red"});
			return false; 
		}else{
			$("input[name=UyeMail]").css({"border": "none"});
			$.ajax({
				type:"post", 
				url:"uyeol_s.php",
				data:$(".uyes").serialize(), 
				beforeSend: function() {
					$(".ub").html("<button class='call-to-action mt-3 '  ><div style='background: #c28f2c'><div ><div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div></div></div></div></button>");
				}, 
				success:function(cevap){
					$(".ub").html("	<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Aktivasyon</div></div></button>");
					if (cevap==1) {
						$(".uyelik").html(' <div class="row text-center justify-content-center align-items-center mb-1" style="background:#D54841; width: 380px;height: 50px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Lütfen üyelik sözleşmesini onaylayınız.</span> </div></div>'); 
					}else if (cevap==2){
						$(".uyelik").html(' <div class="row text-center justify-content-center align-items-center mb-1" style="background:#D54841; width: 380px;height: 50px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Şifreler uyuşmuyor.</span> </div></div>'); 
					}else if (cevap==3){
						$(".uyelik").html('	<div class="row text-center justify-content-center align-items-center mb-1" style="background:#D54841; width: 380px;height: 50px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Şifreniz en az 6 karakter uzunluğunda olmalıdır.</span> </div></div>'); 
					}else if(cevap==4){
						$(".uyelik").html('<div class="row text-center mb-1" style="background:#D54841; max-width: 380px;height: 80px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Bu e-posta adresi ile daha önce kayıt olunmuştur.</span> </div><div class="col-12"><span style="color:white;font-size:13px">Şifremi unuttum seçeneğini kullanabilirsiniz.</span> </div></div>'); 
					}else if (cevap==5){
						$(".uyelik").html('<div class="row text-center justify-content-center align-items-center mb-1" style="background:#D54841; width: 380px;height: 50px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Bu kullanıcı adı kullanılmaktadır.</span> </div></div>'); 
					}else if(cevap==6){
						$(".uyelik").html('<div class="row text-center justify-content-center align-items-center mb-1" style="background:#D54841; width: 380px;height: 50px;"><div class="col-12"><span style="font-weight:bold;color:white;opacity:0.8;font-size:14px">Lütfen zorunlu (*) alanları doldurunuz.</span> </div></div>'); 
					}else{
						$(".uyelik").html('');
						$(".uyes").html(cevap);
					}	
						
				}
			}); 
		}    
	});


	$('body').on('click' , '.giris', function() {
		var duzenli =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if ( duzenli.test( $("input[name=Mail]").val() ) == false ) {
			$("input[name=Mail]").css({"border": "2px solid red"});
			return false; 
		}else{
			$("input[name=Mail]").css({"border": "none"});
			$.ajax({
				type:"post", 
				url:"giris_s.php",
				data:$(".giriss").serialize(), 
				beforeSend: function() {
					$(".gb").html("<button class='call-to-action mt-3 '  ><div style='background: #c28f2c'><div ><div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div></div></div></div></button>");
				}, 
				success:function(cevap){
					$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>');
					if (cevap=="error") {
						var id = $('.g-recaptcha').attr('id');
						grecaptcha.reset(id);
						$(".aa").html("Güvenlik kontrolü hatası");
					}else{
						$(".aa").html(" ");
						var id = $('.g-recaptcha').attr('id');
						grecaptcha.reset(id);
						$(".girisyap").html(cevap);
					}
				}
			}); 
		}    
	});
});   
</script>

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
?>


