<?php

use yii\db\Migration;

/**
 * Handles the creation of table `abs`.
 */
class m180731_192102_create_abs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('abs', [
            'absId' => $keys,
            'machineId' => $keys,
            'position' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'abs', 'absId');

        $this->createIndex(
            'idx-abs-machine',
            'abs',
            'machineId'
        );

        $this->addForeignKey(
            'fk-abs-machine',
            'abs',
            'machineId',
            'machine',
            'machineId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-abs-machine',
            'abs'
        );

        $this->dropIndex(
            'idx-abs-machine',
            'abs'
        );

        $this->dropTable('abs');
    }
}
