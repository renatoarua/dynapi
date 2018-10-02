<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultphasemodel`.
 */
class m180909_123229_create_resultphasemodel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultphasemodel', [
            'phaseId' => $keys,
            // 'unbalanceId' => $keys,
            'model' => $this->string(15), // resultunbalance, resulttime
            'modelId' => $keys,
            'position' => $scinumber,
            'unbalance' => $scinumber,
            'phase' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultphasemodel', 'phaseId');

        $this->createIndex(
            'idx-phase-unbalance',
            'resultphasemodel',
            'modelId'
        );

        /*$this->addForeignKey(
            'fk-phase-unbalance',
            'resultphasemodel',
            'unbalanceId',
            'resultunbalance',
            'unbalanceId',
            'CASCADE'
        );*/
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        /*$this->dropForeignKey(
            'fk-phase-unbalance',
            'resultphasemodel'
        );*/

        $this->dropIndex(
            'idx-phase-unbalance',
            'resultphasemodel'
        );

        $this->dropTable('resultphasemodel');
    }
}
