<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_plan".
 *
 * @property int $planId
 * @property int $group
 * @property int $code
 * @property string $description
 * @property string $costpertx
 * @property string $status
 */
class PayPlan extends \yii\db\ActiveRecord
{
    // const GROUP_MONTHLY = 10;
    // const TYPE_INFINITE = 50;

    // const STATUS_ACTIVE = "ACT";
    // const STATUS_DEACTIVATED = "DAC";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupId', 'typeId', 'tokens'], 'integer'],
            [['costpertx'], 'number'],
            [['description'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'planId' => Yii::t('app', 'Plan ID'),
            'groupId' => Yii::t('app', 'Group'),
            'typeId' => Yii::t('app', 'Type'),
            'description' => Yii::t('app', 'Description'),
            'tokens' => Yii::t('app', 'Tokens'),
            'costpertx' => Yii::t('app', 'Costpertx'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'group';
        $fields[] = 'type';
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(PayGroup::className(), ['id' => 'groupId']);
    }

    public function getType()
    {
        return $this->hasOne(PayType::className(), ['id' => 'groupId']);
    }
}
