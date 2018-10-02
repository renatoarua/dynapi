<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultforcemodel`.
 */
class m180909_120619_create_resultforcemodel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultforcemodel', [
            'forceId' => $keys,
            'constantId' => $keys,
            'position' => $scinumber,
            'coord' => $scinumber,
            'force' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultforcemodel', 'forceId');

        $this->createIndex(
            'idx-force-constant',
            'resultforcemodel',
            'constantId'
        );

        $this->addForeignKey(
            'fk-force-constant',
            'resultforcemodel',
            'constantId',
            'resultconstant',
            'constantId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-force-constant',
            'resultforcemodel'
        );

        $this->dropIndex(
            'idx-force-constant',
            'resultforcemodel'
        );

        $this->dropTable('resultforcemodel');
    }
}
