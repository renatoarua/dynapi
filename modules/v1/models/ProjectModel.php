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
		/*if(!$this->user->validate()) {
			$error = true;
		}
		if(!$this->machine->validate()) {
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
		$this->machine = $this->createMachine();
		$this->user = User::findIdentity($this->project->userId);
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
		$pro->foundation = ($model[0] == 'true' || $model[0] == '1') ? '1' : '0';
		$pro->rollerbearing = ($model[1] == 'true' || $model[1] == '1') ? '1' : '0';
		$pro->journalbearing = ($model[2] == 'true' || $model[2] == '1') ? '1' : '0';
		$pro->ves = ($model[3] == 'true' || $model[3] == '1') ? '1' : '0';
		$pro->abs = ($model[4] == 'true' || $model[4] == '1') ? '1' : '0';
		$pro->staticLine = ($model[5] == 'true' || $model[5] == '1') ? '1' : '0';
		$pro->fatigue = ($model[6] == 'true' || $model[6] == '1') ? '1' : '0';
		$pro->campbell = ($model[7] == 'true' || $model[7] == '1') ? '1' : '0';
		$pro->modes = ($model[8] == 'true' || $model[8] == '1') ? '1' : '0';
		$pro->criticalMap = ($model[9] == 'true' || $model[9] == '1') ? '1' : '0';
		$pro->unbalancedResponse = ($model[10] == 'true' || $model[10] == '1') ? '1' : '0';
		$pro->constantResponse = ($model[11] == 'true' || $model[11] == '1') ? '1' : '0';
		$pro->timeResponse = ($model[12] == 'true' || $model[12] == '1') ? '1' : '0';
		$pro->torsional = ($model[13] == 'true' || $model[13] == '1') ? '1' : '0';
		$pro->balanceOptimization = ($model[14] == 'true' || $model[14] == '1') ? '1' : '0';
		$pro->vesOptimization = ($model[15] == 'true' || $model[15] == '1') ? '1' : '0';
		$pro->absOptimization = ($model[16] == 'true' || $model[16] == '1') ? '1' : '0';

		return $pro;
	}

	protected function createMachine()
	{
		$maq = new Machine();
		$maq->machineId = RestUtils::generateId();

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