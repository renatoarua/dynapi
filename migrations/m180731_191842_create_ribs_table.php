<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ribs`.
 */
class m180731_191842_create_ribs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('ribs', [
            'ribId' => $keys,
            'machineId' => $keys,
            'position' => $scinumber,
            'number' => $scinumber,
            'webThickness' => $scinumber,
            'webDepth' => $scinumber,
            'flangeWidth' => $scinumber,
            'flangeThick' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'ribs', 'ribId');

        $this->createIndex(
            'idx-ribs-machine',
            'ribs',
            'machineId'
        );

        $this->addForeignKey(
            'fk-ribs-machine',
            'ribs',
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
            'fk-ribs-machine',
            'ribs'
        );

        $this->dropIndex(
            'idx-ribs-machine',
            'ribs'
        );

        $this->dropTable('ribs');
    }
}
