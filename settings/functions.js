$(document).ready(function(){var e,i,t,s;$("body").on("click","#pass",function(){var e=document.getElementById("password");e.type="password"==e.type?"text":"password"}),$("body").on("click","#pass1",function(){var e=document.getElementById("password1");e.type="password"==e.type?"text":"password"}),$("body").on("click","#pass2",function(){var e=document.getElementById("password2");e.type="password"==e.type?"text":"password"}),$(".vid-item").each(function(i){$(this).on("click",function(){var e=i+1;$(".vid-item .thumb").removeClass("active"),$(".vid-item:nth-child("+e+") .thumb").addClass("active")})}),e=document,i="script",t="facebook-jssdk",s=e.getElementsByTagName(i)[0],e.getElementById(t)||((i=e.createElement(i)).id=t,i.src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0",s.parentNode.insertBefore(i,s)),$(function(){var e=$.trim($("input[name=tags_input]").val()),i=e.split(",");e&&$.each(i,function(e,i){$("input.addTag").before("<span>"+i+"</span>")}),$("input.addTag").on({focusout:function(){var e,i=this.value.replace(/[^a-z0-9\+\-\.\#]/gi,"");i&&(e=$("input[name=tags_input]").val().split(",").filter(function(e){return""!==e}),$.inArray(i,e)<0&&(i=i.toLowerCase(),$(this).before("<span>"+i+"</span>"),e.length&&(i=", "+i),$("input[name=tags_input]").val($("input[name=tags_input]").val()+i),this.value=""))},keyup:function(e){13==e.which&&$("body").on("click",".add",function(){})}}),$("body").on("click","#tags span",function(){var i=$(this).text();swal({title:"'"+i+"' etiketini silmek istiyor musun ?",buttons:["İptal","Tamam"]}).then(e=>{e&&(e=$("input[name=tags_input]").val().split(","),-1!=$.inArray(i,e)&&($(this).remove(),$("input[name=tags_input]").val($("input[name=tags_input]").val().replace(i,"")),$("input[name=tags_input]").val($("input[name=tags_input]").val().split(",").filter(function(e){return""!==e}).join(", "))))})})}),setTimeout(function(){$("body").addClass("loaded")},1e3);new Swiper(".swiper6",{slidesPerView:1,spaceBetween:30,loop:!0,centeredSlides:!0,autoplay:{delay:2500,disableOnInteraction:!1},pagination:{el:".swiper-pagination6",dynamicBullets:!0},navigation:{nextEl:".swiper-button-next",prevEl:".swiper-button-prev"}}),new Swiper(".swiper2",{grabCursor:!0,pagination:{el:".swiper-pagination2",dynamicBullets:!0},autoplay:{delay:2500,disableOnInteraction:!1}}),new Swiper(".swiper5",{grabCursor:!0,pagination:{el:".swiper-pagination5",dynamicBullets:!0},autoplay:{delay:2500,disableOnInteraction:!1}}),new Swiper(".swiper4",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination4",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}}),new Swiper(".swiper10",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination10",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}}),new Swiper(".swiper3",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination3",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}}),new Swiper(".swiper1",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination1",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}}),new Swiper(".swiper8",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination8",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}}),new Swiper(".swiper9",{slidesPerView:1,spaceBetween:10,pagination:{el:".swiper-pagination9",dynamicBullets:!0},breakpoints:{"@0.00":{slidesPerView:1,spaceBetween:10},"@0.75":{slidesPerView:2,spaceBetween:20},"@1.00":{slidesPerView:3,spaceBetween:40},"@1.50":{slidesPerView:4,spaceBetween:50}}});$.pExec=function(e,i){document.execCommand(e,!1,i)},$("ul.pbuton li a").click(function(){var e,i=$(this).data("obj");return i.prompt?e=prompt(i.promptText,i.promptDefault):i.arg&&(arg=i.arg),$.pExec(i.name,e),!1}),$("button#dgr").click(function(){var e=$(".pedit").html();$("textarea[name=Inceleme]").val(e),$(".save").html("Kaydedildi")}),$(".pedit").keyup(function(){$("textarea[name=Inceleme]").val(""),$(".save").html("Yazıyı Kaydet")}),$("button#degergönder3").click(function(){var e=$(".peditor3").html();$("textarea[name=Inceleme3]").val(e),$(".save3").html("Kaydedildi")}),$(".peditor3").keyup(function(){$("textarea[name=Inceleme3]").val(""),$(".save3").html("Yazıyı Kaydet")});var n=setInterval(c,1e7);$(".carousel, .slider").hover(function(){clearInterval(n)},function(){n=setInterval(c,1e7)});var a=[],r=1,l=0,p=$(".carousel>li").length,o=p;function c(e){var i=e;function t(e){return"leftposition"!=e&&o<r+ ++l&&(l=1-r),"leftposition"==e&&(l=r-1)<1&&(l=p),l}"counter-clockwise"==i&&(0==(e=$(".left-pos").attr("id")-1)&&(e=p),$(".right-pos").removeClass("right-pos").addClass("back-pos"),$(".main-pos").removeClass("main-pos").addClass("right-pos"),$(".left-pos").removeClass("left-pos").addClass("main-pos"),$("#"+e).removeClass("back-pos").addClass("left-pos"),--r<1&&(r=p)),"clockwise"!=i&&""!=i&&null!=i||($("#"+r).removeClass("main-pos").addClass("left-pos"),$("#"+(r+t())).removeClass("right-pos").addClass("main-pos"),$("#"+(r+t())).removeClass("back-pos").addClass("right-pos"),$("#"+t("leftposition")).removeClass("left-pos").addClass("back-pos"),l=0,p<++r&&(r=1))}$(".carousel>li").each(function(e){a[e]=$(this).text()}),$("#next").click(function(){c("clockwise")}),$("#prev").click(function(){c("counter-clockwise")}),$(".items").click(function(){"items left-pos"==$(this).attr("class")?c("counter-clockwise"):c("clockwise")}),$.Mail=function(e){return 0!=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(e)},$.Image=function(e){return".png"==e.substr(-4)||".jpg"==e.substr(-4)||".jpeg"==e.substr(-5)||""==e.substr(-4)||""==e.substr(-5)},$.Cevap=function(e){var i=e;$("#"+e).parent().find("#cg"+i).slideToggle()},$.Hakkinda=function(e){var i=e;$("#"+e).parent().find("#hak"+i).slideToggle()},$.oyunhak=function(e){var i=e;$("#ok"+e).parent().find("#hak"+i).slideToggle()},$.sis=function(e){var i=e;$("#s"+e).parent().find("#sis"+i).slideToggle()},$.Sistem=function(e){var i=e;$("#"+e).parent().find(".Goster"+i).slideToggle()}});