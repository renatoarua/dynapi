<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultresponsemodel`.
 */
class m180909_120701_create_resultresponsemodel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15);
        $keys = $this->string(21)->notNull();

        $this->createTable('resultresponsemodel', [
            'responseId' => $keys,
            'model' => $scinumber, // resultconstant, resulttorsion, resultunbalance
            'modelId' => $keys,
            'position' => $scinumber->notNull()->defaultValue('0.000000e+0'),
            'coord' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultresponsemodel', 'responseId');

        $this->createIndex(
            'idx-response-constant',
            'resultresponsemodel',
            'modelId'
        );

        /*$this->createIndex(
            'idx-response-torsion',
            'resulttorsion',
            'modelId'
        );*/
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        /*$this->dropForeignKey(
            'fk-constant-machine',
            'resultconstant'
        );*/

        $this->dropIndex(
            'idx-response-constant',
            'resultresponsemodel'
        );

        /*$this->dropIndex(
            'idx-response-torsion',
            'resulttorsion'
        );*/

        $this->dropTable('resultresponsemodel');
    }
}
