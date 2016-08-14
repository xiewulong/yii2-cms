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

use yii\cms\models\SiteArticle;
use yii\cms\models\SiteCategory;

class ArticleController extends Controller {

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
		$item = SiteArticle::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->id,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionEdit($id = 0, $cid = 0) {
		$categoryItems = ArrayHelper::map(SiteCategory::find()
							->select(['id', 'name'])
							->where(['site_id' => $this->module->id])
							->orderby('list_order desc, created_at desc')
							->all(), 'id', 'name');
		if(!$categoryItems) {
			\Yii::$app->session->setFlash('error', '1|' . \Yii::t($this->module->messageCategory, 'Please {action} {attribute} first', [
				'action' => \Yii::t($this->module->messageCategory, 'Add'),
				'attribute' => \Yii::t($this->module->messageCategory, 'Category'),
			]));
			return $this->redirect(['category/edit']);
		}

		if(!$id) {
			$item = new SiteArticle;
			$item->scenario = 'add';
			$item->site_id = $this->module->id;
			if($cid) {
				$item->category_id = $cid;
			}
		} else {
			$item = SiteArticle::findOne([
				'id' => $id,
				'site_id' => $this->module->id,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if(\Yii::$app->request->isPost) {
			$item->pictures = [];
			if($item->load(\Yii::$app->request->post()) && $item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['article/list']);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $item,
			'categoryItems' => $categoryItems,
		]);
	}

	public function actionList($cid = 0, $type = 0, $status = 'all', $stype = null, $sword = null) {
		$query = SiteArticle::find()
					->where(['site_id' => $this->module->id])
					->orderby('list_order desc, created_at desc');

		if($cid) {
			$query->andWhere(['category_id' => $cid]);
		}
		if($type) {
			$query->andWhere(['type' => $type]);
		}
		if($status != 'all') {
			$query->andWhere(['status' => $status]);
		}
		if($sword !== null) {
			$query->andWhere("$stype like :sword", [':sword' => "%$sword%"]);
		}

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		$categoryItems = ArrayHelper::merge([
			0 => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Category'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], ArrayHelper::map(SiteCategory::find()
			->select(['id', 'name'])
			->where(['site_id' => $this->module->id])
			->orderby('list_order desc, created_at desc')
			->all(), 'id', 'name'));
		$typeItems = ArrayHelper::merge([
			0 => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Type'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], SiteArticle::defaultAttributeItems('type'));
		$statusItems = ArrayHelper::merge([
			'all' => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Status'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], SiteArticle::defaultAttributeItems('status'));

		return $this->render($this->action->id, [
			'cid' => $cid,
			'type' => $type,
			'status' => $status,
			'stype' => $stype,
			'sword' => $sword,
			'items' => $items,
			'pagination' => $pagination,
			'categoryItems' => $categoryItems,
			'typeItems' => $typeItems,
			'statusItems' => $statusItems,
		]);
	}

}
