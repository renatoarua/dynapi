<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resulttorsional".
 *
 * @property string $torsionalId
 * @property int $settingId
 * @property string $initialFrequency
 * @property string $finalFrequency
 * @property string $steps
 * @property string $modes
 */
class Resulttorsional extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resulttorsional';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['torsionalId'], 'required'],
            [['settingId'], 'integer'],
            [['torsionalId'], 'string', 'max' => 21],
            [['initialFrequency', 'finalFrequency', 'steps', 'modes'], 'string', 'max' => 15],
            [['torsionalId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'torsionalId' => Yii::t('app', 'Torsional ID'),
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
        $fields[] = 'responses';
        $fields[] = 'phases';
        return $fields; 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Resultresponsemodel::className(), ['modelId' => 'torsionalId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhases()
    {
        return $this->hasMany(Resulttorkphasemodel::className(), ['torsionalId' => 'torsionalId']);
    }
}
