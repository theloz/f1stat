<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonGroup;
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\icons\Icon;
Icon::map($this); 


$this->title = Yii::t('app','All races');
?>
<div id="allraces-index">
    <section>
    <div class="row">
        <?php
        $now = date("Y-m-d H:i:s");
        $datetime2 = new DateTime($now);
        // $n=0;
        foreach($races as $r){
            $pimage = \app\assets\Wikimedia::getPageIcon($r->circuit->url,250);
            $ptitle = str_replace("_"," ",urldecode(\app\assets\Wikimedia::getPageTitleFromUrl($r->circuit->url)));
            $timeLeft = ( strtotime($r->date." ".$r->time) - strtotime($now) );
            $datetime1 = new DateTime($r->date." ".$r->time);
            $interval = $datetime1->diff($datetime2);
            if($interval->invert == 1 ){
                $daysLeft = Yii::t('app','Days left:')." ".$interval->format('%R%a');
            }
            else{
                $daysLeft = Yii::t('app','Event completed')." (".$interval->format('%R%a '.Yii::t('app', 'days')).")";
            }
            echo '<div class="col-lg-4 col-md-12 mb-4 all-races-container">';
            echo '<div class="card w-100 h-100 border-secondary allraces-card">
                    <h5 class="card-header text-center allraces-header">'.$r->name.'<br /><small>Round #'.$r->round.'</small></h5>
                    <!--div class="bs-card-crop"><img src="" class="card-img-top" alt="'.$r->name.'"></div-->
                    <div class="row justify-content-between">
                    <div class="col-12">
                    </div>
                    </div>
                    <div class="card-body text-center row justify-content-center">
                        <div class="card-body-content col-8">
                            <p><strong>'.$ptitle.'</strong></p>
                            <img class="panel-profile-img" src="'.$pimage.'" alt="'.$r->name.'">
                            <p class="card-text">'.date('d M Y - H:i', strtotime($r->date." ".$r->time)).' (local TZ)<br />
                            '.$daysLeft.'</p>
                            <p>
                            '.ucfirst(Yii::t('app','location')).' <b>'.$r->circuit->location.' ('.$r->circuit->country.')</b>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer allraces-footer">
                        <small class="float-left">
                        '.Html::a(Icon::showStack('cloud', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::toRoute(['calendar/gp-weather','gpID'=>$r->raceId]), ['alt'=>Yii::t('app','Weather'), 'title'=>Yii::t('app','Grand prix info')]).'
                        '.Html::a(Icon::showStack('map-marked-alt', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), 
                                Url::to('https://www.google.com/maps/search/?api=1&query='.$r->circuit->lat.','.$r->circuit->lng, true),
                                ['alt'=>Yii::t('app','map'), 'title'=>Yii::t('app','map'), 'target'=>'_blank']
                        ).'
                        </small>
                        <small class="text-muted float-right">
                        '.Html::a(Icon::showStack('info-circle', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($r->url, true), ['alt'=>Yii::t('app','Grand prix info'), 'title'=>Yii::t('app','Grand prix info'), 'target'=>'_blank']).'
                        '.Html::a(Icon::showStack('flag-checkered', 'square', ['class'=>'fa-lg'], ['class'=>'fa-inverse']), Url::to($r->circuit->url, true), ['alt'=>Yii::t('app','Circuit info'), 'title'=>Yii::t('app','Circuit info'),'target'=>'_blank']).'
                        </small>
                    </div>
                </div>';
            
            // echo '<div class="card img-fluid" style="width:100%;background-color:rgba(0,0,0,.7);max-height:200px;height:200px;">
            //         <img class="card-img-top" src="'.$pimage.'" alt='.$r->name.'" style="width:100%">
            //         <div class="card-img-overlay">
            //             <h4 class="card-title">Avro</h4>
            //             <p class="card-text">Tutorial for Apache Avro</p>
            //             <a href="#" class="btn btn-info">Learn</a>
            //         </div>
            //     </div>';
            echo '</div>';
            // $n++;
            // if($n==1){exit;}
        }
        ?>
    </div>
    </section>
</div>