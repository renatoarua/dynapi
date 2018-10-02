<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultresponsemodel".
 *
 * @property string $responseId
 * @property string $model
 * @property string $modelId
 * @property string $position
 * @property string $coord
 */
class Resultresponsemodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultresponsemodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['responseId', 'modelId'], 'required'],
            [['responseId', 'modelId'], 'string', 'max' => 21],
            [['model', 'position', 'coord'], 'string', 'max' => 15],
            [['responseId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'responseId' => Yii::t('app', 'Response ID'),
            'model' => Yii::t('app', 'Model'),
            'modelId' => Yii::t('app', 'Model ID'),
            'position' => Yii::t('app', 'Position'),
            'coord' => Yii::t('app', 'Coord'),
        ];
    }
}
