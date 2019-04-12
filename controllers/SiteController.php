<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $nextRace = \app\assets\SeasonUtils::getNextGp();
        $tz = \app\assets\SeasonUtils::getRaceTimezone($nextRace->raceId);

        //last gp result
        $rac = \app\models\Races::find()
            ->where( ['<', 'date', new \yii\db\Expression('NOW()')] )
            ->orderBy('date DESC')
            ->one()
        ;
        $raceId = $rac['raceId'];
        $driverResults = \app\models\Results::find()->where(['raceId'=>$raceId])->orderBy('position ASC')->limit(10)->all();
        //$constructorResults = \app\models\Constructorresults::find()->where(['raceId'=>$raceId])->orderBy('points DESC')->limit(10)->all();

        //driver standings
        $dStands = \app\models\Driverstandings::find()->where(['raceId'=>$raceId])->orderBy('position ASC')->limit(6)->all();
        //constructors standings
        $cStands = \app\models\Constructorstandings::find()->where(['raceId'=>$raceId])->orderBy('position ASC')->limit(6)->all();

        //driver of the day
        return $this->render('index', [
            'raceId' => $raceId,
            'nextRace' => $nextRace,
            'currentRace' => $rac,
            'tz' => $tz,
            'driverResults'=> $driverResults,
            //'constructorResults'=> $constructorResults,
            'dStands'=> $dStands,
            'cStands'=> $cStands,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
