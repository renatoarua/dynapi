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

use app\models\Machine;
use app\modules\v1\models\MachineModel;

use yii\helpers\ArrayHelper;
use app\components\RestUtils;

class MachineController extends RestController
{
	public $modelClass = 'app\models\Machine';

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
				'execute'=> ['get'],
				'change'=> ['get'],
			],
		];
				//'getPermissions'    =>  ['get'],

		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		//$behaviors['authenticator']['except'] = ['index', 'view', 'options'];

		$behaviors['authenticator']['except'][] = 'change';
		$behaviors['authenticator']['except'][] = 'execute';
		$behaviors['authenticator']['except'][] = 'view';
		$behaviors['authenticator']['except'][] = 'index';

		// setup access
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'create', 'update', 'delete', 'execute', 'change'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => ['create', 'delete'],
					'roles' => ['admin', 'manageStaffs'],
				],
				[
					'actions' => ['index', 'view', 'update', 'execute', 'change'],
					'allow' => true,
				],
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
		/*var_dump($model->ves[1]->errorList());
		var_dump($model->errorList());
		die();*/

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

	public function actionExecute($id = null) {
		if(is_null($id)) {
			throw new Exception("No ID given");
		}
		$consoleController = new \app\commands\RotordynController('rotordyn', Yii::$app);
		$res = $consoleController->actionRunMachine($id);
		return $res;
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

}