<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pay_type`.
 */
class m180732_011236_create_plantype_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('pay_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(25),
            'description' => $this->string(80)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('pay_type');
    }
}
