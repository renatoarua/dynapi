<?php

use yii\db\Migration;

/**
 * Handles the creation of table `run`.
 */
class m181030_200758_create_run_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('run', [
            'id' => $this->primaryKey(),
            'projectId' => $this->string(21),
            'userId' => $this->integer(11),
            'date' => $this->integer(11),
            'filename' => $this->string(30),
            'exitcode' => $this->integer(11),
            'status' => $this->string(3)
        ]);

        $this->createIndex('idx-run-project', 'run', 'projectId');
        $this->createIndex('idx-run-user', 'run', 'userId');

        $this->addForeignKey(
            'fk-run-project',
            'run',
            'projectId',
            'project',
            'projectId',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-run-user',
            'run',
            'userId',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('fk-run-project', 'run');
        $this->dropForeignKey('fk-run-user', 'run');

        $this->dropIndex('idx-run-project', 'run');
        $this->dropIndex('idx-run-user', 'run');

        $this->dropTable('run');
    }
}
