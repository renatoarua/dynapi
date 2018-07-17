<?php

namespace app\modules\v1\models;

use Yii;

use app\models\Ves;
use app\models\Sheet;
use app\models\Sheetmaterial;
use app\models\Sheettranslation;
use app\models\Sheetrotation;
use app\models\Vesrollerbearing;

use yii\base\Model;
use yii\widgets\ActiveForm;

use app\components\RestUtils;

class VesModel extends Model
{
	private $_ves;
	private $_sheet;
	private $_sheetmaterials;
	private $_sheetrotations;
	private $_sheettranslations;
	private $_vesrollerbearings;

	public function rules()
	{
		return [
			[['Ves'], 'required'],
		];
	}

	public function afterValidate()
	{
		$error = false;
		if(!$this->ves->validate()) {
			$error = true;
		}
		if(!$this->sheet->validate()) {
			$error = true;
		}
		foreach ($this->sheetmaterials as $mat) {
			if(!$mat->validate()) {
				$error = true;
			}
		}
		foreach ($this->sheetrotations as $rot) {
			if(!$rot->validate()) {
				$error = true;
			}
		}
		foreach ($this->sheettranslations as $tra) {
			if(!$tra->validate()) {
				$error = true;
			}
		}
		foreach ($this->vesrollerbearings as $roll) {
			if(!$roll->validate()) {
				$error = true;
			}
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

			$this->ves->save();
			$this->sheet->vesId = $this->ves->vesId;
			$this->sheet->save();

			foreach ($this->sheetmaterials as $mat) {
				$mat->sheetId = $this->sheet->sheetId;
				$mat->save();
			}

			foreach ($this->sheetrotations as $rot) {
				$rot->sheetId = $this->sheet->sheetId;
				$rot->save();
			}

			foreach ($this->sheettranslations as $tra) {
				$tra->sheetId = $this->sheet->sheetId;
				$tra->save();
			}

			foreach ($this->vesrollerbearings as $roll) {
				$roll->vesId = $this->ves->vesId;
				$roll->save();
			}

			$tx->commit();
			return true;

		} catch(Exception $e) {
			$tx->rollBack();
			return false;
		}
	}

	public function loadAll($data, $machineId)
	{
		$this->ves = new Ves();
		$vesId = RestUtils::generateId();
		$this->ves->vesId = $vesId;
		$this->ves->machineId = $machineId;
		$this->ves->position = (float)$data['position'] / 1000;

		$this->sheet = $this->createSheet($data);
		$sheetId = $this->sheet->sheetId;
		// $this->sheet->vesId = $vesId;

		$this->_sheetmaterials = [];
		foreach ($data['materials'] as $mat) {
			if(!empty($mat['go'])) {
				$this->setSheetmaterials($mat, $sheetId);
			}
		}

		$inertia = 0;
		$this->_sheetrotations = [];
		foreach ($data['rotations'] as $rot) {
			if(!empty($rot['thickness'])) {
				$this->setSheetrotations($rot, $sheetId);
			}

			if(!empty($rot['inertia']))
				$inertia = $rot['inertia'];
		}

		$mass = 0;
		$this->_sheettranslations = [];
		foreach ($data['translations'] as $tra) {
			if(!empty($tra['thickness'])) {
				$this->setSheettranslations($tra, $sheetId);
			}

			if(!empty($tra['mass']))
				$mass = $tra['mass'];
		}

		$this->_vesrollerbearings = [];
		foreach ($data['rollerbearings'] as $roll) {
			if(!empty($roll['mass']) || (!empty($roll['inertia']))) {
				$this->setVesrollerbearings($roll, $vesId);
			}
		}

		$this->sheet->mass = $mass;
		$this->sheet->inertia = $inertia;
	}

	public function getVes()
	{
		return $this->_ves;
	}

	public function setVes($model)
	{
		if($model instanceof Ves) {
			$this->_ves = $model;
		} else if (is_array($model)) {
			//$this->_ves = $this->createVes($model);
		}
	}

	public function getSheet()
	{
		return $this->_sheet;
	}

	public function setSheet($model)
	{
		if($model instanceof Sheet) {
			$this->_sheet = $model;
		} else if (is_array($model)) {
			$this->_ves = $this->createSheet($model);
		}
	}

	public function getSheetmaterials()
	{
		return $this->_sheetmaterials;
	}

	public function setSheetmaterials($model, $sheetId)
	{
		if($model instanceof Sheetmaterial) {
			$this->_sheetmaterials[] = $model;
		} else if (is_array($model)) {
			$this->_sheetmaterials[] = $this->createMaterial($model, $sheetId);
		}
	}

	public function getSheetrotations()
	{
		return $this->_sheetrotations;
	}

	public function setSheetrotations($model, $sheetId)
	{
		if($model instanceof Sheetrotation) {
			$this->_sheetrotations[] = $model;
		} else if (is_array($model)) {
			$this->_sheetrotations[] = $this->createRotation($model, $sheetId);
		}
	}

	public function getSheettranslations()
	{
		return $this->_sheettranslations;
	}

	public function setSheettranslations($model, $sheetId)
	{
		if($model instanceof Sheettranslation) {
			$this->_sheettranslations[] = $model;
		} else if (is_array($model)) {
			$this->_sheettranslations[] = $this->createTranslation($model, $sheetId);
		}
	}

	public function getVesrollerbearings()
	{
		return $this->_vesrollerbearings;
	}

	public function setVesrollerbearings($model, $machineId)
	{
		//$this->_ribs = $model;
		if($model instanceof Vesrollerbearing) {
			$this->_vesrollerbearings[] = $model;
		} else if (is_array($model)) {
			$this->_vesrollerbearings[] = $this->createRoller($model, $machineId);
		}
	}

	protected function createSheet($model)
	{
		$shit = new Sheet();
		$shit->sheetId = RestUtils::generateId();
		// $shit->vesId = $vesId;
		$shit->simple = (int)$model['simple'];
		$shit->single = (int)$model['single'];
		$shit->type = (int)$model['type'];
		// $shit->doubled = (int)$model['doubled'];
		// $shit->mass = (float)$model['mass'];
		// $shit->inertia = (float)$model['inertia'];

		return $shit;
	}

	protected function createMaterial($model, $sheetId)
	{
		$mat = new Sheetmaterial();
		// $mat->sheetId = $sheetId;
		$mat->sheetMaterialId = RestUtils::generateId();

		$mat->go = (float)$model['go'];
		$mat->goo = (float)$model['goo'];
		$mat->beta = (float)$model['beta'];
		$mat->b1 = (float)$model['b1'];
		$mat->theta1 = (float)$model['theta1'];
		$mat->theta2 = (float)$model['theta2'];
		$mat->temperature = (float)$model['temperature'];
		$mat->temperatureRef = (float)$model['temperatureRef'];

		return $mat;
	}

	protected function createRotation($model, $sheetId)
	{
		$rot = new Sheetrotation();
		// $rot->sheetId = $sheetId;
		$rot->sheetRotationId = RestUtils::generateId();

		$rot->thickness = (float)$model['thickness'] / 1000;
		$rot->meanRadius = (float)$model['meanRadius'] / 1000;
		$rot->thickAngle = (float)$model['thickAngle'];
		$rot->lengthAngle = (float)$model['lengthAngle'];

		return $rot;
	}

	protected function createTranslation($model, $sheetId)
	{
		$rot = new Sheettranslation();
		// $rot->sheetId = $sheetId;
		$rot->sheetTranslationId = RestUtils::generateId();

		$rot->segments = (float)$model['segments'];
		$rot->thickness = (float)$model['thickness'] / 1000;
		$rot->diameter = (float)$model['diameter'] / 1000;

		return $rot;
	}

	protected function createRoller($model, $vesId)
	{
		$roll = new Vesrollerbearing();
		// $roll->vesId = $vesId;
		$roll->vesRollerBearingId = RestUtils::generateId();

		$roll->position = (float)$model['position'] / 1000;
		$roll->inertia = $model['inertia'];
		$roll->mass = $model['mass'];
		$roll->kxx = $model['kxx'];
		$roll->kxz = $model['kxz'];
		$roll->kzx = $model['kzx'];
		$roll->kzz = $model['kzz'];
		$roll->cxx = $model['cxx'];
		$roll->cxz = $model['cxz'];
		$roll->czx = $model['czx'];
		$roll->czz = $model['czz'];
		$roll->ktt = $model['ktt'];
		$roll->ktp = $model['ktp'];
		$roll->kpt = $model['kpt'];
		$roll->kpp = $model['kpp'];
		$roll->ctt = $model['ctt'];
		$roll->ctp = $model['ctp'];
		$roll->cpt = $model['cpt'];
		$roll->cpp = $model['cpp'];

		return $roll;
	}

	public function errorList()
	{
		$errorLists = [];
		foreach ($this->getAllModels() as $id => $model) {
			if($model && !empty($model->errors))
				$errorLists[$id] = $model->errors;
		}

		if(!empty($this->errors))
			$errorLists['VesModel'] = $this->errors;

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
		$arr = [];
		$arr[] = ['Ves' => $this->ves];
		$arr[] = ['Sheet' => $this->sheet];

		foreach ($this->sheetmaterials as $key => $value) {
			$arr[] = ['Sheetmaterial'.$key => $value];
		}

		foreach ($this->sheetrotations as $key => $value) {
			$arr[] = ['Sheetrotation'.$key => $value];
		}

		foreach ($this->sheettranslations as $key => $value) {
			$arr[] = ['Sheettranslation'.$key => $value];
		}

		foreach ($this->vesrollerbearings as $key => $value) {
			$arr[] = ['vesRollerbearing'.$key => $value];
		}

		return $arr;
	}
}