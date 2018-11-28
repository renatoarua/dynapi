<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_info".
 *
 * @property int $paymentId
 * @property string $invoice
 * @property string $trasaction_id
 * @property int $log_id
 * @property int $product_id
 * @property string $product_name
 * @property int $product_quantity
 * @property int $product_amount
 * @property string $payer_fname
 * @property string $payer_lname
 * @property string $payer_address
 * @property string $payer_city
 * @property string $payer_state
 * @property string $payer_zip
 * @property string $payer_country
 * @property string $payer_email
 * @property string $payment_status
 * @property string $created_at
 */
class PayInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'product_id', 'product_quantity', 'product_amount'], 'integer'],
            [['created_at'], 'safe'],
            [['invoice', 'product_name', 'payer_fname', 'payer_lname', 'payer_address', 'payer_city', 'payer_state', 'payer_country'], 'string', 'max' => 300],
            [['trasaction_id'], 'string', 'max' => 600],
            [['payer_zip'], 'string', 'max' => 15],
            [['payer_email'], 'string', 'max' => 100],
            [['payment_status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'paymentId' => Yii::t('app', 'Payment ID'),
            'invoice' => Yii::t('app', 'Invoice'),
            'trasaction_id' => Yii::t('app', 'Trasaction ID'),
            'log_id' => Yii::t('app', 'Log ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'product_quantity' => Yii::t('app', 'Product Quantity'),
            'product_amount' => Yii::t('app', 'Product Amount'),
            'payer_fname' => Yii::t('app', 'Payer Fname'),
            'payer_lname' => Yii::t('app', 'Payer Lname'),
            'payer_address' => Yii::t('app', 'Payer Address'),
            'payer_city' => Yii::t('app', 'Payer City'),
            'payer_state' => Yii::t('app', 'Payer State'),
            'payer_zip' => Yii::t('app', 'Payer Zip'),
            'payer_country' => Yii::t('app', 'Payer Country'),
            'payer_email' => Yii::t('app', 'Payer Email'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
}
