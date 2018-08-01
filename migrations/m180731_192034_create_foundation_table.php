<?php

use yii\db\Migration;

/**
 * Handles the creation of table `foundation`.
 */
class m180731_192034_create_foundation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('foundation', [
            'foundationId' => $keys,
            'machineId' => $keys,

            'position' => $scinumber,
            'kxx' => $scinumber,
            'kzz' => $scinumber,
            'cxx' => $scinumber,
            'czz' => $scinumber,
            'mass' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'foundation', 'foundationId');

        $this->createIndex(
            'idx-foundation-machine',
            'foundation',
            'machineId'
        );

        $this->addForeignKey(
            'fk-foundation-machine',
            'foundation',
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
            'fk-foundation-machine',
            'foundation'
        );

        $this->dropIndex(
            'idx-foundation-machine',
            'foundation'
        );

        $this->dropTable('foundation');
    }
}
