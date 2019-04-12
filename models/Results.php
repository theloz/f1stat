<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "results".
 *
 * @property int $resultId
 * @property int $raceId
 * @property int $driverId
 * @property int $constructorId
 * @property int $number
 * @property int $grid
 * @property int $position
 * @property string $positionText
 * @property int $positionOrder
 * @property double $points
 * @property int $laps
 * @property string $time
 * @property int $milliseconds
 * @property int $fastestLap
 * @property int $rank
 * @property string $fastestLapTime
 * @property string $fastestLapSpeed
 * @property int $statusId
 */
class Results extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'driverId', 'constructorId', 'number', 'grid', 'position', 'positionOrder', 'laps', 'milliseconds', 'fastestLap', 'rank', 'statusId'], 'integer'],
            [['points'], 'number'],
            [['positionText', 'time', 'fastestLapTime', 'fastestLapSpeed'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'resultId' => Yii::t('app', 'Result ID'),
            'raceId' => Yii::t('app', 'Race ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'constructorId' => Yii::t('app', 'Constructor ID'),
            'number' => Yii::t('app', 'Number'),
            'grid' => Yii::t('app', 'Grid'),
            'position' => Yii::t('app', 'Position'),
            'positionText' => Yii::t('app', 'Position Text'),
            'positionOrder' => Yii::t('app', 'Position Order'),
            'points' => Yii::t('app', 'Points'),
            'laps' => Yii::t('app', 'Laps'),
            'time' => Yii::t('app', 'Time'),
            'milliseconds' => Yii::t('app', 'Milliseconds'),
            'fastestLap' => Yii::t('app', 'Fastest Lap'),
            'rank' => Yii::t('app', 'Rank'),
            'fastestLapTime' => Yii::t('app', 'Fastest Lap Time'),
            'fastestLapSpeed' => Yii::t('app', 'Fastest Lap Speed'),
            'statusId' => Yii::t('app', 'Status ID'),
        ];
    }
    public function getDriver(){
        return $this->hasOne(Drivers::className(), ['driverId' => 'driverId']);
    }
    public function getRace(){
        return $this->hasOne(Races::className(), ['raceId' => 'raceId']);
    }
    public function getConstructor(){
        return $this->hasOne(Constructors::className(), ['constructorId' => 'constructorId']);
    }
    public function getStatus(){
        return $this->hasOne(Status::className(), ['statusId' => 'statusId']);
    }
}
