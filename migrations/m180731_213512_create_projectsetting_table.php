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
            'id'              => $this->primaryKey(),
            'projectId'       => $this->string(21),
            'systemoptions'   => $this->json(),
            'resultoptions'   => $this->json(),
            'resultcampbell'  => $this->json(),
            'resultstiffness' => $this->json(),
            'resultmodes'     => $this->json(),
            'resultconstant'  => $this->json(),
            'resultunbalance' => $this->json(),
            'resulttorsional' => $this->json(),
            'resulttime'      => $this->json(),
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
