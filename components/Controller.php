<?php
namespace yii\cms\components;

use Yii;

class Controller extends \yii\components\Controller {

	public function accessed() {
		$this->module->site->accessed();

		return $this;
	}

}
