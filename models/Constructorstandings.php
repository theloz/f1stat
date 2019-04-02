<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "constructorstandings".
 *
 * @property int $constructorStandingsId
 * @property int $raceId
 * @property int $constructorId
 * @property double $points
 * @property int $position
 * @property string $positionText
 * @property int $wins
 */
class Constructorstandings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'constructorstandings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'constructorId', 'position', 'wins'], 'integer'],
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
            'constructorStandingsId' => Yii::t('app', 'Constructor Standings ID'),
            'raceId' => Yii::t('app', 'Race ID'),
            'constructorId' => Yii::t('app', 'Constructor ID'),
            'points' => Yii::t('app', 'Points'),
            'position' => Yii::t('app', 'Position'),
            'positionText' => Yii::t('app', 'Position Text'),
            'wins' => Yii::t('app', 'Wins'),
        ];
    }
}
