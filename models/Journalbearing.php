<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "journalbearing".
 *
 * @property string $journalBearingId
 * @property string $machineId
 * @property double $position
 *
 * @property Machine $machine
 * @property Rotation[] $rotations
 */
class Journalbearing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journalbearing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['journalBearingId', 'machineId', 'position'], 'required'],
            [['position'], 'number'],
            [['journalBearingId', 'machineId'], 'string', 'max' => 21],
            [['journalBearingId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'journalBearingId' => Yii::t('app', 'Journal Bearing ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRotations()
    {
        return $this->hasMany(Rotation::className(), ['journalBearingId' => 'journalBearingId']);
    }
}
