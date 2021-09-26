<?php


require_once("api.class.php");





$coinMarketCapApiClass = new coinMarketCapApi;



$coinData = json_decode($coinMarketCapApiClass->getData()); 


// $coinData->data["tags"] = array(); clear coin tags

if($coinData->status->error_code != 0) die($coinData->status->error_message);



foreach ($coinData->data as $value) {

  if(empty($value->id)) continue;

  $logo = ""; $grafik = "";

  $symbol = $value->symbol;


  if(!empty($value->id)) $logo =  '<img src="https://s2.coinmarketcap.com/static/img/coins/64x64/'.$value->id.'.png" height="25" width="25" > '; //coin resmini uzak sunucudan getiriyorum.
    if(!empty($value->id)) $grafik = '<img src="https://s3.coinmarketcap.com/generated/sparklines/web/7d/2781/'.$value->id.'.svg" height="40" width="120" > '; //get coin grafik

    $coinName = $value->name;
    


    $apiMoneyCall =  $value->quote->USD; //



    if(substr($apiMoneyCall->price,0,1) == 0) $price =number_format($apiMoneyCall->price,4); //if price is 0
    else $price= number_format($apiMoneyCall->price,2); //if price not 0

    
    $volume_24h = $apiMoneyCall->volume_24h;
    $percent_change_24h = number_format($apiMoneyCall->percent_change_24h,8);
    $percent_change_7d = number_format($apiMoneyCall->percent_change_7d,8);
    $percent_change_30d = number_format($apiMoneyCall->percent_change_30d,8);
    

    $jsonArray["data"][] = array(
      'cift'=>'  '.$logo.' '.$symbol.' ',
      'coin'=>$coinName,
      'price'=>$price,
      'percentChange24H'=>'<b class="'.$percent_change_24h_Class.'">'.$percent_change_24h.'</b>',
      'percentChange7D'=>$percent_change_7d,
      'percentChange30D'=> $percent_change_30d,
      'volume24H'=>$volume_24h,
      'grafik'=> $grafik

    );
}





echo json_encode($jsonArray);




?>

