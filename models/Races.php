<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "races".
 *
 * @property int $raceId
 * @property int $year
 * @property int $round
 * @property int $circuitId
 * @property string $name
 * @property string $date
 * @property string $time
 * @property string $url
 */
class Races extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'races';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'round', 'circuitId'], 'integer'],
            [['date', 'time'], 'safe'],
            [['name', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'raceId' => Yii::t('app', 'Race ID'),
            'year' => Yii::t('app', 'Year'),
            'round' => Yii::t('app', 'Round'),
            'circuitId' => Yii::t('app', 'Circuit ID'),
            'name' => Yii::t('app', 'Name'),
            'date' => Yii::t('app', 'Date'),
            'time' => Yii::t('app', 'Time'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    public function getResults(){
        return $this->hasMany(Results::className(), ['raceId' => 'raceId']);
    }
    public function getCircuit(){
        return $this->hasOne(Circuits::className(), ['circuitId' => 'circuitId']);
    }
}
