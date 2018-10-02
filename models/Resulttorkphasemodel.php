<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resulttorkphasemodel".
 *
 * @property string $torkPhaseId
 * @property string $torsionalId
 * @property string $position
 * @property string $tork
 * @property string $phase
 */
class Resulttorkphasemodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resulttorkphasemodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['torkPhaseId', 'torsionalId'], 'required'],
            [['torkPhaseId', 'torsionalId'], 'string', 'max' => 21],
            [['position', 'tork', 'phase'], 'string', 'max' => 15],
            [['torkPhaseId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'torkPhaseId' => Yii::t('app', 'Tork Phase ID'),
            'torsionalId' => Yii::t('app', 'Torsional ID'),
            'position' => Yii::t('app', 'Position'),
            'tork' => Yii::t('app', 'Tork'),
            'phase' => Yii::t('app', 'Phase'),
        ];
    }
}
