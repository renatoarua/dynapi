<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_ledger".
 *
 * @property int $ledgerId
 * @property int $action
 * @property int $seller
 * @property int $buyer
 * @property int $orderId
 * @property string $tokenId
 * @property int $date
 * @property string $amount
 */
class PayLedger extends \yii\db\ActiveRecord
{
    public $credit;
    public $debit;
    // const ACTION_CREDIT = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_ledger';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['ledgerId'], 'required'],
            [['actionId', 'sellerId', 'buyerId', 'orderId', 'date'], 'integer'],
            [['amount'], 'number'],
            [['tokenId'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ledgerId' => Yii::t('app', 'Ledger ID'),
            'actionId' => Yii::t('app', 'Action'),
            'sellerId' => Yii::t('app', 'Seller'),
            'buyerId' => Yii::t('app', 'Buyer'),
            'orderId' => Yii::t('app', 'Order ID'),
            'tokenId' => Yii::t('app', 'Token ID'),
            'date' => Yii::t('app', 'Date'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'action';
        // $fields[] = 'seller';
        // $fields[] = 'buyer';
        $fields[] = 'order';
        $fields[] = 'token';
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAction()
    {
        return $this->hasOne(PayLedgeraction::className(), ['actionId' => 'actionId']);
    }

    public function getSeller()
    {
        return $this->hasOne(User::className(), ['id' => 'sellerId']);
    }

    public function getBuyer()
    {
        return $this->hasOne(User::className(), ['id' => 'buyerId']);
    }

    public function getOrder()
    {
        return $this->hasOne(PayOrder::className(), ['orderId' => 'orderId']);
    }

    public function getToken()
    {
        return $this->hasOne(Token::className(), ['tokenId' => 'tokenId']);
    }
}
