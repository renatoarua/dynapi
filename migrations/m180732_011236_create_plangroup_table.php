<?php

use yii\db\Migration;

/**
 * Handles the creation of table `pay_group`.
 */
class m180732_011236_create_plangroup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('pay_group', [
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
        $this->dropTable('pay_group');
    }
}
