<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shaftsession".
 *
 * @property string $shaftSessionId
 * @property string $machineId
 * @property int $materialId
 * @property string $position
 * @property string $externalDiameter
 * @property string $internalDiameter
 * @property string $young
 * @property string $poisson
 * @property string $density
 * @property string $axialForce
 * @property string $magneticForce
 *
 * @property Machine $machine
 */
class Shaftsession extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shaftsession';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shaftSessionId', 'machineId', 'materialId', 'position', 'externalDiameter', 'internalDiameter', 'young', 'poisson', 'density', 'axialForce', 'magneticForce'], 'required'],
            [['materialId'], 'integer'],
            [['shaftSessionId', 'machineId'], 'string', 'max' => 21],
            [['position', 'externalDiameter', 'internalDiameter', 'young', 'poisson', 'density', 'axialForce', 'magneticForce'], 'string', 'max' => 15],
            [['shaftSessionId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shaftSessionId' => Yii::t('app', 'Shaft Session ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'materialId' => Yii::t('app', 'Material ID'),
            'position' => Yii::t('app', 'Position'),
            'externalDiameter' => Yii::t('app', 'External Diameter'),
            'internalDiameter' => Yii::t('app', 'Internal Diameter'),
            'young' => Yii::t('app', 'Young'),
            'poisson' => Yii::t('app', 'Poisson'),
            'density' => Yii::t('app', 'Density'),
            'axialForce' => Yii::t('app', 'Axial Force'),
            'magneticForce' => Yii::t('app', 'Magnetic Force'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        $this->externalDiameter = sprintf('%e', (float)$this->externalDiameter);
        $this->internalDiameter = sprintf('%e', (float)$this->internalDiameter);
        $this->young = sprintf('%e', (float)$this->young);
        $this->poisson = sprintf('%e', (float)$this->poisson);
        $this->density = sprintf('%e', (float)$this->density);
        $this->axialForce = sprintf('%e', (float)$this->axialForce);
        $this->magneticForce = sprintf('%e', (float)$this->magneticForce);

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
