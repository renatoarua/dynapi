<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_order".
 *
 * @property int $orderId
 * @property int $date
 * @property int $userId
 * @property int $planId
 * @property int $paymentId
 * @property string $costpertx
 * @property string $price
 * @property int $quantity
 * @property int $total
 */
class PayOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'userId', 'planId', 'paymentId', 'quantity', 'total'], 'integer'],
            [['costpertx', 'price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orderId' => Yii::t('app', 'Order ID'),
            'date' => Yii::t('app', 'Date'),
            'userId' => Yii::t('app', 'User ID'),
            'planId' => Yii::t('app', 'Plan ID'),
            'paymentId' => Yii::t('app', 'Payment ID'),
            'costpertx' => Yii::t('app', 'Costpertx'),
            'price' => Yii::t('app', 'Price'),
            'quantity' => Yii::t('app', 'Quantity'),
            'total' => Yii::t('app', 'Total'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        // $fields[] = 'user';
        $fields[] = 'plan';
        $fields[] = 'payment';
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getPlan()
    {
        return $this->hasOne(PayPlan::className(), ['planId' => 'planId']);
    }

    public function getPayment()
    {
        return $this->hasOne(PayInfo::className(), ['paymentId' => 'paymentId']);
    }
}
