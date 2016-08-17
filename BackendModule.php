<?php
/*!
 * yii2 - module - backend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/17
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\components\Module;

use yii\cms\models\Site;

class BackendModule extends Module {

	public $site;

	public $siteId;

	public $frontendHost;

	public $frontendModuleId;

	public $controllerNamespace = 'yii\cms\controllers\backend';

	public $defaultRoute = 'dashboard';

	public $layout = 'backend';

	public $viewsPath = '@vendor/xiewulong/yii2-cms/views/backend';

	public $permissions = ['@'];

	public $addSidebarItems = [];

	public $addMenuItems = [];

	public $messageCategory = 'cms';

	public function init() {
		parent::init();

		$this->setSite();
	}

	public function getFrontendUrl($url = null) {
		$frontendModuleId = $this->siteId ? : $this->id;

		return ($this->frontendHost ? : null) . \Yii::$app->urlManager->createUrl([$this->frontendModuleId ? : $frontendModuleId]) . ($url ? \Yii::$app->urlManager->createUrl($url) : null);
	}

	public function url($url) {
		return '/' . $this->id . '/' . $url;
	}

	private function setSite() {
		if(!$this->siteId) {
			$this->siteId = $this->id;
		}

		$this->site = Site::findOne($this->siteId);
		if(!$this->site) {
			$this->site = new Site;
			$this->site->scenario = 'add';
			if(!$this->site->load([$this->site->formName() => ['id' => $this->siteId]]) || !$this->site->commonHandler()) {
				\Yii::$app->end($this->site->getFirstError('id'));
			}
		}
	}

}
