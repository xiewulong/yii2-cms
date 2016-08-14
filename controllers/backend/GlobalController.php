<?php
namespace yii\cms\controllers\backend;

use Yii;
use yii\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

use yii\cms\models\Site;

class GlobalController extends Controller {

	public $defaultAction = 'edit';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['edit'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
		];
	}

	public function actionEdit() {
		$site = Site::findOne($this->module->id);
		$site->scenario = 'edit';
		if($site->load(\Yii::$app->request->post())) {
			if($site->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->refresh();
			}
			\Yii::$app->session->setFlash('item', '1|' . $site->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $site,
		]);
	}

}
