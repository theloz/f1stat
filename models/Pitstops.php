<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pitstops".
 *
 * @property int $raceId
 * @property int $driverId
 * @property int $stop
 * @property int $lap
 * @property string $time
 * @property string $duration
 * @property int $milliseconds
 */
class Pitstops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pitstops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'driverId', 'stop', 'lap', 'time'], 'required'],
            [['raceId', 'driverId', 'stop', 'lap', 'milliseconds'], 'integer'],
            [['time'], 'safe'],
            [['duration'], 'string', 'max' => 255],
            [['raceId', 'driverId', 'stop'], 'unique', 'targetAttribute' => ['raceId', 'driverId', 'stop']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'raceId' => Yii::t('app', 'Race ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'stop' => Yii::t('app', 'Stop'),
            'lap' => Yii::t('app', 'Lap'),
            'time' => Yii::t('app', 'Time'),
            'duration' => Yii::t('app', 'Duration'),
            'milliseconds' => Yii::t('app', 'Milliseconds'),
        ];
    }
}
