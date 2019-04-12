<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Button;
use yii\bootstrap4\ButtonGroup;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

use kartik\icons\Icon;
Icon::map($this);
Icon::map($this, Icon::FI);

?>
<div id="championshipdriver-index">
    <div class="row">
        <div class="col-lg-12 col-md-12 mb-12">
            <div class="card w-100 h-100">
                <div class="card-header text-center">
                    <div class="row">
                        <div class="col-3 text-left"><button class="btn btn-info">Previous race</button></div>
                        <div class="col-6">
                            <h5 class="card-title"><?=Yii::t('app', 'Drivers standings')?> <?= $race->name ?> <?= $race->year ?> - <small>Round #<?= $race->round ?></small></h5>
                        </div>
                        <div class="col-3 text-right"><button class="btn btn-info">Next race</button></div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <?php
                    echo '<table class="table">'.
                        '<thead class="thead-dark">'.
                            '<tr>'.
                                '<th>'.\Yii::t('app','nation').'</th>'.
                                '<th>'.\Yii::t('app','driver').'</th>'.
                                '<th>'.\Yii::t('app','constructor').'</th>'.
                                '<th>'.\Yii::t('app','points').'</th>'.
                            '</tr>'.
                        '</thead>'.
                    '<tbody>';
                    foreach($dStands as $d){
                        echo '<tr>';
                        echo '<td>'.Icon::show(strtolower($d->driver->nation->tag->country_code), ['framework' =>  Icon::FI]).'</td>';
                        echo '<td>'.$d->driver->forename." ".$d->driver->surname.'</td>';
                        echo '<td>';
                        $c = $d->driver->getConstructor($race->raceId)->one();
                        echo $c->constructor->name;
                        echo '</td>';
                        echo '<td>'.$d->points.'</td>';
                        echo '</tr>';
                    }
                    echo '</tobdy></table>';
                    ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>