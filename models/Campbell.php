<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "campbell".
 *
 * @property string $campbellId
 * @property string $machineId
 * @property double $initialSpin
 * @property double $finalSpin
 * @property double $steps
 * @property double $crsp
 *
 * @property Machine $machine
 */
class Campbell extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campbell';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campbellId', 'machineId'], 'required'],
            [['initialSpin', 'finalSpin', 'steps', 'crsp'], 'number'],
            [['campbellId', 'machineId'], 'string', 'max' => 21],
            [['campbellId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campbellId' => Yii::t('app', 'Campbell ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'initialSpin' => Yii::t('app', 'Initial Spin'),
            'finalSpin' => Yii::t('app', 'Final Spin'),
            'steps' => Yii::t('app', 'Steps'),
            'crsp' => Yii::t('app', 'Crsp'),
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
