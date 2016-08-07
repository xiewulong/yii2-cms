<?php
namespace yii\cms\controllers\frontend;

use Yii;
use yii\components\Controller;

class HomeController extends Controller {

	public function actionIndex() {
		return $this->render($this->action->id);
	}

}
