<?php
namespace yii\cms\controllers\backend;

use Yii;
use yii\cms\components\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

use yii\cms\models\Site;

class GlobalController extends Controller {

	public $defaultAction = 'site';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['site'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
		];
	}

	public function actionSite() {
		$item = Site::findOne($this->module->siteId);
		$item->scenario = 'global';
		if(\Yii::$app->request->isPost) {
			$item->logo_id = null;
			$item->sub_logo_id = null;
			$item->weixin_id = null;
			if($item->load(\Yii::$app->request->post())) {
				if($item->commonHandler()) {
					\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

					return $this->refresh();
				}
				\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
			}
		}

		return $this->render($this->action->id, [
			'item' => $item,
		]);
	}

}
