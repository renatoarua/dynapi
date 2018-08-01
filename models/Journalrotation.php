<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "journalrotation".
 *
 * @property string $journalrotationId
 * @property string $journalBearingId
 * @property double $speed
 * @property double $kxx
 * @property double $kxz
 * @property double $kzx
 * @property double $kzz
 * @property double $cxx
 * @property double $cxz
 * @property double $czx
 * @property double $czz
 *
 * @property Journalbearing $journalBearing
 */
class Journalrotation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'journalrotation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['journalRotationId', 'journalBearingId', 'speed', 'kxx', 'kxz', 'kzx', 'kzz', 'cxx', 'cxz', 'czx', 'czz'], 'required'],
            [['speed', 'kxx', 'kxz', 'kzx', 'kzz', 'cxx', 'cxz', 'czx', 'czz'], 'string', 'max' => 15],
            [['journalrotationId', 'journalBearingId'], 'string', 'max' => 21],
            [['journalrotationId'], 'unique'],
            // [['journalBearingId'], 'exist', 'skipOnError' => true, 'targetClass' => Journalbearing::className(), 'targetAttribute' => ['journalBearingId' => 'journalBearingId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'journalRotationId' => Yii::t('app', 'Journal Rotation ID'),
            'journalBearingId' => Yii::t('app', 'Journal Bearing ID'),
            'speed' => Yii::t('app', 'Speed'),
            'kxx' => Yii::t('app', 'Kxx'),
            'kxz' => Yii::t('app', 'Kxz'),
            'kzx' => Yii::t('app', 'Kzx'),
            'kzz' => Yii::t('app', 'Kzz'),
            'cxx' => Yii::t('app', 'Cxx'),
            'cxz' => Yii::t('app', 'Cxz'),
            'czx' => Yii::t('app', 'Czx'),
            'czz' => Yii::t('app', 'Czz'),
        ];
    }

    public function beforeValidate()
    {
        $this->speed = sprintf('%e', (float)$this->speed);
        $this->kxx = sprintf('%e', (float)$this->kxx);
        $this->kxz = sprintf('%e', (float)$this->kxz);
        $this->kzx = sprintf('%e', (float)$this->kzx);
        $this->kzz = sprintf('%e', (float)$this->kzz);
        $this->cxx = sprintf('%e', (float)$this->cxx);
        $this->cxz = sprintf('%e', (float)$this->cxz);
        $this->czx = sprintf('%e', (float)$this->czx);
        $this->czz = sprintf('%e', (float)$this->czz);

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getJournalBearing()
    {
        return $this->hasOne(Journalbearing::className(), ['journalBearingId' => 'journalBearingId']);
    }*/
}
