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

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class ModuleController extends Controller {

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['delete', 'item-delete'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					'item-delete' => ['post'],
				],
			],
		];
	}

	public function actionItemDelete() {
		$item = SiteModuleItem::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->siteId,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'please try again')),
		]) : $this->goBack();
	}

	public function actionDelete() {
		$item = SiteModule::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->siteId,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'please try again')),
		]) : $this->goBack();
	}

}
