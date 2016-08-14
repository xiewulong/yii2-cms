<?php
/*!
 * yii2 - module - backend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/14
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\base\ErrorException;
use yii\components\Module;
use yii\cms\models\Site;

class BackendModule extends Module {

	public $controllerNamespace = 'yii\cms\controllers\backend';

	public $defaultRoute = 'dashboard';

	public $layout = 'backend';

	public $viewsPath = '@vendor/xiewulong/yii2-cms/views/backend';

	public $permissions = ['@'];

	public $messageCategory = 'cms';

	private $_site;

	public function init() {
		parent::init();

		$this->getSite();
	}

	public function getSite() {
		if(!$this->_site) {
			$this->_site = Site::findOne($this->id);
			if(!$this->_site) {
				$this->_site = new Site;
				$this->_site->scenario = 'add';
				if(!$this->_site->load([$this->_site->formName() => ['id' => $this->id]]) || !$this->_site->commonHandler()) {
					throw new ErrorException($this->_site->getFirstError('id'));
				}
			}
		}

		return $this->_site;
	}

}
