<?php

use yii\db\Migration;

/**
 * Handles adding opt to table `machine`.
 */
class m181213_125845_add_opt_columns_to_machine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('machine', 'absOpt', $this->json()->after('ldratio'));
        $this->addColumn('machine', 'vesOpt', $this->json()->after('ldratio'));
        $this->addColumn('machine', 'balanceOpt', $this->json()->after('ldratio'));
        $this->addColumn('machine', 'journalOpt', $this->json()->after('ldratio'));
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('machine', 'absOpt');
        $this->dropColumn('machine', 'vesOpt');
        $this->dropColumn('machine', 'balanceOpt');
        $this->dropColumn('machine', 'journalOpt');
    }
}
