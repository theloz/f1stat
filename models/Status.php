<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $statusId
 * @property string $status
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'statusId' => Yii::t('app', 'Status ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
