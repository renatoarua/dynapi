<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sheetmaterial".
 *
 * @property string $sheetMaterialId
 * @property string $sheetId
 * @property string $go
 * @property string $goo
 * @property string $beta
 * @property string $b1
 * @property string $theta1
 * @property string $theta2
 * @property string $temperature
 * @property string $temperatureRef
 *
 * @property Sheet $sheet
 */
class Sheetmaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sheetmaterial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheetMaterialId', 'go', 'goo', 'beta', 'b1', 'theta1', 'theta2', 'temperature', 'temperatureRef'], 'required'],
            [['sheetMaterialId', 'sheetId'], 'string', 'max' => 21],
            [['go', 'goo', 'beta', 'b1', 'theta1', 'theta2', 'temperature', 'temperatureRef'], 'string', 'max' => 15],
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
            'go' => Yii::t('app', 'Go'),
            'goo' => Yii::t('app', 'Goo'),
            'beta' => Yii::t('app', 'Beta'),
            'b1' => Yii::t('app', 'B1'),
            'theta1' => Yii::t('app', 'Theta1'),
            'theta2' => Yii::t('app', 'Theta2'),
            'temperature' => Yii::t('app', 'Temperature'),
            'temperatureRef' => Yii::t('app', 'Temperature Ref'),
        ];
    }

    public function beforeValidate()
    {
        $this->go = sprintf('%e', (float)$this->go);
        $this->goo = sprintf('%e', (float)$this->goo);
        $this->beta = sprintf('%e', (float)$this->beta);
        $this->b1 = sprintf('%e', (float)$this->b1);
        $this->theta1 = sprintf('%e', (float)$this->theta1);
        $this->theta2 = sprintf('%e', (float)$this->theta2);
        $this->temperature = sprintf('%e', (float)$this->temperature);
        $this->temperatureRef = sprintf('%e', (float)$this->temperatureRef);

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
