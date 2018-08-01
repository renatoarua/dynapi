<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sheetrotation`.
 */
class m180731_192157_create_sheetrotation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('sheetrotation', [
            'sheetRotationId' => $keys,
            'sheetId' => $keys,

            'meanRadius' => $scinumber,
            'thickness' => $scinumber,
            'radius' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'sheetrotation', 'sheetRotationId');

        $this->createIndex(
            'idx-sheetrotation-sheet',
            'sheetrotation',
            'sheetId'
        );

        $this->addForeignKey(
            'fk-sheetrotation-sheet',
            'sheetrotation',
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
            'fk-sheetrotation-sheet',
            'sheetrotation'
        );

        $this->dropIndex(
            'idx-sheetrotation-sheet',
            'sheetrotation'
        );

        $this->dropTable('sheetrotation');
    }
}
