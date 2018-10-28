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

use app\models\Project;
use app\models\Machine;
use app\modules\v1\models\ProjectModel;
use app\modules\v1\models\MachineModel;

use yii\helpers\ArrayHelper;
use app\components\RestUtils;

class ProjectController extends RestController
{
	public $modelClass = 'app\models\Project';

	public function __construct($id, $module, $config = [])
	{
		parent::__construct($id, $module, $config);

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
				'chart'  => ['get'],
				'create' => ['post'],
				'update' => ['put'],
				'delete' => ['delete'],
			],
		];
				//'getPermissions'    =>  ['get'],

		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		//$behaviors['authenticator']['except'] = ['index', 'view', 'options'];

		// setup access
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'chart', 'create', 'update', 'delete'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => ['create', 'update', 'delete'],
					'roles' => ['admin', 'manageStaffs'],
				],
				[
					'actions' => ['index', 'view', 'chart'],
					'allow' => true,
				],
			],
		];

		$behaviors['authenticator']['except'][] = 'chart';
		$behaviors['authenticator']['except'][] = 'view';
		$behaviors['authenticator']['except'][] = 'index';

		return $behaviors;
	}

	/**
	 * Return list of staff members
	 *
	 * @return ActiveDataProvider
	 */
	public function actionIndex($unit = 'mm', $userId = null)
	{
		Yii::$app->session->set('ratio', ($unit == 'm') ? 1 : 1000);
		Yii::$app->converter->ratio = ($unit == 'm') ? 1 : 1000;
		//$data = RestUtils::getQuery(\Yii::$app->request->get(), Project::find());
		$models = array();

		if($userId) {
			$models = Project::find()->where([
				'userId' => $userId
			])->all();
		} else {
			$models = Project::find()->all();
		}

		return $models;
	}

	/** @param $id
	 *
	 * @return array|null|\yii\db\ActiveRecord
	 * @throws NotFoundHttpException
	 */
	public function actionView($id, $unit = 'mm')
	{
		/*for ($i=0; $i < 100; $i++) { 
			echo RestUtils::generateId() . "<br>\n";
		}
		die();*/

		Yii::$app->session->set('ratio', ($unit == 'm') ? 1 : 1000);
		Yii::$app->converter->ratio = ($unit == 'm') ? 1 : 1000;

		$project = Project::find()->where([
			'projectId' => $id
		])->one();
		/*->andWhere([
			'status' => 'ACT'
		])*/

		/*var_dump($project);
		die();*/

		if($project) {
			// Yii::$app->session->set('ratio', 1000);
			return $project;
		} else {
			throw new NotFoundHttpException("Object not found: $id");
		}
	}

	public function actionChart($id, $name="line")
	{
		$basePath = Yii::getAlias('@results');
		$path = $basePath."/$id/$name.json";
		// $path = realpath($basePath."$id/$name.json");

		if(file_exists($path)) {
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(200);
			$string = file_get_contents($path);
			$json = json_decode($string, true);
			return $json;
		} else {
			// throw new NotFoundHttpException("Object not found: $id");
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			return [];
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
		$model = new ProjectModel();
		$params = \Yii::$app->getRequest()->getBodyParams();

		$model->load($params, '');

		if ($model->validate() && $model->save()) {
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(201);
			$id = $model->project->projectId;
			$response->getHeaders()->set('Location', Url::toRoute([$id], true));
		} else {
			// Validation error
			throw new HttpException(422, json_encode($model->errors));
		}

		return $model->project;
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
		$params = \Yii::$app->getRequest()->getBodyParams();
		$model = new MachineModel();
		// $machineId = $params['machine']['machineId'];

		$model->update($id, $params);

		if ($model->validate() && $model->save()) {
			$response = \Yii::$app->getResponse();
			$response->setStatusCode(200);
		} else {
			// Validation error
			throw new HttpException(422, json_encode($model->errorList()));
		}

		return $this->actionView($id);
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

		$model->status = Project::STATUS_REMOVED;

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

	public function actionRun($id) {
		$consoleController = new app\commands\RotordynController('rotordyn', Yii::$app);
		$consoleController->runAction('run-machine');
	}
}