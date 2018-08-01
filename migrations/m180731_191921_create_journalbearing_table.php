<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journalbearing`.
 */
class m180731_191921_create_journalbearing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('journalbearing', [
            'journalBearingId' => $keys,
            'machineId' => $keys,
            'position' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'journalbearing', 'journalBearingId');

        $this->createIndex(
            'idx-journalbearing-machine',
            'journalbearing',
            'machineId'
        );

        $this->addForeignKey(
            'fk-journalbearing-machine',
            'journalbearing',
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
            'fk-journalbearing-machine',
            'journalbearing'
        );

        $this->dropIndex(
            'idx-journalbearing-machine',
            'journalbearing'
        );

        $this->dropTable('journalbearing');
    }
}
