<?php

use yii\db\Migration;

/**
 * Handles the creation of table `section`.
 */
class m180731_191828_create_section_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('section', [
            'sectionId' => $keys,
            'machineId' => $keys,
            'materialId' => $keys,
            'position' => $scinumber,
            'externalDiameter' => $scinumber,
            'internalDiameter' => $scinumber,
            'young' => $scinumber,
            'poisson' => $scinumber,
            'density' => $scinumber,
            'axialForce' => $scinumber,
            'magneticForce' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'section', 'sectionId');

        $this->createIndex(
            'idx-section-machine',
            'section',
            'machineId'
        );

        $this->addForeignKey(
            'fk-section-machine',
            'section',
            'machineId',
            'machine',
            'machineId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-section-machine',
            'section'
        );

        $this->dropIndex(
            'idx-section-machine',
            'section'
        );

        $this->dropTable('section');
    }
}
