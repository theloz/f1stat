<?php
namespace app\assets;

class Ergast{
    function __construct(){
        $this->url = 'https://ergast.com/api/f1/';
    }
    public function callErgast($query){
        $service_url = $this->url.$query;
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info).var_dump($service_url));
        }
        curl_close($curl);
        return $curl_response;
    }
}