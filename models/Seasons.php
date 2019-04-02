<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seasons".
 *
 * @property int $year
 * @property string $url
 */
class Seasons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seasons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            [['year'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['year'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'year' => Yii::t('app', 'Year'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
