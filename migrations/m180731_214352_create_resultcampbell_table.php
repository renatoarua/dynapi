<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultcampbell`.
 */
class m180731_214352_create_resultcampbell_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultcampbell', [
            'campbellId' => $keys,
            'machineId' => $keys,
            'initialSpin' => $scinumber,
            'finalSpin' => $scinumber,
            'steps' => $scinumber,
            'crsp' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultcampbell', 'campbellId');

        $this->createIndex(
            'idx-campbell-machine',
            'resultcampbell',
            'machineId'
        );

        $this->addForeignKey(
            'fk-campbell-machine',
            'resultcampbell',
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
            'fk-campbell-machine',
            'resultcampbell'
        );

        $this->dropIndex(
            'idx-campbell-machine',
            'resultcampbell'
        );

        $this->dropTable('resultcampbell');
    }
}
