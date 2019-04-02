<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "laptimes".
 *
 * @property int $raceId
 * @property int $driverId
 * @property int $lap
 * @property int $position
 * @property string $time
 * @property int $milliseconds
 */
class Laptimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'laptimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'driverId', 'lap'], 'required'],
            [['raceId', 'driverId', 'lap', 'position', 'milliseconds'], 'integer'],
            [['time'], 'string', 'max' => 255],
            [['raceId', 'driverId', 'lap'], 'unique', 'targetAttribute' => ['raceId', 'driverId', 'lap']],
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
            'lap' => Yii::t('app', 'Lap'),
            'position' => Yii::t('app', 'Position'),
            'time' => Yii::t('app', 'Time'),
            'milliseconds' => Yii::t('app', 'Milliseconds'),
        ];
    }
}
