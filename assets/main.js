$(document).ready(function(){$("body").on("click",".roo",function(){i=$(this).attr("data-id"),j=$(this).attr("data"),$(".ooi").html(" "),$.ajax({type:"post",url:"oyunoner",dataType:"json",data:{j:j,i:i},success:function(t){"success"==t.statu&&""!=t.game&&""!=t.img&&""!=t.name&&""!=t.gamename?$(".ooi").html('<div class="row justify-content-center"><div class="col-8   "><div class="row p-2"><div class="col-12 p-0" style="background: black"><a href="oyundetay/'+t.name+"/"+t.game+'"><img  src="images/games/'+t.img+'" alt="'+t.gamename+'" title="'+t.gamename+'" class="img-fluid  oyunlar wWfVCA a"></a></div><div class="col-12 p-0  mt-2  arwWxZxyBG"  ><a style="color: white" href="oyundetay/'+t.name+"/"+t.game+'"><h6 class="oyunAdi bold yaziAlan">'+t.gamename+'</h6></a></div><div class="col-12 text-center mt-3 "><a href="oyundetay/'+t.name+"/"+t.game+'"><button class="call-to-action2" id="sign-up-btn"><div><div>Oyuna Git</div></div></button></a></div></div></div></div>'):"null"==t.statu&&$(".ooi").html('<div class="row justify-content-center"><div class="col-12   text-center"><img src="images/cry.png" class="img-fluid"></div><div class="col-12  mt-4 mb-3 text-center"><h5 class="bold white">Bu kategoride sisteminize uygun hiçbir oyun bulunamadığı için rastgele oyun öneremiyoruz. Başka kategorilere bakmanızı tavsiye ederiz.</h5></div></div>\t\t')}})}),$("body").on("click",".kse",function(){$.ajax({type:"post",url:"kuratorsikayet",dataType:"json",data:$(".ksg").serialize(),success:function(t){"error"==t.statu?swal({title:"Şikayetiniz Alınamadı.",icon:"error",buttons:[!1,"Tamam"]}):"null"==t.statu?swal({title:"Şikayetinizi boş bırakmayınız.",icon:"warning",buttons:[!1,"Tamam"]}):"character"==t.statu?swal({title:"Şikayetiniz 250 karakterden uzun olamaz.",icon:"error",buttons:[!1,"Tamam"]}):"success"==t.statu&&($(".kss").fadeOut(),$(".ksb").fadeOut(),$(".ksb").html('<div class="row "><div class="col-12  "><div class="row"><div class="col-12   text-center mt-3"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 font20 white"><p>Şikayetiniz Alınmıştır.</p>\t</div></div></div></div>').hide().fadeIn(),$(".ksg").trigger("reset"),$(".ksg").fadeOut())}})}),$("body").on("click",".keb",function(){$(".kss").fadeOut(),$(".ksb").fadeOut(),$(".ksg").fadeIn()}),$("body").on("click",".uye",function(){if(0==$.Mail($("input[name=UyeMail]").val()))return $("input[name=UyeMail]").css({border:"2px solid red"}),!1;$("input[name=UyeMail]").css({border:"none"}),$.ajax({type:"post",url:"uyeol",dataType:"json",data:$(".uyes").serialize(),beforeSend:function(){$(".ub").html("<button class='call-to-action mt-3 '  ><div style='background: #c28f2c'><div ><div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div></div></div></div></button>")},success:function(t){"contract"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Lütfen sözleşmeyi okuyup onaylayınız.",icon:"warning",buttons:[!1,"Tamam"]})):"password"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Şifreler uyuşmuyor.",icon:"warning",buttons:[!1,"Tamam"]})):"mail"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Geçersiz E-posta Adresi",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})):"longmail"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:" E-posta Adresi Çok Uzun",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})):"lsusername"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Kullanıcı adı 4 ila 72 karakter arasında  olmalıdır.",icon:"warning",buttons:[!1,"Tamam"]})):"longname"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Ad ve Soyad Çok Uzun",icon:"warning",buttons:[!1,"Tamam"]})):"password2"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Şifreniz  6 ila 72  karakter arasında olmalıdır.",icon:"warning",buttons:[!1,"Tamam"]})):"registered"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Bu e-posta adresi ile daha önce kayıt olunmuştur.",icon:"warning",buttons:[!1,"Tamam"]})):"username"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Bu kullanıcı adı kullanılmaktadır.",icon:"warning",buttons:[!1,"Tamam"]})):"null"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),swal({title:"Lütfen zorunlu (*) alanları doldurunuz.",icon:"warning",buttons:[!1,"Tamam"]})):"error"==t.statu?($(".ub").html("\t<button class='call-to-action mt-3 uye'  type='submit'><div style='background: #c28f2c'><div>Üye Ol</div></div></button>"),$(".uyelik").html(""),swal({title:"Üyelik İşleminiz Tamamlanamadı.",text:"Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})):"success"==t.statu&&($(".uyelik").html(""),$(".uyes").html('<div class="row justify-content-center m-0  "><div class="col-12 col-md-10" ><div class="row justify-content-center "><div class="col-12   text-center mt-5"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 IletisimYazi white"><p>Aramıza Hoşgeldin.</p><p>Üyeliğin başarıyla tamamlanmıştır. Oyun dünyasına ait her şeyi burada bulabileceksin.</p></div></div></div></div>'))}})}),$("body").on("click",".giris",function(){if(0==$.Mail($("input[name=Mail]").val()))return $("input[name=Mail]").css({border:"2px solid red"}),!1;$("input[name=Mail]").css({border:"none"}),$.ajax({type:"post",url:"uyegiris",dataType:"json",data:$(".giriss").serialize(),beforeSend:function(){$(".gb").html("<button class='call-to-action mt-3 '  ><div style='background: #c28f2c'><div ><div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div></div></div></div></button>")},success:function(t){if("recaptcha"==t.statu){$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>');var a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Recaptcha doğrulama hatası. Tekrar deneyiniz",icon:"warning",buttons:[!1,"Tamam"]})}else if("success"==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),setTimeout(function(){window.location="index.php"},500)}else if("error"==t.statu){$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Üye girişi yapılamadı.",text:"Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})}else if("null"==t.statu){$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Hesap bulunamadı",text:"Girdiğiniz bilgiler ile herhangi bir hesabı eşleştiremedik, kontrol edip tekrar deneyiniz.",icon:"warning",buttons:[!1,"Tamam"]})}else if("LoginError"==t.statu){$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Hatalı şifre veya e-posta adresi girdiniz.",text:"Bilgilerinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})}else if("mail"==t.statu){$(".gb").html('<button class="call-to-action mt-3 giris" type="submit" ><div style="background: #c28f2c"><div >Giriş Yap</div></div></button>'),$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Geçersiz E-posta Adresi",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})}}})}),$("body").on("click",".ig",function(){if(0==$.Mail($("input[name=Mail]").val()))return $("input[name=Mail]").css({border:"2px solid red"}),!1;swal({title:"Mesajını göndermek istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&($("input[name=Mail]").css({border:"none"}),$.ajax({type:"post",url:"iltsm",dataType:"json",data:$(".iletisims").serialize(),beforeSend:function(){$(".igb").html('<button class="call-to-action " ><div><div><div class="spinner-border text-warning" role="status"><span class="sr-only"></span></div></div></div></button>')},success:function(t){if("recaptcha"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');var a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Recaptcha doğrulama hatası. Tekrar deneyiniz",icon:"warning",buttons:[!1,"Tamam"]})}else if("null"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Lütfen zorunlu alanları (*) doldurunuz",icon:"warning",buttons:[!1,"Tamam"]})}else if("longmail"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:" E-posta Adresi Çok Uzun",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})}else if("konu"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Konu 100 karakterden fazla olmamalı",icon:"warning",buttons:[!1,"Tamam"]})}else if("mesaj"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Mesajınız 11000 karakterden fazla olmamalı",icon:"warning",buttons:[!1,"Tamam"]})}else if("longname"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Ad ve Soyad Çok Uzun",icon:"warning",buttons:[!1,"Tamam"]})}else if("success"==t.statu){a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),$(".iss").html('<div class="row justify-content-center m-0 mt-5 mb-5 "><div class="col-12 col-md-10"><div class="row justify-content-center "><div class="col-12   text-center mt-5"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 IletisimYazi black"><p >Mesajınız İletilmiştir.</p><p>En kısa sürede  e-posta adresinize dönüş yapılacaktır.</p></div></div></div></div></div>')}else if("error"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Mesajınız İletilememiştir.",text:"Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})}else if("mail"==t.statu){$(".igb").html('<button class="call-to-action ig" type="submit"  ><div><div>Gönder</div></div></button>');a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Geçersiz E-posta Adresi",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})}}}))})}),$("body").on("click",".unuttum",function(){if(0==$.Mail($("input[name=Mail]").val()))return $("input[name=Mail]").css({border:"2px solid red"}),!1;swal({title:"Şifre sıfırlama talebi göndermek istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&($("input[name=Mail]").css({border:"none"}),$.ajax({type:"post",url:"sifreunuttum",dataType:"json",data:$(".unuttums").serialize(),beforeSend:function(){$(".us").html("<button class='call-to-action mt-3 '  ><div style='background: #c28f2c'><div ><div class='spinner-border text-warning' role='status'><span class='sr-only'></span></div></div></div></div></button>")},success:function(t){if("registered"==t.statu)$(".us").html(" <button class='call-to-action unuttum'  type='submit'><div style='background: #c28f2c'><div>Gönder</div></div></button>"),swal({title:"Hesap bulunamadı",text:"Girmiş olduğunuz e-posta adresine ait kayıtlı hesap bilgisi bulunamadı.",icon:"warning",buttons:[!1,"Tamam"]});else if("null"==t.statu)$(".us").html(" <button class='call-to-action unuttum'  type='submit'><div style='background: #c28f2c'><div>Gönder</div></div></button>"),swal({title:"Lütfen e-posta adresinizi giriniz.",icon:"warning",buttons:[!1,"Tamam"]});else if("recaptcha"==t.statu){$(".us").html(" <button class='call-to-action unuttum'  type='submit'><div style='background: #c28f2c'><div>Gönder</div></div></button>");var a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Recaptcha doğrulama hatası. Tekrar deneyiniz",icon:"warning",buttons:[!1,"Tamam"]})}else if(1==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".ss").html('<div class="row justify-content-center m-0  "><div class="col-12  " ><div class="row justify-content-center  mt-5 mb-5 "> <div class="col-12   text-center mt-5  mb-2"> <i class="far fa-envelope fa-5x green" ></i></div> <div class="col-12   text-center  IletisimYazi white"><p>Aramıza dönmen için sabırsızlanıyoruz. Hemen e-posta adresi git ve sana gönderdiğimiz linke tıkla. Umarım şifreni bir daha unutmazsın.</p></div></div>  </div></div>'),setTimeout(function(){window.location="index.php"},7e3)}else if(0==t.statu){$(".us").html(" <button class='call-to-action unuttum'  type='submit'><div style='background: #c28f2c'><div>Gönder</div></div></button>"),$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Şifre Sıfırlama Talebi Gönderilemedi",text:"Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})}else if("mail"==t.statu){$(".us").html(" <button class='call-to-action unuttum'  type='submit'><div style='background: #c28f2c'><div>Gönder</div></div></button>");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".aa").html(" "),swal({title:"Geçersiz E-posta Adresi",text:"E-posta adresinizi doğru girdiğinizden emin olunuz.",icon:"warning",buttons:[!1,"Tamam"]})}}}))})}),$("body").on("click",".ysg",function(){swal({title:"Yeni şifreni kaydetmek istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&$.ajax({type:"post",url:"sifreyeni",dataType:"json",data:$(".ys").serialize(),success:function(t){if("password"==t.statu){$(".aa").html(" ");var a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Şifreniz  6 ila 72  karakter arasında olmalıdır.",icon:"warning",buttons:[!1,"Tamam"]})}else if("incompatible"==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Şifreler Uyuşmuyor.",icon:"warning",buttons:[!1,"Tamam"]})}else if("null"==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Lütfen zorunlu (*) alanları doldurunuz.",icon:"warning",buttons:[!1,"Tamam"]})}else if(0==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Şifreniz Değiştirilemedi",text:"Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]}),setTimeout(function(){window.location="index.php"},5e3)}else if(1==t.statu){$(".aa").html(" ");a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),$(".yss").html('<div class="row justify-content-center m-0 mt-5 mb-5 "><div class="col-12  " ><div class="row justify-content-center"><div class="col-12 text-center mt-5 mb-3"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 IletisimYazi white"><p >Şifreniz yenilendi. Haydi keyif almaya devam et.</p></div></div></div></div>'),setTimeout(function(){window.location="index.php"},5e3)}else if("recaptcha"==t.statu){a=$(".g-recaptcha").attr("id");grecaptcha.reset(a),swal({title:"Recaptcha doğrulama hatası. Tekrar deneyiniz",icon:"warning",buttons:[!1,"Tamam"]})}}})})})});