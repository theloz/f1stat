<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "constructors".
 *
 * @property int $constructorId
 * @property string $constructorRef
 * @property string $name
 * @property string $nationality
 * @property string $url
 */
class Constructors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'constructors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['constructorRef', 'name', 'nationality', 'url'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'constructorId' => Yii::t('app', 'Constructor ID'),
            'constructorRef' => Yii::t('app', 'Constructor Ref'),
            'name' => Yii::t('app', 'Name'),
            'nationality' => Yii::t('app', 'Nationality'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
