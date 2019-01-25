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
			"pa" => 'pa',
			"N" => 'N',
			"Nm" => 'Nm',
			"kg_m3" => "kg_m3",
			"kg" => "kg",
			"kgm2" => "kgm2",
			"kgm" => "kgm",
			"pas" => "pas",
		],
		"metric" => [
			"m" => 'mm',
			"pa" => 'pa',
			"N" => 'N',
			"Nm" => 'Nm',
			"kg_m3" => "kg_m3",
			"kg" => "kg",
			"kgm2" => "kgm2",
			"kgm" => "gmm",
			"pas" => "pas",
		],
		"imperial" => [
			"m" => 'in',
			"pa" => 'psi',
			"N" => 'lbf',
			"Nm" => 'lbfin',
			"kg_m3" => "lb_ft3",
			"kg" => "lb",
			"kgm2" => "lbft2",
			"kgm" => "ozin",
			"pas" => "pas",
		]
	];

	public function init() {
		parent::init();
		$this->make(1, "m");
	}

	public function setSystem($unit) {
		$this->_system = $unit;
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

	public function from($value, $unit, $sci=true, $decimals = null, $round = true) {
		if($unit == '1') {
			$ret = (float)$value;
		} else {
			$this->_convertor->from((float)$value, $this->arr[$this->_system][$unit]);
			$tounit = $unit;
			$ret = $this->_convertor->to($tounit, $decimals, $round);
		}
		return $sci ? sprintf('%e', $ret) : $ret;
	}

	public function to($value, $unit, $sci=true, $decimals = null, $round = true) {
		if($unit == '1') {
			$ret = (float)$value;
		} else {
			$this->_convertor->from((float)$value, $unit);
			$tounit = $this->arr[$this->_system][$unit];
			$ret = $this->_convertor->to($tounit, $decimals, $round);
		}
		return $sci ? sprintf('%e', $ret) : $ret;
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