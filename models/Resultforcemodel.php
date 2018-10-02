<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resultforcemodel".
 *
 * @property string $forceId
 * @property string $constantId
 * @property string $position
 * @property string $coord
 * @property string $force
 */
class Resultforcemodel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultforcemodel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['forceId', 'constantId'], 'required'],
            [['forceId', 'constantId'], 'string', 'max' => 21],
            [['position', 'coord', 'force'], 'string', 'max' => 15],
            [['forceId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'forceId' => Yii::t('app', 'Force ID'),
            'constantId' => Yii::t('app', 'Constant ID'),
            'position' => Yii::t('app', 'Position'),
            'coord' => Yii::t('app', 'Coord'),
            'force' => Yii::t('app', 'Force'),
        ];
    }
}
