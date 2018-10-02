<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultconstant`.
 */
class m180909_120511_create_resultconstant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultconstant', [
            'constantId' => $keys,
            'settingId' => $this->integer(11),
            'initialFrequency' => $scinumber,
            'finalFrequency' => $scinumber,
            'steps' => $scinumber,
            'modes' => $scinumber,
            'speed' => $scinumber,

        ]);

        $this->addPrimaryKey('PK1', 'resultconstant', 'constantId');

        $this->createIndex(
            'idx-constant-setting',
            'resultconstant',
            'settingId'
        );

        $this->addForeignKey(
            'fk-constant-setting',
            'resultconstant',
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
            'fk-constant-setting',
            'resultconstant'
        );

        $this->dropIndex(
            'idx-constant-setting',
            'resultconstant'
        );

        $this->dropTable('resultconstant');
    }
}
