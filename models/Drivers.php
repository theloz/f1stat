<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drivers".
 *
 * @property int $driverId
 * @property string $driverRef
 * @property int $number
 * @property string $code
 * @property string $forename
 * @property string $surname
 * @property string $dob
 * @property string $nationality
 * @property string $url
 */
class Drivers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number'], 'integer'],
            [['dob'], 'safe'],
            [['driverRef', 'forename', 'surname', 'nationality', 'url'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 3],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'driverId' => Yii::t('app', 'Driver ID'),
            'driverRef' => Yii::t('app', 'Driver Ref'),
            'number' => Yii::t('app', 'Number'),
            'code' => Yii::t('app', 'Code'),
            'forename' => Yii::t('app', 'Forename'),
            'surname' => Yii::t('app', 'Surname'),
            'dob' => Yii::t('app', 'Dob'),
            'nationality' => Yii::t('app', 'Nationality'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
    public function getNation(){
        return $this->hasOne(Nationalitynation::className(), ['nationality_name' => 'nationality']);
    }
    public function getConstructor($raceId){
        return $this->hasOne(Results::className(), ['driverId' => 'driverId'])
            ->where(['raceId'=> $raceId])
            ;
    }
}
