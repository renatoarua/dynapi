<?php
namespace app\modules\v1\controllers;

use Yii;
use Sse\Events\TimedEvent;
use odannyc\Yii2SSE\SSEBase;

use yii\base\Event;
use app\models\Runlog;

use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use app\filters\auth\HttpBearerAuth;
use yii\rest\Controller;


class PageController extends Controller
{
	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
		Event::on('app\models\Runlog', Runlog::EVENT_NEW_LOG, function ($ev) {
			echo 'triggered';
		});
	}

	public function onChange($ev) {
		echo $ev->counter;
		// var_dump($ev);
	}

	public function actions()
	{
		return [];
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();


		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBearerAuth::className(),
			],

		];

		$behaviors['verbs'] = [
			'class' => \yii\filters\VerbFilter::className(),
			'actions' => [
				'sse'  => ['get'],
				'log'  => ['get'],
			],
		];

		// remove authentication filter
		$auth = $behaviors['authenticator'];
		unset($behaviors['authenticator']);

		// add CORS filter
		$behaviors['corsFilter'] = [
			'class' => \yii\filters\Cors::className(),
			'cors' => [
				'Origin' => ['*'],
				'Access-Control-Request-Method' => ['GET'],
				'Access-Control-Request-Headers' => ['*'],
			],
		];

		// re-add authentication filter
		$behaviors['authenticator'] = $auth;
		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		$behaviors['authenticator']['except'] = ['options', 'sse', 'log'];

		// setup access
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['sse', 'log'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => ['sse', 'log'],
					'roles' => ['?'],
				],
			],
		];

		$behaviors['contentNegotiator'] = [
			'class' => \yii\filters\ContentNegotiator::className(),
			'only' => ['sse', 'log'],
			'formatParam' => '_format',
			'formats' => [
				'text/event-stream' => \yii\web\Response::FORMAT_RAW,
			],
		];

		return $behaviors;
	}

	public function actionSse(){
		$sse = Yii::$app->sse;
		$sse->set('sleep_time', 0.2);
		$sse->set('allow_cors', true);
		$sse->addEventListener('message', new MessageEventHandler());

		$sse->start();
		$sse->flush();
		// $sse->removeEventListener('message');
	}

	public function actionLog($runId) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		// $sse = Yii::$app->sse;
		// $sse->set('sleep_time', 0.3);
		// $sse->set('allow_cors', true);
		// $sse->addEventListener('message', new LogEventHandler());

		// $sse->start();
		// $sse->flush();

		for ($i=0; $i < 100; $i++) {
			$runlog = new Runlog();
			$runlog->status = '1';
			$runlog->dispatch();
		}
		// $sse->removeEventListener('message');
		// return 'ok';
	}


	public function actionOptions($id = null) {
		return "ok";
	}
}

class Counter extends Event {
	public $counter=0;
	public function __construct($c) {
		$this->counter = $c;
	}
}

class LogEventHandler extends TimedEvent
{
	public $period = 5;
	public $changed = false;

	public function __construct() {
		// $this->on(runlog::EVENT_NEW_LOG, [$this, 'onChange']);
		Event::on('app\models\Runlog', Runlog::EVENT_NEW_LOG, [$this, 'onChange']);
	}

	private $tasks = [
		'general' => [
			'completion' =>  0,
			'message'    =>  '',
			'status'     =>  'running'
		]
	];

	public function onChange($event)
	{
		$this->tasks['general']['completion'] = $event['i'];
		$this->changed = true;
	}

	public function check()
	{
		if($this->tasks['general']['status'] !== 'running')
			return false;

		return true;
	}

	public function update()
	{
		// foreach($this->tasks as $key => $task) {
		// 	$currentPrice = $task['price'];
		// 	$changedPercentage = rand(-5, 5);
		// 	$newPrice = $currentPrice + ($currentPrice*($changedPercentage /100));

		// 	$this->tasks[$key]['price'] = $newPrice;
		// 	$this->tasks[$key]['change'] = $newPrice - $currentPrice;

		// }

		// if ($changed)
		return json_encode($this->tasks);
	}
}

class MessageEventHandler extends TimedEvent
{
	public $period = 5; // the interval in seconds
	public $times = 0;

	private $stocks = [
		[
			'symbol'    =>  'MSFT',
			'price'     =>  30.00,
			'change'    =>  0
		],
		[
			'symbol'    =>  'APPL',
			'price'     =>  30.00,
			'change'    =>  0
		],
		[
			'symbol'    =>  'GOOG',
			'price'     =>  30.00,
			'change'    =>  0
		]
	];
	public function check()
	{
		if ($this->times > 100 && $this->times < 150)
			return false;

		$this->times++;
		return true;
	}

	public function update()
	{
		foreach($this->stocks as $stockKey => $stock) {
			$currentPrice = $stock['price'];
			$changedPercentage = rand(-5, 5);
			$newPrice = $currentPrice + ($currentPrice*($changedPercentage /100));

			$this->stocks[$stockKey]['price'] = $newPrice;
			$this->stocks[$stockKey]['change'] = $newPrice - $currentPrice;

		}
		return json_encode($this->stocks);
	}
}