<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vesrollerbearing".
 *
 * @property string $vesRollerBearingId
 * @property string $vesId
 * @property string $position
 * @property string $mass
 * @property string $inertia
 * @property string $kxx
 * @property string $kxz
 * @property string $kzx
 * @property string $kzz
 * @property string $cxx
 * @property string $cxz
 * @property string $czx
 * @property string $czz
 * @property string $ktt
 * @property string $ktp
 * @property string $kpp
 * @property string $kpt
 * @property string $ctt
 * @property string $ctp
 * @property string $cpp
 * @property string $cpt
 *
 * @property Ves $ves
 */
class Vesrollerbearing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vesrollerbearing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vesRollerBearingId', 'position', 'mass', 'inertia', 'kxx', 'kxz', 'kzx', 'kzz', 'cxx', 'cxz', 'czx', 'czz', 'ktt', 'ktp', 'kpp', 'kpt', 'ctt', 'ctp', 'cpp', 'cpt'], 'required'],
            [['vesRollerBearingId', 'vesId'], 'string', 'max' => 21],
            [['position', 'mass', 'inertia', 'kxx', 'kxz', 'kzx', 'kzz', 'cxx', 'cxz', 'czx', 'czz', 'ktt', 'ktp', 'kpp', 'kpt', 'ctt', 'ctp', 'cpp', 'cpt'], 'string', 'max' => 15],
            [['vesRollerBearingId'], 'unique'],
            [['vesId'], 'exist', 'skipOnError' => true, 'targetClass' => Ves::className(), 'targetAttribute' => ['vesId' => 'vesId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vesRollerBearingId' => Yii::t('app', 'Ves Roller Bearing ID'),
            'vesId' => Yii::t('app', 'Ves ID'),
            'position' => Yii::t('app', 'Position'),
            'mass' => Yii::t('app', 'Mass'),
            'inertia' => Yii::t('app', 'Inertia'),
            'kxx' => Yii::t('app', 'Kxx'),
            'kxz' => Yii::t('app', 'Kxz'),
            'kzx' => Yii::t('app', 'Kzx'),
            'kzz' => Yii::t('app', 'Kzz'),
            'cxx' => Yii::t('app', 'Cxx'),
            'cxz' => Yii::t('app', 'Cxz'),
            'czx' => Yii::t('app', 'Czx'),
            'czz' => Yii::t('app', 'Czz'),
            'ktt' => Yii::t('app', 'Ktt'),
            'ktp' => Yii::t('app', 'Ktp'),
            'kpp' => Yii::t('app', 'Kpp'),
            'kpt' => Yii::t('app', 'Kpt'),
            'ctt' => Yii::t('app', 'Ctt'),
            'ctp' => Yii::t('app', 'Ctp'),
            'cpp' => Yii::t('app', 'Cpp'),
            'cpt' => Yii::t('app', 'Cpt'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        $this->inertia = sprintf('%e', (float)$this->inertia);
        $this->mass = sprintf('%e', (float)$this->mass);
        $this->kxx = sprintf('%e', (float)$this->kxx);
        $this->kxz = sprintf('%e', (float)$this->kxz);
        $this->kzx = sprintf('%e', (float)$this->kzx);
        $this->kzz = sprintf('%e', (float)$this->kzz);
        $this->cxx = sprintf('%e', (float)$this->cxx);
        $this->cxz = sprintf('%e', (float)$this->cxz);
        $this->czx = sprintf('%e', (float)$this->czx);
        $this->czz = sprintf('%e', (float)$this->czz);
        $this->ktt = sprintf('%e', (float)$this->ktt);
        $this->ktp = sprintf('%e', (float)$this->ktp);
        $this->kpt = sprintf('%e', (float)$this->kpt);
        $this->kpp = sprintf('%e', (float)$this->kpp);
        $this->ctt = sprintf('%e', (float)$this->ctt);
        $this->ctp = sprintf('%e', (float)$this->ctp);
        $this->cpt = sprintf('%e', (float)$this->cpt);
        $this->cpp = sprintf('%e', (float)$this->cpp);

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVes()
    {
        return $this->hasOne(Ves::className(), ['vesId' => 'vesId']);
    }
}
