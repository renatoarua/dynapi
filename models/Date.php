<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "date".
 *
 * @property int $dateId
 * @property int $year
 * @property int $month
 * @property int $day
 * @property string $monthName
 * @property int $date
 */
class Date extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'month', 'day', 'date'], 'integer'],
            [['monthName'], 'string', 'max' => 21],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dateId' => Yii::t('app', 'Date ID'),
            'year' => Yii::t('app', 'Year'),
            'month' => Yii::t('app', 'Month'),
            'day' => Yii::t('app', 'Day'),
            'monthName' => Yii::t('app', 'Month Name'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
