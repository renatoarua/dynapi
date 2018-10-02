<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultcampbell".
 *
 * @property string $campbellId
 * @property int $settingId
 * @property string $initialSpin
 * @property string $finalSpin
 * @property string $steps
 * @property string $crsp
 */
class Resultcampbell extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultcampbell';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campbellId'], 'required'],
            [['settingId'], 'integer'],
            [['campbellId'], 'string', 'max' => 21],
            [['initialSpin', 'finalSpin', 'steps', 'crsp'], 'string', 'max' => 15],
            [['campbellId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campbellId' => Yii::t('app', 'Campbell ID'),
            'settingId' => Yii::t('app', 'Setting ID'),
            'initialSpin' => Yii::t('app', 'Initial Spin'),
            'finalSpin' => Yii::t('app', 'Final Spin'),
            'steps' => Yii::t('app', 'Steps'),
            'crsp' => Yii::t('app', 'Crsp'),
        ];
    }
}
