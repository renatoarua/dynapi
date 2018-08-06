<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sheettranslation".
 *
 * @property string $sheetTranslationId
 * @property string $sheetId
 * @property string $segments
 * @property string $thickness
 * @property string $diameter
 *
 * @property Sheet $sheet
 */
class Sheettranslation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sheettranslation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sheetTranslationId', 'segments', 'thickness', 'diameter'], 'required'],
            [['sheetTranslationId', 'sheetId'], 'string', 'max' => 21],
            [['segments', 'thickness', 'diameter'], 'string', 'max' => 15],
            [['sheetTranslationId'], 'unique'],
            [['sheetId'], 'exist', 'skipOnError' => true, 'targetClass' => Sheet::className(), 'targetAttribute' => ['sheetId' => 'sheetId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheetTranslationId' => Yii::t('app', 'Sheet Translation ID'),
            'sheetId' => Yii::t('app', 'Sheet ID'),
            'segments' => Yii::t('app', 'Segments'),
            'thickness' => Yii::t('app', 'Thickness'),
            'diameter' => Yii::t('app', 'Diameter'),
        ];
    }

    public function beforeValidate()
    {
        $this->segments = sprintf('%e', (float)$this->segments);
        $this->thickness = sprintf('%e', (float)$this->thickness);
        $this->diameter = sprintf('%e', (float)$this->diameter);

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->segments = sprintf('%e', (float)Yii::$app->converter->convert(+$this->segments));
        $this->thickness = sprintf('%e', (float)Yii::$app->converter->convert(+$this->thickness));
        $this->diameter = sprintf('%e', (float)Yii::$app->converter->convert(+$this->diameter));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheet()
    {
        return $this->hasOne(Sheet::className(), ['sheetId' => 'sheetId']);
    }
}
