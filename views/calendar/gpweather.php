<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonGroup;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\icons\Icon;
Icon::map($this);
// echo '<pre>'.print_r($weather,true).'</pre>';
?>
<div id="gpweather-index" class="weather-gradient">
    <div class="row">
        <div class="col-12">
            <div class="card mw-100 w-100 h-100">
                <h5 class="card-body text-center">
                    <p><?= $race->name ?>  <small>Round #<?= $race->round ?></small></p>
                    <p><?= Html::a(Icon::show('map-marked-alt', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), 
                                Url::to('https://www.google.com/maps/search/?api=1&query='.$race->circuit->lat.','.$race->circuit->lng, true),
                                ['alt'=>Yii::t('app','map'), 'title'=>Yii::t('app','map'), 'target'=>'_blank']
                        ).$race->circuit->location.' ('.$race->circuit->country.')' ?></p>
                    <p><?= Yii::t('app', '7 days forecast')?></p>
                </h5>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <?php
        foreach($weather->Days as $w){
        ?>
            <div class="p-2 text-center weather-cell">
                <?php 
                //get the 1200 forecast as icon sample
                $days = $w->Timeframes;
                $mainIcon = (isset($days[1])) ? str_replace("gif","png", $days[1]->wx_icon) : '';
                $mainForecast = (isset($days[1])) ? $days[1]->wx_desc : '';
                $stDate = substr($w->date,-4).'-'.substr($w->date,3,2).'-'.substr($w->date,0,2);
                ?>
                <p class="weather-font text-nowrap"><?= date('D, d/m/Y', strtotime($stDate)) ?></p>
                <div class="img-container"><img src="images/weather/<?= $mainIcon ?>" class="img-fluid rounded text-center" /></div>
                <p class="weather-font text-nowrap"><?= Yii::t('app',$mainForecast)?></p>
                <p class="weather-font text-nowrap"><b><?= $w->temp_max_c.'°C / '.$w->temp_max_f.'°F'?></b></p>
                <p class="weather-font text-nowrap"><?= $w->temp_min_c.'°C / '.$w->temp_min_f.'°F'?></p>
                <p class="weather-font text-nowrap"><?= Icon::show('sun', ['class'=>'fa-lg']).$w->sunrise_time ?></p>
                <p class="weather-font text-nowrap"><?= Icon::show('moon',['class'=>'fa-lg']).$w->sunset_time ?></p>
                <?php //echo '<pre>'.print_r($w,true).'</pre>' ?>
                <p class="text-uppercase text-center">
                    <?php
                    Modal::begin([
                        'title' => date('D, d/m/Y', strtotime($stDate)).' - '.$race->circuit->location.' ('.$race->circuit->country.')',
                        'toggleButton' => ['label' => Yii::t('app','details'), 'class'=>'btn btn-small btn-info text-uppercase'],
                        'size' => 'modal-lg',
                        'options' => []
                    ]);
                    echo '<div class="d-flex flex-wrap justify-content-center rounded weather-gradient">';
                    foreach($days as $d){
                        // echo '<pre>'.print_r($d->wx_icon).'</pre>';
                        $icon = str_replace("gif","png", $d->wx_icon);
                        $t = $d->time;
                        switch(strlen($d->time)){
                            case 1:
                                $t = '00:00';
                                break;
                            case 3:
                                $t = '0'.substr($d->time,0,1).':'.substr($d->time,-2);
                                break;
                            case 4:
                                $t = substr($d->time,0,2).':'.substr($d->time,-2);
                                break;
                        }
                        // $t = (strlen($d->time)==3 ? '0'.substr($d->time,0,1).':' : substr($d->time,0,2).':').substr($d->time,-2);
                        echo '<div class="p-2 text-center weather-cell">';
                        echo '<p>'.$t.'</p>';
                        // echo '<p>'.$d->time.'</p>';
                        // echo '<p>'.$d->wx_desc.'</p>';
                        echo '<div class="img-container"><img src="images/weather/'.$icon.'" class="img-fluid rounded text-center" /></div>';
                        echo '<p>'.Yii::t('app','temp').'<br />'.$d->temp_c.'°C<br />'.$d->temp_f.'°F</p>';
                        echo '<p>'.Yii::t('app','wind').'<br />'.$d->windspd_kts.'kts<br />'.$d->windspd_kmh.'kmh<br />'.$d->windspd_mph.'mph<br />'.$d->winddir_compass.'</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                    Modal::end();


                    // Html::a(Yii::t('app','details'), Url::toRoute(
                    // ['calendar/gp-weather','gpID'=>$race->raceId]), [
                    //     'alt'           =>Yii::t('app','Weather'), 
                    //     'title'         =>Yii::t('app','Grand prix info'), 
                    //     'class'         =>'btn btn-small btn-info',
                    //     'data-toggle'   =>'modal',
                    //     'data-target'   => 'bd-example-modal-lg',
                    // ]
                    // )
                    ?>
                </p>
            </div>
        <?php
        }
        ?>
    </div>
</div>