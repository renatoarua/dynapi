<?php

use yii\db\Migration;

/**
 * Handles the creation of table `token`.
 */
class m181027_180131_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('token', [
            'tokenId' => $this->string(21),
            'name' => $this->string(21),

        ]);

        $this->addPrimaryKey('PK1', 'token', 'tokenId');

        $this->insert('token', [
            'tokenId' => 'USD',
            'name' => 'US Dollar',
        ]);

        $this->insert('token', [
            'tokenId' => 'DYN',
            'name' => 'DynTech Token',
        ]);

        $this->insert('token', [
            'tokenId' => 'BRL',
            'name' => 'Brazilian Real',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('token');
    }
}
