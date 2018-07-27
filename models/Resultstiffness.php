<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "criticalmap".
 *
 * @property string $crticalMapId
 * @property string $machineId
 * @property double $initialStiff
 * @property double $initialSpeed
 * @property double $finalSpeed
 * @property double $numDecades
 * @property double $numFrequencies
 *
 * @property Machine $machine
 */
class Resultstiffness extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultstiffness';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['crticalMapId', 'machineId', 'initialStiff', 'initialSpeed', 'finalSpeed', 'numDecades', 'numFrequencies'], 'required'],
            [['initialStiff', 'initialSpeed', 'finalSpeed', 'numDecades', 'numFrequencies'], 'number'],
            [['crticalMapId', 'machineId'], 'string', 'max' => 21],
            [['crticalMapId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crticalMapId' => Yii::t('app', 'Crtical Map ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'initialStiff' => Yii::t('app', 'Initial Stiff'),
            'initialSpeed' => Yii::t('app', 'Initial Speed'),
            'finalSpeed' => Yii::t('app', 'Final Speed'),
            'numDecades' => Yii::t('app', 'Num Decades'),
            'numFrequencies' => Yii::t('app', 'Num Frequencies'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }
}
