<?php
namespace yii\cms\controllers\backend;

use Yii;
use yii\base\ActionEvent;
use yii\components\Controller;
use yii\cms\models\SiteCategory;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

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
		$item = SiteCategory::findOne(\Yii::$app->request->post('id', 0));
		$done = $item && $item->site_id == $this->module->id && $item->delete();

		return \Yii::$app->request->isAjax ? $this->respond([
			'error' => !$done,
			'message' => \Yii::t($this->module->messageCategory, 'Operation ' . ($done ? 'succeeded' : 'failed')) . ($done ? '' : ', ' . \Yii::t($this->module->messageCategory, 'Please try again')),
		]) : $this->goBack();
	}

	public function actionEdit($id = 0) {
		if(!$id) {
			$item = new SiteCategory;
			$item->scenario = 'add';
			$item->site_id = $this->module->id;
		} else {
			$item = SiteCategory::findOne([
				'id' => $id,
				'site_id' => $this->module->id,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
		}

		if($item->load(\Yii::$app->request->post())) {
			if($item->save()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['category/list']);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'item' => $item,
		]);
	}

	public function actionList() {
		$query = SiteCategory::find()->where(['site_id' => $this->module->id])->orderby('list_order desc, created_at');

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render($this->action->id, [
			'items' => $items,
			'pagination' => $pagination,
		]);
	}

}
