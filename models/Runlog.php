<?php

namespace app\models;

use Yii;
use yii\base\Event;

/**
 * This is the model class for table "runlog".
 *
 * @property int $id
 * @property int $runId
 * @property int $ledgerId
 * @property string $task
 * @property string $cost
 * @property string $status
 */
class Runlog extends \yii\db\ActiveRecord
{
    const EVENT_NEW_LOG = 'new-log';
    const EVENT_ERR_LOG = 'error-log';
    const EVENT_END_LOG = 'finish-log';

    private $logs;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'runlog';
    }

    public function dispatch($ev = self::EVENT_NEW_LOG) {
        $this->trigger($ev, new LogEvent($this));
    }

    public function setMessages($data) {
        $data['time'] = time();
        $this->logs = $data;
    }

    public function getMessages() {
        return $this->logs;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['runId', 'ledgerId', 'started_at', 'ended_at', 'percent'], 'integer'],
            [['cost'], 'number'],
            [['task'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'runId' => Yii::t('app', 'Run ID'),
            'ledgerId' => Yii::t('app', 'Ledger ID'),
            'cost' => Yii::t('app', 'Cost'),
            'task' => Yii::t('app', 'Task'),
            'started_at' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'percent' => Yii::t('app', 'Percent'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}

class LogEvent extends Event {
    const EVENT_NEW_LOG = 'new-log';
    public $log;

    public function __construct($runlog) {
        $this->log = $runlog;
    }
}