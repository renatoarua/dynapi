<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "section".
 *
 * @property string $sectionId
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
class Section extends \yii\db\ActiveRecord
{
    /*protected $area;
    protected $border;*/
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sectionId', 'machineId', 'materialId', 'position', 'externalDiameter', 'internalDiameter', 'young', 'poisson', 'density', 'axialForce', 'magneticForce'], 'required'],
            [['materialId'], 'integer'],
            [['sectionId', 'machineId'], 'string', 'max' => 21],
            [['position', 'externalDiameter', 'internalDiameter', 'young', 'poisson', 'density', 'axialForce', 'magneticForce'], 'string', 'max' => 15],
            [['sectionId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sectionId' => Yii::t('app', 'Shaft Section ID'),
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

    public static function findById($id)
    {
        $mod = static::findOne(['sectionId' => $id]);
        return $mod;
    }

    /*public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'area';
        $fields[] = 'border';
        return $fields;
    }*/

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->position = sprintf('%e', (float)Yii::$app->converter->convert(+$this->position));
        $this->externalDiameter = sprintf('%e', (float)Yii::$app->converter->convert(+$this->externalDiameter));
        $this->internalDiameter = sprintf('%e', (float)Yii::$app->converter->convert(+$this->internalDiameter));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
