<?php

require_once("settings.php");

class coinMarketCapApi extends settingsClass
{


  public $jsonFolderDirectory = "apiFolder/coin.json";
 

  function readFile(){
      $jsonFolder = fopen($this->jsonFolderDirectory, "r");
      return json_decode(fgets($jsonFolder),true);
  }

  public function getData(){


    $jsonCreateAtTime = date_create(date("H:i:s",filemtime($this->jsonFolderDirectory)));
   
    $dateTimeNow = date_create(date("H:i:s"));

   

    $dateDifference = date_diff($dateTimeNow, $jsonCreateAtTime);

    $olusturulmaSaat = $dateDifference->h;
    $olusturulmaDakika = $dateDifference->i;


    $olusturulmaSaniye = $dateDifference->s + $olusturulmaDakika * 60 + ($olusturulmaSaat* 60*60);

    $updateHours = $this->apiFolderConfig["updateHours"];
    $updateMinutes = $this->apiFolderConfig["updateMinutes"];


    $updateSeconds = $this->apiFolderConfig["updateSeconds"] + $updateMinutes * 60 +($updateHours*60*60);

    if($olusturulmaSaniye >= $updateSeconds){
      //yeniden yaz..
      $coinData = $this->curlGetMethod();
      file_put_contents($this->jsonFolderDirectory, $coinData);
    }

    return $this->readFile();


  }

  public function curlGetMethod(){

    $qs = http_build_query($this->parameters); // query string encode the parameters
    $request = "{$this->url}?{$qs}"; // create the request URL


    $curl = curl_init(); // Get cURL resource
    // Set cURL options
    curl_setopt_array($curl, array(
      CURLOPT_URL => $request,            // set the request URL
      CURLOPT_HTTPHEADER => $this->headers,     // set the headers 
      CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));

    $response = curl_exec($curl); // Send the request, save the response
    $data = $response;
    curl_close($curl); // Close request
    return json_encode($data);
   
    
  }

}

?>