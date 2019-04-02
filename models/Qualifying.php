<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "qualifying".
 *
 * @property int $qualifyId
 * @property int $raceId
 * @property int $driverId
 * @property int $constructorId
 * @property int $number
 * @property int $position
 * @property string $q1
 * @property string $q2
 * @property string $q3
 */
class Qualifying extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qualifying';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'driverId', 'constructorId', 'number', 'position'], 'integer'],
            [['q1', 'q2', 'q3'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'qualifyId' => Yii::t('app', 'Qualify ID'),
            'raceId' => Yii::t('app', 'Race ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'constructorId' => Yii::t('app', 'Constructor ID'),
            'number' => Yii::t('app', 'Number'),
            'position' => Yii::t('app', 'Position'),
            'q1' => Yii::t('app', 'Q1'),
            'q2' => Yii::t('app', 'Q2'),
            'q3' => Yii::t('app', 'Q3'),
        ];
    }
}
