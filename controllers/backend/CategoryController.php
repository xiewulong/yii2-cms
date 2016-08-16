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

use yii\cms\models\SiteCategory;

class CategoryController extends Controller {

	public $defaultAction = 'List';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['list', 'edit', 'delete'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function actionDelete() {
		$item = SiteCategory::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->siteId,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionEdit($id = 0) {
		if(!$id) {
			$item = new SiteCategory;
			$item->scenario = 'add';
			$item->site_id = $this->module->siteId;
		} else {
			$item = SiteCategory::findOne([
				'id' => $id,
				'site_id' => $this->module->siteId,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if($item->load(\Yii::$app->request->post())) {
			if($item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['category/list']);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $item,
		]);
	}

	public function actionList($stype = null, $sword = null) {
		$query = SiteCategory::find()
			->where(['site_id' => $this->module->siteId])
			->orderby('list_order desc, created_at');

		if($sword !== null) {
			$query->andWhere("$stype like :sword", [':sword' => "%$sword%"]);
		}

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render($this->action->id, [
			'stype' => $stype,
			'sword' => $sword,
			'items' => $items,
			'pagination' => $pagination,
		]);
	}

}
