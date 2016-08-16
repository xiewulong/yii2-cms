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

use yii\cms\models\SiteBannerItem;

class BannerController extends Controller {

	public $defaultAction = 'jump';

	public function actionJump($id) {
		$item = SiteBannerItem::findOne([
			'id' => $id,
			'site_id' => $this->module->siteId,
		]);
		if(!$item || !$item->url) {
			return $this->goBack();
		}

		$item->scenario = 'visited';
		$item->visitedHandler();

		return $this->redirect($item->url);
	}

}
