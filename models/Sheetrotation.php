<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sheetrotation".
 *
 * @property string $sheetMaterialId
 * @property string $sheetId
 * @property string $thickness
 * @property string $meanRadius
 * @property string $thickAngle
 * @property string $lengthAngle
 *
 * @property Sheet $sheet
 */
class Sheetrotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sheetrotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheetMaterialId', 'thickness', 'meanRadius', 'thickAngle', 'lengthAngle'], 'required'],
            [['sheetMaterialId', 'sheetId'], 'string', 'max' => 21],
            [['thickness', 'meanRadius', 'thickAngle', 'lengthAngle'], 'string', 'max' => 15],
            [['sheetMaterialId'], 'unique'],
            [['sheetId'], 'exist', 'skipOnError' => true, 'targetClass' => Sheet::className(), 'targetAttribute' => ['sheetId' => 'sheetId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheetMaterialId' => Yii::t('app', 'Sheet Material ID'),
            'sheetId' => Yii::t('app', 'Sheet ID'),
            'thickness' => Yii::t('app', 'Thickness'),
            'meanRadius' => Yii::t('app', 'Mean Radius'),
            'thickAngle' => Yii::t('app', 'Thick Angle'),
            'lengthAngle' => Yii::t('app', 'Length Angle'),
        ];
    }

    public function beforeValidate()
    {
        $this->thickness = sprintf('%e', (float)$this->thickness);
        $this->meanRadius = sprintf('%e', (float)$this->meanRadius);
        $this->thickAngle = sprintf('%e', (float)$this->thickAngle);
        $this->lengthAngle = sprintf('%e', (float)$this->lengthAngle);

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheet()
    {
        return $this->hasOne(Sheet::className(), ['sheetId' => 'sheetId']);
    }
}
