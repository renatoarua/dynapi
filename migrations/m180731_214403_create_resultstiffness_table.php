<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resultstiffness`.
 */
class m180731_214403_create_resultstiffness_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('resultstiffness', [
            'crticalMapId' => $keys,
            'settingId' => $this->integer(11),
            'initialStiff' => $scinumber,
            'initialSpeed' => $scinumber,
            'finalSpeed' => $scinumber,
            'numDecades' => $scinumber,
            'numFrequencies' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'resultstiffness', 'crticalMapId');

        $this->createIndex(
            'idx-stiffness-setting',
            'resultstiffness',
            'settingId'
        );

        $this->addForeignKey(
            'fk-stiffness-setting',
            'resultstiffness',
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
        Yii::$app->db->createCommand()->truncateTable('resultstiffness')->execute();
        $this->dropForeignKey(
            'fk-stiffness-setting',
            'resultstiffness'
        );

        $this->dropIndex(
            'idx-stiffness-setting',
            'resultstiffness'
        );

        $this->dropTable('resultstiffness');
    }
}
