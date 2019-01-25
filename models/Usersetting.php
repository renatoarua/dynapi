<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usersetting".
 *
 * @property int $id
 * @property int $userId
 * @property int $settingId
 * @property string $value
 * @property int $status
 */
class Usersetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usersetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'settingId', 'status'], 'integer'],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'settingId' => 'Setting ID',
            'value' => 'Value',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'user';
        $fields[] = 'setting';
        return $fields;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting()
    {
        return $this->hasOne(Setting::className(), ['id' => 'settingId']);
    }
}
