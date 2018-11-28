<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plan`.
 */
class m181027_235454_create_plan_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function up()
	{
		$this->createTable('pay_plan', [
			'planId' => $this->primaryKey(),
			'group' => $this->integer(11),
			'code' => $this->integer(11),
			'description' => $this->string(100),
			'costpertx'   => $this->money(),
			'status' => $this->string(3),
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function down()
	{
		$this->dropTable('pay_plan');
	}
}
