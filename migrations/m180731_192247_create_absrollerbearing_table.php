<?php

use yii\db\Migration;

/**
 * Handles the creation of table `absrollerbearing`.
 */
class m180731_192247_create_absrollerbearing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('absrollerbearing', [
            'absRollerBearingId' => $keys,
            'absId' => $keys,

            'position' => $scinumber,
            'mass' => $scinumber,
            'inertia' => $scinumber,
            'kxx' => $scinumber,
            'kxz' => $scinumber,
            'kzx' => $scinumber,
            'kzz' => $scinumber,
            'cxx' => $scinumber,
            'cxz' => $scinumber,
            'czx' => $scinumber,
            'czz' => $scinumber,
            'ktt' => $scinumber,
            'ktp' => $scinumber,
            'kpp' => $scinumber,
            'kpt' => $scinumber,
            'ctt' => $scinumber,
            'ctp' => $scinumber,
            'cpp' => $scinumber,
            'cpt' => $scinumber,
        ]);

        $this->addPrimaryKey('PK1', 'absrollerbearing', 'absRollerBearingId');

        $this->createIndex(
            'idx-absrollerbearing-abs',
            'absrollerbearing',
            'absId'
        );

        $this->addForeignKey(
            'fk-absrollerbearing-abs',
            'absrollerbearing',
            'absId',
            'abs',
            'absId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-absrollerbearing-abs',
            'absrollerbearing'
        );

        $this->dropIndex(
            'idx-absrollerbearing-abs',
            'absrollerbearing'
        );

        $this->dropTable('absrollerbearing');
    }
}
