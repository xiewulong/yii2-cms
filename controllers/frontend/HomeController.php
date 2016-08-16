<?php
namespace yii\cms\controllers\frontend;

use Yii;
use yii\cms\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

use yii\cms\models\Site;

class HomeController extends Controller {

	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	public function actionIndex() {
		return $this->visited()->render($this->action->id);
	}

	public function actionAbout() {
		if($this->module->site->type != Site::TYPE_ENTERPRISE || $this->module->site->about_status != Site::ABOUT_STATUS_ENABLED) {
			throw new NotFoundHttpException(\Yii::t('yii', 'Page not found.'));
		}

		return $this->visited()->render($this->action->id);
	}

	public function actionContact() {
		if($this->module->site->type != Site::TYPE_ENTERPRISE || $this->module->site->about_status != Site::CONTACT_STATUS_ENABLED) {
			throw new NotFoundHttpException(\Yii::t('yii', 'Page not found.'));
		}
		return $this->visited()->render($this->action->id);
	}

}
