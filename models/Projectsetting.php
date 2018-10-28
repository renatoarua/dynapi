<?php

namespace app\models;

use Yii;
use app\components\SciNotation;

/**
 * This is the model class for table "projectsetting".
 *
 * @property int $id
 * @property string $projectId
 * @property string $systemoptions
 * @property string $resultoptions
 * @property string $resultcampbell
 * @property string $resultstiffness
 * @property string $resultmodes
 * @property string $resultconstant
 * @property string $resultunbalance
 * @property string $resulttorsional
 * @property string $resulttime
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
            [['resultcampbell','resultstiffness','resultmodes','resultconstant','resultunbalance','resulttorsional','resulttime','systemoptions','resultoptions'], 'string'],
            [['projectId', 'resultcampbell','resultstiffness','resultmodes','resultconstant','resultunbalance','resulttorsional','resulttime','systemoptions','resultoptions'], 'safe'],
            // [['projectId'], 'exist', 'skipOnError' => false, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'projectId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectId' => Yii::t('app', 'Project ID'),
            'systemoptions' => Yii::t('app', 'Systemoptions'),
            'resultoptions' => Yii::t('app', 'Resultoptions'),
            'resultcampbell' => Yii::t('app', 'Resultcampbell'),
            'resultstiffness' => Yii::t('app', 'Resultstiffness'),
            'resultmodes' => Yii::t('app', 'Resultmodes'),
            'resultconstant' => Yii::t('app', 'Resultconstant'),
            'resultunbalance' => Yii::t('app', 'Resultunbalance'),
            'resulttorsional' => Yii::t('app', 'Resulttorsional'),
            'resulttime' => Yii::t('app', 'Resulttime'),
        ];
    }

    /*public function fields()
    {
        $fields = parent::fields();
        //$fields[] = 'resultline';
        $fields[] = 'resultcampbell';
        $fields[] = 'resultstiffness';
        $fields[] = 'resultmodes';
        $fields[] = 'resultconstant';
        $fields[] = 'resultunbalance';
        $fields[] = 'resulttorsional';
        $fields[] = 'resulttime';

        return $fields; 
    }*/

    public function fixUnits()
    {
        $this->systemoptions = json_encode($this->systemoptions, true);
        $this->resultoptions = json_encode($this->resultoptions, true);
        $this->resultcampbell = json_encode(SciNotation::validateCampbell($this->resultcampbell));
        $this->resultstiffness = json_encode(SciNotation::validateStiffness($this->resultstiffness));
        $this->resultmodes = json_encode(SciNotation::validateModes($this->resultmodes));
        $this->resultconstant = json_encode(SciNotation::validateConstant($this->resultconstant));
        $this->resultunbalance = json_encode(SciNotation::validateUnbalance($this->resultunbalance));
        $this->resulttorsional = json_encode(SciNotation::validateTorsional($this->resulttorsional));
        $this->resulttime = json_encode(SciNotation::validateTime($this->resulttime));
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->systemoptions = json_decode($this->systemoptions, true);
        $this->resultoptions = json_decode($this->resultoptions, true);
        $this->resultcampbell = json_decode($this->resultcampbell, true);
        $this->resultstiffness = json_decode($this->resultstiffness, true);
        $this->resultmodes = json_decode($this->resultmodes, true);
        $this->resultconstant = SciNotation::afterFindConstant(json_decode($this->resultconstant, true));
        $this->resultunbalance = SciNotation::afterFindUnbalance(json_decode($this->resultunbalance, true));
        $this->resulttorsional = SciNotation::afterFindTorsional(json_decode($this->resulttorsional, true));
        $this->resulttime = SciNotation::afterFindTime(json_decode($this->resulttime, true));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectId' => 'projectId']);
    }
}
