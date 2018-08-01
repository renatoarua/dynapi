<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rollerbearing`.
 */
class m180731_191911_create_rollerbearing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('rollerbearing', [
            'rollerBearingId' => $keys,
            'machineId' => $keys,
            'position' => $scinumber,
            'mass' => $scinumber,
            'inertia' => $scinumber,
            'kxx' => $scinumber,
            'kxz' => $scinumber,
            'kzx' => $scinumber,
            'kzz' => $scinumber,
            'cxx' => $scinumber,
            'cxz' => $scinumber,
            'czx' => $scinumber,
            'czz' => $scinumber,
            'ktt' => $scinumber,
            'ktp' => $scinumber,
            'kpp' => $scinumber,
            'kpt' => $scinumber,
            'ctt' => $scinumber,
            'ctp' => $scinumber,
            'cpp' => $scinumber,
            'cpt' => $scinumber,
            
        ]);

        $this->addPrimaryKey('PK1', 'rollerbearing', 'rollerBearingId');

        $this->createIndex(
            'idx-rollerbearing-machine',
            'rollerbearing',
            'machineId'
        );

        $this->addForeignKey(
            'fk-rollerbearing-machine',
            'rollerbearing',
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
            'fk-rollerbearing-machine',
            'rollerbearing'
        );

        $this->dropIndex(
            'idx-rollerbearing-machine',
            'rollerbearing'
        );

        $this->dropTable('rollerbearing');
    }
}
