<?php

use yii\db\Migration;

/**
 * Handles the creation of table `journalrotation`.
 */
class m180731_192008_create_journalrotation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('journalrotation', [
            'journalRotationId' => $keys,
            'journalBearingId' => $keys,
            'speed' => $scinumber,
            'kxx' => $scinumber,
            'kxz' => $scinumber,
            'kzx' => $scinumber,
            'kzz' => $scinumber,
            'cxx' => $scinumber,
            'cxz' => $scinumber,
            'czx' => $scinumber,
            'czz' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'journalrotation', 'journalRotationId');

        $this->createIndex(
            'idx-journalrotation-bearing',
            'journalrotation',
            'journalBearingId'
        );

        $this->addForeignKey(
            'fk-journalrotation-bearing',
            'journalrotation',
            'journalBearingId',
            'journalbearing',
            'journalBearingId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-journalrotation-bearing',
            'journalrotation'
        );

        $this->dropIndex(
            'idx-journalrotation-bearing',
            'journalrotation'
        );

        $this->dropTable('journalrotation');
    }
}
