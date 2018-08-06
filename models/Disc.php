<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disc".
 *
 * @property string $discId
 * @property string $machineId
 * @property int $materialId
 * @property string $position
 * @property string $externalDiameter
 * @property string $internalDiameter
 * @property string $thickness
 * @property string $density
 * @property string $ix
 * @property string $iy
 * @property string $iz
 * @property string $length
 * @property string $mass
 *
 * @property Machine $machine
 */
class Disc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discId', 'machineId', 'materialId', 'position', 'externalDiameter', 'internalDiameter', 'thickness', 'density', 'ix', 'iy', 'iz', 'length', 'mass'], 'required'],
            [['materialId'], 'integer'],
            [['discId', 'machineId'], 'string', 'max' => 21],
            [['position', 'externalDiameter', 'internalDiameter', 'thickness', 'density', 'ix', 'iy', 'iz', 'length', 'mass'], 'string', 'max' => 15],
            [['discId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'discId' => Yii::t('app', 'Disc ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'materialId' => Yii::t('app', 'Material ID'),
            'position' => Yii::t('app', 'Position'),
            'externalDiameter' => Yii::t('app', 'External Diameter'),
            'internalDiameter' => Yii::t('app', 'Internal Diameter'),
            'thickness' => Yii::t('app', 'Thickness'),
            'density' => Yii::t('app', 'Density'),
            'ix' => Yii::t('app', 'Ix'),
            'iy' => Yii::t('app', 'Iy'),
            'iz' => Yii::t('app', 'Iz'),
            'length' => Yii::t('app', 'Length'),
            'mass' => Yii::t('app', 'Mass'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        $this->externalDiameter = sprintf('%e', (float)$this->externalDiameter);
        $this->internalDiameter = sprintf('%e', (float)$this->internalDiameter);
        $this->thickness = sprintf('%e', (float)$this->thickness);
        $this->density = sprintf('%e', (float)$this->density);
        $this->ix = sprintf('%e', (float)$this->ix);
        $this->iy = sprintf('%e', (float)$this->iy);
        $this->iz = sprintf('%e', (float)$this->iz);
        $this->length = sprintf('%e', (float)$this->length);
        $this->mass = sprintf('%e', (float)$this->mass);

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->position = sprintf('%e', (float)Yii::$app->converter->convert(+$this->position));
        $this->externalDiameter = sprintf('%e', (float)Yii::$app->converter->convert(+$this->externalDiameter));
        $this->internalDiameter = sprintf('%e', (float)Yii::$app->converter->convert(+$this->internalDiameter));
        $this->thickness = sprintf('%e', (float)Yii::$app->converter->convert(+$this->thickness));
        $this->length = sprintf('%e', (float)Yii::$app->converter->convert(+$this->length));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
