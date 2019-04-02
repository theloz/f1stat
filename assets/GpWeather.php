<?php
namespace app\assets;

class GpWeather{
    public function __construct(){
        $this->apiUrl = "http://api.weatherunlocked.com/api";
    }
    public function getGpWeather($gp, $day){
        $c = self::getTriggerRequest($gp->circuit->lat.','.$gp->circuit->lng, 'current precipitationtype not anysnow and current precipitationtype not anyrain' );
        //$c = file_get_contents($url);
        $answer = json_decode($c);
        if($answer->ConditionMatched!='Yes'){
            return [];
        }
        else if($answer->ConditionMatched=='Yes' && $answer->ConditionMatchedNum=='1'){
            return "sunny";
        }
        return $c;
    }
    public function getGpCurrentWeather($gp){
        $r = self::getLocationRequest('current',$gp->circuit->lat.','.$gp->circuit->lng);
        if($r){
            $answer = json_decode($r);
            if(!isset($answer->Message)){
                return $answer;
            }
            else{
                return false;
            }
        }
        return \json_decode($r);
    }
    
    public function getGpForecast($gp){
        $r = self::getLocationRequest('forecast',$gp->circuit->lat.','.$gp->circuit->lng);
        if($r){
            $answer = json_decode($r);
            if(!isset($answer->Message)){
                return $answer;
            }
            else{
                return false;
            }
        }
        return \json_decode($r);
    }
    private static function getKey(){
        return "a72ee256fc81f6394f6abc972fe04fdc";
    }
    private static function getAppID(){
        return "b2a1db8c";
    }
    /**
     * location (string): has to be expressed as "lat,lng"
     * query (string): sample is "current precipitationtype not anysnow and current precipitationtype not anyrain"
     */
    private function getTriggerRequest($location, $query){
        $service_url = $this->apiUrl.'/trigger/'.$location.'/'.str_replace(" ","%20",$query).'?app_id='.self::getAppID().'&app_key='.self::getKey();
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        return $curl_response;
    }
    private function getLocationRequest($type,$location){
        $service_url = $this->apiUrl.'/'.$type.'/'.$location.'?app_id='.self::getAppID().'&app_key='.self::getKey();
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: json',
        ]);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        return $curl_response;
    }
}