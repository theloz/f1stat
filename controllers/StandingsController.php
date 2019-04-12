<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class StandingsController extends Controller
{
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

    public function actionDrivers($raceId){
        $rac = \app\models\Races::findOne($raceId);
        $dStands = \app\models\Driverstandings::find()->where(['raceId'=>$raceId])->orderBy('position ASC')->all();
        return $this->render('drivers',[
            'race'  => $rac,
            'dStands' => $dStands,
        ]);
    }
    public function actionConstructors($raceId){
        $rac = \app\models\Races::findOne($raceId);
        return $this->render('constructors',[
            'race'  => $rac,
            'dStands' => $dStands,
        ]);
    }
    public function actionChampionship($year){
        return $this->render('championship',[
            'race'  => $rac,
            'dStands' => $dStands,
        ]);
    }
    public function actionRace($raceId){
        $rac = \app\models\Races::findOne($raceId);
        return $this->render('race',[
            'race'  => $rac,
            'dStands' => $dStands,
        ]);
    }
}
