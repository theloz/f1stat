<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nationalitynation".
 *
 * @property string $nationality_name
 * @property string $country_name
 */
class Nationalitynation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nationalitynation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nationality_name', 'country_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nationality_name' => Yii::t('app', 'Nationality Name'),
            'caountry_name' => Yii::t('app', 'Country Name'),
        ];
    }
    public function getTag(){
        return $this->hasOne(Country::className(), ['country_name' => 'country_name']);
    }
}
