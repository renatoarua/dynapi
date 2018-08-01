<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ves`.
 */
class m180731_192049_create_ves_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('ves', [
            'vesId' => $keys,
            'machineId' => $keys,
            'position' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'ves', 'vesId');

        $this->createIndex(
            'idx-ves-machine',
            'ves',
            'machineId'
        );

        $this->addForeignKey(
            'fk-ves-machine',
            'ves',
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
            'fk-ves-machine',
            'ves'
        );

        $this->dropIndex(
            'idx-ves-machine',
            'ves'
        );

        $this->dropTable('ves');
    }
}
