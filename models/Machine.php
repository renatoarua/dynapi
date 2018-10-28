<?php

namespace app\models;

use Yii;
use app\components\SciNotation;


/**
 * This is the model class for table "machine".
 *
 * @property string $machineId
 * @property string $projectId
 * @property string $length
 * @property string $ldratio
 *
 * @property Abs[] $abs
 * @property Campbell[] $campbells
 * @property Disc[] $discs
 * @property Foundation[] $foundations
 * @property Journalbearing[] $journalbearings
 * @property Project $project
 * @property Resultline[] $resultline
 * @property Ribs[] $ribs
 * @property Rollerbearing[] $rollerbearings
 * @property Section[] $sections
 * @property Ves[] $ves
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'machine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['machineId', 'projectId', 'ldratio'], 'required'],
            [['sections', 'discs', 'ribs', 'rollerbearings', 'journalbearings', 'foundations', 'ves', 'abs'], 'string'],
            [['machineId', 'projectId'], 'string', 'max' => 21],
            [['ldratio'], 'string', 'max' => 15],
            [['machineId'], 'unique'],
            [['machineId', 'projectId', 'ldratio', 'sections', 'discs', 'ribs', 'rollerbearings', 'journalbearings', 'foundations', 'ves', 'abs'], 'safe'],
            //[['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'projectId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'machineId' => Yii::t('app', 'Machine ID'),
            'projectId' => Yii::t('app', 'Project ID'),
            'sections' => Yii::t('app', 'Sections'),
            'discs' => Yii::t('app', 'Discs'),
            'ribs' => Yii::t('app', 'Ribs'),
            'rollerbearings' => Yii::t('app', 'Rollerbearings'),
            'journalbearings' => Yii::t('app', 'Journalbearings'),
            'foundations' => Yii::t('app', 'Foundations'),
            'ves' => Yii::t('app', 'Ves'),
            'abs' => Yii::t('app', 'Abs'),
            'ldratio' => Yii::t('app', 'Ldratio'),
        ];
    }

    public function fixUnits()
    {
        $this->ldratio = sprintf('%e', (float)$this->ldratio);
        $this->sections = json_encode(SciNotation::validateSections($this->sections));
        $this->discs = json_encode(SciNotation::validateDiscs($this->discs));
        $this->ribs = json_encode(SciNotation::validateRibs($this->ribs));
        $this->rollerbearings = json_encode(SciNotation::validateRollerbearings($this->rollerbearings));
        $this->journalbearings = json_encode(SciNotation::validateJournalbearings($this->journalbearings));
        $this->foundations = json_encode(SciNotation::validateFoundations($this->foundations));
        $this->ves = json_encode(SciNotation::validateVes($this->ves));
        $this->abs = json_encode(SciNotation::validateAbs($this->abs));
        // return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        if(!empty($this->sections))
            $this->sections = SciNotation::afterFindSections(json_decode($this->sections, true));
        if(!empty($this->discs))
            $this->discs = SciNotation::afterFindDiscs(json_decode($this->discs, true));
        if(!empty($this->ribs))
            $this->ribs = SciNotation::afterFindRibs(json_decode($this->ribs, true));
        if(!empty($this->rollerbearings))
            $this->rollerbearings = SciNotation::afterFindRollerbearings(json_decode($this->rollerbearings, true));
        if(!empty($this->journalbearings))
            $this->journalbearings = SciNotation::afterFindJournalbearings(json_decode($this->journalbearings, true));
        if(!empty($this->foundations))
            $this->foundations = SciNotation::afterFindFoundations(json_decode($this->foundations, true));
        if(!empty($this->ves))
            $this->ves = SciNotation::afterFindVes(json_decode($this->ves, true));
        if(!empty($this->abs))
            $this->abs = SciNotation::afterFindAbs(json_decode($this->abs, true));
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectId' => 'projectId']);
    }*/
}
