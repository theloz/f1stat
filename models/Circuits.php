<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "circuits".
 *
 * @property int $circuitId
 * @property string $circuitRef
 * @property string $name
 * @property string $location
 * @property string $country
 * @property double $lat
 * @property double $lng
 * @property int $alt
 * @property string $url
 */
class Circuits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'circuits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lat', 'lng'], 'number'],
            [['alt'], 'integer'],
            [['circuitRef', 'name', 'location', 'country', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'circuitId' => Yii::t('app', 'Circuit ID'),
            'circuitRef' => Yii::t('app', 'Circuit Ref'),
            'name' => Yii::t('app', 'Name'),
            'location' => Yii::t('app', 'Location'),
            'country' => Yii::t('app', 'Country'),
            'lat' => Yii::t('app', 'Lat'),
            'lng' => Yii::t('app', 'Lng'),
            'alt' => Yii::t('app', 'Alt'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
