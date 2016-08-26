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

use yii\cms\models\SiteCategory;
use yii\cms\models\SiteArticle;

class ArticleController extends Controller {

	public $defaultAction = 'list';

	public function actionDetails($id) {
		$item = SiteArticle::findOne([
			'id' => $id,
			'site_id' => $this->module->siteId,
			'status' => [SiteArticle::STATUS_RELEASED, SiteArticle::STATUS_FEATURED],
		]);
		if(!$item || $item->superior->status != SiteCategory::STATUS_ENABLED) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		return $this->accessed()->render($this->action->id, [
			'item' => $item->accessed(),
		]);
	}

	public function actionList($id) {
		$superior = SiteCategory::findOne([
			'id' => $id,
			'site_id' => $this->module->siteId,
			'status' => SiteCategory::STATUS_ENABLED,
		]);
		if(!$superior) {
			throw new NotFoundHttpException(\Yii::t($this->module->messageCategory, 'No matched data'));
		}

		$query = $superior->getItems()
			->where([
				'site_id' => $this->module->siteId,
				'status' => [SiteArticle::STATUS_RELEASED, SiteArticle::STATUS_FEATURED],
			])
			->orderby('status desc, list_order desc, created_at desc');

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->accessed()->render($this->action->id, [
			'superior' => $superior,
			'items' => $items,
			'pagination' => $pagination,
		]);
	}

}
