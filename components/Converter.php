<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

use app\components\Convertor;

class Converter extends Component
{
	private $_convertor;
	private $_system;
	private $size = "m";
	public $ratio;

	public $arr = [
		"si" => [
			"m" => 'm',
			"mm" => 'mm',
			"pa" => 'pa',
			"N" => 'N',
			"kg_m3" => "kg_m3",
		],
		"imperial" => [
			"m" => 'ft',
			"mm" => 'in',
			"pa" => 'psi',
			"N" => 'lb',
			"kg_m3" => "slug_ft3",
		]
	];

	public function init() {
		parent::init();
		$this->make(1, "m");
	}

	public function setSystem() {
		$this->_system = "si";
	}

	public function getSystem() {
		return $this->_system;
	}

	public function getConvertor()
    {
        return $this->_convertor;
    }

	public function make($value, $unit) {
		$this->_convertor = new Convertor($value, $unit);
	}

	public function convert2($value, $gr)
	{

		// $this->_convertor->from($value, $arr[$_system][$gr])
	}

	public function _from($value, $unit) {
		return $this->_convertor->from($value, $unit);
	}

	public function _to($unit, $decimals = null, $round = true) {
		return $this->_convertor->from($unit, $decimals, $round);
	}

	public function convert($value)
	{
		return $value * $this->ratio;
	}

	public function refresh()
	{
		// $this->ratio = Yii::$app->params['ratio'];
		$this->ratio = Yii::$app->session->get('ratio');
	}
}