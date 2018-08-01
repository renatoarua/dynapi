<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultstiffness`.
 */
class m180731_214403_create_resultstiffness_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultstiffness', [
            'crticalMapId' => $keys,
            'machineId' => $keys,
            'initialStiff' => $scinumber,
            'initialSpeed' => $scinumber,
            'finalSpeed' => $scinumber,
            'numDecades' => $scinumber,
            'numFrequencies' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultstiffness', 'crticalMapId');

        $this->createIndex(
            'idx-stiffness-machine',
            'resultstiffness',
            'machineId'
        );

        $this->addForeignKey(
            'fk-stiffness-machine',
            'resultstiffness',
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
            'fk-stiffness-machine',
            'resultstiffness'
        );

        $this->dropIndex(
            'idx-stiffness-machine',
            'resultstiffness'
        );

        $this->dropTable('resultstiffness');
    }
}
