$(document).ready(function(){$("body").on("click","#hyg",function(){$.ajax({type:"post",url:"haberyorum",dataType:"json",data:$("#habery").serialize(),beforeSend:function(){$(".hyb").html('<button class="call-to-action2 " ><div><div><div class="spinner-border text-warning" role="status"><span class="sr-only"></span></div></div></div></button>')},success:function(t){$(".hyb").html('<button class="call-to-action2" type="submit" id="hyg"  ><div><div>Gönder</div></div></button>'),"commentError"==t.statu?($("#habery").trigger("reset"),$("#hys").fadeIn(),swal({title:"Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})):"null"==t.statu?($("#habery").trigger("reset"),$("#hys").fadeIn(),swal({title:"Yorumunuz boş bırakılamaz.",icon:"warning",buttons:[!1,"Tamam"]})):"long"==t.statu?($("#habery").trigger("reset"),$("#hys").fadeIn(),swal({title:"Yorumunuz 2000 karakterden uzun olmamalı.",icon:"warning",buttons:[!1,"Tamam"]})):"error"==t.statu?$("#habery").trigger("reset"):"success"==t.statu&&""!=t.ui&&""!=t.commentid&&""!=t.profile&&""!=t.name&&""!=t.date&&""!=t.username&&""!=t.comment&&""!=t.newsid&&""!=t.tkn?($("#hys").html(""),$("#habery").trigger("reset"),$(".yorumlar").prepend('<div id="hy'+t.commentid+'"></div><div class="row p-2 hdy" id="y'+t.commentid+'"> <div class=" col-12"> <div class="row"> <div class="col-12 mb-1 hbyXK"> <div class="row p-0 justify-content-start align-items-center "> <div class="col-12"> <div class="row p-2 justify-content-start align-items-center"><div class="col-12 up"><figure> <img src="'+t.profile+'" class="img-fluid userp" style="border-radius: 50%;"><div class="row"><div class="col-12 "><figcaption> <span class="yorumk bold white">'+t.name+'</span> <span class=" yorumk white opacity05">'+t.date+'</span></figcaption></div><div class="col-12 "> <figcaption ><span class="white yorumk opacity05 ">(@'+t.username+')</span></figcaption></div></div></figure></div> <div class="col-12 mt-1 "><span class="rzrkWzXv yorumk ">'+t.comment+'</span></div> <div class="col-12 text-right mt-1"><span class="bold white yorumk hysb" data-type="'+t.ui+'" id="'+t.newsid+'" data-id="'+t.tkn+'" data="'+t.commentid+'" style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-trash-alt white"></i> Yorumu Sil</span></div> </div> </div> </div> </div> </div> <div class="col-12 mt-1"> <div class="row"> <div class="col-4 col-xl-2 " style="cursor: pointer;" id="'+t.commentid+'" onClick="$.Cevap('+t.commentid+')"><span class="bold white yorumk">Yanıtla</span></div> <div class="col-12 mt-2" id="cg'+t.commentid+'" style="display:none;"> <div class="row justify-content-center"> <div class="col-12 mt-4 haberYorum"> <form id="hyc'+t.commentid+'" action="javascript:void(0);" method="post"> <div class="group2"> <div id="c'+t.commentid+'"></div><textarea name="YorumCevap" placeholder="Yorumunuzu yazın..."></textarea> <input type="hidden" name="hc" value="'+t.newsid+'"><input type="hidden" name="ui" value="'+t.ui+'"><input type="hidden" name="yc" value="'+t.commentid+'"><input type="hidden" name="Tkn" value="'+t.tkn+'"><span class="highlight"></span><span class="bar"></span> </div> <div class="col-12 p-0 mt-3 text-right " id="cb'+t.commentid+'"><button class="call-to-action2 hycg" type="submit" id="'+t.ui+'" data-id="'+t.newsid+'" data="'+t.commentid+'"> <div> <div class="">Yanıtla</div> </div> </button></div> </form> </div> </div> </div> </div> </div> </div></div></div><div class="col-12 mt-1" id="cy'+t.commentid+'"></div>').hide().fadeIn(),$(".hyy").fadeOut()):"block"==t.statu&&""!=t.date&&swal({title:"İşlem Engellendi",text:t.date+" tarihine kadar bu işlemi gerçekleştiremezsiniz. Lütfen daha sonra tekrar dene. Topluluğumuzu korumak için bazı içerikleri ve işlemleri kısıtlıyoruz. Hata yaptığımızı düşünüyorsan bize bildir. ",icon:"error",buttons:[!1,"Tamam"]})}})}),$("body").on("click",".hycg",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),ui=$(this).attr("id"),$.ajax({type:"post",url:"haberyorumc",dataType:"json",data:$("#hyc"+i).serialize(),beforeSend:function(){$("#cb"+i).html('<button class="call-to-action2 " type="submit"  ><div><div >Yanıtla</div></div></button>')},success:function(t){$("#cb"+i).html('<button class="call-to-action2 hycg" type="submit" id="'+ui+'" data-id="'+j+'" data="'+i+'"  ><div><div >Yanıtla</div></div></button>'),"error"==t.statu?($("#hyc"+i).trigger("reset"),$("#c"+i).fadeIn(),swal({title:"Yorumunuz alınamadı.Daha sonra tekrar deneyiniz.",icon:"error",buttons:[!1,"Tamam"]})):"null"==t.statu?($("#hyc"+i).trigger("reset"),$("#c"+i).fadeIn(),swal({title:"Yorumunuz boş bırakılamaz.",icon:"warning",buttons:[!1,"Tamam"]})):"long"==t.statu?($("#hyc"+i).trigger("reset"),$("#c"+i).fadeIn(),swal({title:"Yorumunuz 2000 karakterden uzun olmamalı.",icon:"warning",buttons:[!1,"Tamam"]})):"success"==t.statu&&""!=t.ui&&""!=t.newsid&&""!=t.commentid&&""!=t.profile&&""!=t.name&&""!=t.date&&""!=t.username&&""!=t.comment&&""!=t.tkn?($("#c"+i).html(""),$("#hyc"+i).trigger("reset"),$("#cy"+i).append('<div class="row hdyc justify-content-center align-items-center pb-3 mt-1 " id="cs'+t.commentid+'"> <div class="col-11 col-xl-6 text center hycss" id="ss'+t.commentid+'"></div> <div class=" offset-1 col-11 asdRzwcZ"> <div class="row p-2 justify-content-start align-items-center"> <div class="col-12 up"><figure> <img src="'+t.profile+'" class="img-fluid userp" style="border-radius: 50%;"><div class="row"><div class="col-12 "><figcaption> <span class="yorumk bold white">'+t.name+'</span> <span class=" yorumk white opacity05">'+t.date+'</span></figcaption></div><div class="col-12 "> <figcaption ><span class="white yorumk opacity05 ">(@'+t.username+')</span></figcaption></div></div></figure></div> <div class="col-12 mt-2 "><span class="sadxzaA yorumk ">'+t.comment+'</span></div> <div class="col-12 text-right mt-1 "><span class="bold white yorumk hycsb" id="'+t.newsid+'" data-id="'+t.tkn+'" data-type="'+t.ui+'" data="'+t.commentid+'" style="cursor:pointer;"><i style="color:#c28f2c" class="fas fa-trash-alt white"></i> Yorumu Sil</span></div> </div> </div></div>').hide().fadeIn()):"block"==t.statu&&""!=t.date&&swal({title:"İşlem Engellendi",text:t.date+" tarihine kadar bu işlemi gerçekleştiremezsiniz. Lütfen daha sonra tekrar dene. Topluluğumuzu korumak için bazı içerikleri ve işlemleri kısıtlıyoruz. Hata yaptığımızı düşünüyorsan bize bildir. ",icon:"error",buttons:[!1,"Tamam"]})}})}),$("body").on("click",".ys",function(){i=$(this).attr("data"),$("#yg"+i).trigger("reset"),$(".yss").fadeOut(),$(".ysb").fadeOut(),$("#yg"+i).fadeIn()}),$("body").on("click",".yseb",function(){i=$(this).attr("data"),$.ajax({type:"post",url:"yorumsikayet",dataType:"json",data:$("#yg"+i).serialize(),success:function(t){"error"==t.statu?swal({title:"Şikayetiniz Alınamadı.",icon:"error",buttons:[!1,"Tamam"]}):"null"==t.statu?swal({title:"Şikayetinizi boş bırakmayınız.",icon:"warning",buttons:[!1,"Tamam"]}):"character"==t.statu?swal({title:"Şikayetiniz 250 karakterden uzun olamaz.",icon:"error",buttons:[!1,"Tamam"]}):"success"==t.statu&&($(".yss").fadeOut(),$(".ysb").fadeOut(),$(".ysb").html('<div class="row "><div class="col-12  "><div class="row"><div class="col-12   text-center mt-3"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 font20 white"><p>Şikayetiniz Alınmıştır.</p>\t</div></div></div></div>').hide().fadeIn(),$("#yg"+i).trigger("reset"),$("#yg"+i).fadeOut())}})}),$("body").on("click",".ycs",function(){i=$(this).attr("data"),$("#ycg"+i).trigger("reset"),$(".ycss").fadeOut(),$(".ycsb").fadeOut(),$("#ycg"+i).fadeIn()}),$("body").on("click",".ycseb",function(){i=$(this).attr("data"),$.ajax({type:"post",url:"yorumsikayet",dataType:"json",data:$("#ycg"+i).serialize(),success:function(t){"error"==t.statu?swal({title:"Şikayetiniz Alınamadı.",icon:"error",buttons:[!1,"Tamam"]}):"character"==t.statu?swal({title:"Şikayetiniz 250 karakterden uzun olamaz.",icon:"warning",buttons:[!1,"Tamam"]}):"null"==t.statu?swal({title:"Şikayetinizi boş bırakmayınız.",icon:"warning",buttons:[!1,"Tamam"]}):($(".ycss").fadeOut(),$(".ycsb").fadeOut(),$(".ycsb").html('<div class="row "><div class="col-12  "><div class="row"><div class="col-12   text-center mt-3"><i class="far fa-check-circle fa-5x green" ></i></div><div class="col-12   text-center mt-2 mb-5 font20 white"><p>Şikayetiniz Alınmıştır.</p>\t</div></div></div></div>').hide().fadeIn(),$("#ycg"+i).trigger("reset"),$("#ycg"+i).fadeOut())}})}),$("body").on("click",".hysb",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),h=$(this).attr("id"),ui=$(this).attr("data-type"),swal({title:"Yorumunu silmek istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&$.ajax({type:"post",url:"hyorumsil",data:{yi:i,j:j,h:h,ui:ui},dataType:"json",success:function(t){1==t.statu?($("#y"+i).html("<div class='col-12 text-center'><div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div></div>"),$("#y"+i).remove(),$("#cy"+i).remove(),swal({title:"Yorumunuz Silindi",icon:"success",buttons:[!1,"Tamam"]})):0==t.statu&&swal({title:"Yorumunuz Silinemedi",icon:"error",buttons:[!1,"Tamam"]})}})})}),$("body").on("click",".hycsb",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),h=$(this).attr("id"),ui=$(this).attr("data-type"),swal({title:"Yorumunu silmek istediğine emin misin?",buttons:["İptal","Tamam"]}).then(t=>{t&&$.ajax({type:"post",url:"hcyorumsil",dataType:"json",data:{yci:i,j:j,h:h,ui:ui},success:function(t){1==t.statu?($("#cs"+i).html("<div class='col-12 text-center'><div class='spinner-border text-warning ' role='status'><span class='sr-only'></span></div></div>"),$("#cs"+i).remove(),swal({title:"Yorumunuz Silindi",icon:"success",buttons:[!1,"Tamam"]})):0==t.statu&&swal({title:"Yorumunuz Silinemedi",icon:"error",buttons:[!1,"Tamam"]})}})})}),$("body").on("click",".hfe",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),ui=$(this).attr("id"),$.ajax({type:"post",url:"haberfav",dataType:"json",data:{fei:i,j:j,ui:ui},beforeSend:function(){$(".hfvr").removeClass("hfe")},success:function(t){$(".hfvr").addClass("hfe"),"add"==t.statu&&""!=t.news?$(".hfes"+i).html('<button type="button" class="btn btn-warning hfe favoriEklendi hfvr" id="'+ui+'"  data-id="'+j+'" data='+t.news+' title="Favorilerden Çıkar"><i class="fas fa-heart bold white"></i></button>'):"delete"==t.statu&&""!=t.news&&$(".hfes"+i).html('<button title="Favorilere Ekle" type="button" class="btn btn-warning favoriEkle  hfe hfvr" id="'+ui+'" data-id="'+j+'" data='+t.news+' ><i class="far fa-heart bold"></i></button>')}})})});