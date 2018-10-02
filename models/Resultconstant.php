<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultconstant".
 *
 * @property string $constantId
 * @property int $settingId
 * @property string $initialFrequency
 * @property string $finalFrequency
 * @property string $steps
 * @property string $modes
 * @property string $speed
 */
class Resultconstant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultconstant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['constantId'], 'required'],
            [['settingId'], 'integer'],
            [['constantId'], 'string', 'max' => 21],
            [['initialFrequency', 'finalFrequency', 'steps', 'modes', 'speed'], 'string', 'max' => 15],
            [['constantId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'constantId' => Yii::t('app', 'Constant ID'),
            'settingId' => Yii::t('app', 'Setting ID'),
            'initialFrequency' => Yii::t('app', 'Initial Frequency'),
            'finalFrequency' => Yii::t('app', 'Final Frequency'),
            'steps' => Yii::t('app', 'Steps'),
            'modes' => Yii::t('app', 'Modes'),
            'speed' => Yii::t('app', 'Speed'),
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'responses';
        $fields[] = 'forces';
        return $fields;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getResponses()
    {
        return $this->hasMany(Resultresponsemodel::className(), ['modelId' => 'constantId']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getForces()
    {
        return $this->hasMany(Resultforcemodel::className(), ['constantId' => 'constantId']);
    }
}
