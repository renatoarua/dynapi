<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sheet`.
 */
class m180731_192135_create_sheet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('sheet', [
            'sheetId' => $keys,
            'vesId' => $keys,

            'simple' => $this->boolean(),
            'single' => $this->boolean(),
            'type' => $this->string(25),
            'mass' => $scinumber,
            'inertia' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'sheet', 'sheetId');

        $this->createIndex(
            'idx-sheet-ves',
            'sheet',
            'vesId'
        );

        $this->addForeignKey(
            'fk-sheet-ves',
            'sheet',
            'vesId',
            'ves',
            'vesId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-sheet-ves',
            'sheet'
        );

        $this->dropIndex(
            'idx-sheet-ves',
            'sheet'
        );

        $this->dropTable('sheet');
    }
}
