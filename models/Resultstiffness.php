<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultstiffness".
 *
 * @property string $crticalMapId
 * @property int $settingId
 * @property string $initialStiff
 * @property string $initialSpeed
 * @property string $finalSpeed
 * @property string $numDecades
 * @property string $numFrequencies
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
            [['crticalMapId'], 'required'],
            [['settingId'], 'integer'],
            [['crticalMapId'], 'string', 'max' => 21],
            [['initialStiff', 'initialSpeed', 'finalSpeed', 'numDecades', 'numFrequencies'], 'string', 'max' => 15],
            [['crticalMapId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'crticalMapId' => Yii::t('app', 'Crtical Map ID'),
            'settingId' => Yii::t('app', 'Setting ID'),
            'initialStiff' => Yii::t('app', 'Initial Stiff'),
            'initialSpeed' => Yii::t('app', 'Initial Speed'),
            'finalSpeed' => Yii::t('app', 'Final Speed'),
            'numDecades' => Yii::t('app', 'Num Decades'),
            'numFrequencies' => Yii::t('app', 'Num Frequencies'),
        ];
    }
}
