<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultcampbell`.
 */
class m180731_214352_create_resultcampbell_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultcampbell', [
            'campbellId' => $keys,
            'settingId' => $this->integer(11),
            'initialSpin' => $scinumber,
            'finalSpin' => $scinumber,
            'steps' => $scinumber,
            'crsp' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultcampbell', 'campbellId');

        $this->createIndex(
            'idx-campbell-setting',
            'resultcampbell',
            'settingId'
        );

        $this->addForeignKey(
            'fk-campbell-setting',
            'resultcampbell',
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
        Yii::$app->db->createCommand()->truncateTable('resultcampbell')->execute();

        $this->dropForeignKey(
            'fk-campbell-setting',
            'resultcampbell'
        );

        $this->dropIndex(
            'idx-campbell-setting',
            'resultcampbell'
        );

        $this->dropTable('resultcampbell');
    }
}
