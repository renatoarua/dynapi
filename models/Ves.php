<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ves".
 *
 * @property string $vesId
 * @property string $machineId
 * @property string $position
 *
 * @property Sheet[] $sheets
 * @property Machine $machine
 * @property Vesrollerbearing[] $vesrollerbearings
 */
class Ves extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ves';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vesId', 'machineId', 'position'], 'required'],
            [['vesId', 'machineId'], 'string', 'max' => 21],
            [['position'], 'string', 'max' => 15],
            [['vesId'], 'unique'],
            [['machineId'], 'exist', 'skipOnError' => true, 'targetClass' => Machine::className(), 'targetAttribute' => ['machineId' => 'machineId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vesId' => Yii::t('app', 'Ves ID'),
            'machineId' => Yii::t('app', 'Machine ID'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    public function beforeValidate()
    {
        $this->position = sprintf('%e', (float)$this->position);
        return parent::beforeValidate();
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'sheet';
        $fields[] = 'vesrollerbearings';

        return $fields;
    }

    public function afterFind()
    {
        parent::afterFind();
        Yii::$app->converter->refresh();
        $this->position = sprintf('%e', (float)Yii::$app->converter->convert(+$this->position));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheet()
    {
        return $this->hasOne(Sheet::className(), ['vesId' => 'vesId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['machineId' => 'machineId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVesrollerbearings()
    {
        return $this->hasMany(Vesrollerbearing::className(), ['vesId' => 'vesId']);
    }
}
