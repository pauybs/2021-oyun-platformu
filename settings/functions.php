<?php
function PuanHesapla($Value){
    if(($Value==0) ){
         $Puan =  '<i class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i>';
    }else if(($Value>0) and  ($Value<=1)){
        $Puan = ' <i style="color:#f2b600" class="fas fa-star font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i>';
    }else if(($Value>1) and  ($Value<=2)){
        $Puan = '<i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i>';
    }else if(($Value>2) and  ($Value<=3)){
           $Puan = ' <i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i><i  class="fas fa-star white font15"></i><i  class="fas fa-star white font15"></i>';
    }else if(($Value>3) and ( $Value<=4)){
        $Puan =  ' <i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600"class="fas fa-star font15"></i><i style="color:#f2b600"class="fas fa-star font15"></i><i class="fas fa-star white font15"></i>';
     }else if(($Value>4)){
         $Puan =  ' <i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i><i style="color:#f2b600"class="fas fa-star font15"></i><i style="color:#f2b600"class="fas fa-star font15"></i><i style="color:#f2b600" class="fas fa-star font15"></i>';
    }   
    return $Puan;
}

function OyunPuan($Value){
    if(($Value==0) ){
         $Puan =  '<i class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i>';
    }else if(($Value>0) and  ($Value<=1)){
        $Puan = ' <i style="color:#f2b600" class="fas fa-star font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i>';
    }else if(($Value>1) and  ($Value<=2)){
        $Puan = '<i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i>';
    }else if(($Value>2) and  ($Value<=3)){
           $Puan = ' <i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i><i  class="fas fa-star white font25"></i><i  class="fas fa-star white font25"></i>';
    }else if(($Value>3) and ( $Value<=4)){
        $Puan =  ' <i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600"class="fas fa-star font25"></i><i style="color:#f2b600"class="fas fa-star font25"></i><i class="fas fa-star white font25"></i>';
     }else if(($Value>4)){
         $Puan =  ' <i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i><i style="color:#f2b600"class="fas fa-star font25"></i><i style="color:#f2b600"class="fas fa-star font25"></i><i style="color:#f2b600" class="fas fa-star font25"></i>';
    }   
    return $Puan;
}

function OyunOrtPuan($Value){
    if(($Value==0) ){
        $Puan =  "-";
    }else if(($Value>0) and  ($Value<=1)){
        $Puan = 'Çok olumsuz';
    }else if(($Value>1) and  ($Value<=2)){
       $Puan = 'Olumsuz';
    }else if(($Value>2) and  ($Value<=3)){
        $Puan = 'Kararsız';
    }else if(($Value>3) and ( $Value<=4)){
        $Puan =  'Olumlu';
    }else if(($Value>4)){
        $Puan =  'Çok Olumlu';
    }   
    return $Puan;
}

function Platform($Value){
    if ($Value==1) {         
         $Platform='<span><i class="fab fa-windows white font15 "></i></span>';                                     
    }else if ($Value==2) {                                       
         $Platform='<span><i class="fab fa-xbox white font15"></i></span>';
    }else if ($Value==3) {
        $Platform='<span><i class="fab fa-playstation white font15"></i></span>';                                        
    }else if ($Value==4) {                                        
        $Platform='<span><i class="fab fa-android white font15"></i></span>';                                       
    }else if ($Value==5) {                                       
        $Platform='<span><i class="fab fa-app-store-ios white font15"></i></span>';                                      
    }else if ($Value==6) {                                       
        $Platform='<img src="images/nintendo.png" class="img-fluid " style="width: 15px;height:15px ;margin-bottom: 3px" >';            
    }else if ($Value==7) {                                      
       $Platform=' <img src="images/stadia.png" class="img-fluid " style="width: 15px;height:15px;margin-bottom: 3px " >';
    }else{
        $Platform="";
    }
    return $Platform;
}

function Oy($Value){
   if(($Value==1) ){
        $Oy =  '<i style="color:#f2b600" class="fas fa-star white    font25"></i><i  class="fas fa-star white   font25"></i><i  class="fas fa-star   white font25"></i><i  class="fas fa-star  white font25"></i><i  class="fas fa-star   white font25"></i>';
    }else if(($Value==2)){
        $Oy = ' <i style="color:#f2b600" class="fas fa-star   font25"></i><i style="color:#f2b600"  class="fas fa-star white  font25"></i><i  class="fas fa-star white  font25"></i><i  class="fas fa-star white  font25"></i><i  class="fas fa-star white  font25"></i>';
    }else if(($Value==3)){
        $Oy = ' <i style="color:#f2b600" class="fas fa-star   font25"></i><i style="color:#f2b600"  class="fas fa-star white  font25"></i><i  style="color:#f2b600" class="fas fa-star white  font25"></i><i  class="fas fa-star white  font25"></i><i  class="fas fa-star white font25"></i>';
    }else if(($Value==4)){
        $Oy = ' <i style="color:#f2b600" class="fas fa-star   font25"></i><i style="color:#f2b600" class="fas fa-star  font25"></i><i style="color:#f2b600" class="fas fa-star   font25"></i><i  style="color:#f2b600" class="fas fa-star white   font25"></i><i  class="fas fa-star white   font25"></i>';
    }else if(($Value==5)){
        $Oy =  ' <i style="color:#f2b600" class="fas fa-star  font25"></i><i style="color:#f2b600" class="fas fa-star  font25"></i><i style="color:#f2b600"class="fas fa-star  font25"></i><i style="color:#f2b600"class="fas fa-star   font25"></i><i style="color:#f2b600" class="fas fa-star white   font25"></i>';
    }
    return $Oy;
}

function SatisPlatform($Value){
    if($Value==1){                                            
        $Platform='<img src="images/epicgames.png" class="img-fluid satisResim YzAxxTXzAx">';                                               
    }else if($Value==2){                                                
        $Platform='<img src="images/steam.png" class="img-fluid satisResim YzAxxTXzAx">';                                                
    }else if($Value==3){                                                 
        $Platform='<img src="images/ubisoft.png" class="img-fluid satisResim YzAxxTXzAx">';                                                  
    }else if($Value==4){                                                
        $Platform='<img src="images/nintendo.png" class="img-fluid satisResim YzAxxTXzAx">';                                                  
    }else if ($Value==5){                                                
        $Platform='<img src="images/origin.png" class="img-fluid satisResim YzAxxTXzAx">';                                              
    }else if($Value==6){                                                 
        $Platform='<img src="images/playstation.png" class="img-fluid satisResim YzAxxTXzAx">';                                                 
    }else if($Value==7){                                              
        $Platform='<img src="images/xbox.png" class="img-fluid satisResim YzAxxTXzAx">';                                           
    }else if($Value==8){                                         
        $Platform='<img src="images/stadia.png" class="img-fluid satisResim YzAxxTXzAx">';                                          
   }else{
        $Platform="";
   }                                                
    return $Platform;
}

function number_format_short( $n, $precision = 1 ) {
    if ($n < 1000) {
        $n_format = bcdiv($n, $precision,1);
        $suffix = '';
    } else if ($n < 1000000) {
        
        $n_format = bcdiv($n / 1000, $precision,1);
         $suffix = 'K ';
    } else if ($n < 1000000000) {
        $n_format = bcdiv($n / 1000000, $precision,1);
        $suffix = 'M ';
    } else if ($n < 1000000000000) {
        $n_format = bcdiv($n / 1000000000, $precision,1);
        $suffix = 'B ';
    }else {                                               
        $n_format = bcdiv($n / 1000000000000, $precision,1);
        $suffix = 'T  ';
    }
                                                 
    if ($precision > 0 ) {
        $dotzero = '.' . str_repeat( '0', $precision );
        $n_format = str_replace( $dotzero, '', $n_format );
    }
    return $n_format . $suffix;
 }
                                                                                     
function time_ago($timestamp){
    $timestamp      = (int) $timestamp;
    $current_time   = time();
    $diff           = $current_time - $timestamp;
    $intervals      = array (
        'yıl' => 31556926, 'ay' => 2629744, 'hafta' => 604800, 'gün' => 86400, 'saat' => 3600, 'dakika'=> 60
    );
    if ($diff == 0)
    {
        return 'şimdi';
    }
    if ($diff < 60)
    {
        return 'şimdi';
    }
    if ($diff >= 60 && $diff < $intervals['saat'])
    {
        $diff = floor($diff/$intervals['dakika']);
        return $diff == 1 ? $diff .' dakika önce' : $diff .' dakika önce';
    }
    if ($diff >= $intervals['saat'] && $diff < $intervals['gün'])
    {
        $diff = floor($diff/$intervals['saat']);
        return $diff == 1 ? $diff .' saat önce' : $diff .' saat önce';
    }
    if ($diff >= $intervals['gün'] && $diff < $intervals['hafta'])
    {
        $diff = floor($diff/$intervals['gün']);
        return $diff == 1 ? $diff .' gün önce' : $diff .' gün önce';
    }
    if ($diff >= $intervals['hafta'] && $diff < $intervals['ay'])
    {
        $diff = floor($diff/$intervals['hafta']);
        return $diff == 1 ? $diff .' hafta önce' : $diff .' hafta önce';
    }
    if ($diff >= $intervals['ay'] && $diff < $intervals['yıl'])
    {
        $diff = floor($diff/$intervals['ay']);
        return $diff == 1 ? $diff .' ay önce' : $diff .' ay önce';
    }
    if ($diff >= $intervals['yıl'])
    {
        $diff = floor($diff/$intervals['yıl']);
        return $diff == 1 ? $diff .' yıl önce' : $diff .' yıl önce';
    }
}
function SEO($Value){
	$Icerik = trim($Value);
	$Degisecekler = array("ç","Ç","ğ","Ğ","ı","İ","ö","Ö","ş","Ş","ü","Ü");
	$Degisenler = array("c","c","g","g","i","i","o","o","s","s","u","u");
	$Icerik = str_replace($Degisecekler,$Degisenler, $Icerik);
	$Icerik = mb_strtolower($Icerik,"UTF-8");
	$Icerik = preg_replace("/[^a-z0-9.]/","-", $Icerik);
	$Icerik = preg_replace("/-+/","-", $Icerik);
	$Icerik = trim($Icerik,"-");
	return $Icerik;
}
function TarihCevir($Value){
	$Cevir =date("d.m.Y H:i:s",$Value);
	$Sonuc = $Cevir;
	return $Sonuc;
}
function YaziTemizle($Value){
	$Operation = preg_replace("/[^0-9]/", "", $Value);
	return $Operation;
}
function IcerikTemizle($Value){
	$Undo         = htmlspecialchars_decode($Value,ENT_QUOTES);
	return $Undo;
}
function Guvenlik($Value){
	$DeleteSpace  = trim($Value);
	$DeleteTag    = strip_tags($DeleteSpace);
	$Clean        = htmlspecialchars($DeleteTag,ENT_QUOTES);
	$result       = $Clean;
	return $result;
}
function Editor($Value){
    $DeleteSpace  = trim($Value);
    $DeleteTag    = strip_tags($DeleteSpace,"<br></br><u></u><i></i><hr><ol><li></li></ol><ul><li></li></ul><h1></h1><h2></h2><h3></h3><h4></h4><h5></h5><h6></h6>");
    $Clean        = htmlspecialchars($DeleteSpace,ENT_QUOTES,"");
    $result       = $Clean;
    return $result;
}
function SayfaNumarasiTemizle($Value){
	$DeleteSpace  = trim($Value);
	$DeleteTag    = strip_tags($DeleteSpace);
	$Clean        = htmlspecialchars($DeleteTag,ENT_QUOTES);
	$Filter       = YaziTemizle($Clean);
	return $Filter;
}
function aktivasyonKod(){
	$bir  = rand(10000,99999);
	$iki   = rand(10000,99999);
	$uc   = rand(10000,99999);
	$kod =  $bir . "-" . $iki . "-" . $uc   ;
	$sonuc = $kod;
	return $sonuc;
}
function ResimAdi(){
	$sonuc=  substr(md5(uniqid(time())),0,25);
	return  $sonuc;
}
?>