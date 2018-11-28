<?php

use yii\db\Migration;

/**
 * Handles the creation of table `runlog`.
 */
class m181030_201317_create_runlog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('runlog', [
            'id' => $this->primaryKey(),
            'runId' => $this->integer(11),
            'ledgerId' => $this->integer(11),
            'cost' => $this->money(),
            'task' => $this->string(30),
            'started_at' => $this->integer(11),
            'ended_at' => $this->integer(11),
            'percent' => $this->integer(11),
            'status' => $this->string(3)
        ]);

        $this->createIndex('idx-runlog-run', 'runlog', 'runId');
        $this->createIndex('idx-runlog-ledger', 'runlog', 'ledgerId');

        $this->addForeignKey(
          'fk-runlog-run',
          'runlog',
          'runId',
          'run',
          'id',
          'CASCADE'
        );

        $this->addForeignKey(
          'fk-runlog-ledger',
          'runlog',
          'ledgerId',
          'pay_ledger',
          'ledgerId',
          'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey('fk-runlog-run', 'runlog');
        $this->dropForeignKey('fk-runlog-ledger', 'runlog');

        $this->dropIndex('idx-runlog-run', 'runlog');
        $this->dropIndex('idx-runlog-ledger', 'runlog');

        $this->dropTable('runlog');
    }
}
