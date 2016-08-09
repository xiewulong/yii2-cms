<?php
namespace yii\cms\assets;

use Yii;
use yii\xui\ModuleAsset;

class FrontendAsset extends ModuleAsset {

	public $namespace = 'frontend';

	public $depends = [
		'yii\xui\BootstrapAsset',
	];

}
