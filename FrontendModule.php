<?php
/*!
 * yii2 - module - frontend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/18
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\components\Module;
use yii\helpers\Url;

use yii\cms\models\Site;

class FrontendModule extends Module {

	public $site;

	public $siteId;

	public $controllerNamespace = 'yii\cms\controllers\frontend';

	public $defaultRoute = 'home';

	public $layout = 'frontend';

	public $viewsPath = '@vendor/xiewulong/yii2-cms/views/frontend';

	public $backendEntrance = false;

	public $backendModuleId;

	public $backendHost;

	public $messageCategory = 'cms';

	public function init() {
		parent::init();

		$this->setSite();
	}

	public function isCurrent($route, $params = []) {
		$tag = ltrim($this->url($route), '/') == \Yii::$app->controller->route;
		if(empty($params)) {
			return $tag;
		}

		foreach($params as $name => $value) {
			if($value != \Yii::$app->request->get($name)) {
				$tag = false;
				break;
			}
		}

		return $tag;
	}

	public function getBackendUrl($url = null) {
		$backendModuleId = $this->siteId ? : $this->id;

		return rtrim($this->backendHost ? : null, '/') . \Yii::$app->urlManager->createUrl([$this->backendModuleId ? : $backendModuleId]) . ($url ? \Yii::$app->urlManager->createUrl($url) : null);
	}

	public function url($url) {
		return '/' . $this->uniqueId . '/' . $url;
	}

	private function setSite() {
		if(!$this->siteId) {
			$this->siteId = $this->id;
		}

		$this->site = Site::findOne([
			'id' => $this->siteId,
			'status' => Site::STATUS_ENABLED,
		]);
		if(!$this->site || !$this->site->name || !$this->site->logo) {
			\Yii::$app->end(\Yii::t('yii', 'Page not found.'));
		}
	}

}
