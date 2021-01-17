<div class="col-12 p-0   p-0 uyYzXxZad"  >
	<div class="row justify-content-center align-items-center   m-0 mb-5">
		<div class=" col-12 col-xl-10">
			<div class="row">
				<?php
				$Kategoriler= array(
					array('ResimYolu' =>$OyunlarAksiyon,'Link'=>"aksiyon",'Adi'=>"Aksiyon"),
					array('ResimYolu' =>$OyunlarBasiteglence,'Link'=>"basiteglence",'Adi'=>"Basit Eğlence"),
					array('ResimYolu' =>$OyunlarSpor,'Link'=>"spor",'Adi'=>"Spor"),
					array('ResimYolu' =>$OyunlarSimulasyon,'Link'=>"simulasyon",'Adi'=>"Simülasyon"),
					array('ResimYolu' =>$OyunlarStrateji,'Link'=>"strateji",'Adi'=>"Strateji"),
					array('ResimYolu' =>$OyunlarCokOyunculu,'Link'=>"cokoyunculu",'Adi'=>"Çok Oyunculu"),
					array('ResimYolu' =>$OyunlarMacera,'Link'=>"macera",'Adi'=>"Macera"),
					array('ResimYolu' =>$OyunlarYaris,'Link'=>"yaris",'Adi'=>"Yarış"),
					array('ResimYolu' =>$OyunlarRolYapma,'Link'=>"rolyapma",'Adi'=>"Rol Yapma"),
					array('ResimYolu' =>$OyunlarUcretsiz,'Link'=>"ucretsiz",'Adi'=>"Ücretsiz"),
					array('ResimYolu' =>$OyunlarHayattakalma,'Link'=>"hayattakalma",'Adi'=>"Hayatta Kalma"),
					);	
				?>

				<?php
				for($i=0;$i<count($Kategoriler);$i++){
				?>
			   	<div class="col-12 col-md-6  col-xl-4 ">
					<div class="row justify-content-center align-items-center text-center ">
						<?php
						if (file_exists("images/".$Kategoriler[$i]["ResimYolu"]) and ($Kategoriler[$i]["ResimYolu"])) {
						?>
						<div class="col-11 mt-5 p-0 ">
							<img src="images/<?php echo IcerikTemizle($Kategoriler[$i]["ResimYolu"]); ?>" class="img-fluid  golge2 oyunlar ok"     >
						</div>
						<?php
						}else{
						?>
						<div class="col-11 mt-5  p-0  img-fluid  golge2 oyunlar arwyAEEVZx"  >  </div>
						<?php
						}
						?>	
					</div>
					<div class="col-12   text-center mt-4">
						<a href="<?php echo $Kategoriler[$i]["Link"] ?>"><button class="call-to-action3">
		  					<div>
		    					<div><?php echo  $Kategoriler[$i]["Adi"]; ?></div>
		 					</div>
						</button>
						</a>
					</div>
				</div>				
			 	<?php	
				}
				?>
			</div>
		</div>		
	</div>
</div>

<script type="text/javascript">
	$(".ok").css("display", "none");
	$(".ok").fadeIn("slow");
</script>