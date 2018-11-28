<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property string $tokenId
 * @property string $name
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tokenId'], 'required'],
            [['tokenId', 'name'], 'string', 'max' => 21],
            [['tokenId'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tokenId' => Yii::t('app', 'Token ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
