<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment`.
 */
class m180732_013055_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pay_info', [
            'paymentId' => $this->primaryKey(),
            // maybe need invoice and tx tables
            'invoice' => $this->string(300),
            'trasaction_id' => $this->string(600),
            'log_id' => $this->integer(11),
            'product_id' => $this->integer(),
            'product_name' => $this->string(300),
            'product_quantity' => $this->integer(5),
            'product_amount' => $this->integer(5),
            'payer_fname' => $this->string(300),
            'payer_lname' => $this->string(300),
            'payer_address' => $this->string(300),
            'payer_city' => $this->string(300),
            'payer_state' => $this->string(300),
            'payer_zip' => $this->string(15),
            'payer_country' => $this->string(300),
            'payer_email' => $this->string(100),
            'payment_status' => $this->string(3),
            // 'created_at' => $this->date() / dateTime()
            'created_at' => $this->timestamp()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pay_info');
    }
}
