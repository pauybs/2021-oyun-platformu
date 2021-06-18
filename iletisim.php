<?php
require_once("settings/connect.php");
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
<div class="col-12 p-0 mt-2 BackgroundWhite" >
	<div class="wrapper">
  		<div class="news-item standard-item3 " ></div>
  		<div class="position-absolute  col-12 text-center iltnxzx" ><span class="HakkimizdaYazi "  >İletişim</span></div>
	</div>

	<div class="row justify-content-center m-0 mt-5 mb-5 ">
		<div class="col-12 col-md-6 iss " style="background: #e7e6e3">
			<form class="text-center  p-1 mt-5 mb-5 iletisims" action="javascript:void(0);" method="post"   >
				<div class="mb-2">
					<div class="col-12 text-left p-0 bold font14" >Ad ve Soyad <span  class="red font11 bold">(Zorunlu)</span></div>         
					<input type="text" placeholder="Ad Soyad"  name="AdSoyad" class="p-2 iltjvvn"   >
	   			</div>
				<div class="mb-2">     
					<div class="col-12 text-left p-0 bold font14" >E-Posta <span class="red font11 bold"  >(Zorunlu)</span></div> 
					<input type="email" placeholder="E-Posta Adresi" name="Mail"class="p-2 iltjvvn"  >
					
				</div>
				<div class="mb-2">      
				    <div class="col-12 text-left p-0 bold font14" >Konu <span class="red font11 bold">(Zorunlu)</span></div>
				    <input type="text" name="Konu" placeholder="Konu" class="p-2 iltjvvn" >
				   	
				</div>
				<div class="">
				    <div class="col-12 text-left p-0 bold font14">Mesaj <span class="red font11 bold">(Zorunlu)</span></div>
				    <textarea name="Mesaj" placeholder="Mesaj" class="p-2 iltjvvn" ></textarea>      
				</div>
				<div class="row justify-content-center text-center bold red mt-2 mb-2 font13 aa "></div>
				<div class="row justify-content-center  text-center">
					<div class="g-recaptcha rpcHAZ" data-sitekey="6Lf5VHoaAAAAAMyNXUg7K_Ne6T7dzGK96o4tRnIT"></div>
					<script src="assets/main.js"></script>

				</div>
				<div class="row justify-content-center">
					<div class="col-12 col-md-4 text-center mt-3 igb">
						<button class="call-to-action ig" type="submit">
	  						<div>
	    						<div>Gönder</div>
	 						</div>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>			
</div>
	<script src='https://www.google.com/recaptcha/api.js'></script>

<style type="text/css">
	 .swal-modal {
      background-color: white;
  }

  .swal-title {
    color: black;
    text-align: center;
    font-size: 18px ! important;
  }
  .swal-text {
    color: black;
    text-align: center;
  }

  .swal-button {
  padding: 7px 19px;
  border-radius: 2px;
  background-color: #c28f2c;
  font-size: 12px;
 
 
}
.swal-button:hover {
  padding: 7px 19px ! important;
  border-radius: 2px ! important;
  background-color: #c28f2c ! important;
  font-size: 12px ! important;
 
 
}

.swal-icon--success:after, .swal-icon--success:before {
    content: "";
    border-radius: 50%;
    position: absolute;
    width: 60px;
    height: 120px;
    background: white ! important;
    -webkit-transform: rotate(
45deg
);
    transform: rotate(
45deg
);
}

.swal-icon--success__hide-corners {
    width: 5px;
    height: 90px;
    background-color: white ! important;
    /* padding: 1px; */
    position: absolute;
    left: 28px;
    top: 8px;
    z-index: 1;
    -webkit-transform: rotate(
-45deg
);
    transform: rotate(
-45deg
);
}
</style>
<?php
}else{
    header("location:" .$SiteLink);
    exit();
}
?>