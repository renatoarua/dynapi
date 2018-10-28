<?php

use yii\db\Migration;

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
    $this->createTable('order', [
      'orderId' => $this->primaryKey(),
      'date' => $this->integer(15),
      'userId' => $this->integer(11),
      'planId' => $this->integer(11),
      'paymentId' => $this->integer(11)
    ]);

    /*$this->createIndex('idx-order-date', 'order', 'dateId');*/
    $this->createIndex('idx-order-user', 'order', 'userId');
    $this->createIndex('idx-order-plan', 'order', 'planId');
    $this->createIndex('idx-order-payment', 'order', 'paymentId');

    /*$this->addForeignKey(
      'fk-order-date',
      'order',
      'dateId',
      'date',
      'dateId',
      'CASCADE'
    );*/

    $this->addForeignKey(
      'fk-order-user',
      'order',
      'userId',
      'user',
      'id',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-order-plan',
      'order',
      'planId',
      'plan',
      'planId',
      'CASCADE'
    );

    $this->addForeignKey(
      'fk-order-payment',
      'order',
      'paymentId',
      'payment',
      'paymentId',
      'CASCADE'
    );
  }

  /**
   * {@inheritdoc}
   */
  public function down()
  {
    // $this->dropForeignKey('fk-order-date', 'order');
    $this->dropForeignKey('fk-order-plan', 'order');
    $this->dropForeignKey('fk-order-user', 'order');
    $this->dropForeignKey('fk-order-payment', 'order');

    // $this->dropIndex('idx-order-date', 'order');
    $this->dropIndex('idx-order-plan', 'order');
    $this->dropIndex('idx-order-user', 'order');
    $this->dropIndex('idx-order-payment', 'order');

    $this->dropTable('order');
  }
}
