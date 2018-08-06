<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "foundation".
 *
 * @property string $foundationId
 * @property string $machineId
 * @property string $position
 * @property string $kxx
 * @property string $kzz
 * @property string $cxx
 * @property string $czz
 * @property string $mass
 *
 * @property Machine $machine
 */
class Foundation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foundation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['foundationId', 'machineId', 'position', 'kxx', 'kzz', 'cxx', 'czz', 'mass'], 'required'],
            [['foundationId', 'machineId'], 'string', 'max' => 21],
            [['position', 'kxx', 'kzz', 'cxx', 'czz', 'mass'], 'string', 'max' => 15],
            [['foundationId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'foundationId' => Yii::t('app', 'Foundation ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'position' => Yii::t('app', 'Position'),
            'kxx' => Yii::t('app', 'Kxx'),
            'kzz' => Yii::t('app', 'Kzz'),
            'cxx' => Yii::t('app', 'Cxx'),
            'czz' => Yii::t('app', 'Czz'),
            'mass' => Yii::t('app', 'Mass'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        $this->mass = sprintf('%e', (float)$this->mass);
        $this->kxx = sprintf('%e', (float)$this->kxx);
        $this->kzz = sprintf('%e', (float)$this->kzz);
        $this->cxx = sprintf('%e', (float)$this->cxx);
        $this->czz = sprintf('%e', (float)$this->czz);

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->position = sprintf('%e', (float)Yii::$app->converter->convert(+$this->position));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
