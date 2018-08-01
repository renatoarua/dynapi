<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sheetmaterial`.
 */
class m180731_192146_create_sheetmaterial_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('sheetmaterial', [
            'sheetMaterialId' => $keys,
            'sheetId' => $keys,

            'go' => $scinumber,
            'goo' => $scinumber,
            'beta' => $scinumber,
            'b1' => $scinumber,
            'theta1' => $scinumber,
            'theta2' => $scinumber,
            'temperature' => $scinumber,
            'temperatureRef' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'sheetmaterial', 'sheetMaterialId');

        $this->createIndex(
            'idx-sheetmaterial-sheet',
            'sheetmaterial',
            'sheetId'
        );

        $this->addForeignKey(
            'fk-sheetmaterial-sheet',
            'sheetmaterial',
            'sheetId',
            'sheet',
            'sheetId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-sheetmaterial-sheet',
            'sheetmaterial'
        );

        $this->dropIndex(
            'idx-sheetmaterial-sheet',
            'sheetmaterial'
        );

        $this->dropTable('sheetmaterial');
    }
}
