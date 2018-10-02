<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resulttime".
 *
 * @property string $timeId
 * @property int $settingId
 * @property string $initialFrequency
 * @property string $finalFrequency
 * @property string $steps
 * @property string $modes
 */
class Resulttime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resulttime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['timeId'], 'required'],
            [['settingId'], 'integer'],
            [['timeId'], 'string', 'max' => 21],
            [['initialFrequency', 'finalFrequency', 'steps', 'modes'], 'string', 'max' => 15],
            [['timeId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'timeId' => Yii::t('app', 'Time ID'),
            'settingId' => Yii::t('app', 'Setting ID'),
            'initialFrequency' => Yii::t('app', 'Initial Frequency'),
            'finalFrequency' => Yii::t('app', 'Final Frequency'),
            'steps' => Yii::t('app', 'Steps'),
            'modes' => Yii::t('app', 'Modes'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'phases';
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhases()
    {
        return $this->hasMany(Resultphasemodel::className(), ['modelId' => 'timeId']);
    }
}
