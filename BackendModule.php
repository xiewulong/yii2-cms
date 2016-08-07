<?php
/*!
 * yii2 extension - backend - module
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/7
 * version: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\base\ErrorException;
use yii\base\Module;

class BackendModule extends Module {

	public $layout = 'layouts/backend';

	public function init() {
		parent::init();
	}

}
