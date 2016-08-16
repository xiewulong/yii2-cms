<?php
namespace yii\cms\components;

use Yii;
use yii\helpers\Url;

class Controller extends \yii\components\Controller {

	public function visited() {
		$this->module->site->scenario = 'visited';
		$this->module->site->visitedHandler();

		return $this;
	}

}
