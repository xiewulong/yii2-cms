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

use yii\cms\models\SiteModule;
use yii\cms\models\SiteModuleItem;

class LinkController extends Controller {

	public $defaultAction = 'jump';

	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'jump' => ['get'],
				],
			],
		];
	}

	public function actionJump($id) {
		$item = SiteModuleItem::findOne([
			'id' => $id,
			'site_id' => $this->module->siteId,
			'status' => SiteModuleItem::STATUS_ENABLED,
		]);
		if(!$item || $item->superior->status != SiteModule::STATUS_ENABLED) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		return $this->redirect($item->accessed()->link);
	}

}
