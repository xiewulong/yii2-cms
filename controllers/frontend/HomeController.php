<?php
namespace yii\cms\controllers\frontend;

use Yii;
use yii\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class HomeController extends Controller {

	public function actionIndex() {
		return $this->render($this->action->id);
	}

}
