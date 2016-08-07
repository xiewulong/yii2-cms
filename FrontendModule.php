<?php
/*!
 * yii2 - module - frontend
 * xiewulong <xiewulong@vip.qq.com>
 * https://github.com/xiewulong/yii2-cms
 * https://raw.githubusercontent.com/xiewulong/yii2-cms/master/LICENSE
 * create: 2016/8/7
 * update: 2016/8/7
 * since: 0.0.1
 */

namespace yii\cms;

use Yii;
use yii\base\ErrorException;
use yii\components\Module;

class FrontendModule extends Module {

	public $controllerNamespace = 'yii\cms\controllers\frontend';

	public $defaultRoute = 'home';

	public $layout = 'frontend';

	public $viewsPath = '@vendor/xiewulong/yii2-cms/views/frontend';

}
