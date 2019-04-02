<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Nav;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
// \Yii::$app->language = 'it-IT';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel'    => 'Loz F1 stats project &copy '.date("Y"),
        'options'       => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark',
        ]
    ]);
    echo Nav::widget([
        'items' => [
            [
                'label' => ucfirst(\Yii::t('app', 'dashboard')),
                'url' => ['site/index'],
                //'linkOptions' => [],
            ],
            [
                'label' => ucfirst(\Yii::t('app', 'drivers')),
                'url' => ['site/drivers'],
                //'linkOptions' => [],
            ],
            [
                'label' => ucfirst(\Yii::t('app', 'teams')),
                'url' => ['site/teams'],
                //'linkOptions' => [],
            ],
            [
                'label' => ucfirst(\Yii::t('app', 'circuits')),
                'url' => ['site/circuits'],
                //'linkOptions' => [],
            ],
            [
                'label' => ucfirst(\Yii::t('app', 'lap'))." ".\Yii::t('app', 'chart'),
                'url' => ['site/lapcharts'],
                //'linkOptions' => [],
            ],
            [
                'label' => ucfirst(\Yii::t('app', 'comparisons')),
                'url' => ['site/comparisons'],
                //'linkOptions' => [],
            ],
            // [
            //     'label' => 'Dropdown',
            //     'items' => [
            //         ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
            //         '<div class="dropdown-divider"></div>',
            //         '<div class="dropdown-header">Dropdown Header</div>',
            //         ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
            //     ],
            // ],
            // [
            //     'label' => 'Login',
            //     'url' => ['site/login'],
            //     'visible' => Yii::$app->user->isGuest
            // ],
        ],
        'options' => ['class' =>'nav nav-pills'],
    ]);
    
    NavBar::end();
    ?>
    <div class="container-fluid mt-2">
        <div id="main-container" class="row">
            <div class="col-12">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="float-left">&copy; Loz F1 Stat project <?=date("Y")?></p>
        <p class="float-right"><?= Yii::powered() ?>, <?= Html::a('Ergast', Url::to('http://ergast.com/mrd/', true), ['target'=>'_blank'])?>, <?= Html::a('Chart.js', Url::to('https://www.chartjs.org', true), ['target'=>'_blank'])?></p>
    </div>
    <div class="row">
        <div class="col-12">
            <p class="float-left"><?php 
            $url = Url::toRoute(['utils/get-last-result']);
            echo Html::a("Allinea risultati", $url);
            ?></p>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
