<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_ledgeraction".
 *
 * @property int $actionId
 * @property string $name
 * @property string $description
 */
class PayLedgeraction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_ledgeraction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 25],
            [['description'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionId' => Yii::t('app', 'Action ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
