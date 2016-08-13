<?php
namespace yii\cms\controllers\backend;

use Yii;
use yii\base\ActionEvent;
use yii\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

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
		$this->module->site->scenario = 'edit';
		if($this->module->site->load(\Yii::$app->request->post())) {
			if($this->module->site->save()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->refresh();
			}
			\Yii::$app->session->setFlash('item', '1|' . $this->module->site->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $this->module->site,
		]);
	}

}
