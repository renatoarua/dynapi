<?php
//namespace machour\yii2\notifications;
namespace backend\modules\notification;

use Exception;
use backend\modules\notification\models\Notification;
use yii\base\Module;
use yii\db\Expression;
class NotificationsModule extends Module
{
    /**
     * @var string The controllers namespace
     */
    public $controllerNamespace = 'backend\modules\notification\controllers';
    /**
     * @var Notification The notification class defined by the application
     */
    public $notificationClass;
    /**
    * @var boolean Whether notification can be duplicated (same userId, key, and key_id) or not
    */
    public $allowDuplicate = false;
    /**
     * @var callable|integer The current user id
     */
    public $userId;
    /**
     * @inheritdoc
     */
    public function init() {
        if (is_callable($this->userId)) {
            $this->userId = call_user_func($this->userId);
        }
        parent::init();
    }
    /**
     * Creates a notification
     *
     * @param Notification $notification The notification class
     * @param string $key The notification key
     * @param integer $userId The user id that will get the notification
     * @param string $key_id The key unique id
     * @param string $type The notification type
     * @return bool Returns TRUE on success, FALSE on failure
     * @throws Exception
     */
    public static function notify($notification, $key, $userId, $key_id = null, $type = Notification::TYPE_DEFAULT)
    {
        if (!in_array($key, $notification::$keys)) {
            throw new Exception("Not a registered notification key: $key");
        }
        if (!in_array($type, Notification::$types)) {
            throw new Exception("Unknown notification type: $type");
        }
        /** @var Notification $instance */
        $instance = $notification::findOne(['userId' => $userId, 'key' => $key, 'key_id' => (string)$key_id]);
        if (!$instance || \Yii::$app->getModule('notifications')->allowDuplicate) {
            $instance = new $notification([
                'key' => $key,
                'type' => $type,
                'seen' => 0,
                'userId' => $userId,
                'key_id' => (string)$key_id,
                'createdAt' => new Expression('NOW()'),
            ]);
            return $instance->save();
        }
        return true;
    }
}