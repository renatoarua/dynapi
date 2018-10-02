<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resulttorkphasemodel`.
 */
class m180909_123244_create_resulttorkphasemodel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resulttorkphasemodel', [
            'torkPhaseId' => $keys,
            'torsionalId' => $keys,
            'position' => $scinumber,
            'tork' => $scinumber,
            'phase' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resulttorkphasemodel', 'torkPhaseId');

        $this->createIndex(
            'idx-phasetork-torsional',
            'resulttorkphasemodel',
            'torsionalId'
        );

        $this->addForeignKey(
            'fk-phasetork-torsional',
            'resulttorkphasemodel',
            'torsionalId',
            'resulttorsional',
            'torsionalId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-phasetork-torsional',
            'resulttorkphasemodel'
        );

        $this->dropIndex(
            'idx-phasetork-torsional',
            'resulttorkphasemodel'
        );

        $this->dropTable('resulttorkphasemodel');
    }
}
