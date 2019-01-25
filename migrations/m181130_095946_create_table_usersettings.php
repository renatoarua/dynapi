<?php

use yii\db\Migration;

/**
 * Class m181130_095946_create_table_usersettings
 */
class m181130_095946_create_table_usersettings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('usersetting', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'settingId' => $this->integer(11),
            'value' => $this->text(),
            'status' => $this->integer(3)
        ]);

        $this->createIndex('idx-usersetting-user', 'usersetting', 'userId');
        $this->createIndex('idx-usersetting-setting', 'usersetting', 'settingId');

        $this->addForeignKey(
            'fk-usersetting-setting',
            'usersetting',
            'settingId',
            'setting',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-usersetting-user',
            'usersetting',
            'userId',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-usersetting-user', 'usersetting');
        $this->dropForeignKey('fk-usersetting-setting', 'usersetting');

        $this->dropIndex('idx-usersetting-user', 'usersetting');
        $this->dropIndex('idx-usersetting-setting', 'usersetting');

        $this->dropTable('usersetting');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181130_095946_create_table_usersettings cannot be reverted.\n";

        return false;
    }
    */
}
