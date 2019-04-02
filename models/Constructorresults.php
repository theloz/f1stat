<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "constructorresults".
 *
 * @property int $constructorResultsId
 * @property int $raceId
 * @property int $constructorId
 * @property double $points
 * @property string $status
 */
class Constructorresults extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'constructorresults';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['raceId', 'constructorId'], 'integer'],
            [['points'], 'number'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'constructorResultsId' => Yii::t('app', 'Constructor Results ID'),
            'raceId' => Yii::t('app', 'Race ID'),
            'constructorId' => Yii::t('app', 'Constructor ID'),
            'points' => Yii::t('app', 'Points'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
