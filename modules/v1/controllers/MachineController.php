<?php
namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use Yii;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\helpers\Url;
use yii\rbac\Permission;
use app\controllers\RestController;

use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\BadRequestHttpException;

use app\models\User;
use app\models\Run;
use app\models\Runlog;
use app\models\LogEvent;
use app\models\PayLedger;
use app\models\Machine;
use app\modules\v1\models\MachineModel;

// use Sse\Events\TimedEvent;
use Sse\Event;
use Sse\Data;

// use yii\base\Event;
use odannyc\Yii2SSE\SSEBase;

use yii\helpers\ArrayHelper;
use app\components\RestUtils;

class MachineController extends RestController
{
	public $modelClass = 'app\models\Machine';

	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);
		// Event::on('app\models\Runlog', Runlog::EVENT_NEW_LOG, function ($ev) {
		// 	echo $ev->log->status;
		// });
	}

	public function actions()
	{
		return [];
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['verbs'] = [
			'class' => \yii\filters\VerbFilter::className(),
			'actions' => [
				'index'  => ['get'],
				'view'   => ['get'],
				'create' => ['post'],
				'update' => ['put'],
				'delete' => ['delete'],
				'execute'=> ['get'],
				'change' => ['get'],
				'log'    => ['post'],
				'status' => ['get'],
			],
		];
				//'getPermissions'    =>  ['get'],

		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		//$behaviors['authenticator']['except'] = ['index', 'view', 'options'];

		$behaviors['authenticator']['except'][] = 'change';
		$behaviors['authenticator']['except'][] = 'status';
		$behaviors['authenticator']['except'][] = 'log';
		$behaviors['authenticator']['except'][] = 'view';
		$behaviors['authenticator']['except'][] = 'index';

		// setup access
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete', 'execute', 'change', 'log', 'status'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => ['create', 'delete'],
					'roles' => ['admin', 'manageStaffs'],
				],
				[
					'actions' => ['index', 'view', 'update', 'execute', 'change', 'log', 'status'],
					'allow' => true,
				],
			],
		];

		$behaviors['contentNegotiator'] = [
			'class' => \yii\filters\ContentNegotiator::className(),
			'only' => ['status'],
			'formatParam' => '_format',
			'formats' => [
				'text/event-stream' => \yii\web\Response::FORMAT_RAW,
			],
		];

		return $behaviors;
	}

	/**
	 * Return list of staff members
	 *
	 * @return ActiveDataProvider
	 */
	public function actionIndex($userId = null)
	{
		//$data = RestUtils::getQuery(\Yii::$app->request->get(), Machine::find());
		$models = array();

		$models = Machine::find()->all();

		return $models;
	}

	/** @param $id
	 *
	 * @return array|null|\yii\db\ActiveRecord
	 * @throws NotFoundHttpException
	 */
	public function actionView($id)
	{
		$machine = Machine::find()->where([
			'machineId' => $id
		])->one();
		/*->andWhere([
			'status' => 'ACT'
		])*/
		
		/*var_dump($machine);
		die();*/

		if($machine) {
			return $machine;
		} else {
			throw new NotFoundHttpException("Object not found: $id");
		}
	}

	/**
	 * Create new staff member from backend dashboard
	 *
	 * Request: POST /v1/staff/1
	 *
	 * @return User
	 * @throws HttpException
	 */
	public function actionCreate() {
		$model = new Machine();
		$model->load(\Yii::$app->getRequest()->getBodyParams(), '');
		$model->machineId = RestUtils::generateId();

		if ($model->validate() && $model->save()) {
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			$id = implode(',', array_values($model->getPrimaryKey(true)));
			$response->getHeaders()->set('Location', Url::toRoute([$id], true));
		} else {
			// Validation error
			throw new HttpException(422, json_encode($model->errors));
		}

		return $model;
	}

	/**
	 *
	 *
	 * @param $id
	 *
	 * @return array|null|\yii\db\ActiveRecord
	 * @throws HttpException
	 */
	public function actionUpdate($id) {
		// $model = $this->actionView($id);
		$model = new MachineModel();
		$params = \Yii::$app->getRequest()->getBodyParams();

		$model->update($params);
		var_dump($model);
		die();

		if ($model->validate() && $model->save()) {
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(200);
		} else {
			// Validation error
			throw new HttpException(422, json_encode($model->errors));
		}

		return $model;
	}

	/**
	 * Delete requested project from backend dashboard
	 *
	 * Request: DELETE /v1/project/{id}
	 *
	 * @param $id
	 *
	 * @return string
	 * @throws ServerErrorHttpException
	 */
	public function actionDelete($id) {
		$model = $this->actionView($id);

		//$model->status = Project::STATUS_REMOVED;

		if ($model->save(false) === false) {
			throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
		}

		$response = \Yii::$app->getResponse();
		$response->setStatusCode(204);
		return "ok";
	}

	public function actionOptions($id = null) {
		return "ok";
	}

	public function actionChange($id = null) {
		/*$rows = (new \yii\db\Query())
			->select(['sectiOnId', 'position', 'externalDiameter', 'internalDiameter', 'young', 'poisson', 'density', 'axialForce', 'magneticForce'])
			->from('section')
			->all();

		$conn = \Yii::$app->getDb();
		foreach ($rows as $obj) {
			$qry = "UPDATE `section` SET";


			$qry .= " `position`='" . sprintf("%e", (float)$obj['position']) . "',";
			$qry .= " `externalDiameter`='" . sprintf("%e", (float)$obj['externalDiameter']) . "',";
			$qry .= " `internalDiameter`='" . sprintf("%e", (float)$obj['internalDiameter']) . "',";
			$qry .= " `young`='" . sprintf("%e", (float)$obj['young']) . "',";
			$qry .= " `poisson`='" . sprintf("%e", (float)$obj['poisson']) . "',";
			$qry .= " `density`='" . sprintf("%e", (float)$obj['density']) . "',";

			$qry .= " `axialForce`='" . sprintf("%e", (float)$obj['axialForce']) . "',";
			$qry .= " `magneticForce`='" . sprintf("%e", (float)$obj['magneticForce']) . "'";
			$qry .= " WHERE `sectiOnId` LIKE BINARY '" . $obj['sectiOnId'] . "'";


			echo "<pre>".$qry . "</pre>";
			$com = $conn->createCommand($qry);
			$com->execute();

		}*/

		// var_dump($rows);
		// die();
		return "ok";
	}

	public function actionExecute($id = null) {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		if(is_null($id)) {
			throw new BadRequestHttpException("No projectId given");
		}

		// check balance,
		$consoleController = new \app\commands\RotordynController('rotordyn', Yii::$app);
		$res = $consoleController->actionRunMachine($id);

		$data = new Data('file', array('path' => './uploads/results/'.$id.'/run'.$res->id));
        $data->set('tasks', json_encode(['time' => time(), 'projectId' => $id]));
		// run model
		return $res;
	}

	public function actionLog() {
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$params = Yii::$app->request->post();

		$model = new Runlog();
		if(isset($params['Runlog']['id'])) {
			$model = Runlog::find()->where([
				'id' => $params['Runlog']['id']
			])->one();
		}

		$model->load($params);

		$model->setMessages($params['LogModel']);
		$projectId = $params['LogModel']['projectId'];

		$data = new Data('file', array('path' => './uploads/results/'.$projectId.'/run'.$model->runId));
        $data->set('tasks', json_encode($model->getMessages()));


		if((float)$model->cost > 0) {
			$ref = Run::find()->where([
				'id' => $model->runId
			])->one();

			$entry = new PayLedger();
			// check balance, pay the robot or in the execute
			$entry->actionId = 3;
			$entry->sellerId = $ref->userId;
			$entry->buyerId = 4;
			$entry->tokenId = 'DYN';
			$entry->date = time();
			$entry->amount = +$model->cost;

			// $entry->validate();
			// var_dump($entry->errors);
			// die();
			$entry->save();
		}

		if(!isset($params['Runlog'])) {
			$response = \Yii::$app->getResponse();
            $response->setStatusCode(200);
            return ['id' => -1];
		}
		elseif ($model->validate() && $model->save()) {
            $response = \Yii::$app->getResponse();
            $response->setStatusCode(200);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            return ['id' => $id];
        } else {
            // Validation error
            throw new HttpException(422, json_encode($model->errors));
        }
	}

	public function actionStatus($runid)
	{
		list($projectId, $runId) = explode("_", $runid);
		$data = new Data('file', array('path' => './uploads/results/'.$projectId.'/run'.$runId));
		// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		// check user, runId, projectId

		$sse = Yii::$app->sse;
		$sse->set('sleep_time', 0.5);
		$sse->set('allow_cors', true);
		$timeEvent = new LogEventHandler($data, $runId);

		$sse->addEventListener('logger', $timeEvent);

		$sse->start();
		$sse->flush();

		// $sse->removeEventListener('logger');
	}

}

class LogEventHandler implements Event
{
	private $cache = 0;
    private $storage;
	private $tasks;

	public $runId = -1;

	public function __construct($data, $runid)
	{
        $this->storage = $data;
		$this->runId = $runid;
    }

	public function check()
	{
		$this->tasks = json_decode($this->storage->get('tasks'));
		if($this->tasks->time !== $this->cache){
            $this->cache = $this->tasks->time;
            return true;
        }

		return false;
	}

	public function update()
	{
		return json_encode($this->tasks);
	}
}