<?php

use yii\db\Migration;
// use yii\db\Schema;

/**
 * Handles the creation of table `order`. (orderfact, relationship)
 */
class m181028_000010_create_order_table extends Migration
{
  /**
   * {@inheritdoc}
   */
  public function up()
  {
    $this->createTable('pay_order', [
      'orderId' => $this->primaryKey(),
      'date' => $this->integer(11),
      'userId' => $this->integer(11),
      'planId' => $this->integer(11),
      'paymentId' => $this->integer(11),
      'costpertx' => $this->money(),
      'price' => $this->money(),
      'quantity' => $this->integer(11),
      'total' => $this->integer(11)
    ]);

    /*$this->createIndex('idx-order-date', 'order', 'dateId');*/
    $this->createIndex('idx-order-user', 'pay_order', 'userId');
    $this->createIndex('idx-order-plan', 'pay_order', 'planId');
    $this->createIndex('idx-order-payment', 'pay_order', 'paymentId');

    /*$this->addForeignKey(
      'fk-order-date',
      'pay_order',
      'dateId',
      'date',
      'dateId',
      'CASCADE'
    );*/

    $this->addForeignKey(
      'fk-order-user',
      'pay_order',
      'userId',
      'user',
      'id',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-order-plan',
      'pay_order',
      'planId',
      'pay_plan',
      'planId',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-order-payment',
      'pay_order',
      'paymentId',
      'pay_info',
      'paymentId',
      'CASCADE'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function down()
  {
    // $this->dropForeignKey('fk-order-date', 'pay_order');
    $this->dropForeignKey('fk-order-plan', 'pay_order');
    $this->dropForeignKey('fk-order-user', 'pay_order');
    $this->dropForeignKey('fk-order-payment', 'pay_order');

    // $this->dropIndex('idx-order-date', 'pay_order');
    $this->dropIndex('idx-order-plan', 'pay_order');
    $this->dropIndex('idx-order-user', 'pay_order');
    $this->dropIndex('idx-order-payment', 'pay_order');

    $this->dropTable('pay_order');
  }
}
