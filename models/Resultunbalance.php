<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultunbalance".
 *
 * @property string $unbalanceId
 * @property int $settingId
 * @property string $initialSpin
 * @property string $finalSpin
 * @property string $steps
 * @property string $modes
 */
class Resultunbalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultunbalance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unbalanceId'], 'required'],
            [['settingId'], 'integer'],
            [['unbalanceId'], 'string', 'max' => 21],
            [['initialSpin', 'finalSpin', 'steps', 'modes'], 'string', 'max' => 15],
            [['unbalanceId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unbalanceId' => Yii::t('app', 'Unbalance ID'),
            'settingId' => Yii::t('app', 'Setting ID'),
            'initialSpin' => Yii::t('app', 'Initial Spin'),
            'finalSpin' => Yii::t('app', 'Final Spin'),
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
        return $this->hasMany(Resultresponsemodel::className(), ['modelId' => 'unbalanceId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhases()
    {
        return $this->hasMany(Resultphasemodel::className(), ['modelId' => 'unbalanceId']);
    }
}
