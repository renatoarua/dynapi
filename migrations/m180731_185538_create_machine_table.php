<?php

use yii\db\Migration;

/**
 * Handles the creation of table `machine`.
 */
class m180731_185538_create_machine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('machine', [
            'machineId'       => $this->string(21),
            'projectId'       => $this->string(21),
            'sections'        => $this->json(),
            'discs'           => $this->json(),
            'ribs'            => $this->json(),
            'rollerbearings'  => $this->json(),
            'journalbearings' => $this->json(),
            'journaloptimize' => $this->json(),
            'foundations'     => $this->json(),
            'ves'             => $this->json(),
            'abs'             => $this->json(),
            'ldratio'         => $this->string(15),
        ]);

        $this->addPrimaryKey('PK1', 'machine', 'machineId');

        // creates index for column `projectId`
        $this->createIndex(
            'idx-machine-project',
            'machine',
            'projectId'
        );

        // add foreign key for table `tag`
        // $this->addForeignKey('fk1', 'table1', 'foreign_id', 'table2', 'id','CASCADE','CASCADE');
        $this->addForeignKey(
            'fk-machine-project',
            'machine',
            'projectId',
            'project',
            'projectId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // drops foreign key for table `project`
        $this->dropForeignKey(
            'fk-machine-project',
            'machine'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-machine-project',
            'machine'
        );

        $this->dropTable('machine');
    }
}
