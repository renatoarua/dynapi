<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Converter extends Component
{
	public $ratio;

	public function init() {
		parent::init();
		// $this->refresh();
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