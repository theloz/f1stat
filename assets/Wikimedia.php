<?php
namespace app\assets;

class Wikimedia{
    public static function getPageIcon($url,$size){
        $title = urldecode(self::getPageTitleFromUrl($url));
        $newfile = \Yii::getAlias('@webroot').DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$title.'.png';
        //if the file doesn't exists I download it and cache it
        if(!file_exists($newfile)){
            $wUrl = 'https://en.wikipedia.org/w/api.php?action=query&titles='.urlencode($title).'&format=json&prop=pageimages&pithumbsize='.$size.'&redirects';
            $data = json_decode(file_get_contents($wUrl),true);
            //echo "<pre>".print_r($data->query->pages,true)."</pre>";
            $img = '';
            foreach($data['query']['pages'] as $a){
                if(isset($a['thumbnail'])){
                    $img = $a['thumbnail']['source'];
                    break;
                }
                else{
                    throw new \yii\web\HttpException(306, 'Error, array seems to be empty: '.print_r($a,true).' wurl: '.$wUrl."\n".'url: '.$url."\n file: $newfile" );
                }
            }
            if($img!=""){
                if(!copy($img, $newfile)){
                    throw new \yii\web\HttpException(306, "Impossible to get remote file : $title \n wurl: $wUrl \n url: $url");
                }
            }
        }
        return 'images/'.$title.'.png';
    }
    public static function getPageTitleFromUrl($url){
        $token = explode("/wiki/",$url);
        return $token[1];
    }
}