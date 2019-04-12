<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $country_code
 * @property string $country_name
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_code'], 'string', 'max' => 2],
            [['country_name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'country_code' => Yii::t('app', 'Country Code'),
            'country_name' => Yii::t('app', 'Country Name'),
        ];
    }
}
