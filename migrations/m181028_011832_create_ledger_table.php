<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ledger`. (transaction)
 */
class m181028_011832_create_ledger_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('ledger', [
            'ledgerId' => $this->primaryKey(),
            'orderId' => $this->integer(11),
            'date' => $this->integer(11),
            'cost' => $this->money(),
            'discount' => $this->money(),
            'amount' => $this->money()
        ]);

        $this->createIndex(
            'idx-ledger-order',
            'ledger',
            'orderId'
        );

        $this->addForeignKey(
            'fk-ledger-order',
            'transaction',
            'orderId',
            'order',
            'orderId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('fk-ledger-order', 'ledger');
        $this->dropIndex('idx-ledger-order', 'ledger');
        $this->dropTable('ledger');
    }
}
