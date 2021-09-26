<?php

class settingsClass
{
  public $url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest";

  public $headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: your api key' //your api key ..
  ];

  public $parameters = [
      'start' => '1', //start coin
      'limit' => '400', // finish coin
      'convert' => "USD" //money type
    ];

  //reflesh time H:M:S
  public $apiFolderConfig = [
    "updateHours" => "0",
    "updateMinutes"=>"0",
    "updateSeconds"=> "1"
  ];

 
}

?>