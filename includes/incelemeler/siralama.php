<?php
if(basename($_SERVER['PHP_SELF'])!=basename(__FILE__)){
?>
	<div class="iropdown ">
		<button class="ibutton p-3 ">
			<i class="fas fa-sort-amount-down"></i>
			<?php 
			if ($Sıralama==1){
			?>
				<span>En Popüler</span>
			<?php
			}else if($Sıralama==2){
			?>
				<span>En Eski</span>
			<?php
			}else if ($Sıralama==3){
			?>
				<span>En Beğenilen</span>
			<?php
			}else{
			?>
				<span>Sıralama</span>
			<?php
			}
			?>
		</button>
		<div class="icontent" style="z-index: 3">
			<a class="iylink">
				<form action="oyunincelemeler" method="post">
					<div class="col-12 ">
						<div class=" row justify-content-center ">
							<div class="col-4 p-1 text-center"> 
								<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="3">
							</div>	
						</div>
						<div class="col-12 text-center  form-group">
							<input class="inczsdsa_"   value="En Beğenilen" type="submit" class="btn-block btn btn btn-warning ">
						</div>
					</div>	
				</form>
			</a>
			<a class="iylink">
				<form action="oyunincelemeler " method="post" >
					<div class="col-12 ">
						<div class=" row justify-content-center ">
							<div class="col-4 text-center p-1 text-center"> 
								<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="1">
							</div>	
						</div>
						<div class="col-12 text-center form-group">
							<input class="inczsdsa_"   value="En Popüler" type="submit" class="btn-block btn btn btn-warning ">
						</div>
					</div>	
				</form>
			</a>
			<a class="iylink">
				<form action="oyunincelemeler" method="post">
					<div class="col-12 ">
						<div class=" row justify-content-center">
							<div class="col-4 p-1 text-center"> 
								<input type="hidden" class="vncbcvbinc"  type="radio" name="srl" value="2">
							</div>	
						</div>

						<div class="col-12 text-center form-group">
							<input class="inczsdsa_"  value="En Eski"  type="submit" class="btn-block btn btn btn-warning ">
						</div>
					</div>	
				</form>
			</a>
			<a class="iylink bold white text-center p-2" href="oyunincelemeler">
				<button class=" btn  white bold inczsdsa_" style="color: white">En Yeni</button>
			</a>
		</div>
	</div>
<?php
}else{
	require_once("../../settings/connect.php");

	header("location:" .$SiteLink);
  exit();
}
?>





