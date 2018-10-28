<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plangroup`.
 */
class m181028_011236_create_plangroup_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('plangroup', [
            'id' => $this->primaryKey(),
            'name' = > $this->string(25),
            'description' = > $this->string(80)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('plangroup');
    }
}
