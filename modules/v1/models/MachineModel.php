<?php

namespace app\modules\v1\models;

use Yii;

use app\models\Machine;
use app\models\Shaftsection;
use app\models\Ribs;
use app\models\Disc;
use app\models\Rollerbearing;
use app\models\Journalbearing;
use app\models\Abs;
use app\models\Ves;
use app\models\Foundation;
use app\models\Rotation;

use app\modules\v1\models\VesModel;

use yii\base\Model;
use yii\widgets\ActiveForm;

use app\components\RestUtils;

class MachineModel extends Model
{
	private $_machine;
	private $_section;
	private $_ribs;
	private $_discs;
	private $_rollerbearings;
	private $_journalbearings;
	private $_rotations;
	private $_abs;
	private $_ves;
	private $_foundations;

	public function rules()
	{
		// 'Shaftsection', 'Ribs', 'Disc', 'Rollerbearing'
		// 'Journalbearing', 'Abs', 'Ves', 'Foundation'
		return [
			[['Machine'], 'required'],
		];
	}

	public function afterValidate()
	{
		$error = false;
		if(!$this->machine->validate()) {
			$error = true;
		}
		foreach ($this->section as $section) {
			if(!$section->validate()) {
				$error = true;
			}
		}
		foreach ($this->ribs as $rib) {
			if(!$rib->validate()) {
				$error = true;
			}
		}
		foreach ($this->discs as $disc) {
			if(!$disc->validate()) {
				$error = true;
			}
		}
		foreach ($this->rollerbearings as $roll) {
			if(!$roll->validate()) {
				$error = true;
			}
		}
		foreach ($this->journalbearings as $roll) {
			if(!$roll->validate()) {
				$error = true;
			}
		}
		foreach ($this->rotations as $rot) {
			if(!$rot->validate()) {
				$error = true;
			}
		}
		foreach ($this->ves as $vs) {
			if(!$vs->validate()) {
				$error = true;
			}
		}
		foreach ($this->foundations as $fund) {
			if(!$fund->validate()) {
				$error = true;
			}
		}
		/*if(!$this->abs->validate()) {
			$error = true;
		}*/

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

			$this->machine->save();

			foreach ($this->section as $section) {
				$section->save();
			}

			foreach ($this->ribs as $rib) {
				$rib->save();
			}

			foreach ($this->discs as $disc) {
				$disc->save();
			}

			foreach ($this->rollerbearings as $roll) {
				$roll->save();
			}

			foreach ($this->journalbearings as $roll) {
				$roll->save();
			}

			foreach ($this->ves as $vs) {
				$vs->save();
			}

			foreach ($this->foundations as $fund) {
				$fund->save();
			}

			foreach ($this->rotations as $rot) {
				$rot->save();
			}

			$tx->commit();
			return true;

		} catch(Exception $e) {
			$tx->rollBack();
			return false;
		}
	}

	public function update($data)
	{
		// parent::load($data, $formName);
		/*$sections = $data['sections'];
		usort($sections, 'self::sortByPosition');
		$length = (float)(end($sections)['length']) / 1000;
		var_dump($length);*/
		$machineId = $data['machineId'];
		$this->machine = Machine::find()->where([
			'machineId' => $machineId
		])->one();

		$this->machine->length = (float)$data['length'] / 1000;
		$this->machine->ldratio = $data['ldRatio'];

		$this->_section = [];
		foreach ($data['sections'] as $section) {
			if(!empty($section['position'])) {
				$this->setSection($section, $machineId);
			}
		}

		$this->_discs = [];
		foreach ($data['discs'] as $disc) {
			if(!empty($disc['externalDiameter'])) {
				$this->setDiscs($disc, $machineId);
			}
		}

		$this->_ribs = [];
		foreach ($data['ribs'] as $rib) {
			if(!empty($rib['position'])) {
				$this->setRibs($rib, $machineId);
			}
		}

		foreach ($data['inertias'] as $disc) {
			if(!empty($disc['length'])) {
				$this->setInertias($disc, $machineId);
			}
		}

		$this->_rollerbearings = [];
		foreach ($data['rollerbearings'] as $roll) {
			if((!empty($roll['mass']) || !empty($roll['inertia']))) {
				$this->setRollerbearings($roll, $machineId);
			}
		}

		$this->_journalbearings = [];
		$this->_rotations = [];
		$journalpositions = [];
		$last = -1;
		foreach ($data['journalbearings'] as $roll) {
			if ($last != $roll['position']) {
				$last = $roll['position'];
				$journalpositions[] = $last;
			}
		}

		foreach ($journalpositions as $pos) {
			$filtered = [];
			$filtered = array_filter($data['journalbearings'], function ($value) use ($pos) {
				return $value['position'] == $pos;
			});

			$this->setJournalbearings($filtered, $machineId);
		}

		$this->_ves = [];
		foreach ($data['ves'] as $sve) {
			$v = new VesModel();
			$v->loadAll($sve, $machineId);
			$this->setVes($v);
		}

		$this->_foundations = [];
		foreach ($data['foundations'] as $fund) {
			if(!empty($fund['mass'])) {
				$this->setFoundations($fund, $machineId);
			}
		}

		// var_dump($this->section);
	}

	function sortByPosition($a, $b)
	{
		$a = $a['length'];
		$b = $b['length'];

		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
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

	public function getSection()
	{
		return $this->_section;
	}

	public function setSection($model, $machineId)
	{
		//$this->_ribs = $model;
		if($model instanceof Shaftsection) {
			$this->_section[] = $model;
		} else if (is_array($model)) {
			$this->_section[] = $this->createSection($model, $machineId);
		}
	}

	public function getDiscs()
	{
		return $this->_discs;
	}

	public function setDiscs($model, $machineId)
	{
		//$this->_disc = $model;
		if($model instanceof Disc) {
			$this->_discs[] = $model;
		} else if (is_array($model)) {
			$this->_discs[] = $this->createDisc($model, $machineId);
		}
	}

	public function setInertias($model, $machineId)
	{
		//$this->_disc = $model;
		if($model instanceof Disc) {
			$this->_discs[] = $model;
		} else if (is_array($model)) {
			$this->_discs[] = $this->createInertia($model, $machineId);
		}
	}

	public function getRibs()
	{
		return $this->_ribs;
	}

	public function setRibs($model, $machineId)
	{
		//$this->_ribs = $model;
		if($model instanceof Ribs) {
			$this->_ribs[] = $model;
		} else if (is_array($model)) {
			$this->_ribs[] = $this->createRib($model, $machineId);
		}
	}

	public function getRollerbearings()
	{
		return $this->_rollerbearings;
	}

	public function setRollerbearings($model, $machineId)
	{
		//$this->_ribs = $model;
		if($model instanceof Rollerbearing) {
			$this->_rollerbearings[] = $model;
		} else if (is_array($model)) {
			$this->_rollerbearings[] = $this->createRoller($model, $machineId);
		}
	}

	public function getJournalbearings()
	{
		return $this->_journalbearings;
	}

	public function setJournalbearings($all, $machineId)
	{
		$model = array_values($all)[0];
		if($model instanceof Journalbearing) {
			$this->_journalbearings[] = $model;
		} else if (is_array($model)) {
			$this->_journalbearings[] = $this->createJournal($model, $machineId, $all);
		}
	}

	public function getRotations()
	{
		return $this->_rotations;
	}

	public function setRotations($model, $journalBearingId)
	{
		if($model instanceof Rotation) {
			$this->_rotations[] = $model;
		} else if (is_array($model)) {
			$this->_rotations[] = $this->createRotation($model, $journalBearingId);
		}
	}

	public function addRotation($model)
	{
		$this->_rotations[] = $model;
	}

	public function getVes()
	{
		return $this->_ves;
	}

	public function setVes($model)
	{
		if($model instanceof VesModel) {
			$this->_ves[] = $model;
		} else if (is_array($model)) {
			// $this->_ves[] = $this->createFoundation($model, $machineId);
		}
	}

	public function getFoundations()
	{
		return $this->_foundations;
	}

	public function setFoundations($model, $machineId)
	{
		//$this->_ribs = $model;
		if($model instanceof Foundation) {
			$this->_foundations[] = $model;
		} else if (is_array($model)) {
			$this->_foundations[] = $this->createFoundation($model, $machineId);
		}
	}

	protected function createSection($model, $machineId)
	{
		$sess = new Shaftsection();
		$sess->machineId = $machineId;
		$sess->shaftSectionId = RestUtils::generateId();

		$sess->materialId = (int)$model['materialId'];
		$sess->position = (float)$model['position'] / 1000;
		$sess->externalDiameter = (float)$model['externalDiameter'] / 1000;
		$sess->internalDiameter = (float)$model['internalDiameter'] / 1000;
		$sess->young = $model['young'];
		$sess->poisson = $model['poisson'];
		$sess->density = $model['density'];
		$sess->axialForce = $model['axialForce'];
		$sess->magneticForce = $model['magneticForce'];

		return $sess;
	}

	protected function createDisc($model, $machineId)
	{
		$disc = new Disc();
		$disc->machineId = $machineId;
		$disc->discId = RestUtils::generateId();

		$disc->materialId = (int)$model['materialId'];
		$disc->position = (float)$model['position'] / 1000;
		$disc->externalDiameter = (float)$model['externalDiameter'] / 1000;
		$disc->internalDiameter = (float)$model['internalDiameter'] / 1000;
		$disc->thickness = (float)$model['thickness'] / 1000;
		$disc->density = $model['density'];

		$disc->ix = 0;
		$disc->iy = 0;
		$disc->iz = 0;
		$disc->length = 0;
		$disc->mass = 0;

		return $disc;
	}

	protected function createInertia($model, $machineId)
	{
		$disc = new Disc();
		$disc->machineId = $machineId;
		$disc->discId = RestUtils::generateId();

		$disc->materialId = 0;
		$disc->externalDiameter = 0;
		$disc->internalDiameter = 0;
		$disc->thickness = 0;
		$disc->density = 0;

		$disc->position = (float)$model['position'] / 1000;
		$disc->ix = $model['ix'];
		$disc->iy = $model['iy'];
		$disc->iz = $model['iz'];
		$disc->length = (float)$model['length'] / 1000;
		$disc->mass = $model['mass'];

		return $disc;
	}

	protected function createRib($model, $machineId)
	{
		$rib = new Ribs();
		$rib->machineId = $machineId;
		$rib->ribId = RestUtils::generateId();

		$rib->position = (float)$model['position'] / 1000;
		$rib->number = (int)$model['number'];
		$rib->webThickness = (float)$model['webThickness'] / 1000;
		$rib->webDepth = (float)$model['webDepth'] / 1000;
		$rib->flangeWidth = (float)$model['flangeWidth'] / 1000;
		$rib->flangeThick = (float)$model['flangeThick'] / 1000;

		return $rib;
	}

	protected function createRoller($model, $machineId)
	{
		$roll = new Rollerbearing();
		$roll->machineId = $machineId;
		$roll->rollerBearingId = RestUtils::generateId();

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

	protected function createJournal($model, $machineId, $all)
	{
		$roll = new Journalbearing();
		$roll->machineId = $machineId;
		$roll->journalBearingId = RestUtils::generateId();

		$roll->position = (float)$model['position'] / 1000;

		$this->createRotations($all, $roll->journalBearingId);

		return $roll;
	}

	protected function createRotations($models, $id)
	{
		foreach ($models as $model) {
			$this->addRotation($this->createRotation($model, $id));
		}
	}

	protected function createRotation($model, $id)
	{

		$rot = new Rotation();
		$rot->rotationId = RestUtils::generateId();
		$rot->journalBearingId = $id;
		$rot->speed = $model['speed'];
		$rot->kxx = $model['kxx'];
		$rot->kxz = $model['kxz'];
		$rot->kzx = $model['kzx'];
		$rot->kzz = $model['kzz'];
		$rot->cxx = $model['cxx'];
		$rot->cxz = $model['cxz'];
		$rot->czx = $model['czx'];
		$rot->czz = $model['czz'];

		return $rot;
	}

	protected function createFoundation($model, $machineId)
	{
		$roll = new Foundation();
		$roll->machineId = $machineId;
		$roll->foundationId = RestUtils::generateId();

		$roll->position = (float)$model['position'] / 1000;
		$roll->mass = $model['mass'];
		$roll->kxx = $model['kxx'];
		$roll->kzz = $model['kzz'];
		$roll->cxx = $model['cxx'];
		$roll->czz = $model['czz'];

		return $roll;
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
			$errorLists['MachineModel'] = $this->errors;

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
		$arr[] = ['Machine' => $this->machine];

		foreach ($this->section as $key => $value) {
			$arr[] = ['Section'.$key => $value];
		}

		foreach ($this->ribs as $key => $value) {
			$arr[] = ['Ribs'.$key => $value];
		}

		foreach ($this->discs as $key => $value) {
			$arr[] = ['Disc'.$key => $value];
		}

		foreach ($this->rollerbearings as $key => $value) {
			$arr[] = ['Rollerbearing'.$key => $value];
		}

		foreach ($this->journalbearings as $key => $value) {
			$arr[] = ['Journalbearing'.$key => $value];
		}

		foreach ($this->rotations as $key => $value) {
			$arr[] = ['Rotation'.$key => $value];
		}

		foreach ($this->ves as $key => $value) {
			$arr[] = ['VesModel'.$key => $value];
		}

		foreach ($this->foundations as $key => $value) {
			$arr[] = ['Foundation'.$key => $value];
		}

		return $arr;
	}
}