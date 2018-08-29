<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultmodes".
 *
 * @property string $modesId
 * @property string $machineId
 * @property string $maxFrequency
 * @property string $numModes
 */
class Resultmodes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultmodes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modesId', 'machineId'], 'required'],
            [['modesId', 'machineId'], 'string', 'max' => 21],
            [['maxFrequency', 'numModes'], 'string', 'max' => 15],
            [['modesId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'modesId' => Yii::t('app', 'Modes ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'maxFrequency' => Yii::t('app', 'Max Frequency'),
            'numModes' => Yii::t('app', 'Num Modes'),
        ];
    }
}
