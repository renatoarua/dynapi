<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plantype`.
 */
class m181028_011226_create_plantype_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('plantype', [
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
        $this->dropTable('plantype');
    }
}
