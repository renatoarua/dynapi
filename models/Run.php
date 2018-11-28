<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "run".
 *
 * @property int $id
 * @property string $projectId
 * @property int $userId
 * @property int $date
 * @property string $filename
 * @property int $exitcode
 * @property string $status
 */
class Run extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'run';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'date', 'exitcode'], 'integer'],
            [['projectId'], 'string', 'max' => 21],
            [['filename'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'projectId' => Yii::t('app', 'Project ID'),
            'userId' => Yii::t('app', 'User ID'),
            'date' => Yii::t('app', 'Date'),
            'filename' => Yii::t('app', 'Filename'),
            'exitcode' => Yii::t('app', 'Exitcode'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
