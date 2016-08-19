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

	public $defaultAction = 'list';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['list', 'edit', 'delete', 'get'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					'get' => ['get'],
				],
			],
		];
	}

	public function actionGet() {
		$items = SiteCategory::find()
			->select(['id', 'name'])
			->where([
				'site_id' => $this->module->siteId,
				'type' => [
					SiteCategory::TYPE_NEWS,
					SiteCategory::TYPE_PICTURES,
					SiteCategory::TYPE_PAGE,
				],
				'status' => SiteCategory::STATUS_ENABLED,
			])
			->orderby('list_order desc, created_at desc')
			->asArray()
			->all();
		$done = !empty($items);

		return $this->respond([
			'error' => !$done,
			'message' => $done ? null : \Yii::t($this->module->messageCategory, 'No matched data') . ', ' . \Yii::t($this->module->messageCategory, 'Please {action} {attribute} first', [
				'action' => \Yii::t($this->module->messageCategory, 'Add'),
				'attribute' => \Yii::t($this->module->messageCategory, 'Category'),
			]),
			'data' => $items,
		]);
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

		if(\Yii::$app->request->isPost && $item->load(\Yii::$app->request->post())) {
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

	public function actionList($type = 'all', $stype = null, $sword = null) {
		$query = SiteCategory::find()
			->where(['site_id' => $this->module->siteId])
			->orderby('list_order desc, created_at');

		if($type !== 'all') {
			$query->andWhere(['type' => $type]);
		}
		if($sword !== null) {
			$query->andWhere(['like', "a.$stype", $sword]);
		}

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		$typeItems = ArrayHelper::merge([
			'all' => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Type'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], SiteCategory::defaultAttributeItems('type'));

		return $this->render($this->action->id, [
			'type' => $type,
			'stype' => $stype,
			'sword' => $sword,
			'items' => $items,
			'pagination' => $pagination,
			'typeItems' => $typeItems,
		]);
	}

}
