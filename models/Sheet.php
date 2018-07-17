<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sheet".
 *
 * @property string $sheetId
 * @property string $vesId
 * @property int $simple
 * @property int $single
 * @property string $type
 * @property int $doubled
 * @property string $mass
 * @property string $inertia
 *
 * @property Ves $ves
 * @property Sheetmaterial[] $sheetmaterials
 * @property Sheetrotation[] $sheetrotations
 * @property Sheettranslation[] $sheettranslations
 */
class Sheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        // need a scenario
        // 'vesId'
        return [
            [['sheetId', 'simple', 'single', 'type', 'mass', 'inertia'], 'required'],
            [['sheetId', 'vesId'], 'string', 'max' => 21],
            [['mass', 'inertia'], 'string', 'max' => 15],
            [['sheetId'], 'unique'],
            [['vesId'], 'exist', 'skipOnError' => true, 'targetClass' => Ves::className(), 'targetAttribute' => ['vesId' => 'vesId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'sheetId' => Yii::t('app', 'Sheet ID'),
            'vesId' => Yii::t('app', 'Ves ID'),
            'simple' => Yii::t('app', 'Simple'),
            'single' => Yii::t('app', 'Single'),
            'type' => Yii::t('app', 'Type'),
            'mass' => Yii::t('app', 'Mass'),
            'inertia' => Yii::t('app', 'Inertia'),
        ];
    }

    public function beforeValidate()
    {
        $this->mass = sprintf('%e', (float)$this->mass);
        $this->inertia = sprintf('%e', (float)$this->inertia);

        return parent::beforeValidate();
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'sheetmaterials';
        $fields[] = 'sheetrotations';
        $fields[] = 'sheettranslations';

        return $fields; 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVes()
    {
        return $this->hasOne(Ves::className(), ['vesId' => 'vesId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetmaterials()
    {
        return $this->hasMany(Sheetmaterial::className(), ['sheetId' => 'sheetId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheetrotations()
    {
        return $this->hasMany(Sheetrotation::className(), ['sheetId' => 'sheetId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheettranslations()
    {
        return $this->hasMany(Sheettranslation::className(), ['sheetId' => 'sheetId']);
    }
}
