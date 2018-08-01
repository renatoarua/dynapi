<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sheettranslation`.
 */
class m180731_192208_create_sheettranslation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('sheettranslation', [
            'sheetTranslationId' => $keys,
            'sheetId' => $keys,

            'segments' => $scinumber,
            'thickness' => $scinumber,
            'diameter' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'sheettranslation', 'sheetTranslationId');

        $this->createIndex(
            'idx-sheettranslation-sheet',
            'sheettranslation',
            'sheetId'
        );

        $this->addForeignKey(
            'fk-sheettranslation-sheet',
            'sheettranslation',
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
            'fk-sheettranslation-sheet',
            'sheettranslation'
        );

        $this->dropIndex(
            'idx-sheettranslation-sheet',
            'sheettranslation'
        );

        $this->dropTable('sheettranslation');
    }
}
