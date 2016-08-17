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

class BannerController extends Controller {

	public $defaultAction = 'list';

	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['list', 'edit', 'items', 'item-edit'],
						'allow' => true,
						'roles' => $this->module->permissions,
					],
				],
			],
		];
	}

	public function actionItemEdit($mid, $id = 0) {
		$module = SiteModule::findOne([
			'id' => $mid,
			'site_id' => $this->module->siteId,
			'type' => SiteModule::TYPE_BANNER,
		]);
		if(!$module) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		if(!$id) {
			$item = new SiteModuleItem;
			$item->scenario = 'add';
			$item->site_id = $this->module->siteId;
			$item->module_id = $mid;
			$item->type = SiteModuleItem::TYPE_LINK;
		} else {
			$item = SiteModuleItem::findOne([
				'id' => $id,
				'site_id' => $this->module->siteId,
				'module_id' => $mid,
			]);
			if(!$item) {
				throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
			}
			$item->scenario = 'edit';
			if($item->type == SiteModuleItem::TYPE_CATEGORY) {
				$item->category_id = $item->target_id;
			} else if($item->type == SiteModuleItem::TYPE_ARTICLE) {
				$item->article_id = $item->target_id;
			}
		}

		if($item->load(\Yii::$app->request->post())) {
			if($item->commonHandler()) {
				\Yii::$app->session->setFlash('item', '0|' . \Yii::t($this->module->messageCategory, 'Operation succeeded'));

				return $this->redirect(['banner/items', 'mid' => $mid]);
			}
			\Yii::$app->session->setFlash('item', '1|' . $item->firstErrorInfirstErrors);
		}

		return $this->render($this->action->id, [
			'banner' => $module,
			'item' => $item,
		]);
	}

	public function actionItems($mid, $type = 'all', $stype = null, $sword = null) {
		$module = SiteModule::findOne([
			'id' => $mid,
			'site_id' => $this->module->siteId,
			'type' => SiteModule::TYPE_BANNER,
		]);
		if(!$module) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		if($type !== 'all') {
			$query->andWhere(['type' => $type]);
		}
		$query = SiteModuleItem::find()
			->where(['site_id' => $this->module->siteId, 'module_id' => $mid])
			->orderby('list_order desc, created_at desc');

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
		], SiteModuleItem::defaultAttributeItems('type'));

		return $this->render($this->action->id, [
			'type' => $type,
			'stype' => $stype,
			'sword' => $sword,
			'banner' => $module,
			'items' => $items,
			'pagination' => $pagination,
			'typeItems' => $typeItems,
		]);
	}

	public function actionEdit($id = 0) {
		if(!$id) {
			$item = new SiteModule;
			$item->scenario = 'add';
			$item->site_id = $this->module->siteId;
			$item->type = SiteModule::TYPE_BANNER;
		} else {
			$item = SiteModule::findOne([
				'id' => $id,
				'site_id' => $this->module->siteId,
				'type' => SiteModule::TYPE_BANNER,
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
		$query = SiteModule::find()
			->where([
				'site_id' => $this->module->siteId,
				'type' => SiteModule::TYPE_BANNER,
			])
			->orderby('created_at desc');

		if($sword !== null) {
			$query->andWhere(['like', "a.$stype", $sword]);
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