<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resulttorsion`.
 */
class m180909_120600_create_resulttorsion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resulttorsional', [
            'torsionalId' => $keys,
            'settingId' => $this->integer(11),
            'initialFrequency' => $scinumber,
            'finalFrequency' => $scinumber,
            'steps' => $scinumber,
            'modes' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resulttorsional', 'torsionalId');

        $this->createIndex(
            'idx-torsional-setting',
            'resulttorsional',
            'settingId'
        );

        $this->addForeignKey(
            'fk-torsional-setting',
            'resulttorsional',
            'settingId',
            'projectsetting',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-torsional-setting',
            'resulttorsional'
        );

        $this->dropIndex(
            'idx-torsional-setting',
            'resulttorsional'
        );

        $this->dropTable('resulttorsional');
    }
}
