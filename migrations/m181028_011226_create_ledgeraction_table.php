<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plantype`.
 */
class m181028_011226_create_ledgeraction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('pay_ledgeraction', [
            'actionId' => $this->primaryKey(),
            'name' => $this->string(25),
            'description' => $this->string(80)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('pay_ledgeraction');
    }
}
