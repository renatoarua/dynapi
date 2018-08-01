<?php

use yii\db\Migration;

/**
 * Handles the creation of table `disc`.
 */
class m180731_191858_create_disc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('disc', [
            'discId' => $keys,
            'machineId' => $keys,
            'materialId' => $keys,
            'position' => $scinumber,
            'externalDiameter' => $scinumber,
            'internalDiameter' => $scinumber,
            'thickness' => $scinumber,
            'density' => $scinumber,
            'ix' => $scinumber,
            'iy' => $scinumber,
            'iz' => $scinumber,
            'length' => $scinumber,
            'mass' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'disc', 'discId');

        $this->createIndex(
            'idx-disc-machine',
            'disc',
            'machineId'
        );

        $this->addForeignKey(
            'fk-disc-machine',
            'disc',
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
            'fk-disc-machine',
            'disc'
        );

        $this->dropIndex(
            'idx-disc-machine',
            'disc'
        );

        $this->dropTable('disc');
    }
}
