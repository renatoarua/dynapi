<?php

namespace app\models;

use Yii;

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
 * @property Resultline[] $resultlines
 * @property Ribs[] $ribs
 * @property Rollerbearing[] $rollerbearings
 * @property Shaftsession[] $shaftsessions
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
            [['machineId', 'projectId', 'length', 'ldratio'], 'required'],
            [['machineId', 'projectId'], 'string', 'max' => 21],
            [['length', 'ldratio'], 'string', 'max' => 15],
            [['machineId'], 'unique'],
            [['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['projectId' => 'projectId']],
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
            'length' => Yii::t('app', 'Length'),
            'ldratio' => Yii::t('app', 'Ldratio'),
        ];
    }

    public function beforeValidate()
    {
        $this->length = sprintf('%e', (float)$this->length);
        $this->ldratio = sprintf('%e', (float)$this->ldratio);

        return parent::beforeValidate();
    }

    public function fields() 
    { 
        $fields = parent::fields(); 
        $fields[] = 'shaftsessions'; 
        $fields[] = 'ribs'; 
        $fields[] = 'discs'; 
        $fields[] = 'rollerbearings'; 
        $fields[] = 'journalbearings'; 
        $fields[] = 'ves'; 
        $fields[] = 'abs'; 
        $fields[] = 'foundations'; 

        $fields[] = 'campbell'; 

        return $fields; 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbs()
    {
        return $this->hasMany(Abs::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampbell()
    {
        return $this->hasOne(Campbell::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscs()
    {
        return $this->hasMany(Disc::className(), ['machineId' => 'machineId'])
            ->orderBy([
                    "CAST(SUBSTRING_INDEX(`length`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC,
                    "CAST(SUBSTRING_INDEX(`position`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC
                ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoundations()
    {
        return $this->hasMany(Foundation::className(), ['machineId' => 'machineId'])
            ->orderBy(["CAST(SUBSTRING_INDEX(`position`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJournalbearings()
    {
        return $this->hasMany(Journalbearing::className(), ['machineId' => 'machineId'])
            ->orderBy(["CAST(SUBSTRING_INDEX(`position`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['projectId' => 'projectId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResultlines()
    {
        return $this->hasMany(Resultline::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRibs()
    {
        return $this->hasMany(Ribs::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRollerbearings()
    {
        return $this->hasMany(Rollerbearing::className(), ['machineId' => 'machineId'])
            ->orderBy(["CAST(SUBSTRING_INDEX(`position`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShaftsessions()
    {
        return $this->hasMany(Shaftsession::className(), ['machineId' => 'machineId'])
            ->orderBy(["CAST(SUBSTRING_INDEX(`position`, ' ', -1) AS DECIMAL(5,5))"=>SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVes()
    {
        return $this->hasMany(Ves::className(), ['machineId' => 'machineId']);
            //->orderBy(['CAST(`position` AS SIGNED)'=>SORT_ASC]);
    }
}
