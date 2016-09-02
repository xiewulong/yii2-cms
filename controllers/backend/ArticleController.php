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
use yii\cms\models\SiteArticle;

class ArticleController extends Controller {

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
			->alias('a')
			->select(['a.id', 'a.name'])
			->joinWith([
				'items b' => function($query) {
					return $query->select([
						'b.id',
						'b.category_id',
						'b.title name',
					])->orderby('b.status desc, b.created_at desc');
				}
			])
			->where([
				'a.site_id' => $this->module->siteId,
				'a.type' => [
					SiteCategory::TYPE_NEWS,
					SiteCategory::TYPE_PICTURES,
					SiteCategory::TYPE_PAGE,
				],
				'a.status' => SiteCategory::STATUS_ENABLED,
				'b.status' => [SiteArticle::STATUS_RELEASED, SiteArticle::STATUS_FEATURED],
			])
			->orderby('a.created_at desc')
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
		$item = SiteArticle::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->siteId,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionEdit($id = 0, $cid = 0) {
		$categorys = SiteCategory::find()
			->select(['id', 'name', 'type'])
			->where([
				'site_id' => $this->module->siteId,
				'status' => SiteCategory::STATUS_ENABLED,
			])
			->orderby('created_at desc')
			->all();
		if(!$categorys) {
			\Yii::$app->session->setFlash('error', '1|' . \Yii::t($this->module->messageCategory, 'Please {action} {attribute} first', [
				'action' => \Yii::t($this->module->messageCategory, 'Add'),
				'attribute' => \Yii::t($this->module->messageCategory, 'Category'),
			]));
			return $this->redirect(['category/edit']);
		}

		if(!$id) {
			$item = new SiteArticle;
			$item->scenario = 'add';
			$item->site_id = $this->module->siteId;
			if($cid) {
				$item->category_id = $cid;
			}
		} else {
			$item = SiteArticle::findOne([
				'id' => $id,
				'site_id' => $this->module->siteId,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if(\Yii::$app->request->isPost) {
			$item->thumbnail_id = null;
			$item->picture_ids = [];
			$item->attachment_id = null;
			if($item->load(\Yii::$app->request->post()) && $item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['article/list']);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		$categoryNames = ArrayHelper::map($categorys, 'id', 'name');
		$categoryTypes = ArrayHelper::map($categorys, 'id', 'type');
		$categoryTypeItems = SiteCategory::defaultAttributeItems('type');

		return $this->render($this->action->id, [
			'item' => $item,
			'categoryNames' => $categoryNames,
			'categoryTypes' => Json::encode($categoryTypes),
			'categoryTypeItems' => Json::encode($categoryTypeItems),
		]);
	}

	public function actionList($cid = 0, $type = 'all', $status = 'all', $stype = null, $sword = null) {
		$query = SiteArticle::find()
			->alias('a')
			->where(['a.site_id' => $this->module->siteId])
			->orderby('a.status desc, a.created_at desc');

		if($cid) {
			$query->andWhere(['a.category_id' => $cid]);
		}
		if($type != 'all') {
			$query->joinWith('category b')->andWhere(['b.type' => $type]);
		}
		if($status != 'all') {
			$query->andWhere(['a.status' => $status]);
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

		$categoryItems = ArrayHelper::merge([
			0 => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Category'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], ArrayHelper::map(SiteCategory::find()
			->select(['id', 'name'])
			->where(['site_id' => $this->module->siteId])
			->orderby('created_at desc')
			->all(), 'id', 'name'));
		$categoryTypeItems = ArrayHelper::merge([
			'all' => \Yii::t($this->module->messageCategory, '{attribute} {action}', [
				'attribute' => \Yii::t($this->module->messageCategory, 'Type'),
				'action' => \Yii::t($this->module->messageCategory, 'filtering'),
			]),
		], SiteCategory::defaultAttributeItems('type'));
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
			'categoryTypeItems' => $categoryTypeItems,
			'statusItems' => $statusItems,
		]);
	}

}
