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
        $this->createTable('pay_ledger', [
            'ledgerId' => $this->primaryKey(),
            'action' => $this->integer(11),
            'seller'  => $this->integer(11),
            'buyer'  => $this->integer(11),
            'orderId' => $this->integer(11),
            'tokenId' => $this->string(3),
            'date' => $this->integer(11),
            'amount' => $this->money(),
        ]);

        $this->createIndex(
            'idx-ledger-action',
            'pay_ledger',
            'action'
        );

        $this->createIndex(
            'idx-ledger-seller',
            'pay_ledger',
            'seller'
        );

        $this->createIndex(
            'idx-ledger-buyer',
            'pay_ledger',
            'buyer'
        );

        $this->createIndex(
            'idx-ledger-order',
            'pay_ledger',
            'orderId'
        );

        $this->createIndex(
            'idx-ledger-token',
            'pay_ledger',
            'tokenId'
        );

        $this->addForeignKey(
            'fk-ledger-action',
            'pay_ledger',
            'action',
            'pay_ledgeraction',
            'actionId',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ledger-seller',
            'pay_ledger',
            'seller',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ledger-buyer',
            'pay_ledger',
            'buyer',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ledger-token',
            'pay_ledger',
            'tokenId',
            'pay_token',
            'tokenId',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ledger-order',
            'pay_ledger',
            'orderId',
            'pay_order',
            'orderId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('fk-ledger-action', 'pay_ledger');
        $this->dropForeignKey('fk-ledger-buyer', 'pay_ledger');
        $this->dropForeignKey('fk-ledger-seller', 'pay_ledger');
        $this->dropForeignKey('fk-ledger-order', 'pay_ledger');
        $this->dropForeignKey('fk-ledger-token', 'pay_ledger');
        $this->dropIndex('idx-ledger-action', 'pay_ledger');
        $this->dropIndex('idx-ledger-buyer', 'pay_ledger');
        $this->dropIndex('idx-ledger-seller', 'pay_ledger');
        $this->dropIndex('idx-ledger-order', 'pay_ledger');
        $this->dropIndex('idx-ledger-token', 'pay_ledger');
        $this->dropTable('pay_ledger');
    }
}
