<?php

use yii\db\Migration;

/**
 * Handles the creation of table `date`.
 */
class m181028_010418_create_date_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('date', [
            'dateId' => $this->primaryKey(),
            'year' => $this->integer(11),
            'month' => $this->integer(11),
            'day' => $this->integer(11),
            'monthName' => $this->string(21)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('date');
    }
}
