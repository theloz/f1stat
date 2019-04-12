<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "driverstandings".
 *
 * @property int $driverStandingsId
 * @property int $raceId
 * @property int $driverId
 * @property double $points
 * @property int $position
 * @property string $positionText
 * @property int $wins
 */
class Driverstandings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driverstandings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'driverId', 'position', 'wins'], 'integer'],
            [['points'], 'number'],
            [['positionText'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'driverStandingsId' => Yii::t('app', 'Driver Standings ID'),
            'raceId' => Yii::t('app', 'Race ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'points' => Yii::t('app', 'Points'),
            'position' => Yii::t('app', 'Position'),
            'positionText' => Yii::t('app', 'Position Text'),
            'wins' => Yii::t('app', 'Wins'),
        ];
    }
    public function getDriver(){
        return $this->hasOne(Drivers::className(), ['driverId' => 'driverId']);
    }
    public function getRace(){
        return $this->hasOne(Races::className(), ['raceId' => 'raceId']);
    }
}
