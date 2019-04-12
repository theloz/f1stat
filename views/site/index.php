<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonGroup;
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\icons\Icon;
Icon::map($this);
Icon::map($this, Icon::FI);

$this->title = 'Loz F1 stat project';
$d = new DateTime($tz);
$dtz = ($d->getOffset())/3600;
$dtzString = ($dtz >= 0 ? '+'.$dtz : $dtz); 
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card w-100 h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><?=Yii::t('app', 'Next Race:')?> <?= $nextRace->name ?> - <small>Round #<?= $nextRace->round ?></small></h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text" id="currentracedt">
                        <?= date('d M Y', strtotime($nextRace->date)); ?><br />
                        <small><?= Yii::t('app', 'Local time').' '.date('H:i', strtotime($nextRace->date." ".$nextRace->time)); ?> (UTC <?= $dtzString ?>)</small><br />
                        <small><?= Yii::t('app', 'Your time') ?> <span id="localracedt"></span></small>
                    </p>
                    <p class="card-text"><?=Yii::t('app', 'Time left:')?> <span id="dateCountdown"></span></p>
                    <?= Html::a(Yii::t('app', 'See all races'), Url::toRoute('calendar/all-races'), ['class'=>'btn btn-primary'])?>
                    <p>
                    <?php
                    $w = new \app\assets\GpWeather;
                    $a = $w->getGpCurrentWeather($nextRace);
                    if($a){
                    ?>
                        <h6><?= '<img src="images/weather/'.str_replace("gif","png",$a->wx_icon).'" width="50" />'. Yii::t('app', $a->wx_desc)?></h6>
                        <small><?= Yii::t('app','temp')?>: <?=$a->temp_c?>°C / <?=$a->temp_f?>°F</small><br />
                        <small><?= Yii::t('app','wind')?>: <?=$a->windspd_kts?>kts / <?=$a->windspd_kmh?>kmh / <?=$a->windspd_mph?>mph <?=$a->winddir_compass?></small>
                    <?php
                    }
                    // echo "<pre>".print_r($a,true)."</pre>";
                    ?>
                    </p>
                </div>
                <div class="card-footer allraces-footer">
                        <small class="float-left">
                        <?= Html::a(Icon::showStack('cloud', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::toRoute(['calendar/gp-weather','gpID'=>$nextRace->raceId]), ['alt'=>Yii::t('app','Weather'), 'title'=>Yii::t('app','Grand prix info')]) ?>
                        <?= Html::a(Icon::showStack('map-marked-alt', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), 
                                Url::to('https://www.google.com/maps/search/?api=1&query='.$nextRace->circuit->lat.','.$nextRace->circuit->lng,true),
                                ['alt'=>Yii::t('app','map'), 'title'=>Yii::t('app','map'), 'target'=>'_blank']
                        ) ?>
                        </small>
                        <small class="text-muted float-right">
                        <?= Html::a(Icon::showStack('info-circle', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($nextRace->url, true), ['alt'=>Yii::t('app','Grand prix info'), 'title'=>Yii::t('app','Grand prix info'), 'target'=>'_blank']) ?>
                        <?= Html::a(Icon::showStack('flag-checkered', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($nextRace->circuit->url, true), ['alt'=>Yii::t('app','Circuit info'), 'title'=>Yii::t('app','Circuit info'),'target'=>'_blank']) ?>
                        </small>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card w-100 h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><?=Yii::t('app', 'Drivers standings')?></h5>
                </div>
                <div class="card-body text-center">
                    <?php
                    echo '<table class="table">'.
                        '<thead class="thead-dark">'.
                            '<tr>'.
                                '<th>'.\Yii::t('app','nation').'</th>'.
                                '<th>'.\Yii::t('app','driver').'</th>'.
                                '<th>'.\Yii::t('app','points').'</th>'.
                            '</tr>'.
                        '</thead>'.
                    '<tbody>';
                    foreach($dStands as $d){
                        echo '<tr>';
                        echo '<td>'.Icon::show(strtolower($d->driver->nation->tag->country_code), ['framework' =>  Icon::FI]).'</td>';
                        echo '<td>'.$d->driver->forename." ".$d->driver->surname.'</td>';
                        echo '<td>'.$d->points.'</td>';
                        echo '</tr>';
                    }
                    echo '</tobdy></table>';
                    ?>
                    </p>
                    <p class="text-left">
                    <?= Html::a(Yii::t('app', "See full results"), Url::toRoute(['standings/drivers','raceId'=>$raceId]))?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card w-100 h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><?=Yii::t('app', 'Constructors standings')?></h5>
                </div>
                <div class="card-body text-center">
                    <?php
                    echo '<table class="table">'.
                        '<thead class="thead-dark">'.
                            '<tr>'.
                                '<th>'.\Yii::t('app','nation').'</th>'.
                                '<th>'.\Yii::t('app','driver').'</th>'.
                                '<th>'.\Yii::t('app','points').'</th>'.
                            '</tr>'.
                        '</thead>'.
                    '<tbody>';
                    foreach($cStands as $d){
                        echo '<tr>';
                        echo '<td>'.Icon::show(strtolower($d->constructor->nation->tag->country_code), ['framework' =>  Icon::FI]).'</td>';
                        echo '<td>'.$d->constructor->name.'</td>';
                        echo '<td>'.$d->points.'</td>';
                        echo '</tr>';
                    }
                    echo '</tobdy></table>';
                    ?>
                    </p>
                    <p class="text-left">
                    <?= Html::a(Yii::t('app', "See full results"), Url::toRoute(['standings/constructors','raceId'=>$raceId]))?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 mb-8">
            <div class="card w-100 h-100">
                <div class="card-header text-center">
                    <h5 class="card-title"><?=Yii::t('app', 'Latest results')?>: <?= $currentRace->name ?> - <small>Round #<?= $currentRace->round ?></small></h5>
                </div>
                <div class="card-body text-center">
                    <p class="card-text">
                    <?php
                        echo '<table class="table">'.
                            '<thead class="thead-dark">'.
                                '<tr>'.
                                    '<th>'.\Yii::t('app','position').'</th>'.
                                    '<th class="d-none d-sm-table-cell">'.\Yii::t('app','nation').'</th>'.
                                    '<th>'.\Yii::t('app','driver').'</th>'.
                                    '<th>'.\Yii::t('app','constructor').'</th>'.
                                    '<th class="d-none d-sm-table-cell">'.\Yii::t('app','laps').'</th>'.
                                    '<th class="d-none d-sm-table-cell">'.\Yii::t('app','time').'</th>'.
                                '</tr>'.
                            '</thead>'.
                        '<tbody>';
                        foreach($driverResults as $d){
                            echo '<tr>';
                            echo '<td>'.$d->position.'</td>';
                            echo '<td class="d-none d-sm-table-cell">'.Icon::show(strtolower($d->driver->nation->tag->country_code), ['framework' =>  Icon::FI]).'</td>';
                            echo '<td>'.$d->driver->forename." ".$d->driver->surname.'</td>';
                            echo '<td>'.$d->constructor->name.'</td>';
                            echo '<td class="d-none d-sm-table-cell">'.$d->laps.'</td>';
                            echo '<td class="d-none d-sm-table-cell">'.($d->statusId==1 ? $d->time : $d->status->status).'</td>';
                            echo '</tr>';
                        }
                        echo '</tobdy></table>';
                    ?>
                    </p>
                </div>
                <div class="card-footer allraces-footer">
                <small class="float-left">
                        <?= Html::a(Icon::showStack('map-marked-alt', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), 
                                Url::to('https://www.google.com/maps/search/?api=1&query='.$currentRace->circuit->lat.','.$currentRace->circuit->lng,true),
                                ['alt'=>Yii::t('app','map'), 'title'=>Yii::t('app','map'), 'target'=>'_blank']
                        ) ?>
                        </small>
                        <small class="text-muted float-right">
                        <?= Html::a(Icon::showStack('info-circle', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($currentRace->url, true), ['alt'=>Yii::t('app','Grand prix info'), 'title'=>Yii::t('app','Grand prix info'), 'target'=>'_blank']) ?>
                        <?= Html::a(Icon::showStack('flag-checkered', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($currentRace->circuit->url, true), ['alt'=>Yii::t('app','Circuit info'), 'title'=>Yii::t('app','Circuit info'),'target'=>'_blank']) ?>
                        </small>
                </div>
            </div>
        </div>
    </div> 
</div>
<?php
$this->registerJs('raceCountDown("'.date('M d, Y H:i:s', strtotime($nextRace->date." ".$nextRace->time)).'",\'dateCountdown\', '.$dtz.')', \yii\web\View::POS_END);