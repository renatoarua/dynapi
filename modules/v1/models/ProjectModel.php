<?php

namespace app\modules\v1\models;

use Yii;

use app\models\Project;
use app\models\Machine;
use app\models\Projectsetting;
use app\models\User;

use yii\base\Model;
use yii\widgets\ActiveForm;

use app\components\RestUtils;
use yii\helpers\Json;

class ProjectModel extends Model
{
	private $_project;
	private $_settings;
	private $_machine;
	private $_user;

	public function rules()
	{
		return [
			[['Project', 'Projectsetting', 'Machine', 'User'], 'required'],
		];
	}

	public function afterValidate()
	{
		$error = false;
		/*if(!$this->machine->validate()) {
			$error = true;
		}
		if(!$this->projectsetting->validate()) {
			$error = true;
		}*/
		if(!$this->project->validate()) {
			$error = true;
		}

		if($error)
			$this->addError(null);

		parent::afterValidate();
	}

	public function save()
	{
		if(!$this->validate()) {
			return false;
		}

		try {

			$tx = Yii::$app->db->beginTransaction();
			//$this->user->save();
			$this->project->save();
			$this->machine->projectId = $this->project->projectId;
			$this->projectsetting->projectId = $this->project->projectId;
			$this->machine->save();
			$this->projectsetting->save();

			$tx->commit();
			return true;

		} catch(Exception $e) {
			$tx->rollBack();
			return false;
		}
	}

	public function load($data, $formName = null)
	{
		// parent::load($data, 'project');
		$this->project = $data['project'];
		$this->projectsetting = $data['settings'];
		$this->machine = $this->createMachine($data);
		$this->user = User::findIdentity($this->project->userId);

		$this->projectsetting->projectId = '0L8qMKDBYWXb34IWwRtqg';
		$this->projectsetting->save();
	}

	public function getProject()
	{
		return $this->_project;
	}

	public function setProject($model)
	{
		if($model instanceof Project) {
			$this->_project = $model;
		} else if (is_array($model)) {
			$this->_project = $this->createProject($model);
		}
	}

	public function getMachine()
	{
		return $this->_machine;
	}

	public function setMachine($model)
	{
		//$this->_machine = $model;
		if($model instanceof Machine) {
			$this->_machine = $model;
		} else if (is_array($model)) {
			$this->_machine = $this->createMachine($model);
		}
	}

	public function getProjectsetting()
	{
		return $this->_settings;
	}

	public function setProjectsetting($model)
	{
		if($model instanceof Projectsetting) {
			$this->_settings = $model;
		} else if (is_array($model)) {
			$this->_settings = $this->createSettings($model);
		}
	}

	public function getUser()
	{
		return $this->_user;
	}

	public function setUser($model)
	{
		if($model instanceof User) {
			$this->_user = $model;
		} else if (is_array($model)) {
			// $this->_user = $this->createUser($model);
		}
	}

	protected function createProject($model)
	{
		// project ID
		$pro = new Project();
		$pro->projectId = RestUtils::generateId();
		$pro->userId = $model['userId'];
		$pro->name = $model['name'];
		$pro->status = $model['status'];

		return $pro;
	}

	protected function createSettings($model)
	{
		$pro = new Projectsetting();
		$pro->projectId = RestUtils::generateId();

		$pro->systemoptions = Json::encode([
			'rollerbearing' => $model[0],
			'journalbearing' => $model[1],
			'foundation' => $model[2],
			// 'ves' => $model[3],
			// 'abs' => $model[4]
		]);

		$pro->resultoptions = Json::encode([
			'staticLine' => $model[3],
			'campbell' => $model[4],
			'criticalMap' => $model[5],
			'modes' => $model[6],
			'unbalancedResponse' => $model[7],
			'constantResponse' => $model[8],
			'timeResponse' => $model[9],
			'torsional' => $model[10]
		]);

		$pro->resultcampbell = Json::encode([]);
        $pro->resultstiffness = Json::encode([]);
        $pro->resultmodes = Json::encode([]);
        $pro->resultconstant = Json::encode([]);
        $pro->resultunbalance = Json::encode([]);
        $pro->resulttorsional = Json::encode([]);
        $pro->resulttime = Json::encode([]);

		return $pro;
	}

	protected function createMachine($model)
	{
		$maq = new Machine();
		$maq->machineId = RestUtils::generateId();

		$maq->sections = Json::encode([]);
        $maq->discs = Json::encode([]);
        $maq->rollerbearings = Json::encode([]);
        $maq->journalbearings = Json::encode([]);
        $maq->foundations = Json::encode([]);
        $maq->ves = Json::encode([]);
        $maq->abs = Json::encode([]);
        $maq->ldratio = '1.000000e+0';
        $maq->rangeOptions = Json::encode([
			"minSpeed" => $model['speedMin'],
			"maxSpeed" => $model['speedMax'],
			"maxAmplitude" => $model['ampMax'],
		]);

		return $maq;
	}

	public function errorSummary($form)
	{
		$errorLists = [];
		foreach ($this->getAllModels() as $id => $model) {
			$errorList = $form->errorSummary($model, [
				'header' => '<p>The following fields have errors: <b>'.$id.'</b></p>',
			]);
			$errorList = str_replace('<li></li>', '', $errorList); // remove the empty error
			$errorLists[] = $errorList;
		}
		return implode('', $errorLists);
	}

	public function errorList()
	{
		$errorLists = [];
		foreach ($this->getAllModels() as $id => $model) {
			if($model && !empty($model->errors))
				$errorLists[$id] = $model->errors;
		}

		if(!empty($this->errors))
			$errorLists['ProjectModel'] = $this->errors;

		return $errorLists;
	}

	public function firstError()
	{
		$ret = RestUtils::arrayCleaner($this->errorList());

		while(is_array($ret))
			$ret = reset($ret);

		return $ret;
	}

	private function getAllModels()
	{
		return [
			'User' => $this->user,
			'Project' => $this->project,
			'Projectsetting' => $this->projectsetting,
			'Machine' => $this->machine,
		];
	}
}