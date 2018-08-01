<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vesrollerbearing`.
 */
class m180731_192123_create_vesrollerbearing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $scinumber = $this->string(15)->notNull()->defaultValue('0.000000e+0');
        $keys = $this->string(21)->notNull();

        $this->createTable('vesrollerbearing', [
            'vesRollerBearingId' => $keys,
            'vesId' => $keys,

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

        $this->addPrimaryKey('PK1', 'vesrollerbearing', 'vesRollerBearingId');

        $this->createIndex(
            'idx-vesrollerbearing-ves',
            'vesrollerbearing',
            'vesId'
        );

        $this->addForeignKey(
            'fk-vesrollerbearing-ves',
            'vesrollerbearing',
            'vesId',
            'ves',
            'vesId',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-vesrollerbearing-ves',
            'vesrollerbearing'
        );

        $this->dropIndex(
            'idx-vesrollerbearing-ves',
            'vesrollerbearing'
        );

        $this->dropTable('vesrollerbearing');
    }
}
