<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class CalendarController extends Controller{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionAllRaces(){
        $races = \app\models\Races::find()->where(['year' => date("Y")])->all();
        return $this->render('allraces',[
            'races' => $races,
        ]);
    }

    public function actionGpWeather($gpID){
        $race = \app\models\Races::find()->where(['raceId' => $gpID])->one();
        $weather = new \app\assets\GpWeather();
        // echo '<pre>'.print_r($weather->getGpForecast($race),true).'</pre>';exit;
        return $this->render('gpweather',[
            'race' => $race,
            'weather' => $weather->getGpForecast($race),
        ]);
    }
}