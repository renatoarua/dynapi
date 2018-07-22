<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sheetrotation".
 *
 * @property string $sheetRotationId
 * @property string $sheetId
 * @property string $thickness
 * @property string $meanRadius
 * @property string $radius
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
            [['sheetRotationId', 'thickness', 'meanRadius', 'radius'], 'required'],
            [['sheetRotationId', 'sheetId'], 'string', 'max' => 21],
            [['thickness', 'meanRadius', 'radius'], 'string', 'max' => 15],
            [['sheetRotationId'], 'unique'],
            [['sheetId'], 'exist', 'skipOnError' => true, 'targetClass' => Sheet::className(), 'targetAttribute' => ['sheetId' => 'sheetId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheetRotationId' => Yii::t('app', 'Sheet Rotation ID'),
            'sheetId' => Yii::t('app', 'Sheet ID'),
            'thickness' => Yii::t('app', 'Thickness'),
            'meanRadius' => Yii::t('app', 'Mean Radius'),
            'radius' => Yii::t('app', 'Radius'),
        ];
    }

    public function beforeValidate()
    {
       $this->thickness = sprintf('%e', (float)$this->thickness);
       $this->meanRadius = sprintf('%e', (float)$this->meanRadius);
       $this->radius = sprintf('%e', (float)$this->radius);
       // $this->thickAngle = sprintf('%e', (float)$this->thickAngle);
       // $this->lengthAngle = sprintf('%e', (float)$this->lengthAngle);

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
