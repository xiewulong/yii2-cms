<?php
/*!
 * yii2 - module - backend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/9/2
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\components\Module;

use yii\cms\models\Site;

class BackendModule extends Module {

	public $siteId;

	public $attachmentPath;

	public $attachmentUrl;

	public $frontendHost;

	public $frontendModuleId;

	public $controllerNamespace = 'yii\cms\controllers\backend';

	public $defaultRoute = 'dashboard';

	public $layout = 'backend';

	public $customViewsPath = '@vendor/xiewulong/yii2-cms/views/backend';

	public $permissions = ['@'];

	public $addMenuItems = [];

	public $addSidebarItems = [];

	public $messageCategory = 'cms';

	private $_site;

	public function init() {
		parent::init();

		$this->setSite();
		$this->setAttachmentModule('attachment');
	}

	public function attachmentRoute($id) {
		return [$this->url('attachment'), 'id' => $id];
	}

	public function getFrontendUrl($url = null) {
		$frontendModuleId = $this->siteId ? : $this->id;

		return rtrim($this->frontendHost ? : null, '/') . \Yii::$app->urlManager->createUrl([$this->frontendModuleId ? : $frontendModuleId]) . ($url ? \Yii::$app->urlManager->createUrl($url) : null);
	}

	public function url($url) {
		return '/' . $this->uniqueId . '/' . $url;
	}

	private function setAttachmentModule($id, $options = []) {
		$module = [
			'class' => 'yii\attachment\Module',
			'write' => $this->permissions,
		];
		$modules = $this->modules;
		$modules[$id] = array_merge($module, isset($modules[$id]) ? $modules[$id] : [], $options);
		$this->modules = $modules;
	}

	public function getSite() {
		return $this->_site;
	}

	private function setSite() {
		if(!$this->siteId) {
			$this->siteId = $this->id;
		}

		$this->_site = Site::findOne($this->siteId);
		if(!$this->_site) {
			$this->_site = new Site;
			$this->_site->scenario = 'add';
			$this->_site->id = $this->siteId;
			$this->_site->powered = 'Nanning Automan Technology Co., Ltd.';
			if(!$this->_site->commonHandler()) {
				\Yii::$app->end($this->_site->getFirstError('id'));
			}
		}
	}

}
