$(document).ready(function(){$("body").on("click",".t",function(){i=$(this).attr("data"),j=$(this).attr("data-id"),$.ajax({type:"post",url:"takip",dataType:"json",data:{te:i,j:j},success:function(a){"unfollow"==a.statu&&""!=a.username&&""!=a.image&&""!=a.curator&&""!=a.tkn?$(".kt"+i).html('<figcaption><a style="color: white" href="kurator/'+a.username+'"><img src='+a.image+' class="img-fluid invbnv"> <span class="bold white font15">'+a.username+'</span></a> <span class="bold white font15">•</span> <span class="ktlEc t" data-id="'+a.tkn+'" data='+a.curator+'> <i class="fas fa-user-plus font20"></i></span></figcaption>'):"follow"==a.statu&&""!=a.username&&""!=a.image&&""!=a.curator&&""!=a.tkn&&$(".kt"+i).html('<figcaption><a style="color: white" href="kurator/'+a.username+'"><img src='+a.image+' class="img-fluid invbnv"> <span class="bold white font15">'+a.username+'</span></a> <span class="bold white font15">•</span> <span class="bold font13 t"  data-id="'+a.tkn+'" data='+a.curator+' style="color: green;cursor:pointer;"> <i class="fas fa-user-check" style="font-size:20px"></i></span></figcaption>')}})})});