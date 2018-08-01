<?php

use yii\db\Migration;

/**
 * Handles the creation of table `project`.
 */
class m180731_183112_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('project', [
            'projectId'     => $this->string(21),
            'userId'      => $this->integer(),
            'name'     => $this->string(64),
            'status'     => $this->string(3)
        ]);

        $this->addPrimaryKey('PK1', 'project', 'projectId');

        // creates index for table `setting`
        $this->createIndex(
            'idx-project-user',
            'project',
            ['userId']
        );

        $this->addForeignKey(
            'fk-project-user',
            'project',
            'userId',
            'user',
            'projectId',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropIndex('idx-project-user', 'project');
        $this->dropTable('project');
    }
}
