<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project".
 *
 * @property string $projectId
 * @property string $userId
 * @property string $name
 * @property string $status
 *
 * @property Autolog[] $autologs
 * @property Machine[] $machines
 */
class Project extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 'ACT';
    const STATUS_REMOVED = 'REM';
    const STATUS_BANNED = 'BAN';
    const STATUS_NOT_VERIFIED = 'PEN';

    public static function statusArray() {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_NOT_FINISHED,
            self::STATUS_BANNED,
            self::STATUS_REMOVED,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['projectId'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['projectId', 'userId', 'name', 'status'], 'required'],
            [['projectId'], 'string', 'max' => 21],
            [['name'], 'string', 'max' => 80],
            [['status'], 'string', 'max' => 3],
            [['userId'], 'integer'],
            [['projectId'], 'unique'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'machine';
        $fields[] = 'user';
        $fields[] = 'projectsetting';
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'projectId' => Yii::t('app', 'Project ID'),
            'userId' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /*public function toArrayCourse(array $fields = [], array $expand = [], $recursive = false) {
        $fields = parent::fields();
        return parent::toArray($fields, $expand, $recursive);
    }*/

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
    public function getAutologs()
    {
        return $this->hasMany(Autolog::className(), ['projectId' => 'projectId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMachine()
    {
        return $this->hasOne(Machine::className(), ['projectId' => 'projectId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectsetting()
    {
        return $this->hasOne(Projectsetting::className(), ['projectId' => 'projectId']);
    }
}

/*
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'fatigue', 'Fatigue', 'bool', 'Calculate fatigue?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'campbell', 'Campbell Diagram', 'bool', 'Calculate campbell?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'modes', 'Modes', 'bool', 'Calculate modes?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'critcalMap', 'Critcal Map', 'bool', 'Calculate critcalMap?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'unbalancedResponse', 'Unbalanced Response', 'bool', 'Calculate unbalancedResponse?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'constantResponse', 'Constant Response', 'bool', 'Calculate constantResponse?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'timeResponse', 'Time Response', 'bool', 'Calculate timeResponse?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'torsional', 'Torsional Analisys', 'bool', 'Calculate torsional?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'balanceOptimization', 'Balance Optimization', 'bool', 'Calculate balanceOptimization?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'vesOptimization', 'Visco-Elastic Support Optimization', 'bool', 'Calculate vesOptimization?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
INSERT INTO `dyntech2`.`projectsetting` (`id`, `projectId`, `type`, `meta_key`, `meta_name`, `meta_type`, `meta_desc`, `meta_attribute`, `meta_value`, `status`, `created_at`, `updated_at`) VALUES (NULL, '1oyNkhDBK7UPZsrq7xcPq', '25', 'absOptimization', 'Absorbtion Support Optimization', 'bool', 'Calculate absOptimization?', '', 'false', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);
*/