<?php

use yii\db\Migration;

/**
 * Handles the creation of table `projectsetting`.
 */
class m180731_213512_create_projectsetting_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('projectsetting', [
            'id' => $this->primaryKey(),
            'projectId'     => $this->string(21),
            'foundation' => $this->boolean(),
            'rollerbearing' => $this->boolean(),
            'journalbearing' => $this->boolean(),
            'ves' => $this->boolean(),
            'abs' => $this->boolean(),
            'staticLine' => $this->boolean(),
            'fatigue' => $this->boolean(),
            'campbell' => $this->boolean(),
            'modes' => $this->boolean(),
            'criticalMap' => $this->boolean(),
            'unbalancedResponse' => $this->boolean(),
            'constantResponse' => $this->boolean(),
            'timeResponse' => $this->boolean(),
            'torsional' => $this->boolean(),
            'balanceOptimization' => $this->boolean(),
            'vesOptimization' => $this->boolean(),
            'absOptimization' => $this->boolean(),
        ]);

        // creates index for column `projectId`
        $this->createIndex(
            'idx-setting-project',
            'projectsetting',
            'projectId'
        );

        $this->addForeignKey(
            'fk-setting-project',
            'projectsetting',
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
            'fk-setting-project',
            'projectsetting'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            'idx-setting-project',
            'projectsetting'
        );

        $this->dropTable('projectsetting');
    }
}
