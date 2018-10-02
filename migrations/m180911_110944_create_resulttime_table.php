<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resulttime`.
 */
class m180911_110944_create_resulttime_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resulttime', [
            'timeId' => $keys,
            'settingId' => $this->integer(11),
            'initialFrequency' => $scinumber,
            'finalFrequency' => $scinumber,
            'steps' => $scinumber,
            'modes' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resulttime', 'timeId');

        $this->createIndex(
            'idx-time-setting',
            'resulttime',
            'settingId'
        );

        $this->addForeignKey(
            'fk-time-setting',
            'resulttime',
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
            'fk-time-setting',
            'resulttime'
        );

        $this->dropIndex(
            'idx-time-setting',
            'resulttime'
        );

        $this->dropTable('resulttime');
    }
}
