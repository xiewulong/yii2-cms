<?php
/*!
 * yii2 - module - frontend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/30
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\components\Module;

use yii\cms\models\Site;

class FrontendModule extends Module {

	public $site;

	public $siteId;

	public $backendHost;

	public $backendModuleId;

	public $controllerNamespace = 'yii\cms\controllers\frontend';

	public $defaultRoute = 'home';

	public $layout = 'frontend';

	public $viewsPath = '@vendor/xiewulong/yii2-cms/views/frontend';

	public $backendEntrance = false;

	public $statisticsEnable = false;

	public $messageCategory = 'cms';

	public function init() {
		parent::init();

		$this->setSite();
		$this->setAttachmentModule('attachment', [
			'unsupportTypes' => ['Image'],
		]);
		$this->setAttachmentModule('image', [
			'lockTypes' => ['Image'],
		]);
	}

	public function imageRoute($id) {
		return [$this->url('image'), 'id' => $id];
	}

	public function attachmentRoute($id) {
		return [$this->url('attachment'), 'id' => $id];
	}

	public function getBackendUrl($url = null) {
		$backendModuleId = $this->siteId ? : $this->id;

		return rtrim($this->backendHost ? : null, '/') . \Yii::$app->urlManager->createUrl([$this->backendModuleId ? : $backendModuleId]) . ($url ? \Yii::$app->urlManager->createUrl($url) : null);
	}

	public function url($url) {
		return '/' . $this->uniqueId . '/' . $url;
	}

	private function setAttachmentModule($id, $options = []) {
		$module = [
			'class' => 'yii\attachment\Module',
			'statisticsEnable' => $this->statisticsEnable,
		];
		$modules = $this->modules;
		$modules[$id] = array_merge($module, isset($modules[$id]) ? $modules[$id] : [], $options);
		$this->modules = $modules;
	}

	private function setSite() {
		if(!$this->siteId) {
			$this->siteId = $this->id;
		}

		$this->site = Site::findOne([
			'id' => $this->siteId,
			'status' => Site::STATUS_ENABLED,
		]);
		if(!$this->site || !$this->site->name || !$this->site->logo_id) {
			\Yii::$app->end(\Yii::t('yii', 'Page not found.'));
		}
	}

}
