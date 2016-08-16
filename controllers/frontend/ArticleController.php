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

	public $defaultAction = 'List';

	public function actionDetails($id) {
		return $this->render($this->action->id);
	}

	public function actionList($cid) {
		$category = SiteCategory::findOne([
			'id' => $cid,
			'site_id' => $this->module->siteId,
			'status' => SiteCategory::STATUS_ENABLED,
		]);
		if(!$category) {
			throw new NotFoundHttpException(\Yii::t('yii', 'Page not found.'));
		}

		$query = $category->getArticles()
			->where('status in (' . SiteArticle::STATUS_RELEASED . ', ' . SiteArticle::STATUS_FEATURED . ')')
			->orderby('status desc, list_order desc, created_at desc');

		$pagination = new Pagination([
			'totalCount' => $query->count(),
		]);

		$items = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render($this->action->id, [
			'category' => $category,
			'items' => $items,
			'pagination' => $pagination,
		]);
	}

}
