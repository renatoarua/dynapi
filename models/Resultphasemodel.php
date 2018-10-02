<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultphasemodel".
 *
 * @property string $phaseId
 * @property string $model
 * @property string $modelId
 * @property string $position
 * @property string $unbalance
 * @property string $phase
 */
class Resultphasemodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultphasemodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phaseId', 'modelId'], 'required'],
            [['phaseId', 'modelId'], 'string', 'max' => 21],
            [['model', 'position', 'unbalance', 'phase'], 'string', 'max' => 15],
            [['phaseId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phaseId' => Yii::t('app', 'Phase ID'),
            'model' => Yii::t('app', 'Model'),
            'modelId' => Yii::t('app', 'Model ID'),
            'position' => Yii::t('app', 'Position'),
            'unbalance' => Yii::t('app', 'Unbalance'),
            'phase' => Yii::t('app', 'Phase'),
        ];
    }
}
