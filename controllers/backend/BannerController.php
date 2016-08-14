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

use yii\cms\models\SiteBanner;
use yii\cms\models\SiteBannerItem;

class BannerController extends Controller {

	public $defaultAction = 'List';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['list', 'edit', 'delete', 'items', 'item-edit', 'item-delete', 'jump'],
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

	public function actionJump($id) {
		$item = SiteBannerItem::findOne([
			'id' => $id,
			'site_id' => $this->module->id,
		]);
		if(!$item || !$item->url) {
			return $this->goBack();
		}

		// $item->scenario = 'visited';
		// $item->visitedHandler();

		return $this->redirect($item->url);
	}

	public function actionItemDelete() {
		$item = SiteBannerItem::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->id,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionItemEdit($bid, $id = 0) {
		$banner = SiteBanner::findOne([
			'id' => $bid,
			'site_id' => $this->module->id,
		]);
		if(!$banner) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		if(!$id) {
			$item = new SiteBannerItem;
			$item->scenario = 'add';
			$item->site_id = $this->module->id;
			$item->banner_id = $bid;
		} else {
			$item = SiteBannerItem::findOne([
				'id' => $id,
				'site_id' => $this->module->id,
				'banner_id' => $bid,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if($item->load(\Yii::$app->request->post())) {
			if($item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['banner/items', 'bid' => $bid]);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'banner' => $banner,
			'item' => $item,
		]);
	}

	public function actionItems($bid, $stype = null, $sword = null) {
		$banner = SiteBanner::findOne([
			'id' => $bid,
			'site_id' => $this->module->id,
		]);
		if(!$banner) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		$query = SiteBannerItem::find()
					->where(['site_id' => $this->module->id, 'banner_id' => $bid])
					->orderby('list_order desc, created_at desc');

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
			'banner' => $banner,
			'items' => $items,
			'pagination' => $pagination,
		]);
	}

	public function actionDelete() {
		$item = SiteBanner::findOne([
			'id' => \Yii::$app->request->post('id', 0),
			'site_id' => $this->module->id,
		]);
		$done = $item && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionEdit($id = 0) {
		if(!$id) {
			$item = new SiteBanner;
			$item->scenario = 'add';
			$item->site_id = $this->module->id;
		} else {
			$item = SiteBanner::findOne([
				'id' => $id,
				'site_id' => $this->module->id,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if($item->load(\Yii::$app->request->post())) {
			if($item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['banner/list']);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $item,
		]);
	}

	public function actionList($stype = null, $sword = null) {
		$query = SiteBanner::find()
					->where(['site_id' => $this->module->id])
					->orderby('created_at desc');

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
