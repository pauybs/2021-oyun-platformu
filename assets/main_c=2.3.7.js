$(document).ready(function(){function t(){cwidth=$(window).width(),cwidth<=575.98?(width=270,height=180):(width=760,height=480)}$("body").on("click",".ihk",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),swal({title:"Haber içeriğini kaldırmak istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&$.ajax({type:"post",dataType:"json",url:"iceriksil",data:{ih:i,j:j},beforeSend:function(){$("#hi"+i).removeClass("ihk")},success:function(t){1==t.statu?($("#hi"+i).addClass("ihk"),$("#i"+i).remove(),swal({title:"İçerik Kaldırıldı",icon:"success",buttons:[!1,"Tamam"]})):swal({title:"İçerik Kaldırılamadı",icon:"error",buttons:[!1,"Tamam"]})}})})}),$("body").on("click",".ht",function(){swal({title:"Haberi tamamlamak istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&$.ajax({type:"post",url:"habery",dataType:"json",data:$(".hit").serialize(),beforeSend:function(){$(".hd").removeClass("ht")},success:function(t){1==t.statu?($(".his").html('<div class="row "><div class="col-12  "><div class="row"><div class="col-12   text-center mt-5"><i class="far fa-check-circle fa-4x green" ></i></div><div class="col-12   text-center mt-2 mb-5 font16 white"><p>Haberiniz Başarıyla Kaydedilmiştir</p><p>Haberlerim sayfasından görüntüleyebilirsiniz.</p><p>Yönlendiriliyorsunuz...</p></div></div></div></div>'),setTimeout(function(){window.location="haberlerim"},7e3)):0==t.statu?setTimeout(function(){window.location="index.php"},500):"block"==t.statu&&""!=t.date&&($(".hd").addClass("ht"),swal({title:"İşlem Engellendi",text:t.date+" tarihine kadar bu işlemi gerçekleştiremezsiniz. Lütfen daha sonra tekrar dene. Topluluğumuzu korumak için bazı içerikleri ve işlemleri kısıtlıyoruz. Hata yaptığımızı düşünüyorsan bize bildir. ",icon:"error",buttons:[!1,"Tamam"]}))}})})}),$("body").on("click",".hig",function(){swal({title:"İçeriğini Yüklemek istediğinize emin misin?",buttons:["İptal","Tamam"]}).then(t=>{if(t){value=$(".icrkph").croppie("get").points,$("input[name=img]").val(value);var i=CKEDITOR.instances.ckeditor1.getData();if($("textarea[name=Yazi]").val(i),".zip"==$("input[name=IcerikResmi]").val().substr(-4))return $(".hib").fadeOut(),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$("input[name=IcerikResmi]").val(""),swal({title:"JPG, JPEG veya PNG dosyası yükleyiniz",icon:"warning",buttons:[!1,"Tamam"]}),!1;var e=$(".hie")[0],a=new FormData(e);$.ajax({type:"post",url:"icerike",dataType:"json",enctype:"multipart/form-data",processData:!1,contentType:!1,cache:!1,data:a,beforeSend:function(){$(".higb").html('<button class="call-to-action " ><div><div>Yükleniyor..</div></div></button>')},success:function(t){$(".higb").html('<button class="call-to-action hig" type="submit" ><div><div>İçerik Yükle</div></div></button>'),"error"==t.statu?setTimeout(function(){window.location="index.php"},500):"null"==t.statu?swal({title:"Lütfen zorunlu alanları doldurunuz",icon:"warning",buttons:[!1,"Tamam"]}):"long"==t.statu?swal({title:"İçerik başlığı 100 karakterden uzun olmamalı",icon:"warning",buttons:[!1,"Tamam"]}):"video"==t.statu?swal({title:"Geçersiz  Video Id'si",text:"Lütfen doğru video id'si girdiğinizden emin olun.",icon:"warning",buttons:[!1,"Tamam"]}):"image"==t.statu?($(".hib").fadeOut(),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$("input[name=IcerikResmi]").val(""),$(".icrkph").css({display:"none"}),swal({title:"Resim yüklenemedi. Lütfen başka bir resim yükleyiniz",icon:"error",buttons:[!1,"Tamam"]})):"ContentError"==t.statu?($(".hib").fadeOut(),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$("input[name=IcerikResmi]").val(""),$(".icrkph").css({display:"none"}),swal({title:"İçerik yüklenemedi",icon:"error",buttons:[!1,"Tamam"]})):"size"==t.statu?($(".hib").fadeOut(),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$("input[name=IcerikResmi]").val(""),$(".icrkph").css({display:"none"}),swal({title:"Resim 2 MB'dan yüksek olamaz",icon:"warning",buttons:[!1,"Tamam"]})):"type"==t.statu?($(".hib").fadeOut(),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$("input[name=IcerikResmi]").val(""),$(".icrkph").css({display:"none"}),swal({title:"JPG, JPEG veya PNG dosyası yükleyiniz",icon:"warning",buttons:[!1,"Tamam"]})):"content"==t.statu?swal({title:"Lütfen zorunlu alanları doldurunuz",text:"İçerik yazınızı boş bırakmayınız",icon:"warning",buttons:[!1,"Tamam"]}):"success"==t.statu&&""!=t.content&&""!=t.image&&""!=t.article&&""!=t.tkn?($(".iy").fadeOut(1e4),$(".hib").html(""),$(".hia").html(" "),$(".hrs").html(" "),$(".hss").html(" "),$(".hie").trigger("reset"),swal({title:"İçerik Eklendi",icon:"success",buttons:[!1,"Tamam"]}),""!=t.video?$(".ghi").append('<div class="col-12   mb-5 " id="i'+t.content+'" ><div class="row  justify-content-center  p-4 " ><div class="col-11  text-center" ><img src="'+t.image+'" class="img-fluid " ><div class="row  justify-content-center mt-1"><div class="col-12 col-xl-6 mt-3"><iframe width="100%" height="350" src="https://www.youtube.com/embed/'+t.video+'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div><div class="col-11 p-0 text-left mb-1 mt-2" style="font-weight: bold;color: white">İçerik Başlık</div><div  class="col-11 p-2 text-left" style="background:#202020;width: 100%;color:white">'+t.title+'</div><div class="col-11 p-0 text-left mb-1 mt-4" style="font-weight: bold;color: white">İçerik Açıklama</div><div class="  col-11 p-2 text-left cvxcvqszZ peditor font15">'+t.article+'</div> </div></div></div><div class="row justify-content-center mb-3"><div class="col-5 col-xl-3"><button class="btn-block btn ihk" id="hi'+t.content+'" data-id="'+t.tkn+'" data="'+t.content+'" type="submit" style="font-weight: bold;background-color: red;color:white; "> İçerik Kaldır </button></div></div></div>').hide().fadeIn(2e3):$(".ghi").append('<div class="col-12   mb-5 " id="i'+t.content+'" ><div class="row  justify-content-center  p-4 " ><div class="col-11  text-center" ><img src="'+t.image+'" class="img-fluid " ><div class="row  justify-content-center mt-1"><div class="col-11 p-0 text-left mb-1 mt-2" style="font-weight: bold;color: white">İçerik Başlık</div><div  class="col-11 p-2 text-left" style="background:#202020;width: 100%;color:white">'+t.title+'</div><div class="col-11 p-0 text-left mb-1 mt-4" style="font-weight: bold;color: white">İçerik Açıklama</div><div class="  col-11 p-2 text-left cvxcvqszZ peditor font15">'+t.article+'</div> </div></div></div><div class="row justify-content-center mb-3"><div class="col-5 col-xl-3"><button class="btn-block btn ihk" id="hi'+t.content+'" data-id="'+t.tkn+'" data="'+t.content+'" type="submit" style="font-weight: bold;background-color: red;color:white; "> İçerik Kaldır </button></div></div></div>').hide().fadeIn(2e3),CKEDITOR.instances.ckeditor1.setData("",function(){this.updateElement()}),$(".icrkph").css({display:"none"})):"block"==t.statu&&""!=t.date&&swal({title:"İşlem Engellendi",text:t.date+" tarihine kadar bu işlemi gerçekleştiremezsiniz. Lütfen daha sonra tekrar dene. Topluluğumuzu korumak için bazı içerikleri ve işlemleri kısıtlıyoruz. Hata yaptığımızı düşünüyorsan bize bildir. ",icon:"error",buttons:[!1,"Tamam"]})}})}})}),t(),$(window).resize(function(){t()}),$(function(){$(".icrkph").css({display:"none"}),$uploadCrop=$(".icrkph").croppie({enableExif:!0,viewport:{width:width,height:height},boundary:{width:width,height:height}}),$("#upload").on("change",function(){$(".icrkph").css({display:"block"});var t=document.getElementById("upload");if(t.files&&t.files[0]){var i=new FileReader;i.onload=function(){var t=i.result;$uploadCrop.croppie("bind",{url:t})},i.readAsDataURL(t.files[0])}})})});