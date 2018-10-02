<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultunbalance`.
 */
class m180909_120545_create_resultunbalance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultunbalance', [
            'unbalanceId' => $keys,
            'settingId' => $this->integer(11),
            'initialSpin' => $scinumber,
            'finalSpin' => $scinumber,
            'steps' => $scinumber,
            'modes' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultunbalance', 'unbalanceId');

        $this->createIndex(
            'idx-unbalance-setting',
            'resultunbalance',
            'settingId'
        );

        $this->addForeignKey(
            'fk-unbalance-setting',
            'resultunbalance',
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
            'fk-unbalance-setting',
            'resultunbalance'
        );

        $this->dropIndex(
            'idx-unbalance-setting',
            'resultunbalance'
        );

        $this->dropTable('resultunbalance');
    }
}
