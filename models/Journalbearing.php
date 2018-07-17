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
            [['journalBearingId', 'machineId', 'position'], 'string', 'max' => 21],
            [['journalBearingId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'journalBearingId';
        $fields[] = 'machineId';
        $fields[] = 'position';
        $fields[] = 'rotations';

        return $fields;
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

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);

        return parent::beforeValidate();
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
        $qry = $this->hasMany(Rotation::className(), ['journalBearingId' => 'journalBearingId'])
            // ->orderBy(["CAST(SUBSTRING_INDEX(`speed`, ' ', -1) AS DECIMAL(5,5))"=>SORT_DESC]);
            ->orderBy(["`speed`+0"=>SORT_ASC]);

        return $qry;
    }
}
