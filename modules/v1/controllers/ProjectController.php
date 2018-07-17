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
use app\modules\v1\models\ProjectModel;

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
			'only' => ['index', 'view', 'create', 'update', 'delete'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => ['create', 'update', 'delete'],
					'roles' => ['admin', 'manageStaffs'],
				],
				[
					'actions' => ['index', 'view'],
					'allow' => true,
				],
			],
		];

		$behaviors['authenticator']['except'][] = 'view';
		$behaviors['authenticator']['except'][] = 'index';

		return $behaviors;
	}

	/**
	 * Return list of staff members
	 *
	 * @return ActiveDataProvider
	 */
	public function actionIndex($userId = null)
	{
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
	public function actionView($id)
	{
		$project = Project::find()->where([
			'projectId' => $id
		])->one();
		/*->andWhere([
			'status' => 'ACT'
		])*/
		
		/*var_dump($project);
		die();*/

		if($project) {
			return $project;
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
		$model = $this->actionView($id);

		$model->load(\Yii::$app->getRequest()->getBodyParams(), '');

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