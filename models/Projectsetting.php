<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectsetting".
 *
 * @property int $id
 * @property string $projectId
 * @property int $foundation
 * @property int $rollerbearing
 * @property int $journalbearing
 * @property int $ves
 * @property int $abs
 * @property int $staticLine
 * @property int $fatigue
 * @property int $campbell
 * @property int $modes
 * @property int $criticalMap
 * @property int $unbalancedResponse
 * @property int $constantResponse
 * @property int $timeResponse
 * @property int $torsional
 * @property int $balanceOptimization
 * @property int $vesOptimization
 * @property int $absOptimization
 *
 * @property Project $project
 */
class Projectsetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projectsetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId'], 'required'],
            [['projectId'], 'string', 'max' => 21],
            [['foundation', 'rollerbearing', 'journalbearing', 'ves', 'abs', 'staticLine', 'fatigue', 'campbell', 'modes', 'criticalMap', 'unbalancedResponse', 'constantResponse', 'timeResponse', 'torsional', 'balanceOptimization', 'vesOptimization', 'absOptimization'], 'string', 'max' => 1],
            [['projectId'], 'exist', 'skipOnError' => false, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'projectId']],
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
            'foundation' => Yii::t('app', 'Foundation'),
            'rollerbearing' => Yii::t('app', 'Rollerbearing'),
            'journalbearing' => Yii::t('app', 'Journalbearing'),
            'ves' => Yii::t('app', 'Ves'),
            'abs' => Yii::t('app', 'Abs'),
            'staticLine' => Yii::t('app', 'Static Line'),
            'fatigue' => Yii::t('app', 'Fatigue'),
            'campbell' => Yii::t('app', 'Campbell'),
            'modes' => Yii::t('app', 'Modes'),
            'criticalMap' => Yii::t('app', 'Critical Map'),
            'unbalancedResponse' => Yii::t('app', 'Unbalanced Response'),
            'constantResponse' => Yii::t('app', 'Constant Response'),
            'timeResponse' => Yii::t('app', 'Time Response'),
            'torsional' => Yii::t('app', 'Torsional'),
            'balanceOptimization' => Yii::t('app', 'Balance Optimization'),
            'vesOptimization' => Yii::t('app', 'Ves Optimization'),
            'absOptimization' => Yii::t('app', 'Abs Optimization'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectId' => 'projectId']);
    }
}
