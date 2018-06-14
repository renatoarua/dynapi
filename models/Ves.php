<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ves".
 *
 * @property string $absId
 * @property string $machineId
 * @property string $type
 * @property string $sheet
 *
 * @property Machine $machine
 */
class Ves extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ves';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['absId', 'machineId', 'type', 'sheet'], 'required'],
            [['absId', 'machineId'], 'string', 'max' => 21],
            [['type', 'sheet'], 'string', 'max' => 3],
            [['absId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'absId' => Yii::t('app', 'Abs ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'type' => Yii::t('app', 'Type'),
            'sheet' => Yii::t('app', 'Sheet'),
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
