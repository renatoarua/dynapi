<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ribs".
 *
 * @property string $ribId
 * @property string $machineId
 * @property string $position
 * @property string $number
 * @property string $webThickness
 * @property string $webDepth
 * @property string $flangeWidth
 * @property string $flangeThick
 *
 * @property Machine $machine
 */
class Ribs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ribs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ribId', 'machineId', 'position', 'number', 'webThickness', 'webDepth', 'flangeWidth', 'flangeThick'], 'required'],
            [['ribId', 'machineId'], 'string', 'max' => 21],
            [['position', 'number', 'webThickness', 'webDepth', 'flangeWidth', 'flangeThick'], 'string', 'max' => 15],
            [['ribId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ribId' => Yii::t('app', 'Rib ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'position' => Yii::t('app', 'Position'),
            'number' => Yii::t('app', 'Number'),
            'webThickness' => Yii::t('app', 'Web Thickness'),
            'webDepth' => Yii::t('app', 'Web Depth'),
            'flangeWidth' => Yii::t('app', 'Flange Width'),
            'flangeThick' => Yii::t('app', 'Flange Thick'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        $this->webThickness = sprintf('%e', (float)$this->webThickness);
        $this->webDepth = sprintf('%e', (float)$this->webDepth);
        $this->flangeWidth = sprintf('%e', (float)$this->flangeWidth);
        $this->flangeThick = sprintf('%e', (float)$this->flangeThick);

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->position = sprintf('%e', (float)Yii::$app->converter->convert(+$this->position));
        $this->webThickness = sprintf('%e', (float)Yii::$app->converter->convert(+$this->webThickness));
        $this->webDepth = sprintf('%e', (float)Yii::$app->converter->convert(+$this->webDepth));
        $this->flangeWidth = sprintf('%e', (float)Yii::$app->converter->convert(+$this->flangeWidth));
        $this->flangeThick = sprintf('%e', (float)Yii::$app->converter->convert(+$this->flangeThick));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
