<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultmodes`.
 */
class m180909_120031_create_resultmodes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        // $tableName = $this->db->tablePrefix . 'resultmodes';
        // if ($this->db->getTableSchema($tableName, true) === null) {
        $this->createTable('resultmodes', [
            'modesId' => $keys,
            'settingId' => $this->integer(11),
            'maxFrequency' => $scinumber,
            'numModes' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultmodes', 'modesId');

        $this->createIndex(
            'idx-modes-setting',
            'resultmodes',
            'settingId'
        );
        // }



        $this->addForeignKey(
            'fk-modes-setting',
            'resultmodes',
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
        Yii::$app->db->createCommand()->truncateTable('resultmodes')->execute();
        $this->dropForeignKey(
            'fk-modes-setting',
            'resultmodes'
        );

        $this->dropIndex(
            'idx-modes-setting',
            'resultmodes'
        );

        $this->dropTable('resultmodes');
    }
}

