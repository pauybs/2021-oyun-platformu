<?php
require_once("settings/connect.php");
if(isset($_SESSION["Kullanici"]) and isset($_SESSION["Jeton"]) and Guvenlik($_SESSION["Kullanici"])==Guvenlik($KullaniciMail)  and basename($_SERVER['PHP_SELF'])!=basename(__FILE__) ){


?>
<div class=" col-12 Uizahse cvnQAAzx" >
	<div class="row justify-content-center ">
		<div class="col-12 col-xl-2 oRZNAEazx" >
			<?php
			include 'includes/hesabim_menu.php';
			?>
		</div>
			<div class="col-12 col-xl-10">
				<div class="row mt-5 mb-5  justify-content-center align-items-center">
					<div class="col-11 p-0 " >
						<h1 class="bold font15 white ">Destek</h1>
					</div>
					<div class="col-11 mt-3 golge" style="background:  rgb(0,0,0,0.5);">
						<div class="row  justify-content-center ">
							<div class="col-12 mt-4 mb-5">
								<div class="row justify-content-center ">
									<div class="col-12 col-xl-5">
										<div class="row justify-content-center">
											<div class="col-11 text-left p-0 mt-4 font13 bold white mb-1 "><h6 class="bold white"> <i class="fas fa-envelope"></i> Talep Oluştur</h6></div>      
											<div class="col-11  mb-5 mt-2 " style="background: #101010" >
												<form class=" tof " method="post" id="singnupFrom" action="javascript:void(0);">
													
													<div class=" mt-5">   
														<div class="col-12 text-left p-0 font13 bold white">Konu <span class="font12 red white">(Zorunlu)</span></div>      
														<input  class="p-3 hspadsv"  placeholder="Konu" type="text" name="Konu">
													</div>
													<div class=" mt-5">   
														<div class="col-12 text-left p-0 font13 bold white">İçerik <span class="font12 red white">(Zorunlu)</span></div>      
														<textarea class="p-3 hspadsv" placeholder="İçerik" type="text" name="Icerik" style="height: 230px" ></textarea>
														<input type="hidden"  name="Tkn" value="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>">
													</div>
													<div class="col-12   text-center mt-3 mb-3 tobi">
														<button class="call-to-action tob" type="submit" >
															<div>
																<div>Gönder</div>
															</div>
														</button>
													</div>
												</form>
											</div>	
										</div>
									</div>
									<div class="col-12 col-xl-7">
										<div class="row justify-content-center">
											<div class="col-12">
												<div class="row justify-content-center">
													<div class="col-11">
														<div class="row justify-content-center mt-4">
															<div class="col-12  p-0 mb-4">
																<h6 class="bold white m-0 "><i class="fas fa-envelope-open-text"></i> Cevaplanan Talepler</h6>
															</div>
															<div class="col-12 tlanxsA">
																<div class="row">
																	<div class="col-4 p-2"><h6 class="bold white font14 m-0">Konu</h6></div>
																	<div class="col-4 p-2 TLAXNa" ><h6 class="bold white font14 m-0">İçerik</h6></div>
																	<div class="col-4 p-2"><h6 class="bold white font14 m-0">Cevap</h6></div>
																</div>
															</div>
														
															<div class="col-12  tlpscrl" style=" background: #101010;">
																<div class="row" >
																<?php
																$CevaplananTaleplerim = $DatabaseBaglanti->prepare("SELECT * FROM destek Where UyeId=? and Durum=?  order by id desc");
																$CevaplananTaleplerim->execute([Guvenlik($KullaniciId),1]);
																$CevaplananTaleplerimVeri = $CevaplananTaleplerim->rowCount();
																$CevaplananTaleplerimKayit = $CevaplananTaleplerim->fetchAll(PDO::FETCH_ASSOC);
																if ($CevaplananTaleplerimVeri>0) {
																	foreach ($CevaplananTaleplerimKayit as $cevaptalepler) {	
																?>
																
																	<div class="col-12 tc chTLPAs" data-id="<?php echo IcerikTemizle($cevaptalepler["id"]) ?>" data="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="<?php echo IcerikTemizle($cevaptalepler["destekid"]) ?>" >
																		<div class="row">
																			<div class="col-4 p-2" >
																				<h6  class="bold white font14 m-0 skTlPeX">
																				<?php
																				if (strlen(IcerikTemizle($cevaptalepler["Baslik"]))>30) {
																					echo strip_tags(IcerikTemizle(substr($cevaptalepler["Baslik"],0,30)))."...";
																				}else{
																					echo IcerikTemizle($cevaptalepler["Baslik"]);
																				}
																				?>	
																				</h6>
																			</div>
																			<div class="col-4 p-2 SDCtlpsAS" >
																				<h6 class="bold white font14 m-0">
																				<?php
																				if (strlen(IcerikTemizle($cevaptalepler["Konu"]))>30) {
																					echo strip_tags(IcerikTemizle(substr($cevaptalepler["Konu"],0,30)))."...";
																				}else{
																					echo IcerikTemizle($cevaptalepler["Konu"]);
																				}
																				?>			
																				</h6>
																			</div>
																			<div class="col-4 p-2">
																				<h6 class="skTlPeX bold white font14 m-0">
																				<?php
																				if (strlen(IcerikTemizle($cevaptalepler["Cevap"]))>30) {
																					echo strip_tags(IcerikTemizle(substr($cevaptalepler["Cevap"],0,30)))."...";
																				}else{
																					echo IcerikTemizle($cevaptalepler["Cevap"]);
																				}
																				?>	
																				</h6>
																			</div>
																		</div>
																	</div>
																<?php
																	}
																}else{
																?>
																	<div class="col-12 " >
																		<div class="row">
																			<div class="col-12 mt-5 text-center ">
																				<h6 class="bold white font14"> Cevaplanmış Talebiniz bulunmamaktadır.</h6>
																			</div>
																		</div>
																	</div>
																<?php
																}
																?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-12">
												<div class="row justify-content-center">
													<div class="col-11 mt-3">
														<div class="row justify-content-center mt-4">
															<div class="col-12  p-0 mb-4">
																<h6 class="bold white m-0 "><i class="fas fa-envelope"></i> Talepler</h6>
															</div>
															<div class="col-12 tlanxsA " >
																<div class="row">
																	<div class="col-6 p-2"><h6 class="bold white font14 m-0">Konu</h6></div>
																	<div class="col-6 p-2 GLSDHstly" ><h6 class="bold white font14 m-0">İçerik</h6></div>	
																</div>
															</div>
															<div class="col-12  tlpscrl"  style=" background: #101010;">
																<div class="row" >
																<?php
																$Taleplerim = $DatabaseBaglanti->prepare("SELECT * FROM destek Where UyeId=? and Durum=? order by id desc");
																$Taleplerim->execute([Guvenlik($KullaniciId),0]);
																$TaleplerimVeri = $Taleplerim->rowCount();
																$TaleplerimKayit = $Taleplerim->fetchAll(PDO::FETCH_ASSOC);
																if ($TaleplerimVeri>0) {
																	foreach ($TaleplerimKayit as $talepler) {	
																?>
																
																	<div class="col-12 tb chTLPAs" data-id="<?php echo IcerikTemizle($talepler["id"]) ?>" data="<?php echo IcerikTemizle($_SESSION["Jeton"]) ?>" id="<?php echo IcerikTemizle($talepler["destekid"]) ?>" >
																		<div class="row">
																			<div class="col-6 p-2" style="">
																				<h6  class="skTlPeX bold white font14 m-0">
																				<?php
																				if (strlen(IcerikTemizle($talepler["Baslik"]))>50) {
																					 echo  strip_tags(IcerikTemizle(substr($talepler["Baslik"],0,50)))."...";
																				}else{
																					 echo  IcerikTemizle($talepler["Baslik"]);
																				}
																				?>
																				</h6>
																			</div>
																			<div class="col-6 p-2 SDCtlpsAS"  >
																				<h6 class="bold white font14 m-0">
																				<?php
																				if (strlen(IcerikTemizle($talepler["Konu"]))>50) {
																					 echo  strip_tags(IcerikTemizle(substr($talepler["Konu"],0,50)))."...";
																				}else{
																					 echo  IcerikTemizle($talepler["Konu"]);
																				}
																				?>	
																				</h6>
																			</div>
																			
																		</div>
																	</div>
																<?php
																	}
																}else{
																?>
																	<div class="col-12 " >
																		<div class="row">
																			<div class="col-12 mt-5 text-center ">
																				<h6 class="bold white font14">Talebiniz bulunmamaktadır.</h6>
																			</div>
																		</div>
																	</div>
																<?php
																}
																?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											
										</div>
									</div>
								</div>
							</div>
							

							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 	<script src="assets/main_p=1.2.7.js"></script>
<?php
}else{
	header('Location: ' .$SiteLink);
	exit();
}
?>



