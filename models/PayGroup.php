<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_group".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class PayGroup extends \yii\db\ActiveRecord
{
    // const GROUP_MONTHLY = 10;
    // const ROLE_STAFF = 50;
    // const ROLE_ADMIN = 99;

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 25],
            [['description'], 'string', 'max' => 80],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
