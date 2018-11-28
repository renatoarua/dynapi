<?php
namespace app\modules\v1\controllers;

use app\filters\auth\HttpBearerAuth;
use Yii;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\helpers\Url;
use yii\rbac\Permission;

use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

use yii\helpers\ArrayHelper;
use app\controllers\RestController;
use app\components\RestUtils;

use app\models\PayLedger;

class PaymentController extends RestController
{
	public $modelClass = 'app\models\PayLedger';

	public function actions()
	{
		/*$actions = parent::actions();
	    $actions['balance'] = [];
	    return $actions;*/
	    return [];
	}

	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['verbs'] = [
			'class' => \yii\filters\VerbFilter::className(),
			'actions' => [
				'index'    => ['get'],
				'view'     => ['get'],
				'balance'  => ['get'],
				// 'orders'   => ['get'],
				/*'create' => ['post'],
				'update' => ['put'],
				'delete' => ['delete'],*/
			],
		];

		// avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
		//$behaviors['authenticator']['except'] = ['index', 'view', 'options'];

		// setup access
		$behaviors['access'] = [
			'class' => AccessControl::className(),
			'only' => ['index', 'view', 'balance'], //only be applied to
			'rules' => [
				[
					'allow' => true,
					'actions' => [], //'create', 'update', 'delete'
					'roles' => ['admin', 'manageStaffs'],
				],
				[
					'actions' => ['index', 'view', 'balance'],
					'allow' => true,
				],
			],
		];

		// $behaviors['authenticator']['except'][] = 'orders';
		$behaviors['authenticator']['except'][] = 'balance';
		$behaviors['authenticator']['except'][] = 'view';
		$behaviors['authenticator']['except'][] = 'index';

		return $behaviors;
	}

	public function actionIndex()
	{
		$response = \Yii::$app->getResponse();
		$response->setStatusCode(501);
		return [];
	}

	public function actionView($id)
	{
		$credits = PayLedger::find()->where([
			'buyerId'  =>  $id
		])->andWhere([
			'=', 'tokenId', 'DYN'
		])->all();

		/*->andWhere([
			'=', 'actionId', 1
		])*/

		if($credits){
			return $credits;
		} else {
			throw new NotFoundHttpException("Object not found: $id");
		}
	}

	public function actionOrders($userId)
	{

	}

	public function actionBalance($userId, $order = null)
	{
		$moves = PayLedger::find()
			->where(['or',
	           ['buyerId' => $userId],
	           ['sellerId' => $userId]
	        ])
			->andWhere([
				'=', 'tokenId', 'DYN'
			])->orderBy('date ASC')
			->all();

		if($moves) {
			return $moves;
		} else {
			throw new NotFoundHttpException("Object not found: $userId");
		}
	}

	public function actionOptions($id = null) {
		return "ok";
	}
}
